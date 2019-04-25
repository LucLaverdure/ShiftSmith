<?php

	namespace Wizard\Build;

	// chainable class
	class Model {
		public function __construct ($key="var", $val="", $space="general") {	// Define group of (type)
			Queue::stack_model($space, $key, $val);
			return $this;
		}
		
		public function set($key="var", $val="", $space="general") {	// Define group of (type)
			Queue::stack_model($space, $key, $val);
			return $this;
		}

	}
