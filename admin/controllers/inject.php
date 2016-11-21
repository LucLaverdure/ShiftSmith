<?php

class injector extends Controller {
		
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q()=="/" || q()=="") {
			return 2;	// priority 2
		}
		else return false;
	}

	function execute() {
		$this->injectView('html head', 'prepend', 'header_include.tpl');
	}
}
