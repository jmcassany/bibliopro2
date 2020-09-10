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
include('formatting.php');
include('../config.php');
include_once ("database/database.inc");
error_reporting(0);
?>

<h4>Generació de carpetes dinàmiques</h4>

<?php
db_connect($db_url);

require_once ($CONFIG_PATHADMIN.'/config_admin.inc');

require_once ($CONFIG_PATHADMIN.'/carpetes/variables.inc');
$result_din = db_query("SELECT * FROM CARPETES WHERE CATEGORY1=1 ORDER BY PARE ASC");
while($row_din = db_fetch_array($result_din))
{
	echo "<p>Generant carpeta ".$row_din['ID']." - ".$row_din['NOMCARPETA']." <a href=\"".$CONFIG_NOMCARPETA."/".folderPath($row_din['ID'])."\">".folderPath($row_din['ID'])."</a> </p>";

	folderGenerate(folderPath($row_din['PARE']), $row_din['NOMCARPETA']);

	$missatge = dinFolderGenerateFiles ($row_din);
  	if (!is_string($missatge))
  	{
    	$missatge='<span class="green">Carpeta generada correctament</span>';
  	}
  	else
  	{
  		$missatge='<span class="error">Error generant la carpeta: '.$missatge.' </span>';
  	}
  	echo '<p>'.$missatge.'</p>';

}

?>
<hr />
<h4>Generació de formularis</h4>

<?php


include_once($CONFIG_PATHADMIN.'/formularis/formularis.php');
require_once($CONFIG_PATHADMIN.'/formularis/variables.inc');

$result_forms = db_query("SELECT * FROM FORMULARIS WHERE STATUS=1 ORDER BY PARE ASC");

while($row_forms = db_fetch_array($result_forms))
{
	echo "<p>Generant formulari ".$row_forms['ID']." -  <a href=\"".$CONFIG_NOMCARPETA."/".folderPath($row_forms['PARE'])."/".$row_forms['NOMFORMULARI']."\">".$row_forms['TITOLFORMULARI']."</a> </p>";

	$valors = generate_page ($row_forms);
	if(!is_array($valors))
	{
		$missatge='<span class="error">Error generant formulari </span>';
	}
	else
	{
		$resultat = create_page($row_forms['NOMFORMULARI'], $row_forms['PARE'], $valors['normal']);

    	if(!empty($resultat))
    	{
    		$missatge='<span class="error">Error pàgina no creada </span>';
    	}
    	else
    	{
    		$missatge='<span class="green">Formulari generat correctament</span>';
    	}
	}
	echo '<p>'.$missatge.'</p>';
}


?>
<hr />
<h4>Generació de menús</h4>

<?php




require_once($CONFIG_PATHADMIN.'/moduls/menus/variables.php');

$result_menus = db_query("SELECT * FROM MENUS WHERE STATUS=1 ORDER BY PARE ASC");
while($row_menus = db_fetch_array($result_menus))
{
	echo "<p>Generant formulari ".$row_menus['ID']." ".$row_menus['NOM']." -  <a href=\"".$CONFIG_URLMENU."/".$row_menus['NOM'].".inc\">".$row_menus['DESCRIPCIO']."</a> </p>";

	$contents = '';
	$contents = menu_generate($row_menus['ID'], $row_menus['DESPLEGABLE'], $row_menus['TIPO'], $row_menus['ESTIL']);

  	$tempfilename = $CONFIG_PATHTEMPLATE."/plantilla.html";
  	$targetfilename = $CONFIG_PATHMENU.'/'.$row_menus['NOM'].'.inc';

  	//creo el fitxer amb el menu
  	$tempfile = fopen($tempfilename, 'w');
  	if (!$tempfile) {
    	echo"<strong>Impossible obrir la plantilla!</strong>";
    	//exit();
  	}
  	fwrite($tempfile, $contents);
  	fclose($tempfile);
  	copy($tempfilename, $targetfilename);
  	if (!empty($CONFIG_PERMFILES)) {
    	chmod($targetfilename, $CONFIG_PERMFILES);
  	}

}

?>
