<?
require_once(dirname(__FILE__).'/BaseController.class.php');
class helloWorld extends BaseController {
    public function index($args) {
        nl2br(print_r($args, true));
        echo "hello World!";
    }
}
?>
