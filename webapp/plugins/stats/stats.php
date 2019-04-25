<?php

	class statsEndController extends Wizard\Build\Controller {

		function validate() {
			return 9999999;
		}

		function execute() {
			$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
			$time = round($time, 4);

			$tdiff = new \Wizard\Build\Model("tdiff", $time, "stats");		

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
