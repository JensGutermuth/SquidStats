<?
require_once(dirname(__FILE__)."/../helper/ConfigHandler.class.php");
require_once(dirname(__FILE__)."/../helper/LogHandler.class.php");#
require_once(dirname(__FILE__)."/../helper/DbHandler.class.php");

require_once(dirname(__FILE__)."/base.class.php");

class HitModel extends BaseModel{
    static public function setup()
    {
    }

    public function get($condition)
    {
    }
    
    public function set($id, $value, $createIfNotExists = true)
    {
    }
    
    public function count($condition)
    {
    }
    
    public function delete($condition)
    {
    }
    
}
