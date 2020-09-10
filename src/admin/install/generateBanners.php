<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<title>Houdini Generació de continguts ...</title>
<link rel="stylesheet" href="install.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<div class="border">
<h2 >Houdini&nbsp; |&nbsp; Generar tots els continguts</h2>
<h3>Copyright &#169; 2004 - Can Antaviana</h3>
</div>

<?php

$PATHLIB = substr(dirname(__FILE__),0, -strlen('admin/install/')).'/lib';
$PATHADMIN = substr(dirname(__FILE__),0, -strlen('install/'));

$include_path = ini_get('include_path');
ini_set('include_path', $include_path.':'.$PATHLIB);

require_once('configdb.php');


///configuracio mysql servidor
include('../config.php');
include_once ("database/database.inc");
error_reporting(0);
?>

<h4>Generació de Caixetes</h4>

<?php
db_connect($db_url);

require_once ($CONFIG_PATHADMIN.'/config_admin.inc');

require_once ($CONFIG_PATHADMIN.'/moduls/caixetes/variables.php');
$result_din = db_query("SELECT * FROM CAIXETES");
while($row = db_fetch_array($result_din))
{	
	echo "<p>Generant Caixeta ".$row['NOM']." </p>";
	
	$rutaimatge=$CONFIG_PATHBOX."/".$row['IMATGE'];
	$targeturl = $CONFIG_URLBOX."/".$row['IMATGE'];
	
	$contents = caixeta_create($row);
	
	$dynamic_source = "$contents";
	
	
	$NOM=$row['NOM'];
	
	$tempfilename = $CONFIG_PATHTEMPLATE.'/plantilla.html';
	$targetfilename = $CONFIG_PATHBOX."/".$NOM.'.inc';
	$targeturl = $CONFIG_URLBOX."/".$NOM.'.inc';
	
	$tempfile = fopen($tempfilename, 'w');
	if (!$tempfile) {
	  $missatge='<span class="error">Error generant la caixeta: Impossible obrir la plantilla! </span>';	  
	}
	else 
	{
		fwrite($tempfile, $dynamic_source);
		fclose($tempfile);
		copy($tempfilename, $targetfilename);
		if (!empty($CONFIG_PERMFILES)) {
		  chmod($targetfilename, $CONFIG_PERMFILES);
		}
		
		$missatge= '<span class="green">Caixeta generada correctament</span>';
	}
	echo "<p>$missatge</p>";

}

?>
<h4>Generació de Composicions</h4>

<?php



require_once ($CONFIG_PATHADMIN.'/moduls/composicions/variables.php');
$result_din = db_query("SELECT * FROM BANNERS");
while($row = db_fetch_array($result_din))
{	
	echo "<p>Generant Composició ".$row['NOM']." </p>";
	
	$caixetes = explode('|',$row['TEXT']);

	$contents = call_user_func($tipus_banners[$row['TIPO']]['crear'],$caixetes);
	
	$tempfilename = $CONFIG_PATHTEMPLATE.'/plantilla.html';
	$targetfilename = $CONFIG_PATHBANNER.'/'.$row['NOM'].'.inc';
	$targeturl = $CONFIG_URLBANNER.'/'.$row['NOM'].'.inc';
	
	$tempfile = fopen($tempfilename, 'w');
	if (!$tempfile) {
		$missatge='<span class="error">Error generant la composicio: Impossible obrir la plantilla! </span>';	  
	}
	else {
		fwrite($tempfile, $contents);
		fclose($tempfile);
		copy($tempfilename, $targetfilename);
		if (!empty($CONFIG_PERMFILES)) {
		  chmod($targetfilename, $CONFIG_PERMFILES);
		}
		
		$missatge= '<span class="green">Composició generada correctament</span>';
	}
	echo "<p>$missatge</p>";
}

?>