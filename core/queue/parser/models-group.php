<?php
	// process shared models (variables)
	foreach (self::$obj_models as $varz => $dataz) {

		if (get_class($dataz)=='Wizard\Build\Group') {
			$space = $dataz->space();
			// var
			$var = $dataz->def();
			// data
			$data = $dataz->getValues();

			// when model data is an array
			// fetch for blocks and render loops
			$forblocks = array();
			preg_match_all('/(?<block>\[for:'.$space.'\](?<content>[\s\S]+)\[end:'.$space.'\])/ix', $this_output, $forblocks, PREG_SET_ORDER);
			if (count($forblocks)) {
				// $foundForBlock: [for:user]TEST [user.xyz] [end:user]
				foreach ($forblocks as $foundForBlock) {

					$block_content = array();
					// $data: array(3) [0] => email
					foreach ($data as $mykey => $row) {
						// set model values within the loop, ex: blocks.x value
						foreach ($row as $subvar => $value) {
							if (!isset($block_content[$mykey])) {
								$block_content[$mykey] = $foundForBlock['content'];
							}
							$block_content[$mykey] = str_replace('['.$space.'.'.$var[$subvar].']', $value, $block_content[$mykey]);
						}
						// append the parsed new block (of for loop) as processed view to render (ifs and setters for example)
					}
					$block_content = implode("\n", $block_content);
					$this_output = str_replace($foundForBlock['block'], $block_content, $this_output);
				}
			}
		} else {
			// simple model, replace model with value ex: "[stats.x]" by "18"
			$this_output = str_replace('['.$dataz->space().'.'.$dataz->key().']', $dataz->val(), $this_output);
			$this_output = str_replace('['.$dataz->key().']', $dataz->val(), $this_output);
		}

	}

