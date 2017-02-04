<?php

class view_page extends Controller {
		
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		
		$db = new Database();
		$db::connect();

		// get all triggers
		$data = $db::queryResults("SELECT `namespace`, `id`, `key`, `value`
								   FROM shiftsmith
								   WHERE namespace = 'trigger'
								   ORDER BY id DESC;");
		
		// when no triggers are found, cancel render
		if ($data == false) return false;
		
		// start 
		$verified = array();

		date_default_timezone_set("America/New_York");
		

		foreach ($data as $row) {
			
			if (!isset($verified[$row['id']])) {
				$verified[$row['id']] = 0;
			}

			// verify if date trigger is good
			if ( ($row['key'] == 'date') && (strtotime($row['value']) <= strtotime('now'))) {
				$verified[$row['id']]++;
			}

			// verify page type 
			if ( ($row['key'] == 'tag') && (($row['value'] == 'page') || ($row['value'] == 'post') || ($row['value'] == 'block'))) {
				$verified[$row['id']]++;
			}
			
			// verify if url pattern is good
			if (($row['key'] == 'url') && ("/".q() == $row['value']) && (trim($row['value']) != '') ) {
				$verified[$row['id']]++;
			}
			
			// requires admin logged in or 
			if (($row['key']=='admin_only') && ($row['value']=='Y') && (isset($_SESSION['login']))) {
				$verified[$row['id']]++;
			} else if (($row['key']=='admin_only') && ($row['value']=='N')) {
				$verified[$row['id']]++;
			}

		}

		$valid_ids = array();

		foreach ($verified as $id => $count) {
			if ($count >= 4) {
				$valid_ids[$id] = $id;
			}
		}

		$this->addModel('ids', $valid_ids);

		if (count($valid_ids) > 0) {
			return 1;
		}
		
		return false;
	}
	
	function execute() {
		
		$db = new Database();
		$db::connect();

		$shiftsmith_ids = $this->getModel('ids');

		$sql = "SELECT `id`, `namespace`, `key`, `value`
				FROM shiftsmith
				WHERE id IN(".$db::param(implode(',', $shiftsmith_ids)).");";

		// pages
		$pages = $db::queryResults($sql);

		if ($pages != false) {
			foreach ($pages as $page) {
				$this->addModel('page', $page['key'], $page['value']);
			}
		} else {
			$this->addModel('page', array());
		}
		
		// posts
		$posts = $db::queryResults("SELECT `id`, `namespace`, `key`, `value`
										FROM shiftsmith
										WHERE id IN(".$db::param(implode(',', $shiftsmith_ids)).")
										AND id IN (SELECT id FROM shiftsmith WHERE `key`='tag' AND value='post');");

		if ($posts != false) {
			$this->addModel('posts', $posts);
		} else {
			$this->addModel('posts', array());
		}
		
		// blocks
		$blocks = $db::queryResults("SELECT `id`, `namespace`, `key`, `value`
										FROM shiftsmith
										WHERE id IN(".$db::param(implode(',', $shiftsmith_ids)).")
										AND id IN (SELECT id FROM shiftsmith WHERE `key`='tag' AND value='block');");
		if ($blocks != false) {
			foreach ($blocks as $shift) {
				$this->addModel('blocks', $shift['key'], $shift['value']);
			}
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
		$db::connect();
		
		$db::query('DELETE FROM `shiftsmith` WHERE `id` = '.$db_to_del.';');

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