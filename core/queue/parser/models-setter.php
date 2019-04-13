<?php

/* process model setters, ex: [set:stats.x]18[endset] */
$setvars = array();
preg_match_all('~(?<block>\[set:(?<set_body>[^\[]+)\](?<set_content>[^\[.]+)\[endset\])~i', $this_output, $setvars, PREG_SET_ORDER);
if (count($setvars) > 0) {
	foreach ($setvars as $key => $found) {
		if (isset($found['set_body']) && trim($found['set_body'])!='') {
			if (trim($found['set_content'])=='++') {
				// when setter is ++ increment value of model
				$controller->addModel(trim($found['set_body']), ((int)trim($controller->getModel(trim($found['set_body']))))+1);
				$global_models[trim($found['set_body'])] = ((int)trim($controller->getModel(trim($found['set_body']))))+1;
			} else {
				// otherwise, set value of model to content body
				$controller->addModel(trim($found['set_body']), $found['set_content']);
				$global_models[trim($found['set_body'])] = $found['set_content'];
			}
			// remove found block from output as model has been processed
			$this_output = str_replace($found['block'], '', $this_output);
			// re-render models as new models were added.
			//$this_output = $this->process_view($controller, $this_output, $recursion_level + 1);
			self::parse($this_output, $ret_type, $filter, $to, $display_type, $display_mode, $use_models,  $recursion_level + 1);
		} elseif(isset($found['set_body'])) {
			$controller->addModel(trim($found['set_body']), '');
			$global_models[trim($found['set_body'])] = '';
			// re-render models as new models were added.
			// $this_output = $this->process_view($controller, $this_output, $recursion_level + 1);
			self::parse($this_output, $ret_type, $filter, $to, $display_type, $display_mode, $use_models,  $recursion_level + 1);

		}
	}
}

