<?php

class admin_images extends Controller {
	
	function validate() {
		if (q('admin/images') && $this->user->isAdmin())
			return 1;
		else
			return false;

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
			try {
				if (($file != '.') && ($file != '..')) {
					$width = 0; $height = 0;
					$size = $this->format_size(filesize('webapp/files/upload/'.$file));
					
					if(@is_array(getimagesize('webapp/files/upload/'.$file))){
						list($width, $height) = getimagesize('webapp/files/upload/'.$file);
						// is image
						$return[] = array('file' => $file,'size'=>$size,'width'=>$width,'height'=>$height);
					} else {
						// is not image
					}
				}
			} catch (Exception $e) {
				//var_dump($e);
			}
		}

		$this->addModel('media', $return);
		$this->addModel('web', 'url', "http://" . $_SERVER['SERVER_NAME']);

		// media gallery
		$this->loadView('admin.images.tpl');
	}
}

class admin_audio extends Controller {
	
	function validate() {
		if (q('admin/audio') && $this->user->isAdmin())
			return 1;
		else
			return false;

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
			try {
				if (($file != '.') && ($file != '..')) {
					$width = 0; $height = 0;
					$size = $this->format_size(filesize('webapp/files/upload/'.$file));
					if (in_array(substr($file,-4),
array('.3gp','.aa','.aac','.aax','.act','.aiff','.amr','.ape','.au','.awb','.dct','.dss','.dvf','.flac',
	  '.gsm','.iklax','.ivs','.m4a','.m4b','.m4p','.mmf','.mp3','.mpc','.msv','.ogg','.oga','.mogg','.opus',
	  '.ra','.rm','.raw','.sln','.tta','.vox','.wav','.webm','.wma','.wv'))) {
						$type = substr($file,-3);
						$return[] = array('file' => $file,'size'=>$size, 'type'=>$type);
					}
				}
			} catch (Exception $e) {
				//var_dump($e);
			}
		}

		$this->addModel('audio', $return);
		$this->addModel('web', 'url', "http://" . $_SERVER['SERVER_NAME']);

		// media gallery
		$this->loadView('admin.audio.tpl');
	}
}

class admin_video extends Controller {
	
	function validate() {
		if (q('admin/videos') && $this->user->isAdmin())
			return 1;
		else
			return false;

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
			try {
				if (($file != '.') && ($file != '..')) {
					$width = 0; $height = 0;
					$size = $this->format_size(filesize('webapp/files/upload/'.$file));
					if (in_array(substr($file,-4),
array('.webm','.mkv','.flv','.flv','.vob','.ogv','.ogg', '.drc','.gif','.gifv','.mng','.avi',
	  '.mov','.qt','.wmv','.yuv','.rm','.rmvb','.asf','.amv','.mp4','.m4p','.m4v','.mpg',
	  '.mp2', '.mpeg', '.mpe', '.mpv','.mpg', '.mpeg', '.m2v','.m4v','.svi','.3gp','.3g2','.mxf',
	  '.roq','.nsv','.flv','.f4v','.f4p','.f4a','.f4b'))) {
						$type = substr($file,-3);
						$return[] = array('file' => $file,'size'=>$size, 'type'=>$type);
					}
				}
			} catch (Exception $e) {
				//var_dump($e);
			}
		}

		$this->addModel('video', $return);
		$this->addModel('web', 'url', "http://" . $_SERVER['SERVER_NAME']);

		// media gallery
		$this->loadView('admin.videos.tpl');
	}
}
class admin_upload_misc extends Controller {
	
	function validate() {
		if (q('admin/uploads') && $this->user->isAdmin())
			return 1;
		else
			return false;

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
			try {
				if (($file != '.') && ($file != '..')) {
					$width = 0; $height = 0;
					$size = $this->format_size(filesize('webapp/files/upload/'.$file));
					if (!in_array(substr($file,-4),
array('.webm','.mkv','.flv','.flv','.vob','.ogv','.ogg', '.drc','.gif','.gifv','.mng','.avi',
	  '.mov','.qt','.wmv','.yuv','.rm','.rmvb','.asf','.amv','.mp4','.m4p','.m4v','.mpg',
	  '.mp2', '.mpeg', '.mpe', '.mpv','.mpg', '.mpeg', '.m2v','.m4v','.svi','.3gp','.3g2','.mxf',
	  '.roq','.nsv','.flv','.f4v','.f4p','.f4a','.f4b')) &&
	  !in_array(substr($file,-4),
array('.3gp','.aa','.aac','.aax','.act','.aiff','.amr','.ape','.au','.awb','.dct','.dss','.dvf','.flac',
	  '.gsm','.iklax','.ivs','.m4a','.m4b','.m4p','.mmf','.mp3','.mpc','.msv','.ogg','.oga','.mogg','.opus',
	  '.ra','.rm','.raw','.sln','.tta','.vox','.wav','.webm','.wma','.wv')) &&
!@is_array(getimagesize('webapp/files/upload/'.$file))) {
						$type = substr($file,-3);
						$return[] = array('file' => $file,'size'=>$size, 'type'=>$type);
					}
				}
			} catch (Exception $e) {
				//var_dump($e);
			}
		}

		$this->addModel('misc', $return);
		$this->addModel('web', 'url', "http://" . $_SERVER['SERVER_NAME']);

		// media gallery
		$this->loadView('admin.misc.upload.tpl');
	}
}
class admin_media_del extends Controller {
		
	// Display function: validate urls to activate the controller
	function validate() {
		// Activate home controller for /home and /home/*
		if (q('admin/del/files') && $this->user->isAdmin())
			return 1;	// priority 2
		else return false;
	}

	function execute() {
		global $main_path;
		
		$file = $_GET['f'];
		$file = str_replace('admin/del/files/upload/', '', $file);
		$file = $main_path.'webapp/files/upload/'.$file;

		try {
			unlink($file);
		} catch (Exception $e) {
			var_dump($e);
		}

		// media gallery
		redirect($_SERVER['HTTP_REFERER']);
	}
}
