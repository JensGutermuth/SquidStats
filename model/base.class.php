<?
abstract class BaseModel
{
    abstract public function setup();

    abstract public function get($condition);

    abstract public function set($id, $value, $createIfNotExists = true);

    abstract public function count($condition);

    abstract public function delete($condition);
    
    protected function constructWhere($condition)
    {
        foreach ($condition as $key => $value) {
            
        }
    }
}
