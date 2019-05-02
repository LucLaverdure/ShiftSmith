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
foreach (self::$stack as $val => $var) {
	foreach ($var as $space => $key) {
		foreach ($key as $i => $k) {
			$this_output = str_replace('['.$space.'.'.$k.']', $val, $this_output);
		}
		
	}
}