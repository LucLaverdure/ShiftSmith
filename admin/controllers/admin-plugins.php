<?php

class admin_plugins extends Controller {
	
	function validate() {
		if (q('admin/plugins') && $this->user->isAdmin())
			return 1;
		else
			return false;

	}
	
	function execute() {
		$uploads_dir = 'webapp/files/upload';

		// media gallery
		$this->loadView('admin.plugins.tpl');
	}
}
