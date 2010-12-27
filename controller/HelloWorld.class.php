<?
require_once(dirname(__FILE__).'/BaseController.class.php');
class helloWorld extends BaseController {
    public function index($args) {
        $tpl = new TemplateHandler();
        $vars['args'] = $args;
        $vars['msg'] = "Hello World!";
        $tpl->render("helloWorld", $vars);
    }
}
?>
