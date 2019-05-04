<?php
	class DB_Setup extends Wizard\Build\Controller {

		function validate() {
			$db = DB();

			if (route("/")) {
				if (!$db::isConnected()) {
					if (CMS_DB_HOST=="") return 1;
				} else {
					Wizard\Build\Tools::redirect("/user");
					die();
				}
			}
			return false;
		}

		function execute() {
			Model("error", "", "general");
			if (Posted("CMS_DB_HOST") != "") {
				$con = DB();
				$con::connect(Posted("CMS_DB_HOST"),Posted("CMS_DB_USER"), Posted("CMS_DB_PASS"), Posted("CMS_DB_NAME"));
				if ($con::isConnected()) {
					// save config
					file_put_contents(PATH."config/cms-configs.php", '<?php
						DEFINE("CMS_DB_HOST", "'.Posted("CMS_DB_HOST").'");
						DEFINE("CMS_DB_USER", "'.Posted("CMS_DB_USER").'");
						DEFINE("CMS_DB_PASS", "'.Posted("CMS_DB_PASS").'");
						DEFINE("CMS_DB_NAME", "'.Posted("CMS_DB_NAME").'");
					?>');
				} else {
					$m = Model("error", "Database connection failure", "general");
					// display error
					Model("CMS_DB_NAME", Posted("CMS_DB_NAME"), "db");
					Model("CMS_DB_HOST", Posted("CMS_DB_HOST"), "db");
					Model("CMS_DB_USER", Posted("CMS_DB_USER"), "db");
					Model("CMS_DB_PASS", Posted("CMS_DB_PASS"), "db");
				}
			} else {
				Model("CMS_DB_NAME", Posted("CMS_DB_NAME"), "db");
				Model("CMS_DB_HOST", Posted("CMS_DB_HOST"), "db");
				Model("CMS_DB_USER", Posted("CMS_DB_USER"), "db");
				Model("CMS_DB_PASS", Posted("CMS_DB_PASS"), "db");
			}
			Model("title", "Database Connection", "general");

			$myView = View(); // or $myView = $this->View();
			$myView->from("admin-skeleton.html"); // declare fetch to be a template by filename
			$myView->render(); // declare fetch to be a template by filename

			$myView = View(); // or $myView = $this->View();
			$myView->from("admin-db.html"); // declare fetch to be a template by filename
			$myView->to("body"); // declare fetch to be a template by filename
			$myView->render("prepend"); // declare fetch to be a template by filename

		}

	}
