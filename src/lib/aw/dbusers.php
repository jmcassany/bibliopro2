<?php

include_once("database/database.inc");
$CONFIG_ENCRIPTAR = 'md5';

class dbUsers {

	var $ldap_conn = false;

	function dbUsers()
	{
		$this->Error = '';
		$this->Ok = true;
	}


	function listUsers($number = 0, $name = '',$level = null)
	{
		global $db_url;
		global $USERS_INDEXPAGELENGTH, $USERS_SORTINDEXPAGEBY;
		global $ldap_active;
		$self = "listUsersAll( $number)";
		$page = array();
		$wheresql = array();
		if ($level != null) {
			$level = (int)$level;
			$wheresql[]= 'USERLEVEL='.$level;
		}
		if ($name != '') {
			$wheresql[] = 'LOGIN like \'%'.$name.'%\'';
		}
		$where = '';
		if (count($wheresql) > 0) {
			$where = 'where '.implode(' and ', $wheresql);
		}

		if ($number == 0) {
			$off = 0;
			$max = 9999;
		} else {
			$off = ($number-1) * $USERS_INDEXPAGELENGTH;
			$max = $USERS_INDEXPAGELENGTH;
		}
		$order = '';
		if (isset($USERS_SORTINDEXPAGEBY)) {
			$order = " order by $USERS_SORTINDEXPAGEBY";
		}
		$query = "select * from USERS ".$where." ".$order;
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query_range($query,$off,$max);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		}



		while ($hash = @db_fetch_array($idq)) {
			if ($ldap_active) {
				$ldap_values = $this->ldap_readUser($hash['LOGIN']);
				if (count($ldap_values) > 0) {
					foreach ($ldap_values as $key => $value) {
						$hash[$key] = $ldap_values[$key];
					}
				}
				else {
					$hash['STATUS'] = '1';
					$hash['PASSWD'] = '';
					$hash['EMAIL'] = '';
					$hash['REALNAME'] = '';
					$hash['TELEPHONE'] = '';
					$hash['ldap_error'] = true;
				}
			}
			//			foreach ($hash as $key => $value) {
			//				$hash[$key] = stripslashes($value);
			//			}
			$page[] = $hash;
		}
		return($page);
	}


	function readUser($login)
	{
		global $db_url;
		global $ldap_active;
		$self = "readUser($login)";
		$query = "select * from USERS where LOGIN='$login'";
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return false;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return false;
		}
		if (db_num_rows($idq) > 0) {
			$hash = @db_fetch_array($idq);
		}
		elseif ($ldap_active) {
			$hash = array();
		}
		else {
			return false;
		}

		if ($ldap_active) {
			$ldap_values = $this->ldap_readUser($login);
			if (count($ldap_values) > 0) {
				foreach ($ldap_values as $key => $value) {
					$hash[$key] = $ldap_values[$key];
				}
				$hash['PASSWD'] = '*******';
			}
			elseif (db_num_rows($idq) > 0) {
				$hash['STATUS'] = '1';
				$hash['PASSWD'] = '';
				$hash['EMAIL'] = '';
				$hash['REALNAME'] = '';
				$hash['TELEPHONE'] = '';
				$hash['ldap_error'] = true;
			}
			else {
				return false;
			}
			/*usuari no de houdini pero si de ldap, l'identifiquem com a usuari d'intranet*/
			if (db_num_rows($idq) == 0) {
				$hash['STATUS'] = '0';
				$hash['EXPIRATION'] = '2065-10-10 00:00:00';
				$hash['COMMENTS'] = '';
				$hash['USERLEVEL'] = 1;
			}
		}
		//		foreach ($hash as $key => $value) {
		//			$hash[$key] = stripslashes($value);
		//		}
		return($hash);
	}

	function validateUser($login, $passwd)
	{
		global $db_url;
		global $ldap_active, $CONFIG_ENCRIPTAR;
		$self = "validateUser($login)";
		if ($ldap_active) {
			return $this->_ldap_validate($login, $passwd);
		}
		else {

			$query = "select PASSWD from USERS where LOGIN='$login'";
			$idc = @db_connect($db_url);
			if (!$idc) {
				$this->error($self . ' 1: Could not connect to the database server.');
				return false;
			}
			$idq = @db_query($query);
			if (!$idq) {
				$this->error($self . ' 3: Unable to perform query: ' . $query);
				return false;
			}
			if (db_num_rows($idq) > 0) {
				$row = @db_fetch_array($idq);
				$passwd=$CONFIG_ENCRIPTAR($passwd);
				if ($passwd==$row['PASSWD']) {
					return true;
				}
				else {
					return false;
				}
			}
			else {
				return false;
			}
		}
		return false;
	}


	function existsLogin($login)
	{
		global $db_url;
		$self = "existsLogin($login)";
		$login = $this->normalize($login);
		$query = "select * from USERS where LOGIN='$login'";
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		}
		if (db_num_rows($idq) != 0) {
			return(true);
		}
		else {
			return(false);
		}
	}


	function newUser($login, $passwd, $level, $status, $expiration, $email, $realname, $telephone, $comments)
	{
		global $db_url;
		global $ldap_active;
		$self = "newUser($level,$login)";
		$login = $this->normalize($login);
		if ($ldap_active) {
			if (!$this->_ldap_checkLogin($login)) {
				return (false);
			}
		}
		$passwd = "'" . addslashes($passwd) . "'";
		$level = (int)$level;
		$status = (int)$status;
		$expiration = "'" . addslashes($expiration) . "'";
		$email = "'" . addslashes($email) . "'";
		$realname = "'" . addslashes($realname) . "'";
		$telephone = "'" . addslashes($telephone) . "'";
		$comments = "'" . addslashes($comments) . "'";

		$names = "LOGIN, PASSWD, USERLEVEL, STATUS, EXPIRATION, EMAIL, REALNAME, TELEPHONE, COMMENTS";
		$values = "'$login', $passwd, $level, $status, $expiration, $email, $realname, $telephone, $comments";
		$query = "insert into USERS ($names) VALUES ($values)";
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return(false);
		}

		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return(false);
		}
		return(true);
	}


	function updateUser($login, $passwd, $level, $status, $expiration, $email, $realname, $telephone, $comments)
	{
		global $db_url;
		global $ldap_active;
		$self = "updateUser($login)";
		$login = $this->normalize($login);
		if ($ldap_active) {
			if (!$this->_ldap_checkLogin($login)) {
				return (false);
			}
		}
		////// comprovacio del password////////////////////////
		if ($passwd=="") {// si esta buit no fem res
			$querypassword="";
		}else{
			$passwd = "'" . addslashes($passwd) . "'";
			$querypassword="PASSWD=".$passwd.", ";
		}

		$level = (int)$level;
		$status = (int)$status;
		$expiration = "'" . addslashes($expiration) . "'";
		$email = "'" . addslashes($email) . "'";
		$realname = "'" . addslashes($realname) . "'";
		$telephone = "'" . addslashes($telephone) . "'";
		$comments = "'" . addslashes($comments) . "'";

		$query = "update USERS SET ".$querypassword."USERLEVEL=$level, STATUS=$status, EXPIRATION=$expiration, EMAIL=$email, REALNAME=$realname, TELEPHONE=$telephone, COMMENTS=$comments where LOGIN='".$login."'";
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		}
	}


	function updateUserLogin($login, $newlogin)
	{
		global $db_url;
		global $ldap_active;
		if ($ldap_active) {
			return (false);
		}
		$self = "updateUserLogin($login, $newlogin)";
		$login = $this->normalize($login);
		$newlogin = $this->normalize($newlogin);
		if ($newlogin == $login) {
			return;
		}
		$login = "'" . addslashes($login) . "'";
		$newlogin = "'" . addslashes($newlogin) . "'";

		$query = "update USERS SET LOGIN = ".$newlogin." where LOGIN=".$login;
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		}
	}


	function deleteUser($login)
	{
		global $db_url, $USERS_admin;
		if ($login == $USERS_admin) {
			return false;
		}
		$self = "deleteUser($login)";
		$query = "delete from USERS where LOGIN='$login'";
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return false;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return false;
		}
		return true;

	}


	function countUsers($level = '')
	{
		global $db_url;
		$self = "countUsers($level)";
		$filter = '';
		if ($level != '') {
			$filter = " where USERLEVEL='$level' ";
		}
		$query = "select count(*) as COUNT from USERS" . $filter;
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		}
		$data = @db_fetch_array($idq);
		return($data['COUNT']);
	}


	function countUsersPages($level = '')
	{
		global $db_url;
		global $USERS_INDEXPAGELENGTH;
		$self = "countUsersPages($level)";
		$total = $this->countUsers($level);
		$total = ceil($total / $USERS_INDEXPAGELENGTH);
		if ($total < 1) {
			$total = 1;
		}
		return($total);
	}
	function normalize($login)
	{
		//$login = strtolower(trim($login));
		//$login = preg_replace('#[^[:alnum:]]#', '', $login);
		return($login);
	}
	function error($message)
	{
		$this->Ok = false;
		$this->Error = $message . " " . db_error();
	}


	function listLoginAll()
	{
		global $db_url;
		$self = "listLoginAll()";
		$query = "select LOGIN from USERS order by LOGIN ASC";
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		}
		$logins = array();
		//		while ($row = @db_fetch_array($idq)) {
		//			$logins[] = stripslashes($row['LOGIN']);
		//		}
		return($logins);
	}

	function getComments($login)
	{
		global $db_url;
		$self = "getComments($login)";
		$query = "select COMMENTS from USERS where LOGIN='$login'";
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		}
		$row = db_fetch_array($idq);
		$comments = $row['COMMENTS'];
		if ($comments == '') {
			return (array());
		}
		else {
			return (explode(',',$comments));
		}
	}

	function setComments($login, $comments)
	{
		global $db_url;
		if (!is_array($comments)) {
			$comments = '';
		}
		else {
			$comments = implode(',',$comments);
		}
		$self = "setComments($login,$comments)";
		$comments = addslashes($comments);
		$query = "update USERS set COMMENTS = '".$comments."' where LOGIN='$login'";
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		}
	}



	/*funció de neteja de caracters estranys en ldap*/
	function _ldap_clear($string) {
		return preg_replace('/(\)|\(|\||&)/', '', $string);
	}


	/*funcions ldap*/
	function _ldap_connect() {
		global $ldap_server;
		global $ldap_user, $ldap_password;
		if ($this->ldap_conn) {
			return true;
		}
		$this->ldap_conn = @ldap_connect ($ldap_server);

		if (!$this->ldap_conn) {
			return false;
		}

		if (!@ldap_set_option($this->ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3 )) {
			return false;
		}

		if (isset($ldap_user) && isset($ldap_password)) {
			return (@ldap_bind ($this->ldap_conn, $ldap_user, $ldap_password));
		}
		else {
			return (@ldap_bind ($this->ldap_conn));
		}
	}

	function _ldap_validate($login, $passwd) {

		global $ldap_server, $ldap_dn, $ldap_uid_label;

		if (!$this->_ldap_connect()) {
			return false;
		}

		if (isset($login) && isset($passwd)) {
			$result = @ldap_search ($this->ldap_conn, $ldap_dn, '('.$ldap_uid_label.'='.$this->_ldap_clear($login).')', array($ldap_uid_label));
			if (!$result) {
				return false;
			}
			$info = @ldap_get_entries($this->ldap_conn, $result);

			if ($info['count'] == 1 && $info[0][$ldap_uid_label][0] == $login && $info[0]['dn'] != '') {

				ldap_close($this->ldap_conn);
				$this->ldap_conn = @ldap_connect ($ldap_server);

				if (!$this->ldap_conn) {
					return false;
				}

				if (!@ldap_set_option($this->ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3 )) {
					return false;
				}
				return (ldap_bind ($this->ldap_conn, $info[0]['dn'], $passwd));

			}
			else {
				return false;
			}

		}


		return false;
	}

	function _ldap_checkLogin($login) {
		global $ldap_dn, $ldap_uid_label;
		if (!$this->_ldap_connect()) {
			return false;
		}
		$result = @ldap_search ($this->ldap_conn, $ldap_dn, '('.$ldap_uid_label.'='.$this->_ldap_clear($login).')', array($ldap_uid_label));
		if (!$result) {
			return false;
		}
		$info = @ldap_get_entries($this->ldap_conn, $result);

		if ($info['count'] == 1 && $info[0][$ldap_uid_label][0] == $login) {
			return (true);
		}
		return (false);
	}

	function ldap_readUser($login) {
		global $ldap_dn, $ldap_uid_label;
		if (!$this->_ldap_connect()) {
			return array();
		}
		$result = @ldap_search ($this->ldap_conn, $ldap_dn, '('.$ldap_uid_label.'='.$this->_ldap_clear($login).')', array($ldap_uid_label,'userpassword', 'cn', 'telephonenumber', 'mail'));
		$info = @ldap_get_entries($this->ldap_conn, $result);
		if ($info['count'] == 1 && $info[0][$ldap_uid_label][0] == $login) {
			$login = '';
			if (isset($info[0][$ldap_uid_label][0])) {
				$login = $info[0][$ldap_uid_label][0];
			}
			$email = '';
			if (isset($info[0]['mail'][0])) {
				$email = $info[0]['mail'][0];
			}
			$realname = '';
			if (isset($info[0]['cn'][0])) {
				$realname = $info[0]['cn'][0];
			}
			$telephone = '';
			if (isset($info[0]['telephonenumber'][0])) {
				$telephone = $info[0]['telephonenumber'][0];
			}

			return array('LOGIN' => $login,
			'cn' => $info[0]['cn'][0],
			'EMAIL' => $email,
			'REALNAME' => $realname,
			'TELEPHONE' => $telephone);
		}
		return array();
	}
	function ldap_searchUsers($login) {
		global $ldap_dn, $ldap_uid_label;
		$users = array();
		if (!$this->_ldap_connect()) {
			return false;
		}

		$result = ldap_search ($this->ldap_conn, $ldap_dn, '(&(objectClass=person)('.$ldap_uid_label.'=*'.$this->_ldap_clear($login).'*))');

		if ($result !== false) {
			$info = ldap_get_entries($this->ldap_conn, $result);
			for ($i = 0; $i < $info['count']; $i++) {
				$login = '';
				if (isset($info[$i][$ldap_uid_label][0])) {
					$login = $info[$i][$ldap_uid_label][0];
				}
				$email = '';
				if (isset($info[$i]['mail'][0])) {
					$email = $info[$i]['mail'][0];
				}
				$realname = '';
				if (isset($info[$i]['cn'][0])) {
					$realname = $info[$i]['cn'][0];
				}
				$telephone = '';
				if (isset($info[$i]['telephonenumber'][0])) {
					$telephone = $info[$i]['telephonenumber'][0];
				}

				$users[] = array('LOGIN' => $login,
				'EMAIL' => $email,
				'REALNAME' => $realname,
				'TELEPHONE' => $telephone);
			}
			return $users;
		}
		else { return array(); }
	}
	/*fi funcions ldap*/

}

?>
