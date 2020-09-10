<?php

	define('BEGIN_TRANSACTION', 1);
	define('END_TRANSACTION', 2);
    
	include($CFG_CAMPANYES['PATH_FUNCIONS']."db/mysql.php");

	$db = new sql_db($CONFIG_DBSERVER, $CONFIG_DBUSER, $CONFIG_DBPASSWORD, $CONFIG_DBNAME, false);
	if(!$db->db_connect_id) {
    die("<br /><br /><center><b>Ho lamentem, hi ha problemes amb el servidor.<br /><br />Tornarem el més aviat possible.</b></center>");
	}

?>