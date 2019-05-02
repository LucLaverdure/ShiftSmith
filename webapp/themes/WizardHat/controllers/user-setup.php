<?php
	class User_Setup extends Wizard\Build\Controller {

		function validate() {
			$db = DB();
			// if users count = 0 && DB works
			if (route("/user")) {
				$matrix2 = Matrix();
				$matrix2->space("users")->def("id");
				$counted_users = count($matrix2->load());
				if ($counted_users > 0) {
					\Wizard\Build\Tools::redirect("/admin");
					return false;
				} else {
					return -99;
				}
			}
			return false;
		}

		function execute() {
			$matrix = Matrix();
			$matrix->space("user")->def("name")->def("email")->def("password1")->def("password2");
			//$matrix->input("textbox", "textbox", "password", "password");
			
			$m = Model("error", "", "general");
			if (Posted("email") != "") {
				if (strlen(Posted("password1")) >= 6) {
					// validate passwords
					if (Posted("password1") == Posted("password2")) {
						// validate email
						if (\Wizard\Build\Tools::validate_email(Posted("email"))) {
							// save user as admin
							$matrix2 = Matrix();
							$matrix2->space("users")->def("id", "name", "email", "passhash", "email_token", "status");
							$matrix2->add(1, Posted("name"), Posted("email"), password_hash(Posted("password1"), PASSWORD_BCRYPT, ['cost' => 12]), md5(time()), 0);
							$matrix2->save(1); // save first user as admin

							$matrix3 = Matrix();
							$matrix3->space("access")->def("id", "userid", "access");
							$matrix3->add(1, 1, "admin");
							$matrix3->save(1, 1); // save first user as admin
						} else {
							$m = Model("error", "Invalid email provided.", "general");
						}
					} else {
						$m = Model("error", "Passwords don't match.", "general");
					} 
				} else {
					$m = Model("error", "Passwords minimum length is of 6 characters.", "general");
				}
			}

			$m = Model("title", "Administrator Setup", "general");

			$myView = View(); // or $myView = $this->View();
			$myView->from("admin-skeleton.html"); // declare fetch to be a template by filename
			$myView->render(); // declare fetch to be a template by filename

			$myView2 = View(); // or $myView = $this->View();
			$myView2->from("admin-user.html"); // declare fetch to be a template by filename
			$myView2->to("body"); // declare fetch to be a template by filename
			$myView2->render("prepend"); // declare fetch to be a template by filename

		}

	}
