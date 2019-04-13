<?php

	if ($from != '') {
		// view is string or file
		if (substr($from, 0, 4 )=='http') {
			// fetch url content into output
			$this_output = @file_get_contents($from);
		}

		$path_match_plugins = Wizard\Build\Tools::search_files_matching($from, PATH."webapp/plugins");
		if (count($path_match_plugins) > 0) {
			// fetch template file in active theme folder
			foreach ($path_match_plugins as $match) {
				if (file_exists($match)) {
//					$this_output = @file_get_contents($match); 
					$stack[] = @file_get_contents($match); 
				}
			}


		}

		$path_match = Wizard\Build\Tools::search_files_matching($from, PATH."webapp/themes/".Wizard\Build\Config::ACTIVE_THEME);
		if (count($path_match) > 0) {
			// fetch template file in active theme folder
			foreach ($path_match as $match) {
				if (file_exists($match)) {
//					$this_output = @file_get_contents($match); 
					$stack[] = @file_get_contents($match); 
				}
			}
		}

	}
