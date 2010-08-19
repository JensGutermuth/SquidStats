<?php
/**
 * @Author: Felix hirt
 * @Description: Verwaltung von Einstellungen & Eigenschaften
 * @Version: 0.1
 **/
	class ConfigHandler
	{
		private $db;
		private $property = array();
		
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
		
		public __get($name)
		{
			if(isset($property[$name]))
				return $property[$name];
			else
				throw new Exception("Ungueltiger Name");
		}
		
		public __set($name, $val)
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
		
		
	}
?>