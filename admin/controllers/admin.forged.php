<?php

	class admin_forged extends Controller {
		
		function validate() {
			if (q('0')=='admin' && q(1) == 'forged' && isset($_SESSION['login']))
				return 1;
			else
				return false;

		}
		
		function execute() {
			global $main_path;

			$db = new Database();
			$db::connect();

			// get all triggers
			
			$data = $db::queryResults("SELECT id, value title, (SELECT value FROM shiftsmith WHERE id=s.id AND `key`='url' AND `namespace` = 'trigger') url
			FROM shiftsmith s
			WHERE `key` IN ('title')
				AND `namespace` IN ('content')
			GROUP BY id
			ORDER BY id DESC");

			if ($data) {
				$this->addModel('forged', $data);
			} else {
				$this->addModel('forged', array());
			}

			$classes_compiled = array();
			$custom_classes = get_declared_classes();
			foreach($custom_classes as $class) {
				if (in_array('Controller', class_parents($class))) {
					$classE = new ReflectionClass($class);
					$filename = $classE->getFileName();
					$filename = str_replace(realpath($main_path)."/", '', $filename);
					$classes_compiled[] = array('name' => $class, 'filename'=> $filename);
				}
			}
			$this->addModel('forgedfile', $classes_compiled);
			
			$this->loadView('admin.forged.tpl');
		}
	}

?>