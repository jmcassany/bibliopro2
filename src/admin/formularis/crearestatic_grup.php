<?php

require ('../config_admin.inc');
accessGroupPermCheck('form_publish');

include_once("formularis.php");
require_once('variables.inc');

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
		<td colspan="2" class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("utils"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td width="50%" class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="Sou a" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../index.php"><?php echo t("home"); ?></a>
                    <img src="../comu/kland_etsa.gif" width="19" height="5"  border="0">
                    <a href="../utilitats/index.php"><?php echo t("utils"); ?></a>
                    <img src="../comu/kland_etsa.gif" width="19" height="5"  border="0">
                    <font class="blau10b">Generar formularis</font>
                    </td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td class="text" colspan="2" style="padding:20px;">

<?php


	$result=db_query("select * from FORMULARIS where STATUS=1");


while ($row = db_fetch_array($result)) {

	$valors = generate_page ($row);


  if (!is_array($valors)) {
	echo '
<img src="../comu/houdini_alerta.gif" alt="Alert" border="0" align="absmiddle">
<font class="grana">Formulari no generat</font> | '.$row['NOMFORMULARI'].'</font>
<br><br>';

	continue;
  }

	$resultat = create_page($row['NOMFORMULARI'], $row['PARE'], $valors['normal']);
    if(!empty($resultat)) {
	echo '
<img src="../comu/houdini_alerta.gif" alt="Alert" border="0" align="absmiddle">
<font class="grana">Formulari no generat</font> | '.$row['NOMFORMULARI'].'</font>
<br><br>';
	} else {
      $pagina = folderPath($row['PARE']).'/'.$row['NOMFORMULARI'];
      $ruta_final = str_replace("//", "/", $pagina);
      $ruta_final = $CONFIG_URLBASE."/".$ruta_final;
	echo '
<img src="../comu/miniico_nova.gif" alt="Ok" border="0" align="left" ><font class="blau11b">Formulari creat</font> |<a href="'.$ruta_final.'" target="_blank" class="text">'.$row['NOMFORMULARI'].'</a><br><br>
	';
	}


}






?>

<b><a href="../utilitats/index.php" class="botonavegacio"><?php echo t("continue") ?></a></b>
</tr>
</table>
</div>
<?php echo htmlFoot(); ?>
</body>
</html>
