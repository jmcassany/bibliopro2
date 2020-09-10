<?php

require ('../../config_admin.inc');
accessGroupPermCheck('dinamic_category');

include_once('funcions.inc');

if(isset($_POST['DINAMICA'])) {
  $DINAMICA = $_POST['DINAMICA'];
}
else if(isset($_GET['DINAMICA'])) {
  $DINAMICA = $_GET['DINAMICA'];
}
if(isset($_POST['PARE'])) {
  $PARE = $_POST['PARE'];
}
else if(isset($_GET['PARE'])) {
  $PARE = $_GET['PARE'];
}




//COMPROVEM SI TE ACCES A AQUEST MODUL
include("check_moduls.php");
//FI COMPROVEM SI TE ACCES A AQUEST MODUL
$anteriors = cat_anteriors($DINAMICA,$ID);

?>
<html>
<head>
<?php echo htmlMetas(); ?>
<?php echo editor_head(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>


<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;" colspan="2"><img src="../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t('dincategorytitle'); ?></b></td>

	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td class="text10"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../../index.php"><?php echo t("home"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><?php echo $anteriors['editora'] ?><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php?DINAMICA=<?php echo $_POST['DINAMICA']; ?>"><?php echo t("categories"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t('dincategorynewcat'); ?></font></td>
				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->
<tr>
<td colspan="2" style="padding:5px;">
<fieldset style="padding:5px;" >
<legend  style="padding:10px;"><?php echo t("treecategories"); ?></legend>
<?php echo $anteriors['etsa'] ?>
</fieldset>
</td>
</tr>

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t('dincategorynewcat'); ?></td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<form action="create.php" method="post" enctype="multipart/form-data" name="mainform" onsubmit="return validar();">
		<!-- FORMULARI ENTRADA -->
		<td colspan="2" style="padding:10px;" valign="top">
			<TABLE width="100%" cellpadding="5" cellspacing="0">
			<TR>
			   <TD class=text valign=top width="10%"><?php echo t("name"); ?>:</TD>
			   <TD valign=top width="90%"><INPUT TYPE="text" NAME="NOM" SIZE="50" MAXLENGTH="50" class="formulari" value=""></TD>
			</TR>
			<TR>
			   <TD class=text valign=top width="10%"><?php echo t("description"); ?>:</TD>
			   <TD valign=top width="90%">
<?php echo editor_entry('DESCRIPCIO', '','Antavianabasic'); ?>
               </TD>
			</TR>

			<TR>
			   <TD class=text valign=top width="20%"><?php echo t("image"); ?>:</TD>
			   <TD valign=top width="80%"><input type=file name="img" size=50 class="formulari"></TD>
			</TR>

			<TR>
			   <TD valign=top align=center colspan=2>
<?php
if (isset($PARE)) {
  echo '<INPUT TYPE="hidden" NAME="PARE" VALUE="'.$PARE.'" >';
}
?>
			   <INPUT TYPE="hidden" NAME="DINAMICA" VALUE="<?php echo $DINAMICA; ?>" >
			   <INPUT TYPE="submit" NAME="accion" VALUE="Crear" class=boto>
			   </TD>
			</TR>

			</TABLE>
		</td>
		<!-- /FORMULARI ENTRADA -->

	</tr>


</table>
<!-- /PART CENTRAL -->
<?php
echo htmlFoot();
?>
</form>
</body>
</html>
