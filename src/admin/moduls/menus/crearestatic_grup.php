<?php

require ('../../config_admin.inc');
accessGroupPermCheck('menu_publish');

include_once("menus.php");

?>
<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="carregat();">

<?php echo htmlHeader(); ?>
<div id="carregant" style="width: 780px; height: 100%; text-align: center;"><br><br><?php echo t("generating"); ?></div>
<div id="contingut" style="width: 780px;display: none">
<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;margin-bottom:0px">

	<!-- situacio Sou a -->
	<tr>
		<td colspan="2" class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("utils"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td width="50%" class="text10"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="Sou a" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../index.php"><?php echo t("home"); ?></a>
                    <img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0">
                    <a href="../../utilitats/index.php"><?php echo t("utils"); ?></a>
                    <img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0">
                    <font class="blau10b">Generar Menus</font>
                    </td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td class="text" colspan="2" style="padding:20px;">

<?php

  //crida base de dades
  include_once('variables.php');

  $resultmenus=db_query("select * from MENUS where STATUS=1");
while ($rowmenus = db_fetch_array($resultmenus)) {

  $nommenu = $rowmenus['NOM'];
  $descripmenu = $rowmenus['DESCRIPCIO'];


  $contents = menu_generate($rowmenus['ID'], $rowmenus['DESPLEGABLE'], $rowmenus['TIPO'], $rowmenus['ESTIL']);

  $tempfilename = $CONFIG_PATHTEMPLATE."/plantilla.html";
  $targetfilename = $CONFIG_PATHMENU.'/'.$nommenu.'.inc';

  /*creo el fitxer amb el menu*/
  $tempfile = fopen($tempfilename, 'w');
  if (!$tempfile) {
	echo '
<img src="../comu/houdini_alerta.gif" alt="Alert" border="0" align="absmiddle">
<font class="grana">Menú no generat</font> | '.$rowmenus['NOM'].'</font>
<br><br>';

	continue;
  }
  fwrite($tempfile, $contents);
  fclose($tempfile);
  copy($tempfilename, $targetfilename);
  if (!empty($CONFIG_PERMFILES)) {
    chmod($targetfilename, $CONFIG_PERMFILES);
  }


	echo '
<img src="../../comu/miniico_nova.gif" alt="Ok" border="0" align="left" ><font class="blau11b">Menú creat</font> |<a href="veure.php?menu='.$rowmenus['NOM'].'" target="_blank" class="text">'.$rowmenus['NOM'].'</a><br><br>
	';



}






?>

<b><a href="../../utilitats/index.php" class="botonavegacio"><?php echo t("continue") ?></a></b>
</tr>
</table>
</div>
<?php echo htmlFoot(); ?>
</body>
</html>
