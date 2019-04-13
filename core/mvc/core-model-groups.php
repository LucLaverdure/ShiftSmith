<?php
	namespace Wizard\Build;

	// Core Controller class for all controller objects to extend
	class Group {
		private $id = null;				// id to map in Queue 
		private $index = 0;				// unique index id; 0 to vars count -1, by default = 0  
		private $group_type = null; 			// defaults to Model
		private $space = 'general';			// namespace

		private $stack_defs = array();			// stored stack
		private $values = array();			// stored stack

		public function __construct($group_type="model") {	// Define group of (type)
			if ($group_type == "model") {
				$this->group_type = new Model();
			}
			if ($this->id == null) {
				// Check that ID doesn't exist
				while (($this->id == null) || (Queue::id_exists($this->id)) ) {
					$this->id = md5(mt_rand(0, 999999));
				}
			}
		}

		public function space($space=null) {	
			if ($space  == null) {
				return $this->space; // get table name
			} else {
				$this->space = $space; // set table name
			}
			Queue::stack_model($this->id, $this);
			return $this;
		}

		public function index($index = null) {	// set index
			if ( ($index != null) && (is_numeric($index)) ) {
				$this->index = $index;
				return $this;
			}
			Queue::stack_model($this->id, $this);
			return $this->index;
		}

		public function def() { // set var names
			$args = func_get_args();
			if (count($args) > 0) {
				foreach($args as $arg) {
					$this->stack_defs[] = $arg;
				}
				Queue::stack_model($this->id, $this);
			} else {
				return $this->stack_defs;
			}
		}

		public function add() { // add values

			$values =  array();

			$args = func_get_args();
			foreach($args as $arg) {
				$values[] = $arg;
			}
			$this->values[] = $values;

			Queue::stack_model($this->id, $this);

			return $this;
			
		}
		public function load() {	// load from db
			// TODO
		}
		public function save() {	// save to db
			// TODO
		}

		// return array ("def1" => "val1", "def2" => "val2", [...] )
		function get($id) {
			$ret = array(z);
			foreach ($this->values as $val) {
				if ($val[$this->index] == $id) {

					foreach($val as $k => $v) {
						$ret[$this->stack_defs[$k]] = $v;
					}
				
					return $ret;
				}
			}

		}

		function getAll() {
			$ret = array();
			foreach($this->stack_defs as $key => $var) {
				if (isset($this->values[$key])) $ret[] = array($var, $this->values[$key]);
			}

			return $ret;
		}
		function getValues() {
			return $this->values;
		}
	}
?>
