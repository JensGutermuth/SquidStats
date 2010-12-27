<?

require_once(dirname(__FILE__)."/DbHandler.class.php");
require_once(dirname(__FILE__)."/ConfigHandler.class.php");

class LogHandler {
    static public function setup() {
        self::$enabled = false;
        $db = DbHandler::getInstance();
        $sql = "CREATE TABLE IF NOT EXISTS `log` (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            `origin` TEXT NOT NULL ,
            `severity` INT NOT NULL ,
            `message` TEXT NOT NULL ,
            INDEX ( `time` )
            ) ENGINE = MYISAM;";
        $db->query($sql);
        self::$enabled = true;
    }
    
    const SEVERITY_DEBUG = 1;
    const SEVERITY_DB_QUERY = 2;
    const SEVERITY_DB_QUERY_CHANGE = 3;
    const SEVERITY_ACTION = 10;
    const SEVERITY_NOTICE = 20;
    const SEVERITY_WARNING = 30;
    const SEVERITY_ERROR = 40;
    const SEVERITY_FATAL_ERROR = 50;
    
    private static $enabled = true;
    // Um nicht selbst Log-Einträge zu erzeugen und damit in endloser Rekursion zu enden
    
    private function formatOrigin($trace, $root) {
        // Dateiname von der Position des Projekts befreien
        $basename = realpath(dirname(__FILE__).'/..');
        $file = $trace[$root]['file']; // Code wird kürzer
        $trace[$root]['file'] = substr($file, strlen($basename)+1, strlen($file));
        $tmp = $trace[$root]['file'].' ('.$trace[$root]['line'].'): ';
        if (isset($trace[$root+1])) {
            if (isset($trace[$root+1]['class'])) { // Klassenfunktion
                $tmp .= $trace[$root+1]['class'].$trace[$root+1]['type'];
            }
            $tmp .= $trace[$root+1]['function'].": ";
        }
        $tmp .= "\n";
        return $tmp;
    }
    
    public function log($severity, $message) {
        if (!self::$enabled) {
          return;
        }
        $config = ConfigHandler::getInstance();
        if (($severity > $config->log['min_severity']) and (Loghandler::$enabled)) {
            Loghandler::$enabled = false;
            $trace = debug_backtrace(false);
            $origin = "";
            if (count($trace) > 1) {
                if (($severity == LogHandler::SEVERITY_DB_QUERY) &&
                ($trace[1]['function'] == '__call')) { // Speziallfall für DB-Querys
                    if (count($trace) > 2) {
                        $message = 'Query von '.$this->formatOrigin($trace, 2).$message;
                    }
                    // __call verstecken, und die "richtige" Funktion ausgeben
                    $trace[1]['function'] = $trace[1]['args'][0];
                }
            }
            if (isset($trace[0])) {
                $origin = $this->formatOrigin($trace, 0);
            }
            $db = DbHandler::getInstance();
            
            // Doppelte Leerzeichen entfernen, sind in 99,9% der Fälle Schwachsinn
            $message = preg_replace('/[^\S\n]{2,}/', ' ', $message);
            
            // Leerzeichen am Zeilenende entfernen
            $message = preg_replace('/[^\S\n]+?\n/', "\n", $message);
            $sql = "INSERT INTO log (origin, severity, message) VALUES
                (\"{$db->escape_string($origin)}\",
                \"{$db->escape_string($severity)}\",
                \"{$db->escape_string($message)}\");";
            $db->query($sql);
        }
        Loghandler::$enabled = true;
    }
}
