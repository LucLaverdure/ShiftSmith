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
			$dbsqls = Model("db", print_r(\Wizard\Build\Queue::search_models("sql_"), true), "stats");		
			
			//$_POST
			$postvars = Model("post_vars", print_r($_POST, true), "stats");		
			//$_GET
			$getvars = Model("get_vars", print_r($_GET, true), "stats");		
			//$_SERVER
			$server = Model("server_vars", print_r($_SERVER, true), "stats");		
			//models
			$mods = Model("mods_vars", print_r(\Wizard\Build\Queue::get_all_models(), true), "stats");		
			//templates used
			$tpls = Model("tpls", print_r(\Wizard\Build\Queue::search_models("template_"), true), "stats");		

			// Load HTML(DOM) Skeleton
			$stats = View()
			->from("stats.html")
			->to("body")
			->render("append");

			// Load JS and CSS in HTML header
			$stats2 = View()
			->from("stats-head.html")
			->to("head")
			->render("append");
		}

	}
