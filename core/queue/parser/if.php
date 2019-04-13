<?php
	// process if statements
	$ifsfound = array();
	preg_match_all('~(?<block>\[if:(?<if_body>[^\]]+)\](?<body>.+)\[endif\])~siU', $this_output, $ifsfound, PREG_SET_ORDER);
	if (count($ifsfound) > 0) {
		foreach ($ifsfound as $found) {
			$eval_code = 'return ('.$found['if_body'].');';

			// MUST REMOVE EVAL - INPUT DANGER (TODO)				
			if (eval($eval_code)) {
				//valid if statement
				$this_output = str_replace($found['block'], $found['body'], $this_output);
				// re-render everything within valid if statement
				//$this_output = $this->process_view($controller, $this_output, $recursion_level + 1);
				self::parse($this_output, $ret_type, $filter, $to, $display_type, $display_mode, $use_models,  $recursion_level + 1);
			} else {
				// invalid if statement, erase it from view output
				$this_output = str_replace($found['block'], '', $this_output);
			}
		}
	}
