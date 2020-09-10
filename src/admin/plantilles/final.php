<?php

require ('../config_admin.inc');
accessGroupPermCheck(array('template_edit', 'template_create'));
include_once("plantilles.php");

	 $eleccio=$_GET['eleccio'];
	//CONSULTA per saber el numero de camps de la plantilla
	$result=db_query("select * from PLANTILLA where ID = $eleccio");
	$row = db_fetch_array($result);
	$ID=$row['ID'];
	$nomplantilla=$row['NOM'];

	db_free_result($result);
?>
<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td colspan="2" class="text10" bgcolor="#C0CEE4" style="padding:6px;"><b><?php echo t("templatetitle"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td  class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../index.php"><?php echo t("home"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php"><?php echo t("templatetitle"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="view.php?ID=<?php echo $eleccio ?>"><?php echo $nomplantilla ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="javascript:history.back();"><?php echo t("templatedefine"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("templatecompleted"); ?></font></td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">Registre complet</td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">

					</td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- DESCRIPCIO -->
	<tr>
		<td colspan="2" style="padding:20px;" class="blau11b">
			<img src="../comu/miniico_nova.gif" width="25" height="15" alt="Ok" border="0" align="absmiddle"><?php echo t("templateregistred"); ?>
			<br><br><br>
			<a href="index.php" class="botonavegacio"><?php echo t("backtolist") ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
<?php
if (accessGroupPerm('template_edit')) {
?>
            <a href="view.php?ID=<?php echo $ID; ?>" class="botonavegacio"><?php echo t("templatemodify") ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
<?php
}
if (accessGroupPerm('template_upload')) {
?>
            <a href="javascript:obrir('../plantilles/upload.php',500,200)" class="botonavegacio"><?php echo t("uploadtemplatetitol"); ?></a>
<?php
}
?>
		</td>
	</tr>
	<!-- /DESCRIPCIO -->

</table>
<!-- /PART CENTRAL -->
<?php echo htmlFoot(); ?>
</body>
</html>








