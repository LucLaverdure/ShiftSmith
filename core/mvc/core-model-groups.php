<?php
	namespace Wizard\Build;

	// Core Controller class for all controller objects to extend
	class Group {

		private $nspace = 'general';

		private $stack_defs = array();			// stored stack
		private $values = array();			// stored stack

		public function __construct() {	// Define group of (type)

		}

		public function space($space=null) {	
			if ($space  == null) {
				return $this->nspace; // get table name
			} else {
				$this->nspace = $space; // set table name
			}
			return $this;
		}


		public function def() { // set var names
			$args = func_get_args();
			if (count($args) > 0) {
				foreach($args as $arg) {
					$this->stack_defs[] = $arg;
				}
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

			Queue::stack_model($this->nspace, $this->stack_defs, $values);

			return $this;
			
		}
		public function load() {	// load from db
			// TODO
			$values =  array();
			$args = func_get_args();
			foreach($args as $arg) {
				$values[] = $arg;
			}
		}
		public function save() {	// save to db
			// TODO
			if (count($this->stack_defs) > 0) {
				$values =  array();
				$args = func_get_args();
				foreach($args as $arg) {
					$values[] = $arg;
				}
			}

		}

		// return array ("def1" => "val1", "def2" => "val2", [...] )
		function get($id) {
			$ret = array();
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
