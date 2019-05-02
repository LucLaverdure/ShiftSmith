<?php
	namespace Wizard\Build;
	
	require_once(PATH.'core/lib/phpQuery/phpQuery-onefile.php');
	
	class Queue {

		private static $complete_output = "";

		private $obj_controllers; // Controllers Found
		private static $stack = Array(); // All stacked data
		private static $stackGroups = Array(); // All stacked data
		private static $loops = Array(); // Loop count for namespace Found
		
		public function __construct() {
			
			// Get php's core declared classes count
			$system_classes_count = count(get_declared_classes());
			$system_classes = get_declared_classes();
			
			$paths_to_load = array();

			// search for all files within the webapp's current theme directory
			$initial_dirs = explode(',', PATH.'webapp/themes/'.Config::ACTIVE_THEME."/,".PATH.'webapp/plugins/');
			foreach ($initial_dirs as $dir) {
				$paths_to_load[] = Tools::search_files($dir);
			}

			foreach ($paths_to_load as $path) {
				foreach ($path as $path_within) {
					if ($path_within) include $path_within;
				}
			}
			
			// Remove all classes of php's core to identify webapp classes
			$custom_classes = array_slice(get_declared_classes(), $system_classes_count);

			// Instantiate each controller found (identified by class extended of Controller)
			foreach($custom_classes as $class) {
				if (in_array('Wizard\Build\Controller', class_parents($class))) {
					$this->obj_controllers[$class] = new $class;
				}
			}

		}

		// stack model to queue for processing
		static public function stack_model_single($space, $key, $val, $type) {
			if (!isset(self::$stack[$space])) {
				self::$stack[$space] = array();
			}
			self::$stack[$space][$key] = array($type => $val);
		}
		
		// defs[col1=s, col2=s], vals[ [v1,v2], [v3,v4] ]
		static public function stack_model_group($space, $defs, $vals) {
			
			if (!isset(self::$stackGroups[$space])) {
				self::$stackGroups[$space] = array();
			}
			foreach ($defs as $k => $d) {
				self::$stackGroups[$space][] = array($defs[$k], $vals[$k], count($defs));
			}
		}
		
		//stack($this->nspace, $this->stack_defs, $args);
		//Queue::stack($this->nspace, $this->stack_defs, $args);
		static public function stack($space, $defs, $vals, $type=null) {
			if (is_array($defs) && ($type == null)) {
				self::stack_model_group($space, $defs, $vals);
			} else {
				//$key="var", $val="", $space="general", $type="s"
				self::stack_model_single($defs, $vals, $space, $type);
			}
		}
		
		
		/*
		static public function stack_model($space, $key, $val) {

			if (!isset(self::$loops[$space])) self::$loops[$space] = 0;
			self::$loops[$space]++;

			if (!isset(self::$obj_models[$space])) {
				self::$obj_models[$space] = array();
			}
			if ((!is_array($val)) && (!is_array($key))) {
				self::$obj_models[$space][$key] = $val;
			} else {
				foreach ($val as $i => $value) {
					//
					foreach ($key as $ik => $kvalue) {
						//var_dump($space.".".$kvalue."=".$val[$ik]);
						self::$obj_models[$space][] = Array($kvalue => $val[$ik]);
					}

				}
			}
		}
		*/
		
		static public function get_model($space, $key) {
			return self::$obj_models[$space][$key];
		}
		public static function parse($from='', $ret_type='render', $filter="", $to="", $display_type="html", $display_mode="replace_inner", $use_models=true,  $recursion_level=0) {
			// prevent infinit recursions
			require PATH."core/queue/parser/recursion-safe.php";			

			$this_output = "";
			$stack = array();

			// start output buffer
			if (!Config::DEBUG) ob_start();
		
			// get view as filename, url or data
			require PATH."core/queue/parser/fetch-type.php";

			foreach ($stack as $this_output) {

				if ($use_models) {

					// Include Models block parser (simple and groups)
					require PATH."core/queue/parser/models-group.php";

					// Include Models input
					require PATH."core/queue/parser/models-setter.php";
			
					// process if statements
					require PATH."core/queue/parser/if.php";
					
					// process includes, legacy, to remove or not to remove... dun dun duuuuuuuuun
					//require "parser/include.php";

				}

				// get source HTML
				$place_me = $this_output;
				if ( ($this_output != "") && ($filter != "") ) {
					$fetch = \phpQuery::newDocumentHTML($this_output);
					$place_me = $fetch[$filter];
				}
				// set destination HTML
				$destination = \phpQuery::newDocumentHTML(self::$complete_output);
				if ($to == "") {
					self::$complete_output = $place_me;
				} else {		
					// replace_inner, prepend, append, replace, replace_inner
					switch ($display_mode) {
						case "prepend":
							if ($display_type == "html") {
								$destination[$to]->prepend($place_me);
							} else {
								$destination[$to]->prepend(htmlentities($place_me));
							}
							break;
						case "append":
							if ($display_type == "html") {
								$destination[$to]->append($place_me);
							} else {
								$destination[$to]->append(htmlentities($place_me));
							}
							break;
						case "replace":
							if ($display_type == "html") {
								$destination[$to]->replaceWith($place_me);
							} else {
								$destination[$to]->replaceWith(htmlentities($place_me));
							}
							break;
						default: // replace_inner
							if ($display_type == "html") {
								$destination[$to]->html($place_me);
							} else {
								$destination[$to]->text($place_me);
							}
					}
					self::$complete_output = $destination;
				}
			}
		}

		public static function output() {
			// get current output
			return self::$complete_output;
		}

		/* Main process thread */
		public function process() {

			// validate and assign priorities to controllers
			$priority_controllers = array();

			// ensure all unit tests pass when debugging
			if (Config::DEBUG) {
				$unit_tests_failed = false;
				foreach ($this->obj_controllers as $cname => $controller) {
					if (method_exists($controller, 'test')) {
						$do_unit_test = $controller->test();

						if (!$controller->unit_tests_passed()) {
							$unit_tests_failed = true;
						}
					}
				}

				if ($unit_tests_failed) die(); // logging happens in controllers
			}

			// ensure controllers validate when a validation function is found
			foreach ($this->obj_controllers as $cname => $controller) {
				if (method_exists($controller, 'validate')) {
					$validator_priority = $controller->validate();
					if ($validator_priority !== false) {
						// when controller validates
						if (!is_numeric($validator_priority)) $validator_priority = 0; // when priority isn't numeric assign zero value
						$priority_controllers[$cname] = $validator_priority;	// assign priority to unique class name
					}
				}
			}


			// sort controllers by highest priority to lowest
			uasort($priority_controllers, 'Wizard\Build\Tools::prioritySorter');

			// index of controllers
			$controller_index = 0;
			$output_buffer = '';
			
			foreach ($priority_controllers as $cname => $priority) {

				// find controller of class name
				$controller = $this->obj_controllers[$cname];
				$controller->index = $controller_index;
				$controller_index++;

				// execute if executable is found
				if (method_exists($controller, 'execute')) $controller->execute();
			}

			echo self::output();

		}
	
	}
	// Run Core
	$core = new Queue();
	$core->process();
?>
