<?php
	// Step 1: Create adminisatrator account
	class create_admin extends Controller {
		
		// Display function: validate urls to activate the controller
		function validate() {
			// Activate home controller for /home and /home/*

			$db = new Database();
			$db::connect();
			
			$data = $db::queryResults("SELECT id, email
									   FROM users
									   ORDER BY id DESC
									   LIMIT 1");
			
			if ((q()=="user" || q()=="user/") && $data === false && !isset($_SESSION['login']) ) {
				return 1;	// priority 1
			}
			else return false;
		}

		function execute() {
			$db = new Database();
			$db::connect();

			// Step 1: Create Account
			// no users are registered
			
			$this->addModel('prompt', 'title', 'Create Admin Account');
			$this->addModel('prompt', 'message', "");
			$this->addModel('prompt', 'error', "");
			
		if (
			(isset($_POST['password'])) &&
			(isset($_POST['password2'])) &&
			(isset($_POST['email'])) &&
			($_POST['password'] == $_POST['password2']) && 
			($_POST['password'] != '') && 
			(validate_email($_POST['email'])) 
		) {
			$rnd = substr(str_shuffle('98v31b6opnh694o6nxd9804nb63029871n6bx0798bn32x691b603c2'),0,8);
			Database::query("CREATE TABLE users (
										id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
										email VARCHAR(50) NOT NULL,
										password VARCHAR(32) NOT NULL,
										keygen VARCHAR(32) NOT NULL,
										active VARCHAR(1) NOT NULL
										);");
										
			
			$this->addModel('prompt', 'title', 'Login');

			
			$data = $db::query("DELETE FROM users;");
			$data = $db::query("INSERT INTO users (email, password, keygen, active) VALUES ('".$db::param($_POST['email'])."', '".crypt($_POST['password'], ')&(*"?/BOC(*"&?')."', '".$rnd."', 'N');");
			
			email($_POST['email'], 'Confirm Administration Account', '<a href="http://dreamforgery.com/confirm/admin/'.$rnd.'/'.$db::param($_POST['email']).'">Click here to confirm your account</a>');

			$this->addModel('prompt', 'message', "An email has been sent to ".htmlentities($_POST['email']).", please check your email and confirm the admin account.");
			$this->addModel('prompt', 'includes', 'true');
			$this->loadView('admin-login.tpl');
			return;
		}
		
		$this->addModel('error', "");
		
		$this->loadView('admin-create.tpl');
	}
}

	// Step 2: Confirm account creation by email.
	class admin_confirm_key extends Controller {
		// Display function: validate urls to activate the controller
		function validate() {
			$db = new Database();
			$db::connect();
			
			$data = $db::queryResults("SELECT id, email
									   FROM users
									   WHERE active='N'
									   ORDER BY id DESC
									   LIMIT 1");
			
			if ((q('0')=="confirm" || q(1)=="admin") && ($data !== false) && !isset($_SESSION['login'])) {
				return 1;	// priority 1
			}
			else return false;
		}

		function execute() {
			// Step 1: Create Account
			// no users are registered
			$db = new Database();
			$db::connect();

			$this->addModel('prompt', "message",'');
			$this->addModel('prompt', 'error', "");

			if (q('0')=='confirm' && q(1) == 'admin') {
				$data = $db::queryResults("SELECT id, email
										   FROM users
										   WHERE active='N'
										   AND keygen='".$db::param(q(2))."'
										   AND email='".$db::param(q(3))."'
										   ORDER BY id DESC
										   LIMIT 1");
				if ($data != false) {
					$data = $db::queryResults("	UPDATE users
												SET active='Y'
												WHERE
											   keygen='".$db::param(q(2))."'
											   AND email='".$db::param(q(3))."'
											   ORDER BY id DESC
											   LIMIT 1");
					
					$this->addModel('prompt', "message", 'Key: '.$db::param(q(2)).' applied to account "'.$db::param(q(3)).'". This account is now active, you may now login.');
				} else {
					$this->addModel('prompt', "error", 'Key: '.$db::param(q(2)).' could not be applied to account "'.$db::param(q(3)).'".');
				}
			
			}

			$this->addModel('prompt', 'title', 'Login');
			$this->addModel('prompt', 'includes', 'true');
			$this->loadView('admin-login.tpl');
		}
	}

	// Step 3: Login.
	class admin_login extends Controller {
		// Display function: validate urls to activate the controller
		function validate() {
			$db = new Database();
			$db::connect();
			
			$data = $db::queryResults("SELECT id, email
									   FROM users
									   ORDER BY id DESC
									   LIMIT 1");
			
			if ((q()=="user" || q()=="user/") && ($data !== false) && !isset($_SESSION['login'])) {
				return 1;	// priority 1
			}
			else return false;
		}

		function execute() {

			$db = new Database();
			$db::connect();

			$this->addModel('prompt', 'title', 'Login');
			$this->addModel('prompt', "message",'');
			$this->addModel('prompt', 'error', "");

			if (isset($_POST['login_entry']) && ($_POST['login_entry']=='true') && isset($_POST['password'])) {
				$data = $db::queryResults("SELECT id, email
										   FROM users
										   WHERE active='Y'
										   AND email='".$db::param($_POST['email'])."'
										   AND password='".crypt($_POST['password'], ')&(*"?/BOC(*"&?')."'
										   ORDER BY id DESC
										   LIMIT 1");
				if ($data !== false) {
					$_SESSION['login'] = $data[0]['id'];
					redirect('/user');
					return;
				} else {
					$this->addModel('prompt', 'title', 'Login');
					$this->addModel('prompt', "message",'');
					$this->addModel('prompt', 'error', "Invalid Credentials.");
				}
			}
			
			$this->addModel('prompt', 'includes', 'true');
			$this->loadView('admin-login.tpl');
		}
	}

	// Logged in panel
	class admin_logged_in extends Controller {
		// Display function: validate urls to activate the controller
		function validate() {
			if ((q()=="user" || q()=="user/") && (isset($_SESSION['login']))) {
				return 1;	// priority 1
			}
			else return false;
		}

		function execute() {

			$db = new Database();
			$db::connect();

			$data = $db::queryResults("SELECT email
									   FROM users
									   WHERE active='Y'
									   AND id='".$db::param($_SESSION['login'])."'
									   ORDER BY id DESC
									   LIMIT 1");

			
			$this->addModel('prompt', "title",'Account Status');
			$this->addModel('prompt', "message", $data[0]['email'].' logged In.');
			$this->addModel('prompt', "error",'');
			
			$this->addModel('prompt', 'includes', 'false');
			
			$d3data = $db::queryResults("SELECT COUNT(value) as valcount, value
									   FROM `shiftsmith`
									   WHERE `key`='tag'
									   AND `namespace`='trigger'
									   GROUP BY `value`
									   ORDER BY id DESC");

			$this->addModel('d3data', $d3data);
									   
			
			$this->loadView('admin-logged-in.tpl');
			
		}
	}


	// Logged in panel
	class admin_logout extends Controller {
		// Display function: validate urls to activate the controller
		function validate() {
			if ((q('0')=="admin" && q(1)=="logout") && (isset($_SESSION['login']))) {
				return 1;	// priority 1
			}
			else return false;
		}

		function execute() {
			
			unset($_SESSION['login']);
			redirect('/');
			
			$this->addModel('prompt', 'includes', 'false');
			$this->loadView('admin-logged-in.tpl');
			
		}
	}