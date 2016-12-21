<?php

class login_dispatch extends controller {
	
	public function validate() {
		/*
		if (q('0')=='user')
			return 1;
		else 
		*/
			return false;
	}
	
	public function execute() {
		$this->injectView('html head', 'append', '/plugins/login-theme/login-styles.css');
		$this->injectView('html body', 'prepend', '/plugins/login-theme/login-page.tpl');
	}
}