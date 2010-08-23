<?
    function strEndsWith($str, $end)
    {
        $len = strlen($end);
        $strend = substr($str, strlen($str) - $len);
        return $strend == $end;
    }
    
    function findFiles($dir, &$files) {
        if($dirhandle = dir($dir)) {
            while (false !== ($file = $dirhandle->read())) {
                if(is_dir($dir.'/'.$file)) {
                    if (($file != '..') && ($file != '.') && ($file != '.git')) {
                        findFiles($dir.'/'.$file, $files);
                    }
                } else {
                    if (strEndsWith($file, '.class.php')) {
                        require_once($dir.'/'.$file);
                        $classname = substr($file, 0, strlen($file)-strlen('.class.php'));
                        echo "loaded class ".$classname."<br>\n";
                        if (is_callable($classname.'::setup')) {
                            call_user_func($classname.'::setup');
                            echo "called setup of class ".$classname."<br>\n";
                        }
                    }
                    echo $dir.'/'.$file."<br>\n";
                }
            }
            $dirhandle->close();
        }
    }
    findFiles(realpath(dirname(__FILE__).'/..'), $files);
?>
