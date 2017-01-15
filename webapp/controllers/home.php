<?php
// Dashboard
class homepage extends Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=="home" || q()=="/" || q()=="") {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		$this->addModel('page','url', 'http://'.$_SERVER['HTTP_HOST']);
		$this->loadView('default-theme/home.tpl');
		$this->injectView('#version-inject','replace','https://raw.githubusercontent.com/LucLaverdure/ShiftSmith/master/admin/views/core-version.tpl','');
	}
}

class help extends Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=="help") {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		$this->loadView('default-theme/help.tpl');
	}
}