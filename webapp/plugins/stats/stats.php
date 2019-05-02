<?php

	class statsEndController extends Wizard\Build\Controller {

		function validate() {
			return 9999999;
		}

		function execute() {
			$time = round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"],4);
			//$time = $time, 4);
			//$key, $val, $space, $type
			$tdiff = Model("tdiff", $time."", "stats");		

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
