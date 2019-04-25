<?php
foreach (self::$obj_models as $space => $var) {
	$forblocks = array();
	preg_match_all('/(?<block>\[for:'.$space.'\](?<content>[\s\S]+)\[end:'.$space.'\])/ix', $this_output, $forblocks, PREG_SET_ORDER);

	// parse groups
	if (count($forblocks)) {

		$out = array();
		foreach ($forblocks as $block) {	//for:space end:space

			for ($iii = 0; $iii < self::$loops[$space]; $iii++) {	// 1 to 6

				if (is_array($var)) { // email => mail@mail.com

					foreach ($var as $key => $var_list) {
						if (is_array($var_list)) {
							foreach ($var_list as $varB => $val) {
								if (!isset($out[$iii])) {
									$out[$iii] = $block['content']; //out[1] = content
								}
								$out[$iii] = str_replace('['.$space.'.'.$varB.']', $val, $out[$iii]);
							}
						}
					}
				}
				for($counted = 1; $counted < self::$loops[$space]; ++$counted) {
					array_shift($var);
				}

			}

			$implode = implode("\n", $out);
			$this_output = str_replace($block['block'], $implode, $this_output); 
			$out = array();
		}
	}


	// parse singles
	if (is_array($var)) {
		foreach ($var as $key => $val) {
			if ( (!is_array($val)) && (!is_array($key)) ) {
				$this_output = str_replace('['.$space.'.'.$key.']', $val, $this_output);
			}
		}
	}
}


