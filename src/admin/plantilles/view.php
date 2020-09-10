<?php

require ('../config_admin.inc');
accessGroupPermCheck('template_edit');
include_once("plantilles.php");

   $ID=$_GET['ID'];
?>
<html>
<head>
<?php echo htmlMetas(); ?>
<script type="text/javascript">
//compravar camps formulari
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
</SCRIPT>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader();  ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td colspan="2" class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b>Gestió de plantilles</b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td  class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../index.php"><?php echo t("home"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php"><?php echo t("templatetitle"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("update")." ".t("template"); ?></font></td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t("update")." ".t("template"); ?></td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">

					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<form action="update.php" method="post" name="mainform"  onsubmit="return validar();">
		<!-- FORMULARI ENTRADA -->
		<td colspan="2" style="padding:10px;" valign="top">

<?php
   $result=db_query("select * from PLANTILLA where ID = $ID");
?>
<table cellpadding="2" cellspacing="2" border="0" class="text">

<?php
while($row = db_fetch_array($result)) {

	echo("<INPUT TYPE=\"hidden\" NAME=\"ID\" SIZE=50 MAXLENGTH=11 value=\"".$row['ID']."\" class=formulari>");
	echo("<tr><td>".t("templateformname")."</td><td><input type=\"text\" name=\"NOM\" value=\"".$row['NOM']."\" maxlength=\"100\" class=\"formulari\" style=\"width:250px;\"></td></tr>");
	echo("<tr><td>".t("templateformdescription")."</td><td><input type=\"text\" name=\"DESCRIPCIO\" value=\"".filtreQuote($row['DESCRIPCIO'])."\" maxlength=\"255\" class=\"formulari\" style=\"width:450px;\"><br></td></tr>");
	echo("<tr><td>".t("templateformshortfields")."</td><td><input type=\"text\" name=\"TEXTCURT\" value=\"".$row['TEXTCURT']."\" maxlength=\"2\" class=\"formulari\" style=\"width:50px;\"><br></td></tr>");
	echo("<tr><td>".t("templateformlargefields")."</td><td><input type=\"text\" name=\"TEXTLLARG\" value=\"".$row['TEXTLLARG']."\" maxlength=\"2\" class=\"formulari\" style=\"width:50px;\"><br></td></tr>");
	echo("<tr><td>".t("templateformiamges")."</td><td><input type=\"text\" name=\"IMATGES\" value=\"".$row['IMATGES']."\" maxlength=\"2\" class=\"formulari\" style=\"width:50px;\"><br></td></tr>");
	echo("<tr><td>".t("templateformfiles")."</td><td><input type=\"text\" name=\"ADJUNTS\" value=\"".$row['ADJUNTS']."\" maxlength=\"2\" class=\"formulari\" style=\"width:50px;\"><br></td></tr>");
	echo("<tr><td>Opcionals</td><td><input type=\"text\" name=\"OP\" value=\"".$row['OP']."\" maxlength=\"2\" class=\"formulari\" style=\"width:50px;\"><br></td></tr>");
	echo("<tr><td class=text valign=top>".t("templateformdata")."</td><td class=text valign=top><select class=\"formulari\"  name=\"PARE\"  style=\"width:250px;\">");

echo staticFolderSelect($row['PARE'],true);
	echo("</selected></td></tr>\n");
	$classe=$row['ECLASS'];


}
?>

			<tr>
				<td colspan="2">
					<?php echo t("templateformforothers"); ?><br>
					<input type="radio" name="ECLASS" value="1" <?php if ($classe == 1) echo "checked"; ?>><?php echo t("yes"); ?>&nbsp;&nbsp;&nbsp;
					<input type="radio" name="ECLASS" value="2" <?php if ($classe == 2) echo "checked"; ?>><?php echo t("no"); ?>
				</td>
			</tr>

			<TR>
			   <TD valign=top align=center colspan=2>

			   <INPUT TYPE="hidden" NAME="ID" VALUE="<?php echo $ID ?>" class=boto>
			   <INPUT TYPE="submit" NAME="accion" VALUE="<?php echo t("update"); ?>" class=boto>
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
<?php
db_free_result($result);
?>
</body>
</html>
