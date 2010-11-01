<?
require_once(dirname(__FILE__)."/../helper/DbHandler.class.php");

require_once(dirname(__FILE__)."/base.class.php");

class HitModel extends BaseModel {
  // Eigenschaften:
  // id, time, clientId, protocol, method, domainId, port, path, request_size,
  // response_size, response_code, squid_status, content_type
  
  const SELECT_WITH_JOINS = "SELECT * FROM hits
    JOIN domains ON (hits.domainId = domains.id)
    JOIN clients ON (hits.clientId = clients.id) ";
  
  static public function setup() {

  }
  
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
