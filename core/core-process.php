<?php
	if (!IN_DREAMFORGERY) die();

	// TODO: Must preprocess models to be shared accross all controllers with scope priority of local controller override
	
	class Core {

		private $obj_controllers; // Controllers Found

		public function __construct() {

			// Get php's core declared classes count
			$system_classes_count = count(get_declared_classes());
			$system_classes = get_declared_classes();
			
			// search for all files within the webapp directory
			$it = new RecursiveDirectoryIterator("webapp");	//start at webapp level
			$webapp_files = Array('php');	//search for all php files
			foreach(new RecursiveIteratorIterator($it) as $file) {
				// when filename ends with webapp_files extension, include the file
				if (in_array(substr($file, strpos($file, '.' ) + 1 ), $webapp_files) == true) {
					include $file;
				}
			}

			// Remove all classes of php's core to identify webapp classes
			$custom_classes = array_slice(get_declared_classes(), $system_classes_count);

			// Instantiate each controller found (identified by class extended of Controller)
			foreach($custom_classes as $class) {
				if (in_array('Controller', class_parents($class))) {
					$this->obj_controllers[$class] = new $class;
				}
			}

		}

		// Views and subviews process
		public function process_view(&$controller, $view, $recursion_level = 0) {
			// prevent infinite recursions
			if ($recursion_level > 999999)
				die("Template ".$filename." surpasses maximum recursion level. (Prevented infinite loop from crashing server)");

			// start template engine
			$this->template = new Template_Engine();
			$this->template->set_template();

			// start output buffer
			ob_start();
			
			/* Assign Primary model values */
			// assign model values to template
			$vars = array();
			foreach ($controller->models as $key => $model) {
				if (is_array($model)) {
					foreach ($model as $subkey => $data) {
						if (is_array($data)) {
							$this->template->assign_block_vars($key, $data);
						}
					}
				} else {
					$vars[$key] = $model;
				}
			}

			$this->template->assign_vars($vars);

			$this->template->set_filenames(array('main' => $view));
			$this->template->display('main');
			$view_output = ob_get_clean();


			// process subview variables, syntax: [variable_name]
			foreach (Controller::$subviews as $var => $data) {
				if ($data['view'] == $view || $data['view'] == '=all') {
					if (strpos($view_output, $data['view']) !== false) {
						$view_output = str_replace('['.$var.']', process_view($controller, $data['view'], $recursion_level+1), $view_output);
					}

				}
			}

			// process translations, syntax: t[text]
			preg_match_all('/t\[[^\[]*[^\\\]\]/i', $view_output, $matches);
			foreach ($matches as $found_a) {
				foreach ($found_a as $found) {
					$translate = substr($found, 2, -1);
					$view_output = str_replace($found, t($translate), $view_output);
				}
			}

			// process subview paths, syntax: include[filename] or [filename]
			preg_match_all('/include\[[^\[]*[^\\\]\]/i', $view_output, $matches);
			foreach ($matches as $found_a) {
				foreach ($found_a as $found) {
					$filename = trim(substr($found, 8, -1));
					if (file_exists(PATH.'webapp/views/'.$filename)) {
						$view_output = str_replace($found, $this->process_view($controller, $filename, $recursion_level+1), $view_output);
					}
				}
			}
			preg_match_all('/\[[^\[]*[^\\\]\]/i', $view_output, $matches);
			foreach ($matches as $found_a) {
				foreach ($found_a as $found) {
					$filename = trim(substr($found, 1, -1));
					if (file_exists(PATH.'webapp/views/'.$filename)) {
						$view_output = str_replace($found, $this->process_view($controller, $filename, $recursion_level+1), $view_output);
					}
				}
			}

			return $view_output;

		}

		/* Main process thread */
		public function process() {
		
			// validate and assign priorities to controllers
			$priority_controllers = array();
			foreach ($this->obj_controllers as $cname => $controller) {
				// ensure controller validates when a validation function is found
				if (method_exists($controller, 'validate')) {
					$validator_priority = $controller->validate();
					if ($validator_priority !== false) {
						// when controller validates
						if (!is_numeric($validator_priority)) $validator_priority = 0; // when priority isn't numeric assign zero value
						$priority_controllers[] = array($validator_priority, $cname);	// assign priority to unique class name
					}
				}
			}

			// sort controllers by highest priority to lowest
			usort($priority_controllers, array('Core', 'prioritySort'));
			
			foreach ($priority_controllers as $this_priority_controller) {
				$priority = $this_priority_controller[0];
				$cname = $this_priority_controller[1];
				// find controller of class name
				$controller = $this->obj_controllers[$cname];
				
				// execute if executable is found
				if (method_exists($controller, 'execute')) $controller->execute();
				
				// render each view of controller
				foreach($controller->views as $view) {
					echo $this->process_view($controller, $view); 
				}
			}
			
		}
		
		private static function prioritySort($a, $b) {
			if ($a[0] == $b[0]) {
				return 0;
			}
			return ($a[0] < $b[0]) ? -1 : 1;
		}
	}

	// Run Core
	global $core;
	$core = new Core();
	$core->process();
?>