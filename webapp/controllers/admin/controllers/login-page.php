<?php
class admin_login_page extends Controller {
	
	function validate() {
		if ((q()=='admin') || (q('0')=='confirm' && q(1) == 'admin')) return 1;
		else return false;
		die();
	}
	
	function execute() {
		try {
			
			if (isset($_SESSION['admin'])) {
				$this->addModel('admin', 'email', $_SESSION['admin'][0]['email']);
				$this->loadView('admin/admin-loggedin.tpl');
				return;
			}
			
			// attempt connection to the database
			$db = new Database();
			$db::connect();
			
			$this->cacheForm('user', array('email'=>''));

			// confirm admin
			if (q('0')=='confirm' && q(1) == 'admin') {
				$code = q(2);
				$email = q(3);
				
				$data = $db::queryResults("SELECT id, email
										   FROM users
										   WHERE active='N'
										   AND keygen='".$db::param($code)."'
										   AND email='".$email."'
										   ORDER BY id DESC
										   LIMIT 1");
				if ($data==false) {
					$this->addModel('misc.fail', 'redbg');
					$this->loadView('admin/admin.tpl');
					return;
				} else {
					$data = $db::query("UPDATE users SET active='Y' WHERE keygen='".$db::param($code)."' AND email='".$email."'");
					$this->addModel('misc.fail', 'greenbg2');
					$this->loadView('admin/admin.tpl');
					return;
				}
				
			}
			
			// verify if an admin user exists
			$data = $db::queryResults("SELECT id, email
									   FROM users
									   WHERE active='Y'
									   ORDER BY id DESC
									   LIMIT 1");
			if ($data==false) {
				// no users are registered
				
				$this->addModel('misc.fail', 'redbg');
				
				if ( ($_POST['password'] == $_POST['password2']) && ($_POST['password'] != '') && (validate_email($_POST['email'])) ) {
					$rnd = substr(str_shuffle('98v31b6opnh694o6nxd9804nb63029871n6bx0798bn32x691b603c2'),0,8);
					$data = $db::query("CREATE TABLE users (
												id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
												email VARCHAR(50) NOT NULL,
												password VARCHAR(32) NOT NULL,
												keygen VARCHAR(32) NOT NULL,
												active VARCHAR(1) NOT NULL
												);");
					$data = $db::query("INSERT INTO users (email, password, keygen, active) VALUES ('".$db::param($this->getModel('user', 'email'))."', '".md5($_POST['password'])."', '".$rnd."', 'N');");
					email($_POST['email'], 'Confirm Administration Account', '<a href="http://dreamforgery.com/confirm/admin/'.$rnd.'/'.$db::param($_POST['email']).'">Click here to confirm your account</a>');
					$this->addModel('misc.fail', 'greenbg');
				}
				
				
				
				$this->loadView('admin/register.tpl');
				return;
			} else {
				$data = $db::queryResults("SELECT id, email
										   FROM users
										   WHERE active='Y'
										   AND email='".$db::param($_POST['email'])."'
										   AND password='".md5($_POST['password'])."'
										   ORDER BY id DESC
										   LIMIT 1");
				
				if ($data != false) {
					$_SESSION['admin'] = $data;
					redirect('/');
				} else {
					unset($_SESSION['admin']);
				}
			}

			// login user
			$data = $db::queryResults("SELECT id, email
									   FROM users
									   WHERE email='".$db::param($_POST['email'])."'
									   AND password='".md5($_POST['password'])."'
									   ORDER BY id DESC
									   LIMIT 1");
			
			if ($data == false)
				$this->addModel('misc.fail', 'redbg');
			else
				$this->addModel('misc.fail', 'greenbg');
			
			$this->loadView('admin/admin.tpl');
		} catch (Exception $e) {
			$this->addModel('dbStatus', 'down');
			$this->loadView('admin/db.tpl');
		}
	}
}

class admin_tools extends Controller {
	
	function validate() {
		// ensure we are logged in as admin
		if (isset($_SESSION['admin']))
			return 99;
		else
			return false;
	}
	
	function execute() {
		$this->injectView('head', 'append', 'admin/admin-head.tpl');
		$this->injectView('body', 'prepend', 'admin/admin-banner.tpl');
	}
}