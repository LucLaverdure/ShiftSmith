<?php

	namespace Wizard\Build;

	// Core Controller class for all controller objects to extend
	class Controller {
		// unit tests results
		private $unit_tests = array();

		// Unit Testing
		public function passed($log) {
			// log success test
			$this->note($log);
			$this->unit_tests[] = true;
		}
		public function failed($log) {
			// log failed test
			$this->note($log);
			$this->unit_tests[] = false;
		}

		public function unit_tests_passed() {
			if (count($this->unit_tests) > 0) {
				if (in_array(false, $this->unit_tests)) {
					return false;
				}
			}
			return true;
		}

		// MVC shortcuts
		public function View() {
			return new \Wizard\Build\View();
		}
		//__construct($var, $val, $id=null, $parent_id=null, $namespace="general")
		public function Model($var, $val, $id=null, $parent_id=null, $namespace="general") {
			return new \Wizard\Build\Model($var, $val, $id, $parent_id, $namespace);
		}
		public function Group() {
			return new \Wizard\Build\Group();
		}

		// Misc Shortcuts
		public function note($log) {
			\Wizard\Build\Tools::note($log);
		}
		public function q($arg) {
			\Wizard\Build\Tools::queryURL($arg);
		}
		public function a($arg) {
			\Wizard\Build\Tools::access($arg);
		}

	}
