<?
/**
 * @Author: Felix hirt
 * @Description: Verwaltung von Einstellungen & Eigenschaften
 * @Version: 0.1
 **/

require_once(dirname(__FILE__)."/DbHandler.class.php");
if (file_exists(dirname(__FILE__)."/../config.php")) {
    require_once(dirname(__FILE__)."/../config.php"); // Lokale Konfiguration
} else {
    require_once(dirname(__FILE__)."/../config_default.php"); // Default
}    

	class ConfigHandler implements arrayaccess
	{
		private $db;
		static private $instance;
		private $property = array();
		private $property_file = array();
		private $property_changed = array();
		private $property_ready = false;
		private $any_filechanges = false;
        
        private $basepath = '';
		
		public static function getInstance()
		{
			if(!self::$instance) {
				self::$instance = new ConfigHandler();
			}
			return self::$instance;			
		}
		
		public static function setup() 
		{
			$db = DbHandler::getInstance();
			$sql = "CREATE TABLE IF NOT EXISTS `property` (
					`name` VARCHAR( 255 ) NOT NULL ,
					`val` TEXT NOT NULL ,
					PRIMARY KEY ( `name` )
				) ENGINE = MYISAM ;";
			$db->query($sql);
		}
		
		private function loadPropertiesFromDb() 
		{
			$this->property_ready = true;
			$this->db = Dbhandler::getInstance();
			
			$result = $this->db->query("SELECT * FROM `property`;");
			if(!$result)
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
		
		private function __construct() 
		{ 
            $this->property = get_config_from_config_file();
            foreach ($this->property as $key => $value) {
                $this->property_file[$key] = 'y';
            }
		}
		
		public function __destruct()
		{
			$this->write_config();
		}
		
		private function write_config()
		{
			$file_data = array();
			foreach($this->property_changed as $key => $data)
			{
				if(!isset($this->property_file[$key]))
				{
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
			}
			if($this->any_filechanges == true)
				$this->writeFileConf();
		}
		
		public function get($name)
		{
			if(isset($this->property[$name]))
				return $this->property[$name];
			else
				if (!$this->property_ready) {
					$this->loadPropertiesFromDb();
					return $this->get($name);
				} else {
					throw new Exception("Ungueltiger Name ".$name);
				}
		}

		public function set($name, $val)
		{
			$this->property[$name] = $val;
			
			if(isset($this->property_file[$name]))
				$this->setFileConf($name, $name);
			else 
			{
				$val = serialize($val);
				$result = $this->db->query("INSERT INTO `property` SET 
												val = '".$this->db->escape_string($val)."',
												name = '".$this->db->escape_string($name)."' 
											ON DUPLICATE KEY
												UPDATE
												val = '".$this->db->escape_string($val)."',
												name = '".$this->db->escape_string($name)."';");
				if($result === false)
					throw new Exception("MySQL Fehler");
				$result->free();
			}
		}
		
		public function exists($name)
		{
			if (!$this->property_ready) {
				$this->loadPropertiesFromDb();
			}
			return isset($this->property[$name]);
		}
		
		// Zugriff über Eigenschaften
		public function __get($name)
		{
			return $this->get($name);
		}
		
		public function __set($name, $val)
		{
			$this->set($name, $val);
		}
		
		public function __isset($name)
		{
			return $this->exists($name);
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
		
		
		
		// Datei-funktionen
		// 
		// LANGSAM! nur für einstellungen, die nicht häufig geändert werden müssen!
		
		private function writeFileConf()
		{
			$basepath = $this->property['basepath']; // Existiert immer
            $file = fopen($basepath."/config.php", "w+", 1);
			fputs($file, "<?php \n".
                         "require_once(dirname(__FILE__).\"/helper/ConfigHandler.class.php\");\n".
						 "function get_config_from_config_file() {\n".
                         "  \$config = array();");
			
			foreach($this->property_file as $key=> &$data)
			{
                if ($key != 'basepath') { // wird speziell gehandhabt
                    fputs($file, '  $config["'.$key.'"] =  '.var_export($this->property[$key], true).'; '."\n");
                }
			}
			fputs($file, '  $config["basepath"] = dirname(__FILE__);'."\n");

			fputs($file, '} ?>');
			fclose($file);
		}
		
		public function setFileConf($name, $val, $new = 1)
		{
			$this->property[$name] = $val;
			$this->property_file[$name] = "y"; // der array-index muss existieren...
			if($new == 1)
				$this->any_filechanges = true;
		}
		
		public function delFileConf($name)
		{
			unset($this->property[$name]);
			unset($this->property_file[$name]);
			$this->any_filechanges = true;
		}		
	}
// Tests:	
/*
	$conf = ConfigHandler::getInstance();
	$conf->setFileConf("bla", "f00bar1", 1);
	$conf->setFileConf("bla1", "f00bar2", 1);
*/
?>
