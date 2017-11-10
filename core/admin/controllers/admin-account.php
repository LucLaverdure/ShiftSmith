<?php
	// Step 1: Create admin account
	class create_user extends Controller {
		
		function validate() {
			// inpath /user
			if (q('user') && (!$this->user->isLoggedIn()) && ($this->user->counted() == 0)) {
				return 1;	// priority 1
			}
			else return false;
		}

		function execute() {
			// Step 1: Create Account
			
			$this->addModel('prompt', 'title', 'Create Admin Account');
			$this->addModel('prompt', 'message', '');
			$this->addModel('prompt', 'error', '');

			$ret = false;
			
			if (input('trigger.email') != '') {
				if (!validate_email(input('trigger.email'))) {
					$ret = "Invalid Email!";
				} else {
					$ret = $this->user->add(input('trigger.email'), input('trigger.password'), input('trigger.password2'));
				}
			}

			if ($ret === true) {
				if ($this->user->counted() == 0) {
					$this->addModel('prompt', 'error', "Database connection failed. Please verify `config/config-cms.php`");
					$this->loadView('admin-create.tpl');
					return true;
				}
				$this->addModel('prompt', 'message', "A confirmation email has been sent to validate your account.");
				$this->loadView('admin-login.tpl');
				return true;
			} else {
				$this->addModel('prompt', 'error', $ret);
			}
			
			$this->loadView('admin-create.tpl');
		}
	}

	// Step 2: Confirm account creation by email.
	class user_confirm_key extends Controller {
		// Display function: validate urls to activate the controller
		function validate() {
			if (q('confirm/admin/*/*') && (!$this->user->isLoggedIn())) {
				return 1;	// priority 1
			}
			else return false;
		}

		function execute() {
			$this->addModel('prompt', "message",'');
			$this->addModel('prompt', 'error', "");
		
			//url: confirm/admin/{key}/{email}
			$key = q(2);
			$email = q(3); 

			// verify key to user combination to activate account (no login yet)
			$ret = $this->user->confirm($email, $key);
			
			if ($ret === true) {
				// account activated.
				$this->addModel('prompt', "message", 'Key: '.p($key).' applied to account "'.p($email).'". This account is now active, you may now login.');
			} else {
				// invalid key to user
				$this->addModel('prompt', "error", 'Key: '.p($key).' could not be applied to account "'.p($email).'".');
			}
			$this->addModel('prompt', 'title', 'Login');
			$this->loadView('admin-login.tpl');
		}
	}

	// Step 3: Login.
	class user_login extends Controller {
		// Display function: validate urls to activate the controller
		function validate() {
			if ((q('user')) && (!$this->user->isLoggedIn()) && ($this->user->counted() > 0) ) {
				return 1;	// priority 1
			}
			else return false;
		}

		function execute() {
			// login user
			
			// default values
			$ret = false;
			$this->addModel('prompt', "message", '');
			$this->addModel('prompt', "error", '');

			// login user when form submitted
			if (input('trigger.email') != '') {
				$ret = $this->user->login(input('trigger.email'), input('trigger.password'));
			}

			// when user is logged in, redirect to dashboard
			if ($ret === true) {
				$this->addModel('prompt', "message", 'Login success!');
				redirect('/user');
			} elseif (input('trigger.email') != '') {
				$this->addModel('prompt', "error", 'Invalid email/password combination or account');
			}
			
			$this->loadView('admin-login.tpl');
		}	
	}

	// Logged in panel
	class user_logged_in extends Controller {
		// Display function: validate urls to activate the controller
		function validate() {
			if ((q('user')) && ($this->user->isLoggedIn()) && ($this->user->isAdmin())) {
				return 1;	// priority 1
			}
			else return false;
		}

		function execute() {
			$email = $this->user->getEmail();
			
			$this->addModel('prompt', "title",'Account Status');
			$this->addModel('prompt', "message", p($email).' logged In.');
			$this->addModel('prompt', "error",'');
			
			// custom visualization
			$d3data = $this->db->queryResults("SELECT COUNT(value) valcount, value
									   FROM `shiftsmith`
									   WHERE `key` LIKE '%tags.name%'
									   GROUP BY `value`
									   ORDER BY id DESC");

			$this->addModel('d3data', $d3data);
									   
			
			$this->loadView('admin-logged-in.tpl');
			
		}
	}


	// Log out in panel
	class user_logout extends Controller {
		// Display function: validate urls to activate the controller
		function validate() {
			if (q('admin/logout') && ($this->user->isLoggedIn())) {
				return 1;	// priority 1
			}
			else return false;
		}

		function execute() {
			$this->user->logout();
			redirect('/');
		}
	}
