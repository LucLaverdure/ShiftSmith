<?php
	namespace Wizard\Build;

	// Core Controller class for all controller objects to extend
	class Group {

		private $nspace = 'general';

		private $stack_defs = array();		// col => s
		private $values = array();			// 0 => val1
		private $inputs = array();			// col => html

		// set ot get namespace
		public function space($space=null) {	
			if ($space  == null) {
				return $this->nspace; // get table name
			} else {
				$this->nspace = $space; // set table name
			}
			return $this;
		}

		// render html input elements
		public function input() { // set var names
			$values = array();
			$args = func_get_args();
			foreach($args as $key => $arg) {
				switch ($arg) {
					case "textbox":
						$values[] = '<input type="textbox" name="'.$this->stack_defs[$key].'" value="'.Posted($this->stack_defs[$key]).'" />';
						break;
					case "password":
						$values[] = '<input type="password" name="'.$this->stack_defs[$key].'" />';
						break;

				}
			}

			$this->values[] = $values;

			Queue::stack($this->nspace, $this->stack_defs, $values);

			return $this;
		}

		// set or get columns definitions
		// ex: def("column1", "i")
		public function def($col=null, $type="s") { // set var names
			if ($col == null) return $this->stack_defs;
			$this->stack_defs[] = array($col => $type);
			return $this;
		}

		// add a row of values
		public function add() { // add values

			$args = func_get_args();

			$this->values[] = $args;

			Queue::stack($this->nspace, $this->stack_defs, $args);

			return $this;
			
		}

		// Pull data from database
		public function load() {	// load from db
			$rows_to_save = array();
			$args = func_get_args();
			if (count($args) > 0) {
				// load by args
			} else {
				// load everything
				$db = DB();
				$rows = $db::query("SELECT ".implode(",", $this->def())." FROM ".$this->nspace);
				return $rows;
			}
		}

		// Push data to database
		public function save() {	// save to db
			$rows_to_save = array();
			$args = func_get_args();
			if (count($args) > 0) {
				for($i = 0; $i < count($args); ++$i) {
					foreach ($this->values as $k => $v) {
						foreach ($v as $kk => $vv) {
							if ($args[$i]==$vv) {								
								$rows_to_save[$i] = $v;
							}
						}
					}
				}
				$db = DB();
				$db::setTable( $this->nspace, $this->def() );
				foreach ($rows_to_save as $k => $val) {
					$db::write($val, $this->nspace, $this->def());
				}

			} else {
				// save everything
				$db = DB();
				$db::setTable( $this->nspace, $this->def() );
				foreach ($this->values as $row) {
					$db::write($row, $this->nspace, $this->def());
				}
			}

		}

		// Get full objects stack
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
			// Get full objects stack
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
