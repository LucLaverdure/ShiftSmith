<?php

// Register email
class sleepwalk extends Controller {
	// Display function: validate urls to activate the controller
	function validate() {
		// url pattern chatbox/register/username
		if (isset($_SESSION['login']) && q('0')=="sleepwalk") {
			return 1;	// priority 1
		}
		else return false;
	}

	private function subscan() {
		global $main_path;
		
		$di = new RecursiveDirectoryIterator($main_path,RecursiveDirectoryIterator::SKIP_DOTS);
		$it = new RecursiveIteratorIterator($di);

		$files = array();
		foreach($it as $file) {
			//if (pathinfo($file, PATHINFO_EXTENSION) == "php") {
				$files[] = $file;
			//}
		}
		return $files;
	}
	
	function execute() {
		$files = $this->subscan();
		
		foreach ($files as $file) {
			$path = explode('/', $file);
			echo $file;
		}
		die();
	}
}
