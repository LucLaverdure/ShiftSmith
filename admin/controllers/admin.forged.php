<?php

	class forged extends Controller {
		
		function validate() {
			if (q('0')=='admin' && q(1) == 'forged')
				return 1;
			else
				return false;
		}
		
		function execute() {

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
			
			$this->loadView('admin.forged.tpl');
		}
	}

?>