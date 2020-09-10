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

<h4>Generació de visualitzadors RSS</h4>

<?php
db_connect($db_url);

require_once ($CONFIG_PATHADMIN.'/config_admin.inc');

require_once ($CONFIG_PATHADMIN.'/carpetes/variables.inc');
$result_din = db_query("SELECT * FROM VIEWRSS");
while($row = db_fetch_array($result_din))
{	
	echo "<p>Generant RSS ".$row['NOM']." -  <a href=\"".$CONFIG_NOMCARPETA."/".folderPath($row_din['ID'])."\">".folderPath($row_din['ID'])."</a> </p>";
	
  $plantillafile = $CONFIG_PATHTEMPLATERSS.'/'.$row['PLANTILLA'];

  $rssfile = $CONFIG_PATHRSS.'/'.$row['NOM'].'.inc';
  $targeturl = urlDir($CONFIG_URLRSS).'/'.$row['NOM'].'.inc';
  if (file_exists($plantillafile)) {

     $fitxer = fopen($plantillafile, 'r');
     $content = fread($fitxer,filesize($plantillafile));
     fclose($fitxer);
     $content = str_replace(array('|CONFIG_PATHBASE|','|CONFIG_URLBASE|','|LINKRSS|','|MAXRSS|'),array($CONFIG_PATHBASE, $CONFIG_URLBASE, $row['LINKRSS'],$row['MAXRSS']), $content);
     $fitxer = fopen($rssfile, 'w+');
     fwrite($fitxer, $content);
     fclose($fitxer);
     if (!empty($CONFIG_PERMFILES)) {
       chmod($rssfile, $CONFIG_PERMFILES);
     }

     echo '<b>Visualitzador creat</b>'.$targeturl.'<br>';
  }

}

?>
