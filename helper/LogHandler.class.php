<?

require_once("DbHandler.class.php");
require_once("ConfigHandler.class.php");

class LogHandler {
    static public function setup() {
        $db = DbHandler::getInstance();
        $sql = "CREATE TABLE `log` (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            `origin` TEXT NOT NULL ,
            `severity` INT NOT NULL ,
            `message` TEXT NOT NULL ,
            INDEX ( `time` )
            ) ENGINE = MYISAM;";
        $db->query($sql);
    }
    
    const SEVERITY_DEBUG = 1;
    const SEVERITY_DB_QUERY = 2;
    const SEVERITY_ACTION = 10;
    const SEVERITY_NOTICE = 20;
    const SEVERITY_WARNING = 30;
    const SEVERITY_ERROR = 40;
    const SEVERITY_FATAL_ERROR = 50;
    
    private static $enabled = true;
    // Um nicht selbst Log-Einträge zu erzeugen und damit in endloser Rekursion zu enden
    
    public function log($severity, $message) {
        $config = ConfigHandler::getInstance();
        if (($severity > $config->log['min_severity']) and (Loghandler::$enabled)) {
            Loghandler::$enabled = false;
            $trace = debug_backtrace(false);
            var_dump($trace);
            $origin = "";
            if (isset($trace[0])) {
                $caller = $trace[0];
                $origin = $caller["file"]." (".$caller["line"]."): ";
//                $origin = "";
                if (count($trace) > 1) { // Wir wurden aus einer Funktion heraus aufgerufen
                    $subcaller = $trace[1];
                    if (isset($subcaller['class'])) { // Klassenfunktion
                        $origin .= $subcaller['class'].$subcaller['type'];
                    }
                    $origin .= $subcaller['function'];
                }
            }
            $db = DbHandler::getInstance();

            // Doppelte Leerzeichen entfernen, sind in 99,9% der Fälle Schwachsinn
            $message = preg_replace('/\s{2,}/', '', $message);
            $sql = "INSERT INTO log (origin, severity, message) VALUES
                (\"{$db->escape_string($origin)}\",
                \"{$db->escape_string($severity)}\",
                \"{$db->escape_string($message)}\");";
            $db->query($sql);
        }
        Loghandler::$enabled = true;
    }
}
