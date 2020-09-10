<?php

require ('../../config_admin.inc');
accessGroupPermCheck('menu_publish');

include_once("menus.php");

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
  //crida base de dades
  include_once('variables.php');

  $ID=$_GET['ID'];
  $resultmenus=db_query("select * from MENUS Where ID = '$ID'");
  $rowmenus = db_fetch_array($resultmenus);

  $nommenu = $rowmenus['NOM'];
  $descripmenu = $rowmenus['DESCRIPCIO'];


  $contents = menu_generate($_GET['ID'], $rowmenus['DESPLEGABLE'], $rowmenus['TIPO'], $rowmenus['ESTIL']);

  $tempfilename = $CONFIG_PATHTEMPLATE."/plantilla.html";
  $targetfilename = $CONFIG_PATHMENU.'/'.$nommenu.'.inc';

  /*creo el fitxer amb el menu*/
  $tempfile = fopen($tempfilename, 'w');
  if (!$tempfile) {
    echo"<strong>Impossible obrir la plantilla!</strong>";
    exit();
  }
  fwrite($tempfile, $contents);
  fclose($tempfile);
  copy($tempfilename, $targetfilename);
  if (!empty($CONFIG_PERMFILES)) {
    chmod($targetfilename, $CONFIG_PERMFILES);
  }


			$missatge= "<b>".t("menuregistrycreate")."</b><br><a href=\"veure.php?menu=".$nommenu."\" target=\"_blank\" class=\"text\">".$CONFIG_URLMENU.'/'.$nommenu."</a><br><br>";




  echo $missatge;

  echo ("<b><a href=\"index.php\" class=\"botonavegacio\">".t("continue")."</a></b>");

  db_free_result($resultmenus);
  //insertar registre d'accions
  register_add(t("menuregistrycreate"), "$nommenu ($descripmenu)");
  //fi


?>
</tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
