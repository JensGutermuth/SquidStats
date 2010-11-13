<?
require_once("CodeCompressorBase.class.php");
require_once("ConfigHandler.class.php");
class CssCompressor extends CodeCompressorBase {
  abstract protected function getFilename($hash) {
    $config = ConfigHandler::getInstance();
    return $config->basepath.'/web/cache/css/'.$hash.'.css';
  }

  protected function getLinkpath($hash) {
    $config = ConfigHandler::getInstance();
    return $config->baseurl.'/cache/css/'.$hash.'.css';
  }
  
  protected function compress($files, $destFile) {
    $css = '';
    foreach ($files as $file) {
      $css .= "\n".file_get_contents($file);
    }
    // Basiert auf: http://www.catswhocode.com/blog/3-ways-to-compress-css-files-using-php
    /* remove comments */
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    /* remove tabs, spaces, newlines, etc. */
    $css = str_replace(array("\r\n", "\r", "\n", "\t", "  ", "   "), '', $css);
    
    file_put_contents($destFile, $css);    
  }
}
?>
