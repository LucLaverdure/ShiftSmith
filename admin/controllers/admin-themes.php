<?php

class admin_themes extends Controller {
	
	function validate() {
		if (q('admin/themes') && $this->user->isAdmin())
			return 1;
		else
			return false;

	}
	
	function execute() {
		$uploads_dir = 'webapp/files/upload';

		// media gallery
		$this->loadView('admin.themes.tpl');
	}
}
