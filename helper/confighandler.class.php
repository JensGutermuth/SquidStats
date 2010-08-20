<?php
/**
 * @Author: Felix hirt
 * @Description: Verwaltung von Einstellungen & Eigenschaften
 * @Version: 0.1
 **/
	class ConfigHandler
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
			$db = Dbhandler::getInstance();
			
			$result = $db->query("SELECT * FROM `property`;");
			if($result === false}
				throw new Exception("MySQL Fehler");
			else
			{
				while($data = $result->fetch_assoc())
				{
					$property[$data['name']] = unserialize($data['val']);
				}
				$result->free();
			}
		}
		
        public function get($name)
        {
			if(isset($property[$name]))
				return $property[$name];
			else
				throw new Exception("Ungueltiger Name");
        }

        public function set($name, $val)
        {
   			$val = serialize($val);
			$result = $db->query("INSERT INTO `property` SET 
									val = '".mysql_escape_string($val)."',
									name = '".mysql_escape_string($name)."' 
								ON DUPLICATE KEY
									UPDATE `property` SET 
									val = '".mysql_escape_string($val)."',
									name = '".mysql_escape_string($name)."';");
			if($result === false}
				throw new Exception("MySQL Fehler");
			$result->free();
        }
        
		public function __get($name)
		{
            $this->get($name);
		}
		
		public function __set($name, $val)
		{
            $this->set($name, $val);
		}
		
		
	}
?>
