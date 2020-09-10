<?php

require ('../../config_admin.inc');
accessGroupPermCheck('users_create');

include_once("grups.php");

//include_once("funcions.php");


?>
<html>
<head>
<title>Houdini v2.0</title>
	<link rel="STYLESHEET" type="text/css" href="../../css/estils.css">
<?php echo editor_head(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<div id="contingut">
<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td class="text10" bgcolor="#C0CEE4" style="padding:6px;" colspan="2"><img src="../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t('uploadgrouptitle'); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td  class="text10"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../../index.php"><?php echo t("home"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../../utilitats/index.php"><?php echo t("utils"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php"><?php echo t('uploadgrouptitle'); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("createregistry"); ?></font></td>
				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t("createregistry"); ?></td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">

					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<form action="create.php" method="post" enctype="multipart/form-data">
		<!-- FORMULARI ENTRADA -->
		<td colspan="2" style="padding:10px;" valign="top">
			<TABLE width="620" cellpadding="5" cellspacing="0">
			<TR>
			   <TD class=text valign=top width="20%"><?php echo t("uploadgroupgroup"); ?>:</TD>
			   <TD valign=top width="80%"><input type="text" name="NOM_GRUP" class="formulari"></TD>
			</TR>

			<TR>
			   <TD class=text valign=top width="20%"><?php echo t("folder"); ?>:</TD>
			   <TD valign=top width="80%"><input type="text" name="NOM_CARPETA" class="formulari"></TD>
			</TR>

			<TR>
			   <TD valign=top align=center colspan=2>
			   <INPUT TYPE="submit" NAME="accion" VALUE="<?php echo t('create'); ?>" class=boto>
			   </TD>
			</TR>

			</TABLE>
		</td>
		<!-- /FORMULARI ENTRADA -->

	</tr>


</table>
<!-- /PART CENTRAL -->
<?php echo htmlFoot(); ?>
</form>
</div>
</body>
</html>

