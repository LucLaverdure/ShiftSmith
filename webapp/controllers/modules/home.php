<?php

// Dashboard
class homepage extends Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=="home" || q()=="/") {
			return 1;	// priority 1
		}
		else return false;
	}

	function execute() {
		$this->loadView('default-theme/home.tpl');
		$this->injectView('#version', 'replace', 'https://raw.githubusercontent.com/LucLaverdure/DreamForgery/master/core/core-version.php');
	}
}