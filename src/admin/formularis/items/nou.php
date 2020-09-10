<?php

require ('../../config_admin.inc');
accessGroupPermCheck('form_entrys');

	if($_POST){
		$ID=$_POST['ID'];
	}else{
		$ID=$_GET['ID'];
	}
	$result=db_query("select * from FORMULARIS where ID = $ID");
	$row = db_fetch_array($result);
	if (empty($row['ID'])){
	 htmlPageBasicError(t("errordbcardscodinotfound"));
	}
?>
<html>
<head>
<?php echo htmlMetas(); ?>
<SCRIPT type="text/javascript">
//compravar camps formulari
function validar() {
if (mainform.TIPO[0].checked || mainform.TIPO[1].checked || mainform.TIPO[2].checked || mainform.TIPO[3].checked || mainform.TIPO[4].checked || mainform.TIPO[5].checked || mainform.TIPO[6].checked || mainform.TIPO[7].checked) {
	if (mainform.TEXT.value=='') {
		mainform.TEXT.focus();
		result = missatge("../../php/missatge.php?missatge=<?php echo t("formsmessagesgeneric")." ".t("text"); ?>");
		return false;
	}else{
		if (mainform.NOM.value=='') {
			mainform.NOM.focus();
			result = missatge("../../php/missatge.php?missatge=<?php echo t("formsmessagesgeneric")." ".t("name"); ?>");
			return false;
		}else{
			if ( (mainform.TIPO[1].checked || mainform.TIPO[3].checked || mainform.TIPO[4].checked || mainform.TIPO[5].checked) && mainform.VALOR.value==''){
				mainform.VALOR.focus();
				result = missatge("../../php/missatge.php?missatge=<?php echo t("formsmessagesgeneric")." ".t("value"); ?>");
				return false;
			}
		}
	}
}else{
	result = missatge("../../php/missatge.php?missatge=<?php echo t("formselectfield"); ?>");
	return false;
}

}
</SCRIPT>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("formstitle"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
		    <table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td  class="text10"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../../index.php"><?php echo t("home"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../index.php"><?php echo t("formstitle"); ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php?ID=<?php echo $row['ID']; ?>"><?php echo t("form"); ?> <?php echo $row['NOMFORMULARI']; ?></a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">Crear camp</font></td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t("formcreatefield").": ".$row['NOMFORMULARI']; ?></td>
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
			<TABLE width="100%" cellpadding="5" cellspacing="0">
			<TR>
			   <TD class=text valign=top width="10%"><?php echo t("text"); ?>:</TD>
			   <TD valign=top width="60%"><INPUT TYPE="text" NAME="TEXT" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
			   <td rowspan="7" valign="top">
			   	<table cellpadding="0" cellspacing="0" bgcolor="#f8f8f8" style="border:solid #CCCCCC 1px;padding:5px;" >
					<tr>
						<td valign="top"><img src="../../comu/ico_info.gif" width="11" height="11" alt="Info" border="0"> </td>
						<td class="text9" valign="top">
							<font color="#999999">
							<?php echo t("forminfo"); ?>
							</font>
						</td>
					</tr>
				</table>
			   </td>
			</TR>
			<TR>
			   <TD class=text valign=top width="10%"><?php echo t("name"); ?>:</TD>
			   <TD valign=top ><INPUT TYPE="text" NAME="NOM" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
			</TR>
			<TR>
			   <TD class=text valign=top width="10%"><?php echo t("value"); ?>:</TD>
			   <TD valign=top ><INPUT TYPE="text" NAME="VALOR" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
			</TR>

			<TR>
			   <TD class=text valign=top ><?php echo t("obligatory"); ?></TD>
			   <TD valign=top >
			   <input type="checkbox" name="OBLIGATORI" value="1">
			   </TD>
			</TR>





			<TR>
				<TD class=text valign=top ><?php echo t("formselectfield"); ?>:</TD>
			   <TD valign=top class="text10">
			   		<table cellpadding="2" cellspacing="2" border="0" class="text10" width="480">
						<tr>
							<td><img src="../../comu/form_on.gif" width="84" height="74" alt="Text" border="0"></td>
							<td><img src="../../comu/form_off.gif" width="84" height="74" alt="Ocult" border="0"></td>
							<td><img src="../../comu/form_textarea.gif" width="84" height="74" alt="Text Area" border="0"></td>
							<td><img src="../../comu/form_desplega.gif" width="84" height="74" alt="Select" border="0"></td>
						</tr>
						<tr>
							<td valign="top"><table  class="text10" cellpadding="0" cellspacing="0" border="0"><tr><td valign="top"><input type="radio" name="TIPO" value="0"></td><td style="padding-top:3px;" class="text10"><?php echo t("formtext"); ?></td></tr></table></td>
							<td valign="top"><table  class="text10" cellpadding="0" cellspacing="0" border="0"><tr><td valign="top"><input type="radio" name="TIPO" value="5"></td><td  class="text10"><?php echo t("formhidden"); ?></td></tr></table></td>
							<td valign="top"><table  class="text10" cellpadding="0" cellspacing="0" border="0"><tr><td valign="top"><input type="radio" name="TIPO" value="1"></td><td style="padding-top:3px;" class="text10"><?php echo t("formtextarea"); ?></td></tr></table></td>
							<td valign="top"><table  class="text10" cellpadding="0" cellspacing="0" border="0"><tr><td valign="top"><input type="radio" name="TIPO" value="4"></td><td style="padding-top:3px;" class="text10"><?php echo t("formcombobox"); ?></td></tr></table></td>
						</tr>
						<tr>
							<td style="padding-top:12px;"><img src="../../comu/form_check.gif" width="84" height="74" alt="Checkbox" border="0"></td>
							<td style="padding-top:12px;"><img src="../../comu/form_radiobutton.gif" width="84" height="74" alt="Radio Button" border="0"></td>
							<td  style="padding-top:12px;"><img src="../../comu/form_text.gif" width="84" height="74" alt="Text normal" border="0"></td>
							<td style="padding-top:12px;"><img src="../../comu/form_upload.gif" width="84" height="74" alt="<?php echo t("formupload"); ?>" border="0"></td>
						</tr>
						<tr>
							<td valign="top"><table  class="text10" cellpadding="0" cellspacing="0" border="0"><tr><td valign="top"><input type="radio" name="TIPO" value="2"></td><td style="padding-top:3px;" class="text10"><?php echo t("formcheckbox"); ?></td></tr></table></td>
							<td valign="top"><table  class="text10" cellpadding="0" cellspacing="0" border="0"><tr><td valign="top"><input type="radio" name="TIPO" value="3"></td><td class="text10" ><?php echo t("formradiobutton"); ?></td></tr></table></td>
							<td valign="top"><table  class="text10" cellpadding="0" cellspacing="0" border="0"><tr><td valign="top"><input type="radio" name="TIPO" value="6"></td><td style="padding-top:3px;" class="text10"><?php echo t("formtextdescription"); ?></td></tr></table></td>
							<td valign="top"><table  class="text10" cellpadding="0" cellspacing="0" border="0"><tr><td valign="top"><input type="radio" name="TIPO" value="7"></td><td style="padding-top:3px;" class="text10"><?php echo t("formupload"); ?></td></tr></table></td>
						</tr>

					</table>

			   </TD>
			</TR>
			<TR>
			   <TD class=text valign=top width="10%"><?php echo t("size"); ?>:</TD>
			   <TD valign=top >
			   <select name="TAMANY" class="formulari" style="width:80">
			   		<option value='0'><?php echo t("small"); ?></option>
			   		<option value='1' selected><?php echo t("medium"); ?></option>
					<option value='2'><?php echo t("large"); ?></option>
			   </select>
			</TR>




			<TR>
			   <TD valign=top align=center colspan=2>
			   <INPUT TYPE="hidden" NAME="FORMULARI" VALUE="<?php echo $ID; ?>" >
			   <INPUT TYPE="submit" NAME="accion" VALUE="<?php echo t("create"); ?>" class=boto>
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

