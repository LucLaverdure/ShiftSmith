<?php

	namespace Wizard\Build;

	// chainable class
	class Model {

		private $space = "general";
		private $key = "var";
		private $val = "";
		private $id = null;
		private $ui = "textbox";

		public function get() {
			// get active data
			return $this->val;
		}

		public function val() {
			// get active data
			return $this->get();
		}

		public function key() {
			// get active data
			return $this->key;
		}

		public function space() {
			// get active data
			return $this->space;
		}

		public function set($key="var", $val="", $space="general", $id=null, $parent_id=null) {	// Define group of (type)
			// set manually

			if ($id == null) {
				// Check that ID doesn't exist
				while (($id == null) || (Queue::id_exists($id)) ) {
					$id = md5(mt_rand(0, 999999));
				}
			}

			$this->space = $space;
			$this->key = $key;
			$this->val = $val;
			$this->id = $id;
			$this->parent_id = $parent_id;
			
			Queue::stack_model($this->id, $this);

			return $this;
		}
		//set($key="var", $val="", $space="general", $id=null, $parent_id=null) {	// Define group of (type)
		public function __construct($key="var", $val="", $space="general", $id=null, $parent_id=null) {	// Define group of (type)
			$this->set($key, $val, $space, $id, $parent_id); 
		}

		public function setUI($ui_type="textbox") {
			// set UI render type for forms
			$this->ui = $ui_type;
			return $this;
		}

		public function load($query, $args) {
			// load from database
			return $this;
		}

		public function save() {
			// save id, namespace, name, val & UI to DB
			return $this;
		}

	}
