<?
require_once(dirname(__FILE__)."/../helper/DbHandler.class.php");

abstract class BaseModel {
  // Low-Level interface

  static public function setup() { // sollte immernoch implementiert werden..
  }

  abstract public function getById($id, $fields);

  abstract public function set($id, $values, $createIfNotExists = false);

  abstract public function count($distinctField = NULL);

  abstract public function deleteById($id);
  
  protected function returnQueryResult($sql, $count=-1, $start=0) {
    $db = DbHandler::getInstance();
    if ($count > 0) {
      $sql .= " LIMIT $start,$count";
    }
    $db_result = $db->query($sql);
    return $db_result->fetch_all(MYSQLI_ASSOC);
  }
}
