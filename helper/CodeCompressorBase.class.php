<?

abstract class CodeCompressorBase {
  
  public function getCompressedHtmlTag($files) {
    sort($files); // Reihenfolge muss egal sein
    $fileinfo = array();
    foreach ($files as $file) {
      if (!file_exists($file)) {
        throw Exception('file to be compressed not found ('.$file.')');
        return '';
      }
      $tmp = array();
      // Einiges an Informationen, die eindeutig für eine Version
      // der Datei sind, aber dennoch schnell zu beschaffen
      $tmp['name'] = $file;
      $tmp['mtime'] = filemtime($file);
      $tmp['size'] = filesize($file);
      $fileinfo[] = $tmp;
    }
    $md5 = md5(serialize($fileinfo));
    if ((!file_exists($this->getFilename($md5))) || (!$this->getUseCache())) {
      echo "new Version!";
      $this->compress($files, $this->getFilename($md5));
    }
    return $this->getHtmlTag($md5);
  }
  
  abstract protected function getUseCache();
  
  /*
   * Erzeuge einen Link.
   * zB: <link rel="stylesheet" type="text/css" href="style.css" />
   */
  abstract protected function getHtmlTag($hash);

  /*
   * Erzeuge einen Dateinamen
   */
  abstract protected function getFilename($hash);
  
  abstract protected function compress($files, $destFile);
}
