<?php

require ('../../config_admin.inc');
accessGroupPermCheck('composition');

require('compositions.php');


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

$result = db_query('SELECT * FROM BANNERS Where ID=\''.$ID.'\'');
$row = db_fetch_array($result);
$caixetes = explode('|',$row['TEXT']);

include ('variables.php');
$contents = call_user_func($tipus_banners[$TIPO]['crear'],$row,$caixetes);

$tempfilename = $CONFIG_PATHTEMPLATE.'/plantilla.html';
$targetfilename = $CONFIG_PATHBANNER.'/'.$row['NOM'].'.inc';
$targeturl = $CONFIG_URLBANNER.'/'.$row['NOM'].'.inc';

$tempfile = fopen($tempfilename, 'w');
if (!$tempfile) {
  echo"<strong>Impossible obrir la plantilla!</strong>";
}
else {
  fwrite($tempfile, $contents);
  fclose($tempfile);
  copy($tempfilename, $targetfilename);
  if (!empty($CONFIG_PERMFILES)) {
    chmod($targetfilename, $CONFIG_PERMFILES);
  }
  echo '<b>Banner creat</b><br><a href="veure.php?banner='.$row['NOM'].'" target="_blank" class="text">'.$targeturl.'</a><br><br>';
}

echo ("<b><a href=\"index.php\" class=\"botonavegacio\">".t("continue")."</a></b>");

//insertar registre d'accions
register_add("Banner generat", $row['NOM'].' ('.$row['DESCRIPCIO'].')');
//fi


?>
</tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
