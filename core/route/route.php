<?php
	// when no url provided and file provided, lookup file in current theme
	if (!isset($_REQUEST['q']) && isset($_REQUEST['f'])) {
		$path_to_file = $_REQUEST['f'];
		if (strpos($path_to_file, '..') != false) die();
		if (strpos($path_to_file, 'private') != false) die();
		$filename = PATH."webapp/themes/".Wizard\Build\Config::ACTIVE_THEME."/".$path_to_file;
		if (@file_exists($filename)) {
			$arr = explode('.', $filename);
			$ext = end($arr);
			switch ($ext) {
				case "css":
					header("Content-Type: text/css");
					break;
				case "js":
					header("Content-Type: text/javascript");
					break;
				default:
					header("Content-Type: ".mime_content_type($filename));
					break;
			}
			echo @file_get_contents($filename, false);
			die();
		}
	}

	if (!isset($_REQUEST['q']) && !isset($_REQUEST['f']) && isset($_REQUEST['p']) ) {
		$path_to_file = $_REQUEST['p'];
		if (strpos($path_to_file, '..') != false) die();
		if (strpos($path_to_file, 'private') != false) die();
		$filename = PATH."webapp/plugins/".$path_to_file;
		if (@file_exists($filename)) {
			$arr = explode('.', $filename);
			$ext = end($arr);
			switch ($ext) {
				case "css":
					header("Content-Type: text/css");
					break;
				case "js":
					header("Content-Type: text/javascript");
					break;
				default:
					header("Content-Type: ".mime_content_type($filename));
					break;
			}
			echo @file_get_contents($filename, false);
			die();
		}
	}
