<?
require_once("CodeCompressorBase.class.php");
require_once("ConfigHandler.class.php");

class CssCompressor extends CodeCompressorBase {

  public static function setup() {
    $config = ConfigHandler::getInstance();
    $config->CssCompressor_useCache = true;
    $config->CssCompressor_removeNewlines = true;
    $config->CssCompressor_removeWhitespace = true;
    $config->CssCompressor_generateDataurls = true;
    $config->CssCompressor_generateGzipVersion = true;
    $config->CssCompressor_maxFilesizeForDataurl = 1024;
  }
  
  protected function getUseCache() {
    $config = ConfigHandler::getInstance();
    return $config->CssCompressor_useCache;
  }
  
  protected function getFilename($hash) {
    $config = ConfigHandler::getInstance();
    return $config->basepath.'/web/cache/css/'.$hash.'.css';
  }

  protected function getHtmlTag($hash) {
    $config = ConfigHandler::getInstance();
    $result = '<link rel="stylesheet" type="text/css" href="'.$config->baseurl.'cache/css/'.$hash.'.css" />'."\n";
    if ($config->CssCompressor_generateDataurls) {
      $result .= '<!--[if lte IE 6]>
      <link rel="stylesheet" type="text/css" href="'.$config->baseurl.'cache/css/'.$hash.'-lte-ie7.css" />
      <![endif]-->'."\n"; // Hack für IE7 und kleiner, da die keine data-urls unterstützen
    }
//    $result .= '<a href="'.$config->baseurl.'cache/css/'.$hash.'.css" >Stylesheet</a><br>';
//    $result .= '<a href="'.$config->baseurl.'cache/css/'.$hash.'-lte-ie7.css" >IE-Stylesheet</a><br>';
    return $result;
  }
  
  protected function compress($files, $destFile) {
    $config = ConfigHandler::getInstance();
    $css = '';
    foreach ($files as $file) {
      $css .= "\n".file_get_contents($file);
    }
    // Basiert auf: http://www.catswhocode.com/blog/3-ways-to-compress-css-files-using-php
    /* remove comments */
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    /* remove tabs, spaces, newlines, etc. */
    if ($config->CssCompressor_removeNewlines) {
      $css = str_replace(array("\r\n", "\r", "\n"), "", $css);
    }
    if ($config->CssCompressor_removeWhitespace) {
      $css = str_replace(array("\t", "  ", "   "), "", $css);
      $css = str_replace(array(" {", "  {"), "{", $css);
    }
    if ($config->CssCompressor_generateDataurls) {
      // Files without data-urls for IE <= 7
      $ieFilename = substr($destFile, 0, -4).'-lte-ie7.css';
      file_put_contents($ieFilename, $css);
      if ($config->CssCompressor_generateGzipVersion) {
        file_put_contents($ieFilename.'.gz', gzencode($css, 9));
      }
      
      $css = preg_replace_callback('!background\s*:\s*url\((.+?)\)!',
        array($this, 'replaceUrlWithDataUrl'), $css);
      $css = preg_replace_callback('!background-image\s*?:\s*url\((.+?)\)!',
        array($this, 'replaceUrlWithDataUrl'), $css);
      $css = preg_replace_callback('!list-style-image\s*?:\s*url\((.+?)\)!',
        array($this, 'replaceUrlWithDataUrl'), $css);
    }
    file_put_contents($destFile, $css);    
    if ($config->CssCompressor_generateGzipVersion) {
      file_put_contents($destFile.'.gz', gzencode($css, 9));    
    }
  }

  public function replaceUrlWithDataUrl($treffer) {
    if (($treffer[1][0] == "'") && ($treffer[1][strlen($treffer[1])-1] == "'")) {
      $treffer[1] = substr($treffer[1], 1, strlen($treffer[1])-2);
    }
    if (($treffer[1][0] == '"') && ($treffer[1][strlen($treffer[1])-1] == '"')) {
      $treffer[1] = substr($treffer[1], 1, strlen($treffer[1])-2);
    }
    
    $config = ConfigHandler::getInstance();
    $file = $config->basepath.'/web/'.$treffer[1];
    if (file_exists($file)) {
      if (filesize($file) < $config->CssCompressor_maxFilesizeForDataurl) {
        $content   = file_get_contents($file); 
        $content_base64 = base64_encode($content);
        $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
        $mime = finfo_buffer($finfo, $content);
        finfo_close($finfo);
        $tmp = explode(':', $treffer[0]);
        $css_property = $tmp[0];
        return "$css_property:url('data:$mime;base64,$content_base64')";
      }
    }
    return $treffer[0];
  }
}
?>
