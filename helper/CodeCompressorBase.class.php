<?
abstract class CodeCompressorBase {
  public function getLink($files) {
    $files = sort($files); // Reihnfolge muss egal sein
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
      $tmp['mtime'] = filemtime($file)
      $tmp['size'] = filesize($file);
      $fileinfo[] = $tmp;
    }
    $md5 = md5(serialize($fileinfo));
    if (!file_exists($this->getFilename($hash))) {
      $this->compress($files, $this->getFilename($hash));
    }
    echo '<link rel="stylesheet" type="text/css" href="'.$this->getLinkpath($md5).'" />'
  }
  
  /*
   * Erzeuge einen Dateinamen
   */
  
  abstract protected function getFilename($hash) {
  }
  
  /*
   * Sollte der Dateiname nicht als Pfad im Link verwendet werden können,
   * muss diese Funktion überschrieben werden.
   */
  protected function getLinkpath($hash) {
    return $this->getFilename($hash);
  }
  
  abstract protected function compress($files, $destFile) {
  }
}
