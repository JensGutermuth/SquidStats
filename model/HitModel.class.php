<?
require_once(dirname(__FILE__)."/../helper/DbHandler.class.php");

require_once(dirname(__FILE__)."/BaseModel.class.php");

class HitModel extends BaseModel {
  // Eigenschaften:
  // id, time, clientId, protocol, method, domainId, port, path, request_size,
  // response_size, response_code, squid_status, content_type
  
  static public function setup() { // sollte immernoch implementiert werden..
    $db = DbHandler::getInstance();
    $sql = "CREATE TABLE IF NOT EXISTS hit (
      id BIGINT NOT NULL ,
      time TIMESTAMP NOT NULL ,
      clientId BIGINT NOT NULL ,
      protocol CHAR( 5 ) NOT NULL ,
      method VARCHAR( 20 ) NOT NULL ,
      domainId BIGINT NOT NULL ,
      port INT NOT NULL ,
      path VARCHAR( 500 ) NOT NULL ,
      request_size BIGINT NOT NULL ,
      response_size BIGINT NOT NULL ,
      response_code INT NOT NULL ,
      squid_status VARCHAR( 20 ) NOT NULL ,
      content_type VARCHAR( 50 ) NOT NULL
      ) ENGINE = MYISAM ;
    ";
    $db->query($sql);
  }  
  
  const SELECT_WITH_JOINS = "SELECT * FROM hits
    JOIN domains ON (hits.domainId = domains.id)
    JOIN clients ON (hits.clientId = clients.id) ";
  
  
  public function getByDomain($domain, $count=-1, $start=0) {
    return $this->returnQueryResult(self::SELECT_WITH_JOINS."
      WHERE domains.name = '".$db->escape_string($domain)."'", $count, $start);
  }

  public function getByDomainId($domainId, $count=-1, $start=0) {
    return $this->returnQueryResult(self::SELECT_WITH_JOINS."
      WHERE hits.domainId = '".$db->escape_string($domainId)."'", $count, $start);
  }

  public function getById($id) {
    return $this->returnQueryResult(self::SELECT_WITH_JOINS."
      WHERE hits.id = '".$db->escape_string($id)."'");
  }

  public function set($id, $values, $createIfNotExists = false) {
  }

  public function count($distinctField = NULL) {
  }

  public function deleteById($id) {
  }
}
