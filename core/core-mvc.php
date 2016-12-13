<?php
	if (!IN_DREAMFORGERY) die();

	// Core Controller class for all controller objects to extend
	class Controller {
		public $models = array();
		public $views = array();
		public $injected_views = array();
		public static $subviews = array();
		public $index;
		
		// Add model data directly
		/*
			usage: addModel('form1', 'title', 'mytitle') // with namespace
			or
			usage: addModel('title', 'mytitle') // no namespace
		*/
		function addModel($nameOrNamespace, $dataOrName, $data=null) {
			if ($data == null) {
				if (in_array($nameOrNamespace, explode(',',PROTECTED_VARIABLES))) return;
					//throw new Exception ('Invalid model name: '.$form_name.' reserved for server-side access');
				
				$this->models[$nameOrNamespace] = $dataOrName;
			}
			if (in_array($dataOrName, explode(',',PROTECTED_VARIABLES))) return;
				//throw new Exception ('Invalid model name: '.$form_name.' reserved for server-side access');
			try {
				if (is_array($dataOrName)) {
					foreach ($dataOrName as $key => $val) {
						$this->models[$nameOrNamespace.'.'.$key] = $val;
					}
				} else {
					$this->models[$nameOrNamespace.'.'.$dataOrName] = $data;
				}
			} catch (Exception $e) {var_dump($e);}
		}
		function setModel($nameOrNamespace, $dataOrName, $data=null) {
			$this->addModel($nameOrNamespace, $dataOrName, $data);
		}
		function modResultsModel(&$results, $keys, $function, $new_col=null) {
			if ($new_col==null) $newcol=$keys;
			if (is_array($results)) {
				foreach ($results as $key_row => $row) {
					foreach ($row as $key => $data) {
						if ((is_array($keys) && in_array($key, $keys)) || (!is_array($keys) && $keys == $key)) {
							$results[$key_row][$new_col] = $function($data);
						}
					}
				}
			}
		}
		// get model usually variable
		/*
			usage: getModel('form1', 'title') // with namespace
			or
			usage: getModel('title') // no namespace
		*/
		function getModel($nameOrNamespace, $name=null) {
			if ($name == null)
				return $this->models[$nameOrNamespace];
			
			return $this->models[$nameOrNamespace.'.'.$name];
		}
		
		// Load model from a controller
		function loadModel($varOrNamespace, $varOrController, $controller=null) {
			if ($model == null) {
				if (in_array($varOrNamespace, explode(',',PROTECTED_VARIABLES))) return;
					//throw new Exception ('Invalid model name: '.$form_name.' reserved for server-side access');
				$model = new $varOrNamespace;
				$this->models[$varOrNamespace] = $varOrController->execute();
			}
			if (in_array($controller, explode(',',PROTECTED_VARIABLES))) return;
				//throw new Exception ('Invalid model name: '.$form_name.' reserved for server-side access');
			$model = new $controller;
			$this->models[$varOrNamespace.'.'.$varOrController] = $controller->execute();
			
		}

		// Save & Load form data into cache
		function cacheForm($name, $default_values = array(), $forcecache='N') {
			$cache_vars = form_cache($name, $default_values, $forcecache);
			foreach ($cache_vars as $var => $value) {
				$this->addModel($name.'.'.$var, $value);
			}
		}

		// secure single property storage not accessible with formcache nor models
		function setcache($namespace, $name, $value) {
			// only admin access (configurable)
			if (in_array($namespace, explode(',',PROTECTED_SESSION_NAMESPACES))) {
				// set form array if not created
				if (!isset($_SESSION[$namespace])) $_SESSION[$namespace] = array();
				
				// store cashe
				$_SESSION[trim($namespace)][$name] = $value;
			}
		}

		// secure single property fetch not accessible with formcache nor models
		function getcache($namespace, $name) {
			// only admin access (configurable)
			if (in_array($namespace, explode(',',PROTECTED_SESSION_NAMESPACES))) {
				// set form array if not created
				if (!isset($_SESSION[$namespace])) return '';
				if (!isset($_SESSION[$namespace][$name])) return '';
				// store cashe
				return $_SESSION[trim($namespace)][$name];
			}
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

		// Load view template from filename
		/*
		function injectView($selector, $mode, $view_filename) {
			if (in_array($mode, array('prepend', 'append', 'replace', 'outer-replace'))) {
				$this->injected_views[] = array($selector, $mode, $view_filename);
			}
		}
		*/

		// inject resource
		function injectView($selector, $mode, $view_filename) {
			if (in_array($mode, array('prepend', 'append', 'replace', 'outer-replace'))) {
				switch (substr($view_filename,-3, 4)) {
					case '.js':
						$this->injected_views[] = array($view_filename, '<script src="'+$resource+'" type="text/javascript">', $mode);
						break;
					case 'css':
						$this->injected_views[] = array($view_filename, '<link rel="stylesheet" type="text/css" href="'+$resource+'">', $mode);
						break;
					default:
							$this->injected_views[] = array($selector, $mode, $view_filename);
					break;
				}
			}
		}
			
		
		function loadViewAsJSON($omitted_namespaces, $ommited_models) {
			$JSON = array();
			foreach ($this->models as $modelOrNamespace => $thisJSON) {
				if (!in_array($modelOrNamespace, $ommited_models) && !is_array($thisJSON)) {
					$JSON[$modelOrNamespace] = $thisJSON;
				} elseif (is_array($thisJSON) && !in_array($modelOrNamespace, $ommited_namespaces)) {
					$block = array();
					foreach ($thisJSON as $namespace => $model) {
						if (!in_array($namespace, $ommited_models)) {
							$block[$namespace] = $model;
						}
					}
					$JSON[$modelOrNamespace] = $block;
				}
			}
			echo json_encode($JSON);
		}
		function loadJSON() {
			$this->loadViewAsJSON();
		}
	}

?>