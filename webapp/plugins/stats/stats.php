<?php

	class statsStartController extends Wizard\Build\Controller {

		function validate() {
			return -99999;
		}

		function execute() {
			$start_timer = new \Wizard\Build\Model("startTimer", microtime(true), "start_timer", null, "stats");		
		}

	}

	class statsEndController extends Wizard\Build\Controller {

		function validate() {
			return 9999999;
		}

		function execute() {

			//memory_get_usage();
			$end_timer = new \Wizard\Build\Model("endTimer", microtime(true), "end_timer", null, "stats");		
			//$start_timer = Queue::get_model("start_timer");
			//echo $start_timer;

			// Load HTML(DOM) Skeleton
			$stats = View()
			->from("stats.html")
			->to("body")
			->display_mode("append")
			->render();

			// Load JS and CSS in HTML header
			$stats2 = View()
			->from("stats-head.html")
			->to("head")
			->display_mode("append")
			->render();
		}

	}
