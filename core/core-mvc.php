<?php
	if (!IN_DREAMFORGERY) die();

	// Core Controller class for all controller objects to extend
	class Controller {
		public $models = array();
		public $views = array();
		public $injected_views = array();
		public static $subviews = array();
		public $index;
		public $user;
		public $db;
		
		// Add model data directly
		/*
			usage: addModel('form1', 'title', 'mytitle') // with namespace
			or
			usage: addModel('title', 'mytitle') // no namespace //deprecated
		*/
		
		function __construct() {
			// setup user helper class
			$this->user = new User();
			
			// setup database helper class
			$this->db = new Database();
			$this->db::connect();
		}

		function addModel($nameOrNamespace, $dataOrName, $data=null) {
			if ($data == null) {
				if (in_array($nameOrNamespace, explode(',',PROTECTED_UNIT))) return;
					//throw new Exception ('Invalid model name: '.$form_name.' reserved for server-side access');
				
				$this->models[$nameOrNamespace] = $dataOrName;
			}
			if (in_array($dataOrName, explode(',',PROTECTED_UNIT))) return;
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
			usage: getModel('title') // no namespace //deprecated
		*/
		function getModel($nameOrNamespace, $name=null) {
			if ($name == null)
				return $this->models[$nameOrNamespace];
			
			return $this->models[$nameOrNamespace.'.'.$name];
		}
		
		// Load model from a controller
		function loadModel($varOrNamespace, $varOrController, $controller=null) {
			if ($model == null) {
				if (in_array($varOrNamespace, explode(',',PROTECTED_UNIT))) return;
					//throw new Exception ('Invalid model name: '.$form_name.' reserved for server-side access');
				$model = new $varOrNamespace;
				$this->models[$varOrNamespace] = $varOrController->execute();
			}
			if (in_array($controller, explode(',',PROTECTED_UNIT))) return;
				//throw new Exception ('Invalid model name: '.$form_name.' reserved for server-side access');
			$model = new $controller;
			$this->models[$varOrNamespace.'.'.$varOrController] = $controller->execute();
			
		}

		// Save & Load form data into cache
		function cacheForm($name = 'page', $default_values = array(), $forcecache = 'N') {
			$cache_vars = form_cache($name, $default_values, $forcecache);
			
			// skip protected namespaces
			
			foreach ($cache_vars as $var => $value) {
				$this->addModel($name.'.'.$var, $value);
			}
		}

		// save form data to database
		function saveForm($id='new', $acceptedNamespaces = array('content', 'trigger', 'page')) {
			
			// get database
			$db = new Database();
			$db::connect();

			// initialize db structure and get new id
			$init_shift = $db::getShift();
			
			// cache info 
			$this->cacheForm();

			// delete previous data
			if (is_numeric($init_shift) & isset($init_shift)) {
				$id = (int) $init_shift;
				$del_sql = "DELETE FROM `shiftsmith` WHERE `id`=".$id;
				$shiftroot = $db::query($del_sql);
			}
			
			
			$sql = array();
			
			foreach ($this->models as $key => $value) {
				$key_explosion = explode('.', $key);
				$forekey = array_shift($key_explosion);
				if (!in_array($forekey, explode(',', PROTECTED_UNIT))) {
					$sql[] = "(".$init_shift.", '".$db::param($forekey)."' , '".$db::param(implode('.', $key_explosion))."', '".$db::param($value)."')";
				}
			
			}
			
			//save new data

			$fullQuery = "INSERT INTO shiftsmith (`id`, `namespace`, `key`, `value`) VALUES ".implode(', ', $sql);
			
			$shiftroot = $db::query($fullQuery);
		}
		
		
		/*
		function clearCache() {
			foreach ($_SESSION as $key => cache) {
				if (!in_array($key, explode(',', PROTECTED_UNIT))) {
					unset($_SESSION[$key]);
				}
			}
		}
		*/
		
		// loadById - load information from the db for a single item. // ignore protected values
		function loadById($id) {
			// ensure id is numeric
			$id = (int) $id;
			
			// fetch all id related models
			$data = $db::queryResults("SELECT `namespace`, `key`, `value`
										FROM shiftsmith
										WHERE id=".$id."
										ORDER BY `namespace`, `key`;");
										
			foreach ($data as $value) {
				if (!in_array($value['namespace'], explode(',', PROTECTED_UNIT))) {
					if (!in_array($value['key'], explode(',', PROTECTED_UNIT))) {
						$this->setModel($value['namespace'], $value['key'], $value['value']);
					}
				}
			}		
		}
			
		
		// secure single property storage not accessible with formcache nor models
		function setcache($namespace, $name, $value) {
			// only admin access (configurable)
			if (in_array($namespace, explode(',',PROTECTED_UNIT))) {
				// set form array if not created
				if (!isset($_SESSION[$namespace])) $_SESSION[$namespace] = array();
				
				// store cashe
				$_SESSION[trim($namespace)][$name] = $value;
			}
		}

		// secure single property fetch not accessible with formcache nor models
		function getcache($namespace, $name) {
			// only admin access (configurable)
			if (in_array($namespace, explode(',',PROTECTED_UNIT))) {
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


		// inject resource
		function injectView($selector_destination, $mode, $view_filename, $selector_after_fetch) {
			if (in_array($mode, array('prepend', 'append', 'replace', 'outer-replace'))) {
				switch (substr($view_filename,-3, 4)) {
					case '.js':
						$this->injected_views[] = array($selector_destination, $mode, '<script src="'+$view_filename+'" type="text/javascript">', $selector_after_fetch);
						break;
					case 'css':
						$this->injected_views[] = array($selector_destination, $mode, '<link rel="stylesheet" type="text/css" href="'+$view_filename+'">', $selector_after_fetch);
						break;
					default:
							$this->injected_views[] = array($selector_destination, $mode, $view_filename, $selector_after_fetch);
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