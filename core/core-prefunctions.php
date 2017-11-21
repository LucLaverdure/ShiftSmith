<?php
	if (!IN_SHIFTSMITH) die();

	function q($arg_number='all') {
		if ($arg_number=='all') {
			return (isset($_GET['q'])) ? $_GET['q'] : '/';
		} elseif (is_numeric($arg_number)) {
			$array = explode('/', q());
			if (isset($array[$arg_number])) {
				return $array[$arg_number.''];
			}
		} elseif (!is_numeric($arg_number)) {
			return inpath($arg_number);
		}
		return '';
	}

	function p($param) {
		$db = new Database();
		$dblink = $db->connect();
		return $db->param($param);
	}
	
	function input($key='all') {
		if ($key=='all') {
			$keys = array();
			foreach($_REQUEST as $mkey => $val) {
				if (!in_array($mkey, explode(',', PROTECTED_UNIT))) {
					$this_key = str_replace('_', '.', $mkey);
					$ex_key = explode('.', $this_key);
					if (count($ex_key) > 1) {
						$keys[$this_key] = array();
						foreach ($ex_key as $k => $v) {
							if (!in_array($k, explode(',', PROTECTED_UNIT))) {
								if (is_numeric($k) && is_array($v)) {
									$keys[$this_key.'[]'] = $val;
								} elseif (is_numeric($k)) {
									$keys[$this_key] = $val;
								} elseif (is_array($v)) {
									foreach ($v as $k1 => $v1) {
										$keys[$this_key.'.'.$k.'.'.$k1] = $v1;
									}
								} else {
									$keys[$this_key.'.'.$k] = $val;
								}
							}
						}
					} else {
						$keys[$this_key] = $val;
					}
				}
			}

			return $keys;
		} else {
			$key = str_replace('.', '_', $key);

			if (isset($_REQUEST[$key])) {
				if (!in_array($key, explode(',', PROTECTED_UNIT))) {
					return $_REQUEST[$key];
				}
			} else {
				return '';
			}
		}
		return '';
	}

	function inpath($url) {
		
//		echo "key:".$url.':'.q()."\n";
		
		if (substr($url, 0, 1) == "/") $url = substr($url, 1);
		if (substr($url, -1) == "/") $url = substr($url, 0, -1);
		$url = preg_quote($url, '/');
		$url = str_replace('\*', '(.*)',$url);
		
		$q = trim(q());
		
		if (substr($q, 0, 1) == "/") $q = substr($q, 1);
		if (substr($q, -1) == "/") $q = substr($q, 0, -1);

//		echo "key2:".$url.':'.$q."\n";
		
		$ret = trim(preg_match('/^'.$url.'$/', $q));
		return $ret;
	}

	function elog($data) {
		global $mainpath;
		$log_file = $mainpath."logs/errors.log";
		$fh = @fopen($log_file, 'a');
		@fwrite($fh, $data."\n");
		@fclose($fh);
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