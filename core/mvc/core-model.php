<?php

	namespace Wizard\Build;

	// chainable class
	class Model {
		public function __construct ($key="var", $val="", $space="general", $type="s") {	// Define group of (type)
			Queue::stack($key, $val, $space, $type);
			return $this;
		}
	}
