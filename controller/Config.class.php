<?
require_once(dirname(__FILE__).'/BaseController.class.php');
require_once(dirname(__FILE__).'/../helper/ConfigHandler.class.php');
require_once(dirname(__FILE__).'/../helper/TemplateHandler.class.php');

class Config extends BaseController {
    public function index($args) {
        $tpl = new TemplateHandler();
        $config = ConfigHandler::getInstance();
        $vars = array();
        $vars['config'] = $config->getAll();
        $tpl->render('config', $vars);
      
    }
}
?>
