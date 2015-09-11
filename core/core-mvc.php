<?php
	if (!IN_DREAMFORGERY) die();

	// Core Controller class for all controller objects to extend
	class Controller {
		public $models = array();
		public $views = array();
		public static $subviews = array();

		// Add model data directly
		function addModel($name, $data, $type='private') {
			$this->models[$name] = $data;
		}

		// Load model from a class
		function loadModel($name, $type='private') {
			$model = new $name;

			$this->models[$name] = $model->execute();
		}

		// Load view template from filename
		function loadView($view_filename) {
			if (is_array($view_filename)) {
				foreach($view_filename as $filename)
					$this->views[$filename] = $filename;
			} else {
				$this->views[$view_filename] = $view_filename;
			}
		}

		// Save & Load form data into cache
		function cacheForm($name, $default_values = array()) {
			$cache_vars = form_cache($name, $default_values);
			foreach ($cache_vars as $var => $value) {
				$this->addModel($var, $value);
			}
		}

	}

	// Core Model class for all model objects to extend
	class Model {
		function loadFile($view_filename) {
			global $mainpath;
			return file_get_contents($mainpath.'webapp/views/'.$view_filename);
		}

	}

?>