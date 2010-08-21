<?

require_once("DbHandler.class.php");
require_once("ConfigHandler.class.php");

class LogHandler {
    public function setup() {
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
    
    private $enabled = true;
    // Um nicht selbst Log-Einträge zu erzeugen und damit in endloser Rekursion zu enden
    
    public function log($severity, $message) {
        $this->enabled = false;
        $config = ConfigHandler::getInstance();
        if (($severity > $config->get("log.min_severity", 0)) && ($this->enabled)) {
            $trace = debug_backtrace(false);
            $origin = "";
            if (isset($trace[1])) {
                $caller = $trace[1];
                $origin = $caller["file"]." (".$caller["line"].") :";
                if (!isset($caller['class'])) {
                    $origin .= $caller['class'].$caller['type'];
                }
                $origin .= $caller['function'];
            }
            $db = DbHandler::getInstance();

            // Doppelte Leerzeichen entfernen, sind in 99,9% der Fälle Schwachsinn
            $message = preg_replace('/\s+/',$message);

            $sql = "INSERT INTO log (origin, severity, message) VALUES
                (\"${$db->escape_string($origin)}\",
                \"${$db->escape_string($severity)}\",
                \"${$db->escape_string($message)}\");";
            $db->query($sql);
        }
        $this->enabled = true;
    }
}
