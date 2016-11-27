<?php

class version_injection extends Controller {
		
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=='home')
			return 50;	// priority 50
		else return false;
	}

	function execute() {
		$this->injectView('.core-version','append','core-version.tpl');
	}
}
