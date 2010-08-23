<?
require_once(dirname(__FILE__).'/BaseController.class.php');
require_once(dirname(__FILE__).'/../helper/TemplateHandler.class.php');

class Error404 extends BaseController {
    public function index($args) {
        $tpl = new TemplateHandler();
//        header("HTTP/1.1 404 Not Found");
//        header("Status: 404 Not Found");
        $tpl->render('404', array());
    }
}
