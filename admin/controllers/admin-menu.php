<?php

class admin_menu_injection extends Controller {
		
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (isset($_SESSION['login']))
			return 25;	// priority 2
		else return false;
	}

	function execute() {

		$db = new Database();
		$db::connect();
	
		$data = $db::queryResults("SELECT email
								   FROM users
								   WHERE active='Y'
								   AND id='".$db::param($_SESSION['login'])."'
								   ORDER BY id DESC
								   LIMIT 1");
		if ($data != false) {
			$this->addModel('user', "email", $data[0]['email']);
		} else {
			$this->addModel('user', "email", 'error');
		}
		// inject required scripts and css
		$this->injectView('html head', 'prepend', 'admin.inject.head.tpl');
		
		//inject administration menu
		$this->injectView('html body', 'prepend', 'admin.inject.menu.tpl');
	}
}
