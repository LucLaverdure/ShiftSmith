<?php
$i = 0;
// parse groups
foreach (self::$stackGroups as $space => $var) {
	
	$forblocks = array();
	preg_match_all('/(?<block>\[for:'.$space.'\](?<content>[\s\S]+)\[end:'.$space.'\])/ix', $this_output, $forblocks, PREG_SET_ORDER);
	
	$block_content = "";
	if (count($forblocks)) {
		$rows_set = 0;
		foreach ($forblocks as $rownum => $block) {	//for:space end:space
			foreach ($var as $line_num => $data) {
				foreach ($data[0] as $subvar => $vartype) {
					if ($i >= $data[2]) {
						$i=0;
						$rows_set++;
					}
					if (!isset($row[$rows_set])) {
						$row[$rows_set] = $block['content'];
					}
					$fullvar = '['.$space.'.'.$subvar .']';
					$value = $data[1];

					$row[$rows_set] = str_replace($fullvar, $value, $row[$rows_set]);
					
					$i++;
				}
			}
			$block_content .= implode("\n", $row);
			$this_output = str_replace($block['block'], $block_content, $this_output); 
			
		}
	}
}



// parse singles
//SINGLE: self::$stack[$space][$key] = array($type => $val);
foreach (self::$stack as $space => $var) {
	foreach ($var as $subvar => $item) {
		foreach ($item as $i => $k) {
			$this_output = str_replace('['.$space.'.'.$subvar.']', $k, $this_output);
		}
		
	}
}

// parse inputs
foreach (self::$stack as $space => $item) {
	foreach ($item as $key => $subitem) {
		foreach ($subitem as $i=>$val) {
			$this_output = str_replace('[textbox:'.$space.'.'.$key.']', \Wizard\Build\Tools::mvc_input("textbox", $key, $val), $this_output);
			$this_output = str_replace('[checkbox:'.$space.'.'.$key.']', \Wizard\Build\Tools::mvc_input("checkbox", $key, $val), $this_output);
			$this_output = str_replace('[radio:'.$space.'.'.$key.']', \Wizard\Build\Tools::mvc_input("radio", $key, $val), $this_output);
			$this_output = str_replace('[textarea:'.$space.'.'.$key.']', \Wizard\Build\Tools::mvc_input("textarea", $key, $val), $this_output);
			$this_output = str_replace('[password:'.$space.'.'.$key.']', \Wizard\Build\Tools::mvc_input("password", $key, $val), $this_output);
		}
		
	}
}
