<?

require_once(dirname(__FILE__)."/ConfigHandler.class.php");
require_once(dirname(__FILE__)."/FilterHandler.class.php");

class TemplateHandler {
	const FILTER_SLOT_FINAL = 'template_final';
	const FILTER_SLOT_VARS = 'template_vars';
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
        $tpl_filename = $config['basepath']."/".$config['tpl']['template_dir'].'/'.$template.'.tpl.php';
        if (is_file($tpl_filename)) {
            $filter = FilterHandler::getInstance();
            global $v;
            global $t;
            
			// Variablen / Daten fürs Template
            $v = $filter->useSlot(self::FILTER_SLOT_VARS, $vars);
            $c = $config; // Konfiguration
            $t = $this; // Hilfsfunktionen
            
            ob_start();
            require ($tpl_filename);
            $site = ob_get_contents();
            ob_end_clean();
            echo $filter->useSlot(self::FILTER_SLOT_FINAL, $site);
            
            unset($v);
            unset($t);
        }
    }
	
	public function str_maxlength($str, $len=80)
	{
		if(strlen($str) > $len)
			return substr($str, 0, $len-3)."...";
		
		return $str;
	}
}
?>
