<?php

	class admin_file_editor extends Controller {
		
		function validate() {
			if (q('0')=='admin' && q(1) == 'file' && q(2) == 'editor'  && isset($_SESSION['login']) && isset($_REQUEST['filename']))
				return 1;
			else
				return false;

		}
		
		function execute() {
			
			global $main_path;
			
			$filename = $main_path.$_REQUEST['filename'];

			if (file_exists($filename)) {

				$myfile = fopen($filename, "r") or die("Unable to open file!");
				$file_contents = fread($myfile, filesize($filename));
				fclose($myfile);
				
				$this->addModel('file', 'contents', $file_contents);
				$this->addModel('file', 'name', $_REQUEST['filename']);
				
				$this->loadView('admin.file-editor.tpl');
				
			}
			
		}
	}

?>