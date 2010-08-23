<?
// To be ported to MVC
require_once(dirname(__FILE__).'/../helper/DbHandler.class.php');
require_once(dirname(__FILE__).'/../helper/TemplateHandler.class.php');

$tpl = new TemplateHandler();
$db = DbHandler::getInstance();
$vars = array();
$sql = "SELECT time, origin, severity, message
        FROM log
        ORDER BY time DESC
        LIMIT 0 , 30;";
$result = $db->query($sql);
$vars['log'] = array();
while ($row = $result->fetch_assoc()) {
    $vars['log'][] = $row;
}
$tpl->render("log", $vars);
?>
