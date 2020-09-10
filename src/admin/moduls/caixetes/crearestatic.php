<?php

require ('../../config_admin.inc');
accessGroupPermCheck('boxes');

require('caixetes.php');


include("variables.php");
?>
<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;padding:20px;">
	<tr>
		<td class="text" align="center">

<?php

$result=db_query("select * from CAIXETES where ID=$ID");
$row = db_fetch_array($result);


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
  echo"<strong>Impossible obrir la plantilla!</strong>";
  exit();
}
fwrite($tempfile, $dynamic_source);
fclose($tempfile);
copy($tempfilename, $targetfilename);
if (!empty($CONFIG_PERMFILES)) {
  chmod($targetfilename, $CONFIG_PERMFILES);
}

$missatge= '<b>Caixeta creada</b><br><a href="veure.php?caixeta='.$NOM.'" target="_blank" class="text">'.$targeturl.'</a><br><br>';

echo $missatge;

echo ("<b><a href=\"index.php\" class=\"botonavegacio\">".t("continue")."</a></b>");

//insertar registre d'accions
register_add("Caixeta generada", $NOM.' ('.$row['DESCRIPCIO'].')');
//fi


?>
</tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
