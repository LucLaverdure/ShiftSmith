<?php

	class admin extends Controller {
		
		// Display function: validate urls to activate the controller
		function validate() {
			// Activate home controller for /home and /home/*
			if (q()=="user" || q()=="user/") {
				return 1;	// priority 1
			}
			else return false;
		}

		function execute() {
		// Step 1: Create Account
		// no users are registered
			$this->addModel('glob', 'title',  'Create Login');
		
		if ( ($_POST['password'] == $_POST['password2']) && ($_POST['password'] != '') && (validate_email($_POST['email'])) ) {
			$rnd = substr(str_shuffle('98v31b6opnh694o6nxd9804nb63029871n6bx0798bn32x691b603c2'),0,8);
			Database::query("CREATE TABLE users (
										id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
										email VARCHAR(50) NOT NULL,
										password VARCHAR(32) NOT NULL,
										keygen VARCHAR(32) NOT NULL,
										active VARCHAR(1) NOT NULL
										);");
										
			
			$this->addModel('adcreate', true);
			
			$data = $db::query("INSERT INTO users (email, password, keygen, active) VALUES ('".$db::param($this->getModel('user', 'email'))."', '".md5($_POST['password'])."', '".$rnd."', 'N');");
			
			email($_POST['email'], 'Confirm Administration Account', '<a href="http://dreamforgery.com/confirm/admin/'.$rnd.'/'.$db::param($_POST['email']).'">Click here to confirm your account</a>');
		}
		
		$this->loadView('default-theme/user.tpl');
	}
	}

	class admin_confirm extends Controller {
			// Display function: validate urls to activate the controller
			function validate() {

				Database::queryResults("SELECT id FROM users;");
				if ($data == false) {
					return false;
					// Activate home controller for /home and /home/*
					if (q()=="user" || q()=="user/") {
						return 1;	// priority 1
					}
					else return false;
				}
			}

			function execute() {
				// Step 1: Create Account
				// no users are registered
				
				$this->addModel('title', 'Login');
				if (q('0')=='confirm' && q(1) == 'admin') {
					$data = $db::queryResults("SELECT id, email
											   FROM users
											   WHERE active='N'
											   AND keygen='".$db::param($_POST['key'])."'
											   AND email='".$_POST['email']."'
											   ORDER BY id DESC
											   LIMIT 1");
				
				}
				
				$this->loadView('default-theme/user.tpl');
			}
	}
