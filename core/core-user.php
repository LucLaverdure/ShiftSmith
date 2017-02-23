<?php

	if (!IN_DREAMFORGERY) die();
	
	class User {
		
		static private $isAdmin;
		static private $isLoggedIn;
		
		public function isAdmin() {
			if (isset($_SESSION['login']))
				return true;
			else
				return false;
		}

		public function isLoggedIn() {
			
		}
		
		public function getProperty($prop) {
			$db = new Database();
			$db::connect();
			
			
		}

		public function login($email, $password) {
			$db = new Database();
			$db::connect();
			
			$sql = "SELECT id, password FROM user WHERE email='".$db::param($email)."' LIMIT 1;";
			if (count($sql) > 0) {
				
				$encrypted = crypt($password, ')&(*"?/BOC(*"&?');
				
				if ($encrypted == $sql[0]['password']) {
					
					// login user
					$_SESSION['login'] = $sql[0]['id'];
					
				} else {
					$this->logout();
				}
			}
		}
		
		public function logOut() {
			unset($_SESSION['login']);
		}
	
	}
?>