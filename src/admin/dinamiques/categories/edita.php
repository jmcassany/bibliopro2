<?php

require ('../../config_admin.inc');
accessGroupPermCheck('dinamic_category');

include_once('funcions.inc');

if(isset($_POST['ID'])){
  $ID = $_POST['ID'];
}
else if (isset($_GET['ID'])){
  $ID = $_GET['ID'];
}

$result=db_query("select * from DIN_CATEGORIES Where ID=$ID");
if(db_num_rows($result) != 1){
  htmlPageError(t("errordbcardscodinotfound"));
}
$row2 = db_fetch_array($result);

//COMPROVEM SI TE ACCES A AQUEST MODUL
$DINAMICA = $row2['DINAMICA'];
include("check_moduls.php");
//FI COMPROVEM SI TE ACCES A AQUEST MODUL

$anteriors = cat_anteriors($DINAMICA,$ID,0);


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
					<td  class="text10"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../../index.php"><?php echo t("home"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><?php echo $anteriors['editora'] ?><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php?DINAMICA=<?php echo $_GET['DINAMICA']; ?>"><?php echo t("categories"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("update"); ?></font></td>

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
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t("update"); ?></td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">

					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<form action="update.php" method="post" enctype="multipart/form-data"  name="mainform" onsubmit="return validar();">
		<!-- FORMULARI ENTRADA -->
		<td colspan="2" style="padding:10px;" valign="top">
			<TABLE width="100%" cellpadding="5" cellspacing="0">
			<TR>
			   <TD class=text valign=top width="10%"><?php echo t("name"); ?>:</TD>
			   <TD valign=top width="90%"><INPUT TYPE="text" NAME="NOM" SIZE="50" MAXLENGTH="50" class="formulari" value="<?php echo filtreQuote($row2['NOM']); ?>"></TD>
			</TR>
			<TR>
			   <TD class=text valign=top width="10%"><?php echo t("description"); ?>:</TD>
			   <TD valign=top width="90%">
<?php echo editor_entry('DESCRIPCIO', $row2['DESCRIPCIO'],'Antavianabasic'); ?>
               </TD>
			</TR>

			<TR>
			   <TD  valign=top  class="text10" colspan=2><b><?php echo t("image") ?>:</b>
			   		<!-- vincles -->
					<table cellpadding="0" cellspacing="0" border="0" width="558" style="border:solid #CCCCCC 1px;">
						<tr style="padding:5px;">
							<td valign="top" >
<?php
if ($row2['IMATGE'] != '') {
?>
                            <img src="<?php echo $CONFIG_URLUPLOADIM ?>/<?php echo $row2['IMATGE'] ?>" border="0" style="zoom:50%;margin-bottom:5px;" ><br>
                            <input type="checkbox" name="delete_image" value="1"><img src="../../comu/ico_paperera.gif" width="11" height="13" alt="Eliminar" border="0" align="absmiddle" style="margin-right:5px;"><?php echo t('delete') ?></a>
<?php
}
?>
                            </td>
							<td valign="top">
                            <input type=file name="img" size=50 class="formulari" style="width:250px;">
                            <INPUT TYPE="hidden" NAME="NOMIMATGEEXIS" VALUE="<?php echo $row2['IMATGE'] ?>" >
                            </td>
						</tr>

					</table>
			   </TD>
			</TR>

            <TR>
			   <TD valign=top align=center colspan=2>
			   <INPUT TYPE="hidden" NAME="ID" VALUE="<?php echo $ID; ?>" >
<?php
if (isset($row2['PARE'])) {
  echo '<INPUT TYPE="hidden" NAME="PARE" VALUE="'.$row2['PARE'].'" >';
}
?>
			   <INPUT TYPE="hidden" NAME="DINAMICA" VALUE="<?php echo $DINAMICA; ?>" >
			   <INPUT TYPE="submit" NAME="accion" VALUE="<?php echo t("update"); ?>" class=boto>
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
