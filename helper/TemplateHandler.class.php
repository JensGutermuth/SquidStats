<?

require_once(dirname(__FILE__)."/ConfigHandler.class.php");

class TemplateHandler
{
    private function get_include_contents($filename) {
        if (is_file($filename)) {
            ob_start();
            include $filename;
            $contents = ob_get_contents();
            ob_end_clean();
            return $contents;
        }
        return false;
    }

    public function render($template, $vars) {
        $config = ConfigHandler::getInstance();
        $tpl_filename = $config["basepath"]."/".$config["tpl.template_dir"].'/'.$template.'.tpl.php';
        if (is_file($tpl_filename)) {
            global $v;
            global $t;
            $v = $vars; // Variablen / Daten fürs Template
            $c = $config; // Konfiguration
            $t = $this; // Hilfsfunktionen
            require ($tpl_filename);
            unset($v);
            unset($t);
        }
    }
}
?>
