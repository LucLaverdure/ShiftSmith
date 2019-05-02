<?php
	class Admin_Panel extends Wizard\Build\Controller {

		function validate() {
			$db = DB();

			if (route("/admin")) {
				return -10;
			}
			return false;
		}

		function execute() {
			$m = Model("title", "Select Site Categories");
			
			$matrix = Matrix();

			$matrix->space("category")
				->def("id", "i")
				->def("title");
			$matrix->add(1, "Blog or Personal")
			->add(2, "Commerce")
			->add(3, "Business")
			->add(4, "Portfolio")
			->add(5, "Media")
			->add(6, "Brochure")
			->add(7, "Non Profit")
			->add(8, "Educational")
			->add(9, "Portal")
			->add(10, "Wiki");

			$myView = View(); // or $myView = $this->View();
			$myView->from("admin-skeleton.html"); // declare fetch to be a template by filename
			$myView->render(); // declare fetch to be a template by filename

			$myView2 = View(); // or $myView = $this->View();
			$myView2->from("admin-panel.html"); // declare fetch to be a template by filename
			$myView2->to("body"); // declare fetch to be a template by filename
			$myView2->render("prepend"); // declare fetch to be a template by filename

		}

	}
