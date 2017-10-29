<?php
	if (!IN_SHIFTSMITH) die();
	
	/*
	 *  Main User class
	 */
	class User {
		
		// returns count of all users in db
		public function counted() {
			
			$db = new Database();
			$db->connect();
			
			$sql = $db->queryResults("SELECT COUNT(id) counted FROM users;");
			if ($sql) {
				return $sql[0]['counted'];
			} 
			return 0;
		}

		// returns count of all users activated by email in db
		public function counted_active() {
			$db = new Database();
			$db->connect();
			
			$sql = $db->queryResults("SELECT COUNT(id) counted FROM users WHERE active='Y';");
			if ($sql) {
				return $sql[0]['counted'];
			} 
			return 0;
		}

		// get email of current user
		public function getEmail() {
			if ($this->isLoggedIn()) {
				$db = new Database();
				$db->connect();
				$sql = $db->queryResults("SELECT email FROM users WHERE active='Y' AND id='".$_SESSION['login']."' LIMIT 1;");
				if ($sql != false) {
					return $sql[0]['email'];
				}
				return;
			}
			
			return false;
		}

		
		// returns true if admin is logged on, false otherwise
		public function isAdmin() {
			$db = new Database();
			$db->connect();

			if (isset($_SESSION['login'])) {
				$sql = "SELECT id
					   FROM users
					   WHERE active = 'Y'
					   AND admin = 'Y'
					   AND id = '".p($_SESSION['login'])."'
					   LIMIT 1;";
					   
				$data = $db->queryResults($sql);

				if (($data != false) && ($data[0]['id']==$_SESSION['login'])) {
					return true;
				}
			}
			
			return false;
		}

		// return true if a user is logged in, false otherwise
		public function isLoggedIn() {
			if (isset($_SESSION['login']))
				return true;
			else
				return false;
		}
		
		// login with email and password, returns true on logon, false otherwise
		public function login($email, $password) {
			$db = new Database();
			$db->connect();

			$data = $db->queryResults("SELECT id, email, `password` pwd
									   FROM users
									   WHERE active='Y'
									   AND email='".p($email)."'
									   ORDER BY id DESC
									   LIMIT 1");
			if ($data != false) {
				if (($password != '') && (password_verify($password, $data[0]['pwd']) != false)) {
					$_SESSION['login'] = $data[0]['id'];
					return true;
				}
			}
			
			$this->logout();
			
			return false;
			
		}
		
		// Creates a user, first user created is admin
		// returns string of error or exact===true for created
		public function add($email, $password, $password_confirm) {
			// init db
			$db = new Database();
			$db->connect();

			// verify if passwords match
			if ($password != $password_confirm) {
				// passwords mismatch
				return 'Passwords mismatch';
			}
			
			$listusers = $db->queryResults("SELECT COUNT(id)
										   FROM users
										   LIMIT 1;");
			// db table doesn't exist
			if ($listusers == false) {
					$sql = "CREATE TABLE `users` (
					  `id` int(6) UNSIGNED NOT NULL,
					  `email` varchar(50) COLLATE latin1_general_ci NOT NULL,
					  `password` text COLLATE latin1_general_ci NOT NULL,
					  `keygen` varchar(32) COLLATE latin1_general_ci NOT NULL,
					  `active` varchar(1) COLLATE latin1_general_ci NOT NULL,
					  `admin` varchar(1) COLLATE latin1_general_ci NOT NULL
					) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;";
					$ret = $db->query($sql);
					$sql = "ALTER TABLE `users`
					  ADD PRIMARY KEY (`id`);";
					$ret = $db->query($sql);
					$sql = "ALTER TABLE `users`
					  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;";
					$ret = $db->query($sql);
			}
			
			// verify if email exists
			$email_exists = $db->queryResults("SELECT id, email
									   ORDER BY id DESC
									   FROM users
									   WHERE email='".p($email)."'
									   LIMIT 1");
			
			if ($email_exists != false) {
				// email already exists
				return 'Email already exists';
			}

			
			// random string, ommitting confusing values like 0oO, l1i
			$rnd = substr(str_shuffle('23456789abcdefghjklmnpqrstuvwxyz'), 0, 8);

			
			$count = $this->counted();
			
			$isAdmin = 'N'; // default: not admin
			if ($count <= 0) { // when no users in active db
				$isAdmin = 'Y'; // first user is admin
			}
			
			$sql = "INSERT INTO users (email, password, keygen, active, admin)
								VALUES ('".p($email)."',
										'".password_hash($password, PASSWORD_BCRYPT, ['cost' => 12])."',
										'".$rnd."',
										'N',
										'".$isAdmin."'
										);";

			$data = $db->query($sql);

			email($email, 'Account Confirmation', 'Please <a href="http://'.$_SERVER['SERVER_NAME'].'/confirm/admin/'.p($rnd).'/'.p($email).'">click here</a> to activate your account at '.$_SERVER['SERVER_NAME']);

			return true;
		}
		
		// confirm email account link to user
		public function confirm ($email, $key) {

			$db = new Database();
			$db->connect();

			// verify if user exists
			$data = $db->queryResults("SELECT id, email
									   FROM users
									   WHERE active='N'
									   AND keygen='".p($key)."'
									   AND email='".p($email)."'
									   ORDER BY id DESC
									   LIMIT 1;");
			if ($data != false) {
				// on found user, update to active user (user must still login)
				$data = $db->query("UPDATE users
									SET active='Y'
									WHERE
									keygen='".p($key)."'
									AND email='".p($email)."'
									ORDER BY id DESC
									LIMIT 1;");
				return true;
			}
			
			return false;
		}
		
		// remove admin session
		public function logout() {
			if (isset($_SESSION['login'])) {
				unset($_SESSION['login']);
			}
			return true;
		}
	
	}
?>