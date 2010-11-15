<?

require_once(dirname(__FILE__)."/ConfigHandler.class.php");

class FilterHandler {
	static private $instance = NULL;
	private $filters;
	protected function __construct() {
		$this->filters = array();
	}
	
	public static function getInstance() {
		if (!self::$instance) {
			self::$instance = new FilterHandler();
		}
		return self::$instance;
	}
	
	public function registerFilter($slot, $function) {
		if (is_callable($function)) {
			$this->filters[$slot][] = $function;
		} else {
			throw new Exception("Funktion für Filteraufruf ungültig");
		}
	}
	public function useSlot($slot, $input) {
		$output = $input;
		if (array_key_exists($slot, $this->filters)) {
			foreach ($this->filters[$slot] as $filter) {
				$output = call_user_func($filter, $output);
			}
		}
		return $output;
	}
}
