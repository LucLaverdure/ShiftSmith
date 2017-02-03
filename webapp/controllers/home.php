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
	}
}

class edocs extends Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=="docs") {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		$this->loadView('default-theme/docs.tpl');
	}
}

class tutorials extends Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=="tutorials") {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		$this->loadView('default-theme/tutorials.tpl');
	}
}

class pluginspage extends Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=="plugins") {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		$this->loadView('default-theme/plugins.tpl');
	}
}

class themespage extends Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=="themes") {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		$this->loadView('default-theme/themes.tpl');
	}
}

class aboutpage extends Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=="about") {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		$this->loadView('default-theme/about.tpl');
	}
}