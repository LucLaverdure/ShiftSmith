<?php
// Dashboard
class homepage extends Wizard\Build\Controller {
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
		$this->loadView('home.tpl');
	}
}

class edocs extends Wizard\Build\Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=="docs") {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		$this->loadView('docs.tpl');
	}
}

class tutorials extends Wizard\Build\Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=="tutorials") {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		$this->loadView('tutorials.tpl');
	}
}

class pluginspage extends Wizard\Build\Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=="plugins") {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		$this->loadView('plugins.tpl');
	}
}

class themespage extends Wizard\Build\Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=="themes") {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		$this->loadView('themes.tpl');
	}
}

class aboutpage extends Wizard\Build\Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=="about") {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		$this->loadView('about.tpl');
	}
}

class downloadpage extends Wizard\Build\Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=="download") {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		$this->loadView('download.tpl');
	}
}

class thankyoupage extends Wizard\Build\Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=="thank-you") {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		$this->loadView('thank-you.tpl');
	}
}