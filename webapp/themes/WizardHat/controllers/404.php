<?php

class page404 extends Wizard\Build\Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		//return 999;	// last priority
		return -999;	// last priority
	}

	function execute() {
		/**
		 * This controller has last priority, meaning it is executed the last
		 * if it is also executed the first, this means we must render the 404 page
		 * as no other controllers were picked up by the application.
		 */
		if ($this->index == 0) {
			$this->loadView('/theme/404.tpl');		
		} else {
			//die();
		}
	}
}
