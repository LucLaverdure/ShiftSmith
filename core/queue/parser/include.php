<?php

// process subview (include) paths, syntax: [filename]
$matches = array();
/*                 /\[[^\[]*[^\\\]\]		*/
preg_match_all('/\[\S*\]/i', $this_output, $matches);
foreach ($matches as $found_a) {
	foreach ($found_a as $found) {
		if (strlen($found)>=3) {
			$filename = trim(substr($found, 1, -1));
			if (substr($filename, 0, 4)=='http') {
				// file is a web fetch
				$this_output = str_replace($found, $this->process_view($controller, $filename, $recursion_level+1), $this_output);
			} else if (file_exists("webapp/themes/".Wizard\Build\Config::ACTIVE_THEME."/views/".$filename)) {
				// file is an webapp file
				$this_output = str_replace($found, $this->process_view($controller, $filename, $recursion_level+1), $this_output);
			}
		}
	}
}

