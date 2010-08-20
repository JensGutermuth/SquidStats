<?
/**
 * @Author: Felix hirt
 * @Description: Verwaltung von Einstellungen & Eigenschaften
 * @Version: 0.1
 **/

require_once("DbHandler.class.php");

	class ConfigHandler implements arrayaccess
	{
		private $db;
        static private $instance;
		private $property = array();
		
        public static function getInstance()
        {
            if(!self::$instance) {
                self::$instance = new ConfigHandler();
            }
            return self::$instance;            
        }
        
		private function __construct() 
		{
			$this->db = Dbhandler::getInstance();
			
			$result = $this->db->query("SELECT * FROM `property`;");
			if($result === false)
				throw new Exception("MySQL Fehler");
			else
			{
				while($data = $result->fetch_assoc())
				{
					$this->property[$data['name']] = unserialize($data['val']);
				}
				$result->free();
			}
		}
		
        public function get($name)
        {
			if(isset($this->property[$name]))
				return $this->property[$name];
			else
				throw new Exception("Ungueltiger Name");
        }

        public function set($name, $val)
        {
            $this->property[$name] = $val;
   			$val = serialize($val);
			$result = $this->db->query("INSERT INTO `property` SET 
									val = '".$this->db->escape_string($val)."',
									name = '".$this->db->escape_string($name)."' 
								ON DUPLICATE KEY
									UPDATE `property` SET 
									val = '".$this->db->escape_string($val)."',
									name = '".$this->db->escape_string($name)."';");
			if($result === false)
				throw new Exception("MySQL Fehler");
			$result->free();
        }
        
        public function exists($name)
        {
            return isset($this->property[$name]);
        }
        
        // Zugriff über Eigenschaften
		public function __get($name)
		{
            $this->get($name);
		}
		
		public function __set($name, $val)
		{
            $this->set($name, $val);
		}
		
		public function __isset($name)
		{
            $this->exists($name);
		}

        // arrayaccess
        
        public function offsetExists ($name)
        {
            return $this->exists($name);
        }
            
        public function offsetGet($name)
        {
            return $this->get($name);
        }
            
        public function offsetSet($name, $val)
        {
            $this->set($name, $val);
        }
            
        public function offsetUnset($name)
        {
            // ToDo
        }
            		
	}
?>
