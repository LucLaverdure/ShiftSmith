<?php
	class User_Login extends Wizard\Build\Controller {

		function validate() {
			$user = new \Wizard\Build\User();
			// if users count = 0 && DB works
			if (route("/user") && (!$user->isLoggedIn()) ) {
				return 1;
			}
			return false;
		}

		function execute() {
			
			Model("title", "Administrator Login", "general");

			Model("error", "", "general");
			Model("email", Posted("email"), "user");
			Model("password1", Posted("password1"), "user");
			
			$user = new \Wizard\Build\User();
			$login_success = $user->login(Posted("email"), Posted("password1"));
			if ($login_success) {
				\Wizard\Build\Tools::redirect("/");
				die();
			} elseif (Posted("email") != "") {
				Model("error", "Invalid Credentials!", "general");
			}


			// display if not redirected
			$myView = View(); // or $myView = $this->View();
			$myView->from("admin-skeleton.html"); // declare fetch to be a template by filename
			$myView->render(); // declare fetch to be a template by filename

			$myView2 = View(); // or $myView = $this->View();
			$myView2->from("admin-login.html"); // declare fetch to be a template by filename
			$myView2->to("body"); // declare fetch to be a template by filename
			$myView2->render("prepend"); // declare fetch to be a template by filename

		}

	}
