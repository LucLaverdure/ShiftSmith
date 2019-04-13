<?php


	class MyFirstController extends Wizard\Build\Controller {

		function validate() {
			//if (q('h') && a('view content')) return 1;
			if (q("/")) return 1;
			else return false;
		}

		function execute() {
			// My first Model
			// args: $var, $val, $id=null, $parent_id=null, $namespace="general"
			$myModel = new \Wizard\Build\Model("title","My First Page!", "general");
			$main_img = new \Wizard\Build\Model("headImgSrc","/theme/files/img/sections/docs-bg.jpg", "general");

			// Load HTML(DOM) Skeleton
			$myView = new Wizard\Build\View(); // or $myView = $this->View();
			$myView->from("body.html"); // declare fetch to be a template by filename
			$myView->render();

			// Load HTML(DOM) Skeleton
			$content = new Wizard\Build\View(); // or $myView = $this->View();
			$content->from("home-content.html"); // declare fetch to be a template by filename
			$content->to(".page-content"); // declare fetch to be a template by filename
			$content->display_mode("append"); // declare fetch to be a template by filename
			$content->render();

		}

	}
