<?

require_once("ConfigHandler.class.php");
require_once("LogHandler.class.php");

/*
 * Dies ist die Kapslung des Datenbankzugriffs. Diese Klasse kann genauso
 * wie ein MySQLi-Object benutzt werden, Ausnahme ist das erstellen, das
 * hier über die statische Methode getInstance funktioniert,
 * diese Klasse also ein Singleton ist.
 */
class DbHandler
{
    private $db;
    static private $instance;
    private function __construct() {
        $this->checkDbConnection();
    }
    
    private function checkDbConnection() {
        if (!$this->db) {
            $config = ConfigHandler::getInstance();
// geht so noch nicht...
/*            if (!$config->exists(array("db.host", "db.username",
                "db.password", "db.dbname", "db.port"))) { // config unvollständig
                throw new Exception("DB-Konfiguration ist unvollständig!");
            }
*/
            if (!$this->db = new mysqli($config->db['host'],
                    $config->db['username'], $config->db['password'],
                    $config->db['dbname'])) {
                throw new Exception("DB-Verbindung fehlgeschlagen");
            }
        }
    }
    
    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new DbHandler();
        }
        return self::$instance;
    }
    
    /* MySQLi API zugreifbar machen */
    
    public function __get($name) {
        // $obj->$var greif auf die Objeckteigenschaft mit dem Namen zu, der in $var steht.
        if (isset($this->db->$name)) {
            return $this->db->$name;
        } else {
            throw new Exception("Ungültige Eigenschaft");
        }
    }
    
    public function __call($name, $args) {
        if(is_callable(array($this->db, $name))) {
            if ($name == "query") { // Loggen ist was feines :)
                $log = new LogHandler();
                $sql = preg_replace("/\r|\n/s", " ", $args[0]);
                $log->log(logHandler::SEVERITY_DB_QUERY, $sql);
            }
            
              $result = call_user_func_array(array($this->db, $name), $args);
            if ($this->db->errno != 0) {
                throw new Exception("MySQL-Fehler ".$this->db->errno.": ".$this->db->error);
            }
            return $result;
        } else {
            throw new Exception("Ungültige Methode");
        }
    }
}
?>
