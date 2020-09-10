<?php
session_start();

include("config.php");

//CONTROL DE CLICKS ALS BANNERS
//if (empty($_SERVER['HTTP_REFERER'])) {

	$_SESSION['id'] = session_id();

	$result_cookie = mysql_query("SELECT * FROM newsletter_clicsbanners WHERE ID_NL=".$_GET['ID']." AND ID_BAN=".$_GET['idbanner']);
	$num_cookie = mysql_num_rows($result_cookie);
	if($num_cookie != 0)
	{
		$exit = 0;
		while ($row_cookie = mysql_fetch_array($result_cookie))
		{
			if($_SESSION['id'] == $row_cookie['GALETA']) $exit = 1;
		}
		if($exit==0)
		{
			$result_links = mysql_query("SELECT * FROM newsletter_nltobanner WHERE ID_NL=".$_GET['ID']." AND ID_BAN=".$_GET['idbanner']);
			$row_links = mysql_fetch_array($result_links);
			$links = $row_links['LINKS']+1;

			$result_links2 = mysql_query("UPDATE newsletter_nltobanner SET LINKS=".$links." WHERE ID_NL=".$_GET['ID']." AND ID_BAN=".$_GET['idbanner']);

			$result_cookie2 = mysql_query("INSERT INTO newsletter_clicsbanners (ID_BAN,ID_NL,GALETA) VALUES (".$_GET['idbanner'].",".$_GET['ID'].",'".$_SESSION['id']."')");
		}
	}
	else {
		$result_links = mysql_query("SELECT * FROM newsletter_nltobanner WHERE ID_NL=".$_GET['ID']." AND ID_BAN=".$_GET['idbanner']);
		$row_links = mysql_fetch_array($result_links);
		$links = $row_links['LINKS']+1;

		$result_links2 = mysql_query("UPDATE newsletter_nltobanner SET LINKS=".$links." WHERE ID_NL=".$_GET['ID']." AND ID_BAN=".$_GET['idbanner']);

		$result_cookie2 = mysql_query("INSERT INTO newsletter_clicsbanners (ID_BAN,ID_NL,GALETA) VALUES (".$_GET['idbanner'].",".$_GET['ID'].",'".$_SESSION['id']."')");
	}
//}

header("Location: ".$_GET['urlbanner']);
?>
