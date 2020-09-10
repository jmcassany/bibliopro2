<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

		// mySQL connection information




		$dades_db = db_url_parser($db_url);

		$CONFIG_DBSERVER   = $dades_db['host'];
		$CONFIG_DBNAME     = $dades_db['name'];
		$CONFIG_DBUSER     = $dades_db['user'];
		$CONFIG_DBPASSWORD = $dades_db['passwd'];


		//require_once(dirname(__FILE__).'/../../config.php');

?>
