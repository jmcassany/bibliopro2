<?php

require ('../config_admin.inc');
accessGroupPermCheck('template_create');
include_once("plantilles.php");

?>
<html>
<head>
<?php echo htmlMetas(); ?>
<script type="text/javascript">
function validar() {
  if (mainform.NOM.value=='') {
    mainform.NOM.focus();
    result = window.open("../php/missatge.php?missatge=<?php echo t("formerrorname"); ?>","missatge","left=0,top=0,screenX=0,screenY=0,status=no,toolbar=no,width=200,height=200,directory=no,resize=no,scrollbars=no");
    return false;
  }else{
    if (mainform.TEXTCURT.value=='0' && mainform.TEXTLLARG.value=='0' && mainform.IMATGES.value=='0' && mainform.ADJUNTS.value=='0') {
      mainform.TEXTCURT.focus();
      result = window.open("../php/missatge.php?missatge=<?php echo t("formerrorfields0"); ?>","missatge","left=0,top=0,screenX=0,screenY=0,status=no,toolbar=no,width=200,height=200,directory=no,resize=no,scrollbars=no");
      return false;
    }
  }
}
</script>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td colspan="2" class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("templatetitle"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td  class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../index.php"><?php echo t("home"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php"><?php echo t("templatetitle"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("templateregister"); ?></font></td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t("templateregister"); ?></td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">

					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<form action="create.php" method="post" name="mainform" onsubmit="return validar();">
		<!-- FORMULARI ENTRADA -->
		<td colspan="2" style="padding:10px;" valign="top">

<table cellpadding="2" cellspacing="2" border="0" class="text">

	<tr>
		<td><?php echo t("templateformname"); ?></td><td><input type="text" name="NOM" maxlength="100" class="formulari" style="width:250px;"></td>
	</tr>
	<tr>
		<td><?php echo t("templateformdescription"); ?></td><td><input type="text" name="DESCRIPCIO" maxlength="255" class="formulari" style="width:450px;"><br></td>
	</tr>
	<tr>
		<td><?php echo t("templateformshortfields"); ?></td><td><input type="text" name="TEXTCURT" maxlength="2" class="formulari" style="width:50px;" value="0"><br></td>
	</tr>
	<tr>
		<td><?php echo t("templateformlargefields"); ?></td><td><input type="text" name="TEXTLLARG" maxlength="2" class="formulari" style="width:50px;" value="0"><br></td>
	</tr>
	<tr>
		<td><?php echo t("templateformiamges"); ?></td><td><input type="text" name="IMATGES" maxlength="2" class="formulari" style="width:50px;" value="0"><br></td>
	</tr>
	<tr>
		<td><?php echo t("templateformfiles"); ?></td><td><input type="text" name="ADJUNTS" maxlength="2" class="formulari" style="width:50px;" value="0"><br></td>
	</tr>
	<TR>
   <TD class=text valign=top ><?php echo t("templateformdata"); ?></TD>
   <TD valign=top >
   <select class="formulari"  name="PARE" style="width:250px;">
<?php

echo staticFolderSelect(null,true);
?>
   </select>
   </TD>
</TR>
	<tr>
		<td colspan="2">
			<?php echo t("templateformforothers"); ?><br>
			<input type="radio" name="ECLASS" value="1" checked><?php echo t("yes"); ?>&nbsp;&nbsp;&nbsp;
			<input type="radio" name="ECLASS" value="2"><?php echo t("no"); ?>
		</td>
	</tr>
	<TR>

<!-- PART CENTRAL DADES-->


			<TR>
			   <TD valign=top align=center colspan=2>


			   <INPUT TYPE="submit" NAME="accion" VALUE="<?php echo t("templateregister"); ?>" class=boto>
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
</body>
</html>

