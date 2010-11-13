<?
require_once("CodeCompressorBase.class.php");
require_once("ConfigHandler.class.php");
class CssCompressor extends CodeCompressorBase {
  const MAX_FILESIZE_FOR_DATA_URL = 1024; // max. laut RFC
  public $remove_newlines = true;
  public $remove_whitespace = true;
  public $replace_images_with_dataurls = true;
  protected function getFilename($hash) {
    $config = ConfigHandler::getInstance();
    return $config->basepath.'/web/cache/css/'.$hash.'.css';
  }

  protected function getHtmlTag($hash) {
    $config = ConfigHandler::getInstance();
    return '<link rel="stylesheet" type="text/css" href="'.$config->baseurl.'cache/css/'.$hash.'.css" />';
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
    if ($this->remove_newlines) {
      $css = str_replace(array("\r\n", "\r", "\n"), '', $css);
    }
    if ($this->remove_whitespace) {
      $css = str_replace(array("\t", "  ", "   ", " {"), '', $css);
    }
    if ($this->replace_images_with_dataurls) {
      $css = preg_replace_callback('!background\s*:\s*url\((.+?)\)!',
        array($this, 'replaceUrlWithDataUrl'), $css);
      $css = preg_replace_callback('!background-image\s*?:\s*url\((.+?)\)!',
        array($this, 'replaceUrlWithDataUrl'), $css);
    }
    file_put_contents($destFile, $css);    
  }
  public function replaceUrlWithDataUrl($treffer) {
    $config = ConfigHandler::getInstance();
    $file = $config->basepath.'/web/'.$treffer[1];
    if (file_exists($file)) {
      if (filesize($file) < self::MAX_FILESIZE_FOR_DATA_URL) {
        $content   = base64_encode(file_get_contents($file)); 
        $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
        $mime = finfo_file($finfo, $file);
        finfo_close($finfo);
        if (stripos($treffer[0], 'background-image') === 0) {
          return "background-image:url(data:$mime;base64,$content)";
        } else {
          return "background:url(data:$mime;base64,$content)";
        }
      }
    }
    return $treffer[0];
  }
}
?>
