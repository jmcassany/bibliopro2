<?php

	if (getenv('testserver')) {
		$CONFIG_PATHPHP = dirname(__FILE__);
	}
	else {
// 		$CONFIG_PATHPHP = '/var/www/media/php';
		$CONFIG_PATHPHP = dirname(__FILE__);
	}

	// funció comprovació correus electrònics
	function isValidEmail ($email)
	{
		$isValid = true;
		$atIndex = strrpos($email, "@");
		if (is_bool($atIndex) && !$atIndex) {
			$isValid = false;
		}
		else {
			$domain = substr($email, $atIndex+1);
			$local = substr($email, 0, $atIndex);
			$localLen = strlen($local);
			$domainLen = strlen($domain);
			if ($localLen < 1 || $localLen > 64) {
				$isValid = false;
			}
			else if ($domainLen < 1 || $domainLen > 255) {
				$isValid = false;
			}
			else if ($local[0] == '.' || $local[$localLen-1] == '.') {
				// local part starts or ends with '.'
				$isValid = false;
			}
			else if (preg_match('/\\.\\./', $local)) {
				// local part has two consecutive dots
				$isValid = false;
			}
			else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
				// character not valid in domain part
				$isValid = false;
			}
			else if (preg_match('/\\.\\./', $domain)) {
				// domain part has two consecutive dots
				$isValid = false;
			}
			else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
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

	require_once($CONFIG_PATHPHP.'/config.php');
	require_once('configdb.php');
	require_once ("database/database.inc");
	include_once($CONFIG_PATHBASE.'/admin/config/05ldap.config.php');
	db_connect($db_url_web);
	require_once ('aw/awaccess.php');

	manageLogout();

// 	if (accessGetLogin() != '') { accessGroupPermCheck('intranet', $LOGIN_page); }

	function manageLogout()
	{
		if (isset($_GET['logout'])) {
			accessLogout();
		}
		return;
	}

?>