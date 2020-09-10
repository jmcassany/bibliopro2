<?php

require ('../config_admin.inc');
accessGroupPermCheck('folder_delete');

require ($CONFIG_PATHADMIN."/php/lib/imatge_seguretat/securityImageClass.inc");
$si = new securityImage();

?>
<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;margin-bottom:0px">
	<tr>
		<td class="text" align="center"><br><br>
<?php
if (isset($_POST['callback']) && isset($_POST['ID']) && isset($_POST['carpeta']) && $_POST['carpeta'] != '' && isset($_POST['pare']) && $_POST['pare'] != '') {
	if ($si->isValid()) {


	 if(staticfolderDelete($_POST['ID'])) {
		   $missatge=t("foldersregistrydelete").": <b>".$_POST['carpeta']."</b>";
	  } else {
		    $missatge="<img src=\"../comu/houdini_alerta.gif\" width=\"19\" height=\"31\" alt=\"Alerta\" border=\"0\" align=\"absmiddle\"> <font class=\"grana\">".t("folderserrordelete")." <b>".$_POST['carpeta']."</b></font>";
	  }

	//// Inserta al registre d'accions
    register_add(t("foldersregistrydelete"), $_POST['carpeta']);
	// fi inserta
?>

			<table  border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td  width="26" valign="top" style="padding-bottom:10px;"><img src="../comu/ico_paperera3.gif" alt="" width="19" height="21" border="0"></td>
					<td class="text" style="padding-left:10px;padding-bottom:10px;" valign="top"><?php echo $missatge; ?></td>
				</tr>
			</table>

			<b><a href="index.php?carpeta=<?php echo $_POST['pare']; ?>" class="botonavegacio"><?php echo t("continue"); ?></a></b>
			<br><br>


<?php
} else {
?>
			<table  border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td  width="26" valign="top" style="padding-bottom:10px;"><img src="../comu/houdini_alerta.gif" alt="Alert" width="19" height="31" hspace="6" border="0" align="absmiddle"></td>
					<td class="grana" style="padding-left:10px;padding-bottom:10px;" valign="top"><?php echo t("invalidcode"); ?></td>
				</tr>
			</table>

			<b><a href="javascript:history.back();" class="botonavegacio"><?php echo t("back"); ?></a></b>
			<br><br>

<?php
	}
}

?>
</td>
	</tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>

