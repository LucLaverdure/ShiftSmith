<?php
	if (!IN_DREAMFORGERY) die();

	function q($arg_number='all') {
		if ($arg_number=='all') {
			return (isset($_GET['q'])) ? $_GET['q'] : '/';
		} elseif (is_numeric($arg_number)) {
			$array = explode('/', q());
			if (isset($array[$arg_number])) {
				return $array[$arg_number+''];
			}
		} elseif (!is_numeric($arg_number)) {
			return inpath($arg_number);
		}
		return '';
	}

	function p($param) {
		$db = new Database();
		$dblink = $db::connect();
		return mysqli_real_escape_string($dblink, $param);
	}
	
	function input($key) {
		$key = str_replace('.', '_', $key);

		if (isset($_REQUEST[$key]))
			return $_REQUEST[$key];
		else
			return '';
	}

	function inpath($url) {
		$url = preg_quote($url, '/');
		$url = str_replace('\*', '(.*)',$url);
		$url = preg_match('/^'.$url.'$/', q());
		return $url;
	}

	function elog($data) {
		global $mainpath;
		$log_file = $mainpath."logs/errors.log";
		$fh = @fopen($log_file, 'a');
		@fwrite($fh, $data."\n");
		@fclose($fh);
	}

	function form_cache($form_name, $default_values = array(), $options='N') {
		// prevent admin access (configurable)
		if (in_array($form_name, explode(',', PROTECTED_UNIT))) {
			$form_name = '';
		}

		// set form array if not created
		if (!isset($_SESSION[$form_name])) $_SESSION[$form_name] = array();

		// set default values
		foreach ($default_values as $key => $var) {
			if ((!isset($_SESSION[$form_name][$key])) || $options == 'FORCE.CACHE') {
				if (in_array($key, explode(',', PROTECTED_UNIT))) {
					unset($_SESSION[$form_name][$key]);
				}
				$_SESSION[$form_name][$key] = $var;
			}
		}

		// override previous values when form is posted
		if ($options != 'FETCH.ONLY') {
			foreach ($_REQUEST as $key => $var) {
				if (strpos($key, '.') !== false) {
					$key_explosion = explode('.', $key);
					$forekey = array_shift($key_explosion);
					if (in_array($forekey, explode(',', PROTECTED_UNIT))) {
						unset($_SESSION[$forekey]);
					} else {
						$_SESSION[$forekey][implode('.', $key_explosion)] = $value;
					}
				} else {
					if (in_array($key, explode(',', PROTECTED_UNIT))) {
                                                unset($_SESSION[$form_name][$key]);
                                        } else {
						$_SESSION[$form_name][$key] = $var;
                                        }
				}
			}
		}
		
		// return form cache
		return $_SESSION;
	}

	function validate_email($email) {
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

	function redirect($url) {
		header("Location: ". $url);
		die();
	}

	function t($text) {
		return $text;
	}
	
	function email($to, $subject, $message) {
		$message='<table width="100%" colspan="0" cellpadding="0" border="0">
	<tr>
		<td width="350"><img src="http://'.$_SERVER["SERVER_NAME"].'/files/img/logo-black.gif" width="114" height="121" /></td>
		<td colspan="2"><span style="font-size:20px;color:orange;font-family:\'Arial\';">'.$subject.'</span></td>
	</tr>
	<tr>
		<td colspan="3" style="font-size:20px;color:#924c0e;font-family:\'Arial\';">
			<br><br>'.$message.'<br><br>
		</td>
	</tr>
	<tr>
		<td colspan="3"><a href="http://'.$_SERVER["SERVER_NAME"].'">http://'.$_SERVER["SERVER_NAME"].'</a></td>
	</tr>
</table>';

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

?>
