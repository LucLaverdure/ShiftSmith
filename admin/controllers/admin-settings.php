<?php

class admin_settings extends Controller {
	
	function validate() {
		if (q('admin/settings') && $this->user->isAdmin())
			return 1;
		else
			return false;

	}
	
	function execute() {
		$uploads_dir = 'webapp/files/upload';

		// media gallery
		$this->loadView('admin.settings.tpl');
	}
}
