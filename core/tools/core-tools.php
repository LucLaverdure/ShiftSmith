<?php

namespace Wizard\Build; // see "Defining Namespaces" section

	class Tools {

		public static function version() {
			return "0.4.1";
		}

		// test if current user has access level
		public static function access($access_level) {
			// TODO
			return true;
		}

		// q(number) = query argument
		// q(string) = test if current url matches string 
		public static function queryURL($arg_number='all') {
			if ($arg_number=='all') {
				return (isset($_GET['q'])) ? $_GET['q'] : '/';
			} elseif (is_numeric($arg_number)) {
				$array = explode('/', self::queryURL());
				if (isset($array[$arg_number])) {
					return $array[$arg_number.''];
				}
			} elseif (!is_numeric($arg_number)) {
				return self::inpath($arg_number);
			}
			return '';
		}

		
		// q(string) = test if current url matches string 
		private static function inpath($url) {

			if (substr($url, 0, 1) == "/") $url = substr($url, 1);
			if (substr($url, -1) == "/") $url = substr($url, 0, -1);
			$url = preg_quote($url, '/');
			$url = str_replace('\*', '(.*)',$url);
			
			$q = trim(self::queryURL());
			
			if (substr($q, 0, 1) == "/") $q = substr($q, 1);
			if (substr($q, -1) == "/") $q = substr($q, 0, -1);

			$ret = trim(preg_match('/^'.$url.'$/', $q));
			return $ret;
		}

		//custom sort 
		public static function prioritySorter($a, $b) {
			if ($a == $b) return 0;
			return ($a > $b) ? 1 : -1;
		}


		public static function Posted($var) {
			if (isset($_POST[$var])) {
				return $_POST[$var];
			}
			return "";
		}

		public static function Got($var) {
			if (isset($_POST[$var])) {
				return true;
			} else {
				return false;
			}
		}

		// write to logs
		public static function note($data) {
			$log_file = PATH."logs/notes.log";
			$fh = @fopen($log_file, 'a');
			@fwrite($fh, $data."\n");
			@fclose($fh);
		}

		// validate email
		public static function validate_email($email) {
			$isValid = true;
			$atIndex = strrpos($email, "@");
			if (is_bool($atIndex) && !$atIndex) {
				$isValid = false;
			} else {
				$domain = substr($email, $atIndex+1);
				$local = substr($email, 0, $atIndex);
				$localLen = strlen($local);
				$domainLen = strlen($domain);
				if ($localLen < 1 || $localLen > 64) {
					// local part length exceeded
					$isValid = false;
				} else if ($domainLen < 1 || $domainLen > 255) {
					// domain part length exceeded
					$isValid = false;
				} else if ($local[0] == '.' || $local[$localLen-1] == '.') {
					// local part starts or ends with '.'
					$isValid = false;
				} else if (preg_match('/\\.\\./', $local)) {
					// local part has two consecutive dots
					$isValid = false;
				} else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
					// character not valid in domain part
					$isValid = false;
				} else if (preg_match('/\\.\\./', $domain)) {
					// domain part has two consecutive dots
					$isValid = false;
				} else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
					// character not valid in local part unless 
					// local part is quoted
					if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) {
						$isValid = false;
					}
				}
				if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) {
					// domain not found in DNS
					$isValid = false;
				}
			}
			return $isValid;
		}

		// redirect user to new location
		public static function redirect($url) {
			header("Location: ". $url);
			die();
		}

		// translate text
		public static function translate($text) {
			return $text;
		}
		
		// send email
		public static function email($to, $subject, $message) {
			// normal headers
			$num = md5(time()); 
			$headers  = "From: ShiftSmith <noreply@".$_SERVER["SERVER_NAME"].".com>\r\n";

			// This two steps to help avoid spam   
			$headers .= "Message-ID: <".time()." TheSystem@".$_SERVER['SERVER_NAME'].">\r\n";
			$headers .= "X-Mailer: PHP v".phpversion()."\r\n";         

			// With message
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

			mail($to, $subject, $message, $headers);
		}

		public static function endsWith($haystack, $needle) {
			$length = strlen($needle);
			if ($length == 0) {
				return true;
			}

			return (substr($haystack, -$length) === $needle);
		}

		public static function search_files($dir, &$results = array()){

			$files = scandir($dir);
			foreach($files as $key => $value){
				$path = realpath($dir.DIRECTORY_SEPARATOR.$value);
				if(!is_dir($path)) {
					// on file check for allowed config extensions
					$allowed_extensions = explode(',', 'php,php5,php6,php7');
					$allowed = false;
					foreach($allowed_extensions as $ext) {
						if (self::endsWith($path, $ext)) {
							$allowed = true;
						}
					}
					// when allowed, add to array of controller pattern
					if ($allowed) $results[] = $path;
				} else if($value != "." && $value != "..") {
					// on directory, browse
					self::search_files($path, $results);
				}
			}

			return $results;
		}

		private static function search_files_matching_helper($filename, $dir, &$results = array()){
			$files = scandir($dir);

			foreach($files as $key => $value) {
				$path = realpath($dir.DIRECTORY_SEPARATOR.$value);
				if(!is_dir($path)) {

					if ( (strtolower($filename)) == (strtolower(basename($path))) ) {
						$results[] = $path;
					}
				} else if($value != "." && $value != "..") {
					// on directory, browse
					self::search_files_matching_helper($filename, $path, $results);
				}
			}
			return $results;
	 	}

		public static function search_files_matching($filename, $dir){

			$results = self::search_files_matching_helper($filename, $dir);

			return $results;
		}

		public static function stack_resource($filename) {
			Queue::stack_resource($filename);
		}
		
		public static function mvc_input($input_type, $var, $val) {
			switch ($input_type) {
				case "radio":
					return '<input type="radio" name="'.$var.'" value="'.$val.'" />';
					break;
				case "textarea":
					return '<textarea name="'.$var.'">'.$val.'</textarea>';
					break;
				case "checkbox":
					return '<input type="checkbox" name="'.$var.'" value="'.$val.'" />';
					break;
				case "password":
					// passwords values aren't returned for security reasons
					return '<input type="password" name="'.$var.'" />';
					break;
				default:
					return '<input type="textbox" name="'.$var.'" value="'.$val.'" />';
					// textbox
			}
		}
			
	}
?>
