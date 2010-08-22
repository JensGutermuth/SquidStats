<?
    // TEST des Templatesystems, das kann hier nicht so bleiben :)
    require_once(dirname(__FILE__)."/../helper/ConfigHandler.class.php");
    require_once(dirname(__FILE__)."/../helper/LogHandler.class.php");
    require_once(dirname(__FILE__)."/../helper/TemplateHandler.class.php");
    
    $tpl = new TemplateHandler();
    $vars = array();
    $vars["test"] = "Lorem Ipsum";
    $vars["test2"] = "Ne, ne ne";
    $tpl->render("index", $vars);
?>
