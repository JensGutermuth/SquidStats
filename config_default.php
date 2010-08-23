<?
require_once(dirname(__FILE__)."/helper/ConfigHandler.class.php");
function get_config_from_config_file() {
  $config = array();  $config["db"] =  array (
  'host' => 'localhost',
  'username' => 'squidstats',
  'password' => 'squidstats',
  'dbname' => 'squidstats',
); 
  $config["log"] =  'log'; 
  $config["tpl"] =  'tpl'; 
  $config["basepath"] = dirname(__FILE__);
}
?>
