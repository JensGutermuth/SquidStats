<?
    // TEST des Templatesystems, das kann hier nicht so bleiben :)
    require_once("../helper/ConfigHandler.class.php");
    require_once("../helper/LogHandler.class.php");
    require_once("../helper/TemplateHandler.class.php");
    
    $tpl = new TemplateHandler();
    $vars = array();
    $vars["test"] = "Lorem Ipsum";
    $vars["test2"] = "Ne, ne ne";
    $tpl->render("index", $vars);
    $log = new LogHandler();
    $log->log(LogHandler::SEVERITY_DEBUG, "User hat Seite index.php aufgerufen");
?>
