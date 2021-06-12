<?php

foreach (self::$resources as $filename) {
			$i=0;
			$ext = substr(strrchr($filename,'.'), 1);
			switch ($ext) {
				case "js":
					$place_me = '<script type="text/javascript" src="'.$filename.'"></script>';
					break;
				case "css":
					$place_me = '<link rel="stylesheet" type="text/css" media="all" href="'.$filename.'" />';
					break;
				default:
					$place_me = '';
					break;
			}

			if (\Wizard\Build\Config::DEBUG) {
				$i++;
				Model("resource_".$i, $filename, "stats");
			}


			// set destination HTML
			$destination = \phpQuery::newDocumentHTML($this_output);
			
			$destination["head"]->append($place_me);

			$this_output = $destination;
			
}