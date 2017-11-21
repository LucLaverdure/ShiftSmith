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
			$db->connect();

			switch (input("action")) {
				case "del":
					$items = input("chkItem");
					$todel = array();
					if ($items != "") {
						foreach ($items as $item) {
							$todel[] = (int) $item;
						}
						if (count($todel) > 0) {
							$del_query = "DELETE FROM shiftsmith WHERE `id` IN (".implode(',', $todel).");";
							$this->db->query($del_query);
						}
					}
					break;
			}

			$this->setModel('prompt', 'message', '');
			$this->setModel('prompt', 'error', '');

			$res = $db->querykvp();
			
			$forged = array();
			if ($res) {
				foreach ($res as $data) {
					$row = array();
					$tags = array();
					$edit = '';
					$trigger_url = "N/A";
					foreach ($data as $key => $val) {
						if (strrpos ($key, 'tags.name') !== false) {
							$tags[] = $val;
							if (in_array($val, array('page', 'block', 'post', 'sale', 'form', 'image', 'audio', 'video', 'poc','wp', 'db', 'menu'))) {
								$edit .= '<a href="/admin/edit/'.$val.'/'.$data['id'].'">Edit as '.$val.'</a> ';
							}
						}
						if (strrpos ($key, 'trigger.url') !== false) {
							$trigger_url = $val;
						}
						if (strrpos ($key, 'content.title') !== false) {
							$content_title = $val;
						}
						
					}
					
					if ($edit == '') $edit .= '<a href="/admin/edit/page/'.$data['id'].'">Edit as page</a> ';
					
					if (count($tags) > 0) {
						$tags = implode(', ', $tags);
					} else {
						$tags = '';
					}
					
					$row = array(
						'content.id' => $data['id'],
						'content.url' => $trigger_url,
						'content.title' => $content_title,
						'content.edit' => $edit,
						'tags' => $tags
					);

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