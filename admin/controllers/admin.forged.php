<?php

	class admin_forged extends Controller {
		
		function validate() {
			if (q('admin/forged') && $this->user->isAdmin())
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
			
			
			$ret = $db::loadIdHas('page.trigger.url');
			$forged = array();
			if ($ret) {
				foreach($ret as $id) {
					$row = $db::loadById($id);
					foreach ($row as $k => $v) {
						if ($v['var']=='page.trigger.url') {
							$row['id'] = $v['id'];
							$row['url'] = $v['value'];
						}
						if ($v['var']=='page.content.title') {
							$row['title'] = $v['value'];
						}
						if ($v['var']=='page.tags') {
							$row['tags'] = $v['value'];
						}
					}
					$forged[] = $row;
				}
			}
			$this->addModel('forged', $forged);

			/*************************************************/
			
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