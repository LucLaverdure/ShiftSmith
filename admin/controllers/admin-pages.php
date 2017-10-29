<?php

class view_page extends Controller {
		
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate custom page controller for db entries forged
		
		$db = new Database();
		$db->connect();

		// get all triggers
		$data = $db->queryResults("SELECT `namespace`, `id`, `key`, `value`
								   FROM shiftsmith
								   WHERE `key` = 'trigger.url'
								   OR `key` = 'trigger.date'
								   OR `key` = 'trigger.admin_only'
								   ORDER BY id DESC;");
		
		// when no triggers are found, cancel render
		if ($data == false) return false;
		
		// start 
		$verified = array();

		date_default_timezone_set("America/New_York");
		

		foreach ($data as $row) {
			$id = $row['id'];
			
			if (!isset($verified[$id])) {
				$verified[$id] = 0;
			}

			// verify if date trigger is good
			if ( ($row['key'] == 'trigger.date') && (strtotime($row['value']) <= strtotime('now'))) {
				$verified[$id] = $verified[$id] + 1;
			}
			
			// verify if url pattern is good
			if ((trim($row['key']) == 'trigger.url') && (inpath($row['value'])) && (trim($row['value']) != '') ) {
				$verified[$id] = $verified[$id] + 1;
			}
			
		}

		$valid_id = 0;

		foreach ($verified as $id => $counted) {
			if ($counted >= 2) {
				$admin_check = $db->queryResults("SELECT `namespace`, `id`, `key`, `value`
										   FROM shiftsmith
										   WHERE `key` = 'trigger.admin.only'
										   AND `id` IN (".$db->param($id).")
										   ORDER BY id DESC;");

			if (((count($admin_check) > 0) && $admin_check[0]['value'] == 'Y' && $this->user->isAdmin()) ||
					((count($admin_check) > 0) && $admin_check[0]['value'] == 'N') || 
					($admin_check == false)) {
						$valid_id = $id;
					}
			}
		}


		if ($valid_id > 0) {
			$this->addModel('page', 'ids', $valid_id);
			return 1;
		}
		
		return false;
	}
	
	function execute() {
		
		$db = new Database();
		$db->connect();

		$shiftsmith_ids = $this->getModel('page', 'ids');
		$sql = "SELECT `id`, `namespace`, `key`, `value`
				FROM shiftsmith
				WHERE id IN(".$db->param($shiftsmith_ids).");";

		// pages
		$pages = $db->queryResults($sql);

		if ($pages != false) {
			foreach ($pages as $page) {
				$this->addModel("page", $page['key'], $page['value']);
			}
		} else {
			$this->addModel('page', array());
		}

		// load global template
		$this->loadView('default-theme/page.common.tpl');
	}
}

class admin_delete_page extends Controller {
	
	function validate() {
		if ( (q('0')=='admin') && (q(1)=='del') && (q(2)=='db') && (isset($_SESSION['login'])) ) {
			return 1;
		} else {
			return false;
		}
	}
	
	function execute() {
		$db_to_del = (int) q(3);

		$db = new Database();
		$db->connect();
		
		$db->query('DELETE FROM `shiftsmith` WHERE `id` = '.$db_to_del.';');

		redirect('/admin/forged');
		die();
	}
}


class admin_forge extends Controller {
		
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (isset($_SESSION['login']) && (q('0')=='admin') && q(1)=='forge')
			return 1;	// priority 1, late processing to get all controllers before
		else return false;
	}
	
	function execute() {
		
		$this->setModel('prompt', 'message', '');
		$this->setModel('prompt', 'error', '');

		$this->loadView('admin.forge.tpl');
	}
}