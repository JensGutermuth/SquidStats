<?php
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
    
    private checkDbConnection() {
        if (!$db) {
            $config = new configHandler();
            if (!$config->exists(array("db.host", "db.username",
                "db.password", "db.dbname", "db.port"))) { // config unvollständig
                throw new Exception("DB-Konfiguration ist unvollständig!");
            }
            if (!$this->$db = new mysqli($config->get("db.host"),
                    $config->get("db.username"), $config->get("db.password"),
                    $config->get("db.dbname"), $config->get("db.port")) {
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
    
    public __get($name) {
        if (isset($this->db->$name)) {
            return $this->db->$name;
        } else {
            throw new Exception("Ungültige Eigenschaft");
        }
    }
    
    public __call($name, $args) {
        if(is_callable(array($this->db, $name))) {
            call_user_func(array($this->db, $name), $args);
        } else {
            throw new Exception("Ungültige Methode");
        }
    }
}
?>
