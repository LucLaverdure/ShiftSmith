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

			$this->setModel('prompt', 'message', '');
			$this->setModel('prompt', 'error', '');
			
			// get all triggers
			
			$data = $db::queryResults("SELECT s.id, s.value title, (SELECT sub.value FROM shiftsmith sub WHERE sub.id=s.id AND sub.`key`='url' AND sub.`namespace` = 'trigger' ORDER BY sub.id DESC LIMIT 1) url, GROUP_CONCAT(DISTINCT ss.value SEPARATOR ', ') tags
			FROM shiftsmith s
			INNER JOIN shiftsmith ss
				ON ss.id=s.id AND ss.`key`='tag' AND ss.`namespace`='trigger'
			WHERE s.`key` IN ('title')
				AND s.`namespace` IN ('content')
			GROUP BY s.id
			ORDER BY s.id DESC");

			if ($data != false) {
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