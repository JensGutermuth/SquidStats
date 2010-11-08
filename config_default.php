<?php 
require_once(dirname(__FILE__)."/helper/ConfigHandler.class.php");
function get_config_from_config_file() {
  // Hilfsfunktionen

  function getBaseUrl() {
    $pageURL = 'http';
    if (isset($_SERVER['HTTPS'])) {$pageURL .= 's';}
      $pageURL .= '://';
    if ($_SERVER['SERVER_PORT'] != '80') {
      $pageURL .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].dirname($_SERVER['SCRIPT_NAME']);
    } else {
      $pageURL .= $_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']);
    }
    return $pageURL;
  }
  $config = array();

/* User einrichten mit:
    CREATE USER 'squidstats'@'localhost' IDENTIFIED BY 'squidstats';

    GRANT USAGE ON * . * TO 'squidstats'@'localhost' IDENTIFIED BY 'squidstats' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;

    CREATE DATABASE IF NOT EXISTS `squidstats` ;

    GRANT ALL PRIVILEGES ON `squidstats` . * TO 'squidstats'@'localhost';
*/
  $config["db"] =  array (
  'host' => 'localhost',
  'username' => 'squidstats',
  'password' => 'squidstats',
  'dbname' => 'squidstats',
); 
  $config["routing"] =  array (
  'defaultClass' => 'Error404',
  'defaultFunction' => 'index',
); 
  $config["log"] = array('min_severity' => 0);
  $config["tpl"] = array('template_dir' => 'tpl');
  $config["basepath"] = dirname(__FILE__);
  $config["baseurl"] = getBaseUrl();
  return $config;
}
?>
