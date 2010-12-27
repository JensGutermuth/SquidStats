<?
    // TEST des Templatesystems, das kann hier nicht so bleiben :)
    require_once(dirname(__FILE__)."/../helper/ConfigHandler.class.php");
    require_once(dirname(__FILE__)."/../controller/BaseController.class.php");
    require_once(dirname(__FILE__)."/../helper/LogHandler.class.php");
    require_once(dirname(__FILE__)."/../helper/TemplateHandler.class.php");
    $config = ConfigHandler::getInstance();
    
    // Argumente aus URL hohlen
    
    $urlData = explode("/",$_SERVER['REQUEST_URI']);
    for ($i = 0; $i < count($urlData); $i++) {
        if ($urlData[$i] == basename(__FILE__)) {
            $urlData = array_slice($urlData, $i+1, count($urlData));
            break;
        }
    }
    function isEmptyString($var) { return $var !== ""; }
    $urlData = array_filter($urlData, "isEmptyString"); // entfernt leere Einträge
    $urlData = array_values($urlData); // start index at 0

    if (isset($urlData[0])) {
        $classname = $urlData[0];
    } else {
        $classname = $config->routing['defaultClass'];
    }
    if (isset($urlData[1])) {
        $function = $urlData[1];
    } else {
        $function = $config->routing['defaultFunction'];
    }
    $args = array_slice($urlData, 2, count($urlData));
    if (!ctype_alnum($classname) && !ctype_alnum($function)) {
        throw new Exception("Illegale Zeichen in Klasse oder Funktion");
    }


    function strEndsWith($str, $end)
    {
        $len = strlen($end);
        $strend = substr($str, strlen($str) - $len);
        return $strend == $end;
    }

    // nach Klasse suchen und diese laden
    $called = false; // wurde etwas aufgerufen?
    $dir = $config->basepath.'/controller';
    if($dirhandle = dir($dir)) {
        while (false !== ($file = $dirhandle->read())) {
            if(!is_dir($dir.'/'.$file)) {
                if (strEndsWith($file, '.class.php') &&
                (strtolower($file) == strtolower($classname.'.class.php'))) {
                    require_once($dir.'/'.$file);
                    // Den aus dem Dateinamen nehmen, da der richtige Groß/Kleinschreibung hat
                    $classname = substr($file, 0, strlen($file)-strlen('.class.php'));
                    $obj = new $classname;
                    if (is_callable(array($obj, $function)) && ($obj instanceof BaseController)) {
                        echo call_user_func(array($obj, $function), $args);
                        $called = true;
                    }
                }
            }
        }
        $dirhandle->close();
    }
    if (!$called) {
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"])) {$pageURL .= "s";}
            $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["SCRIPT_NAME"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"];
        }
        header("HTTP/1.1 404 Not Found");
        header("Status: 404 Not Found");
        header("Location: $pageURL/error404/");
    }
?>
