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
					// at least one user is in the database
					$user = new \Wizard\Build\User();
					if ($user->isLoggedIn()) {
						\Wizard\Build\Tools::redirect("/");
						return false;
					}
				} else {
					// no users in the database, must create first user
					return 2;
				}
			}
			return false;
		}

		function execute() {
			
			Model("error", "", "general");
			Model("name", Posted("name"), "user");
			Model("email", Posted("email"), "user");
			Model("password1", Posted("password1"), "user");
			Model("password2", Posted("password2"), "user");
			if (Got("name") && (strlen(Posted("name")) < 3 )) {
				Model("error", "Name must contain at least 3 characters", "general");
			}
			if (Got("email") && (!\Wizard\Build\Tools::validate_email(Posted("email"))) ) {
				Model("error", "Invalid email!", "general");
			}
			if (Got("password1")) {
				if (strlen(Posted("password1")) >= 6) {
					// validate passwords
					if (Posted("password1") == Posted("password2")) {
						// save user as admin
						$rec = Matrix();
						$rec->space("users")->def("id", "i")->def("name")->def("email")->def("passhash")->def("email_token")->def("status", "i");
						$rec->add(1, Posted("name"), Posted("email"), password_hash(Posted("password1"), PASSWORD_BCRYPT, ['cost' => 12]), md5(time()), 0);
						$rec->save(1); // save first user as admin

						// save access GROUP matrix
						$rec2 = Matrix();
						$rec2->space("access_groups")->def("uid", "i")->def("aid", "i");
						$rec2->add(1, 1);
						$rec2->save(); // save first user as admin

						// save access USER matrix
						$rec3 = Matrix();
						$rec3->space("access_levels")->def("id", "i")->def("label");
						$rec3->add(0, "guest");
						$rec3->add(1, "admin");
						$rec3->save(); // save first user as admin
						
						// login user as it is created
						$user = new \Wizard\Build\User();
						$login_ret = $user->login(Posted("email"), Posted("password1"));

					} else {
						Model("error", "Passwords don't match.", "general");
					} 
				} else {
					Model("error", "Passwords minimum length is of 6 characters.", "general");
				}
			}

			Model("title", "Administrator Setup", "general");

			// redirect user after saving
			$usersIn = Matrix();
			$usersIn->space("users")->def("id");
			$counted_users = count($usersIn->load());
			if ($counted_users > 0) {
				\Wizard\Build\Tools::redirect("/");
				die();
			}

			// display if not redirected
			$myView = View(); // or $myView = $this->View();
			$myView->from("admin-skeleton.html"); // declare fetch to be a template by filename
			$myView->render(); // declare fetch to be a template by filename

			$myView2 = View(); // or $myView = $this->View();
			$myView2->from("admin-user.html"); // declare fetch to be a template by filename
			$myView2->to("body"); // declare fetch to be a template by filename
			$myView2->render("prepend"); // declare fetch to be a template by filename

		}

	}
