<?php

	namespace Wizard\Build;

	// chainable class
	class Model {
		public function __construct ($key="var", $val="", $space="general", $type="s") {	// Define group of (type)
			//stack_model_single($space, $key, $val, $type)
			Queue::stack_model_single($space, $key, $val, $type);
			return $this;
		}
	}
