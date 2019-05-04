<?php

	class statsEndController extends Wizard\Build\Controller {

		function validate() {
			if (access("admin"))
				return 9999999;
			else
				return false;
		}
		
		function convert_filesize($bytes, $decimals = 2){
			$size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
			$factor = floor((strlen($bytes) - 1) / 3);
			return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
		}

		function execute() {
			// get execution time
			$time = round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"],4);
			$tdiff = Model("tdiff", $time."", "stats");		

			// get mem used
			$mem = Model("mem", $this->convert_filesize(memory_get_usage()), "stats");		
			$maxmem = Model("maxmem", $this->convert_filesize(memory_get_peak_usage()), "stats");		
			
			//DB Time
			//DB Queries
			Model("db", print_r(\Wizard\Build\Queue::search_models("sql_"), true), "stats");		
			
			//$_POST
			Model("post_vars", print_r($_POST, true), "stats");		
			//$_GET
			Model("get_vars", print_r($_GET, true), "stats");		
			//$_SERVER
			Model("server_vars", print_r($_SERVER, true), "stats");		
			//models
			Model("mods_vars", print_r(\Wizard\Build\Queue::get_all_models(), true), "stats");		
			//templates used
			Model("tpls", print_r(\Wizard\Build\Queue::search_models("template_"), true), "stats");		

			Model("ctrls", print_r(\Wizard\Build\Queue::search_models("controller_"), true), "stats");		

			Model("units", print_r(\Wizard\Build\Queue::search_models("unit_test_"), true), "stats");		
			
			stack_resource("/plugins/stats/stats.css");
			Model("resources", print_r(\Wizard\Build\Queue::search_models("resource_"), true), "stats");		

			// Load HTML(DOM) Skeleton
			$stats = View()
			->from("stats.html")
			->to("body")
			->render("append");

		}

	}
