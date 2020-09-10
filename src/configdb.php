<?php

	/*configuració del la conecció amb la db*/
	/*$db_url = 'dbengine://login:password@localhost/dbname';*/

	if (getenv('testserver')) {
		$db_url = 'mysql://root:dae.woo@localhost/imim_bibliopro';
	}
	else {
		$db_url = 'mysqli://deploy:VeptOmriga@biblioprodb/bibliopro';
	}

	$db_url_web = $db_url;

?>
