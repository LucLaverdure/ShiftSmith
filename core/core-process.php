<?php
	if (!IN_SHIFTSMITH) die();

	global $global_models,$main_path;
	$global_models = array();

	include_once($main_path.'core/phpQuery/phpQuery-onefile.php');
	
	
	class Core {

		private $obj_controllers; // Controllers Found
		
		private function endsWith($haystack, $needle) {
			$length = strlen($needle);
			if ($length == 0) {
				return true;
			}

			return (substr($haystack, -$length) === $needle);
		}
		
		private function getDirContents($dir, &$results = array()){
			$files = scandir($dir);

			foreach($files as $key => $value){
				$path = realpath($dir.DIRECTORY_SEPARATOR.$value);
				if(!is_dir($path)) {
					// on file check for allowed config extensions
					$allowed_extensions = explode(',', FILE_FILTER_CONTROLLERS);
					$allowed = false;
					foreach($allowed_extensions as $ext) {
						if ($this->endsWith($path, $ext)) {
							$allowed = true;
						}
					}
					// when allowed, add to array of controller pattern
					if ($allowed) $results[] = $path;
				} else if($value != "." && $value != "..") {
					// on directory, browse
					$this->getDirContents($path, $results);
				}
			}

			return $results;
		}

		
		public function __construct() {
			global $main_path;
			
			// Get php's core declared classes count
			$system_classes_count = count(get_declared_classes());
			$system_classes = get_declared_classes();
			
			$paths_to_load = array();
			// search for all files within the webapp directory
			
			$initial_dirs = explode(',', SEARCH_DIRECTORY_CONTROLLERS);
			
			foreach ($initial_dirs as $dir) {
				$paths_to_load[] = $this->getDirContents($dir);
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
				if (in_array('Controller', class_parents($class))) {
					$this->obj_controllers[$class] = new $class;
				}
			}

		}

		// Views and subviews process
		public function process_view(&$controller, $view, $recursion_level = 0, $mode = 'append') {
			// global models, shared across all controllers
			global $global_models;
			
			// prevent infinite recursions
			if ($recursion_level > 999999)
				die("Template ".$filename." surpasses maximum recursion level. (Prevented infinite loop from crashing server)");
			
			
			// start output buffer
			ob_start();

			// view is string or file
			$view_output = ""; 
			if (substr($view, 0, 4 )=='http') {
				$view_output = @file_get_contents($view);
			} else if (file_exists("admin/views/".$view)) {
				$view_output = @file_get_contents("admin/views/".$view);
			} else if (file_exists("webapp/views/".$view)) {
				$view_output = @file_get_contents("webapp/views/".$view);
			} else {
				// when view is a file, fetch content
				$view_output = $view;
			}
	
			/* process subview arrays, syntax: 
			[for:blocks]
				[blocks.x]
				[blocks.y]
				[blocks.z]
				[blocks.t]
			[end:blocks]
			*/
			// process shared models (variables)
			foreach ($global_models as $var => $data) {
				// when model data is an array
				if (is_array($data)) {
					// fetch for blocks and render loops
					$forblocks = array();
					preg_match_all('/(?<block>\[for:'.$var.'\](?<content>[\s\S]+)\[end:'.$var.'\])/ix', $view_output, $forblocks, PREG_SET_ORDER);
					if (count($forblocks)) {
						foreach ($forblocks as $foundForBlock) {
							$foreach_data = '';
							foreach ($data as $row) {
								// set model values within the loop, ex: blocks.x value
								$block_content = $foundForBlock['content'];
								foreach ($row as $subvar => $value) {
									if (!is_array($value)) {
										$block_content = str_replace('['.$var.'.'.$subvar.']', $value, $block_content);
									}
								}
								// append the parsed new block (of for loop) as processed view to render (ifs and setters for example)
								$foreach_data .=  $this->process_view($controller, $block_content, $recursion_level + 1);
							}
							$view_output = str_replace($foundForBlock['block'], $foreach_data, $view_output);
						}
					}

				} else {
					// simple model, replace model with value ex: "[stats.x]" by "18"
					$view_output = str_replace('['.$var.']', $data, $view_output);
				}
			}

			/* process model setters, ex: [set:stats.x]18[endset] */
			$setvars = array();
			preg_match_all('~(?<block>\[set:(?<set_body>[^\[]+)\](?<set_content>[^\[.]+)\[endset\])~i', $view_output, $setvars, PREG_SET_ORDER);
			if (count($setvars) > 0) {
				foreach ($setvars as $key => $found) {
					if (isset($found['set_body']) && trim($found['set_body'])!='') {
						if (trim($found['set_content'])=='++') {
							// when setter is ++ increment value of model
							$controller->addModel(trim($found['set_body']), ((int)trim($controller->getModel(trim($found['set_body']))))+1);
							$global_models[trim($found['set_body'])] = ((int)trim($controller->getModel(trim($found['set_body']))))+1;
						} else {
							// otherwise, set value of model to content body
							$controller->addModel(trim($found['set_body']), $found['set_content']);
							$global_models[trim($found['set_body'])] = $found['set_content'];
						}
						// remove found block from output as model has been processed
						$view_output = str_replace($found['block'], '', $view_output);
						// re-render models as new models were added.
						$view_output = $this->process_view($controller, $view_output, $recursion_level + 1);
					} elseif(isset($found['set_body'])) {
						$controller->addModel(trim($found['set_body']), '');
						$global_models[trim($found['set_body'])] = '';
						// re-render models as new models were added.
						$view_output = $this->process_view($controller, $view_output, $recursion_level + 1);
					}
				}
			}
			
			// process if statements
			$ifsfound = array();
		    preg_match_all('~(?<block>\[if:(?<if_body>[^\]]+)\](?<body>.+)\[endif\])~siU', $view_output, $ifsfound, PREG_SET_ORDER);
			if (count($ifsfound) > 0) {
				foreach ($ifsfound as $found) {
					$eval_code = 'return ('.$found['if_body'].');';

					// MUST REMOVE EVAL - INPUT DANGER					
					if (eval($eval_code)) {
						//valid if statement
						$view_output = str_replace($found['block'], $found['body'], $view_output);
						// re-render everything within valid if statement
						$view_output = $this->process_view($controller, $view_output, $recursion_level + 1);
					} else {
						// invalid if statement, erase it from view output
						$view_output = str_replace($found['block'], '', $view_output);
					}
				}
			}
			
			// process translations, syntax: t[text]
			$matches = array();
			preg_match_all('/t\[[^\[]*[^\\\]\]/i', $view_output, $matches);
			foreach ($matches as $found_a) {
				foreach ($found_a as $found) {
					$translate = substr($found, 2, -1);
					$view_output = str_replace($found, t($translate), $view_output);
				}
			}



			
			// process subview paths, syntax: [filename]
			$matches = array();
			preg_match_all('/\[[^\[]*[^\\\]\]/i', $view_output, $matches);
			foreach ($matches as $found_a) {
				foreach ($found_a as $found) {
					$filename = trim(substr($found, 1, -1));
					if (substr($filename, 0, 4)=='http') {
						// file is a web fetch
						$view_output = str_replace($found, $this->process_view($controller, $filename, $recursion_level+1), $view_output);
					} else if (file_exists("admin/views/".$filename)) {
						// file is an admin file
						$view_output = str_replace($found, $this->process_view($controller, $filename, $recursion_level+1), $view_output);
					} else if (file_exists("webapp/views/".$filename)) {
						// file is an webapp file
						$view_output = str_replace($found, $this->process_view($controller, $filename, $recursion_level+1), $view_output);
					}
				}
			}

			return $view_output;

		}

		/* Main process thread */
		public function process() {
			global $docX;
			global $global_models;
			global $view_complete_output;
			// validate and assign priorities to controllers
			$priority_controllers = array();
			foreach ($this->obj_controllers as $cname => $controller) {
				// ensure controller validates when a validation function is found
				if (method_exists($controller, 'validate')) {
					$validator_priority = $controller->validate();
					if ($validator_priority !== false) {
						// when controller validates
						if (!is_numeric($validator_priority)) $validator_priority = 0; // when priority isn't numeric assign zero value
						$priority_controllers[$cname] = $validator_priority;	// assign priority to unique class name
					}
				}
			}

			function prioritySorter($a, $b) {
				if ($a == $b) return 0;
				return ($a > $b) ? -1 : 1;
			}

			// sort controllers by highest priority to lowest
			uasort($priority_controllers, 'prioritySorter');

			// index of controllers
			$controller_index=0;
			
			$output_buffer = '';
			$injections = array();
			
			foreach ($priority_controllers as $cname => $priority) {
				
				// find controller of class name
				$controller = $this->obj_controllers[$cname];
				$controller->index = $controller_index;
				$controller_index++;

				// execute if executable is found
				if (method_exists($controller, 'execute')) $controller->execute();

				// add models to shared models
				foreach ($controller->models as $key => $model) {
					$global_models[$key] = $model;
				}
				
				// render each view of controller
				$view_complete_output .= '';
				foreach($controller->views as $view) {
					$view_complete_output .= $this->process_view($controller, $view); 
					$output_buffer .= $view_complete_output;
				}

				// re-add models to shared models
				foreach ($controller->models as $key => $model) {
					$global_models[$key] = $model;
				}
				
				foreach($controller->injected_views as $injected_view) {
					$injections[] = $injected_view;
				}
			}
			
			$docX = phpQuery::newDocument($output_buffer);
			
			foreach($injections as $injected_view) {
				$selector = $injected_view[0];
				$mode = $injected_view[1];
				$view_filename = $injected_view[2];
				$selector_after_fetch = $injected_view[3];
				
				$injected_html = '';
				if ((trim($selector_after_fetch) != '') && (trim($selector_after_fetch) != "0")) {
					$docZ = phpQuery::newDocument(@file_get_contents($view_filename));
					$injected_html = $docZ[$selector_after_fetch]->html();
				} else {
					$injected_html = $view_filename;
				}
				switch ($mode) {
					case 'append':
						$docX[$selector]->append($injected_html);
						break;
					case 'prepend':
						$docX[$selector]->prepend($injected_html);
						break;
					case 'replace':
						$docX[$selector]->html($injected_html);
						break;
				}

			}
			
			echo $docX->getDocument();
		}
		
	}
	

	// Run Core
	global $core;
	$core = new Core();
	$core->process();
?>