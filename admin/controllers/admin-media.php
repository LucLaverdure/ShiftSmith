<?php

class admin_media extends Controller {
		
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (isset($_SESSION['login']) && ((q()=='media') || q()=='media/'))
			return 1;	// priority 2
		else return false;
	}

	function format_size($size) {
		$sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
		if ($size == 0) { return('n/a'); } else {
		return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]); }
	}

	
	function execute() {
		$uploads_dir = 'webapp/files/upload';
		
		$files = scandir($uploads_dir);
		$return = array();
		foreach($files as $file) {
			if (($file != '.') && ($file != '..')) {
				$width = 0; $height = 0;
				$size = $this->format_size(filesize('webapp/files/upload/'.$file));
				try {
					list($width, $height) = getimagesize('webapp/files/upload/'.$file);
				} catch (Exception $e) {}
				$return[] = array('file' => $file,'size'=>$size,'width'=>$width,'height'=>$height);
			}
		}

		$this->addModel('media', $return);

		// media gallery
		$this->loadView('admin.media.tpl');
	}
}

class admin_media_del extends Controller {
		
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (isset($_SESSION['login']) && (q('0')=='admin') && (q(1)=='del') && (q(2)=='files') )
			return 1;	// priority 2
		else return false;
	}

	function execute() {
		global $main_path;
		
		$file = q();
		$file = str_replace('admin/del/files/upload/', '', $file);
		$file = $main_path.'webapp/files/upload/'.$file;

		try {
			unlink($file);
		} catch (Exception $e) {
		}

		// media gallery
		redirect('/media');
	}
}
