<?
    // TEST des Templatesystems, das kann hier nicht so bleiben :)
    require_once(dirname(__FILE__)."/../helper/ConfigHandler.class.php");
    require_once(dirname(__FILE__)."/../helper/LogHandler.class.php");
    require_once(dirname(__FILE__)."/../helper/TemplateHandler.class.php");
    
    $config = ConfigHandler::getInstance();
    $config->log = array('min_severity' => 0);
    $config->tpl = array('template_dir' => "tpl");
    $config->log['min_severity'] = 20;
//    $config->tpl['template_dir'] = "tpl";
    function test_log() {
        $log = new LogHandler();
        $log->log(LogHandler::SEVERITY_DEBUG, "User hat Seite index.php aufgerufen");
    }
        
    test_log();
    $tpl = new TemplateHandler();
    $vars = array();
    $vars["test"] = "Lorem Ipsum";
    $vars["test2"] = "Ne, ne ne";
    $tpl->render("index", $vars);
?>
