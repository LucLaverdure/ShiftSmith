<?php

	namespace Wizard\Build;
	
	/*
	 *  Main User class
	 */
	class User {
		
		// returns count of all users in db
		public function counted() {
			$ret = DB()->query("SELECT COUNT(id) counted FROM users;");
			if ($ret == false) {
				return 0;
			} else {
				return $ret[0]['counted'];
			}
		}
		// returns count of all users activated by email in db
		public function counted_active() {
			$ret = DB()->query("SELECT COUNT(id) counted FROM users WHERE active='Y';");
			if ($ret == false) {
				return 0;
			} else {
				return $ret[0]['counted'];
			}
		}
		// get email of current user
		public function getEmail() {
			if ($this->isLoggedIn()) {
				$ret = DB()->query("SELECT email FROM users WHERE active='Y' AND id='?' LIMIT 1;", 's', $_SESSION['login']);
				if ($ret != false) {
					return $ret[0]['email'];
				}
			}
			
			return false;
		}
		
		// returns true if admin is logged on, false otherwise
		public function isAdmin() {
			if (isset($_SESSION['login'])) {
				$sql = "SELECT id
					   FROM users
					   WHERE active = 'Y'
					   AND admin = 'Y'
					   AND id = '?'
					   LIMIT 1;";
					   
				$data = DB()->query($sql, 's', $_SESSION['login']);
				if (($data != false) && ($data[0]['id'] == $_SESSION['login'])) {
					return true;
				}
			}
			
			return false;
		}
		// return true if a user is logged in, false otherwise
		public function isLoggedIn() {
			if (isset($_SESSION['login'])) {
				return true;
			}
			return false;
		}
		
		// login with email and password, returns true on logon, false otherwise
		public function login($email, $password) {
			$data = DB()->query("SELECT id, email, `password` pwd
						   FROM users
						   WHERE active='Y'
						   AND email='?'
						   ORDER BY id DESC
						   LIMIT 1", 's', $email);

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
			// verify if passwords match
			if ($password != $password_confirm) {
				// passwords mismatch
				return 'Passwords mismatch';
			}
			
			$counted_users = $this->counted();

			// db table doesn't exist
			if ($counted_users == 0) {
					$sql = "CREATE TABLE `users` (
					  `id` int(6) UNSIGNED NOT NULL,
					  `email` varchar(50) COLLATE latin1_general_ci NOT NULL,
					  `password` text COLLATE latin1_general_ci NOT NULL,
					  `keygen` varchar(32) COLLATE latin1_general_ci NOT NULL,
					  `active` varchar(1) COLLATE latin1_general_ci NOT NULL,
					  `admin` varchar(1) COLLATE latin1_general_ci NOT NULL
					) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;";
					$ret = DB()->query($sql);
					$sql = "ALTER TABLE `users`
					  ADD PRIMARY KEY (`id`);";
					$ret = DB()->query($sql);
					$sql = "ALTER TABLE `users`
					  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;";
					$ret = DB()->query($sql);
			}
			
			// verify if email exists
			$email_exists = DB()->query("SELECT id, email
							   FROM users
							   WHERE email='?'
							   ORDER BY id DESC
							   LIMIT 1", 's', $email);
			
			if ($email_exists != false) {
				// email already exists
				return 'Email already exists';
			}
			
			// random string, ommitting confusing values like 0oO, l1i
			$rnd = substr(str_shuffle('23456789abcdefghjklmnpqrstuvwxyz'), 0, 8);
			
			$isAdmin = 'N'; // default: not admin
			if ($counted_users <= 0) { // when no users in active db
				$isAdmin = 'Y'; // first user is admin
			}
			
			$sql = "INSERT INTO users (email, password, keygen, active, admin)
				VALUES ('?', '?', '?', 'N', '?');";

			$data = DB()->query($sql, 'sssss', $email, password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]), $rnd, $isAdmin);

			email($email, 'Account Confirmation', 'Please <a href="http://'.$_SERVER['SERVER_NAME'].'/confirm/admin/'.$rnd.'/'.$email.'">click here</a> to activate your account at '.$_SERVER['SERVER_NAME']);
			return true;
		}
		
		// confirm email account link to user
		public function confirm ($email, $key) {
			// verify if user exists
			$data = DB()->query("SELECT id, email
					   FROM users
					   WHERE active='N'
					   AND keygen='?'
					   AND email='?'
					   ORDER BY id DESC
					   LIMIT 1;", 'ss', $key, $email);
			if ($data != false) {
				// on found user, update to active user (user must still login)
				DB()->query("UPDATE users
						SET active='Y'
						WHERE
						keygen='?'
						AND email='?'
						ORDER BY id DESC
						LIMIT 1;", 'ss', $key, $email);
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
