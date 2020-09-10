<?php

require ('../config_admin.inc');
accessGroupPermCheck('form_create');

include_once("formularis.php");


?>

<html>
<head>
<?php echo htmlMetas(); ?>
<script type="text/javascript">
	function validar() {
		if (mainform.TITOLFORMULARI.value=='') {
				mainform.TITOLFORMULARI.focus();
				result = missatge("../php/missatge.php?missatge=<?php echo t("formsmessages1"); ?>");
				return false;
		}else{
			if (mainform.NOMFORMULARI.value=='') {
					mainform.NOMFORMULARI.focus();
					result = missatge("../php/missatge.php?missatge=<?php echo t("formsmessages2"); ?>");
					return false;
			}else{
				if (mainform.RECIPIENT.value=='') {
					mainform.RECIPIENT.focus();
					result = missatge("../php/missatge.php?missatge=<?php echo t("formsmessages3"); ?>");
					return false;
				}else{
					if (mainform.REDIRECT.value=='') {
						mainform.REDIRECT.focus();
						result = missatge("../php/missatge.php?missatge=<?php echo t("formsmessages4"); ?>");
						return false;
					}

				}
			}
		}
	}
</script>
<?php echo editor_head(); ?>
<script type="text/javascript">
	function mostraropcionsavan(){
		document.getElementById('opcionsavanboto').style.display='none';
		document.getElementById('opcionsavan').style.display='inline';
	}
	function amagaropcionsavan(){
		document.getElementById('opcionsavanboto').style.display='inline';
		document.getElementById('opcionsavan').style.display='none';
	}

</script>


</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("formstitle"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td  class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../index.php"><?php echo t("home"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php"><?php echo t("formstitle"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("create")." ".t("form"); ?></font></td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t("formsconfig"); ?></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<form action="create.php" method="post" name="mainform" onsubmit="return validar();">
		<!-- FORMULARI ENTRADA -->
		<td colspan="2" style="padding:10px;" valign="top">
			<TABLE width="620" cellpadding="5" cellspacing="0">
			<TR>
			   <TD class=text valign=top width="20%"><?php echo t("name")." ".t("form"); ?>:</TD>
			   <TD valign=top width="80%"><INPUT TYPE="text" NAME="NOMFORMULARI" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
			</TR>
			<TR>
			   <TD class=text valign=top width="20%"><?php echo t("title"); ?>:</TD>
			   <TD valign=top width="80%"><INPUT TYPE="text" NAME="TITOLFORMULARI"  SIZE="50" MAXLENGTH="250" class="formulari"></TD>
			</TR>
			<TR>
			   <TD class=text valign=top width="20%"><?php echo t("description"); ?>:</TD>
			   <TD valign=top width="80%">
			   <?php
				echo editor_entry("DESCRIPCIO", '','Antaviana');
				?>
			   </TD>
			</TR>

			<TR>
			   <TD class=text valign=top width="20%"><?php echo t("formsconfigemailreceipt"); ?>:</TD>
			   <TD valign=top width="80%"><INPUT TYPE="text" NAME="RECIPIENT" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
			</TR>
			<TR>
			   <TD class=text valign=top width="20%"><?php echo t("formsconfigurlreturn"); ?>:</TD>
			   <TD valign=top width="80%"><INPUT TYPE="text" NAME="REDIRECT" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
			</TR>


			<TR>
				<TD class="text" valign=top width="20%"><?php echo t("language"); ?>:</TD>
				<TD valign=top width="80%">
			    <select class="formulari" name="IDIOMA" style="width:250px;">
			    <?php

					for($i=0;$i<count($CONFIG_idiomes[$CONFIG_IDIOMA]);$i++){
						$trozos = explode ("_", $CONFIG_idiomes[$CONFIG_IDIOMA][$i]);
						$numerocategoria=$trozos['0'];
						$idioma=$trozos['1'];
						$codiidioma=$trozos['2'];
						echo"<option value=\"".$codiidioma."\" />".$idioma."</br>";
					}

				?>
			    </select>
				</TD>
			</TR>

			<TR>
			   <TD class=text valign=top width="20%"><?php echo t("template"); ?>:</TD>
			   <TD valign=top width="80%"><select class="formulari"  name="PLANTILLA" style="width:250px;">
<?php
   $templates = file_list($CONFIG_PATHTEMPLATEFORM);
   foreach ($templates as $value) {
     echo '<option value="'.$value.'">'.$value.'</option>';
   }
?>
			   </select>
			   </TD>
			</TR>
	<TR>
   <TD class=text valign=top ><?php echo t("saveto"); ?>:</TD>
   <TD valign=top >
	   <select class="formulari"  name="PARE" style="width:250px;">
	<?php
     echo staticFolderSelect();
	?>
	   </select>
	   </TD>
	</TR>


<!-- ultim bloc OPCIONS AVANÇADES -->
	<TR>
	   <TD valign=top  colspan=2>
<?php
if (accessGroupPerm('avanced_options')) {
?>
<div id="opcionsavanboto" style="background-color:#ECECEC;margin-right:15px;padding-left:10px;">
<br />
<table cellpadding="0"  cellspacing="0" border="0" style="background-color:#FFFFFF;padding:5px;border:solid #676766 1px;border-bottom:solid #676766 2px;">
	<tr>
		<td width="31"><a href="#opcions" onclick="javascript:mostraropcionsavan();" width="31"><img src="../comu/ico_opcionsavansades.png" width="31" height="19" alt="<?php echo t("view")." ".t("optionsadvanced");?>" border="0" ></a></td>
		<td style="padding-left:5px;"><a href="#opcions" onclick="javascript:mostraropcionsavan();" class="text" title="<?php echo t("view")." ".t("optionsadvanced");?>"><strong><?php echo t("optionsadvanced");?> &raquo;</strong></a></td>
	</tr>
</table>
<br />
</div>
<div id="opcionsavan"  style="display: none;" >
<div  style="background-color:#ECECEC;margin-right:15px;padding:15px;">

<table cellpadding="0"  cellspacing="5" border="0" width="95%" style="border:solid  #CCCCCC 1px;">

<?php
if (file_exists($CONFIG_PATHADMIN.'/moduls/menus')) {
  require_once($CONFIG_PATHADMIN.'/moduls/menus/funcions.inc');
?>
	<tr>
		<td colspan="2" class="text10" style="padding-bottom:5px;"><img src="../comu/ico_fletxa_opcions.gif" width="12" height="10" border="0" align="absmiddle"><b><?php echo t("staticpagesselectoptions"); ?></b></td>
	</tr>
	<tr>
	   <td class=text valign=top width="20%"><?php echo t("left"); ?>:</TD>
	   <td valign=top width="80%">
		<select class="formulari" name="MENU1" style="width:250px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
echo menu_list('', 0, 'home');
			?>
		</select>
		</td>
	</tr>
	<tr>
	   <td class=text valign=top width="20%"><?php echo t("right"); ?>:</TD>
	   <td valign=top width="80%">
		<select class="formulari" name="MENU2" style="width:250px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
echo menu_list('', 0, 'home');
			?>
		</select>
		</td>
	</tr>
	<tr>
	   <td class=text valign=top width="20%"><?php echo t("up"); ?>:</TD>
	   <td valign=top width="80%">
		<select class="formulari" name="MENU3" style="width:250px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
echo menu_list('', 1, 'home');
			?>
		</select>


		</td>
	</tr>
<?php
}
if (file_exists($CONFIG_PATHADMIN.'/moduls/composicions')) {
  include_once('../php/funcions.php');
?>
	<tr>
		<td colspan="2" class="text10" style="padding-top:8px;padding-bottom:5px;"><img src="../comu/ico_fletxa_opcions.gif" width="12" height="10" border="0" align="absmiddle"><b><?php echo t("staticpagesselectoptionsbanner"); ?></b></td>

	</tr>

	<tr>
	   <td class=text valign=top width="20%"><?php echo t("left"); ?>:</TD>
	   <td valign=top width="80%">
		<select class="formulari" name="BANNER1" style="width:250px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
option_dinamic('');
			?>
		</select>
		</td>
	</tr>
	<tr>
	   <td class=text valign=top width="20%"><?php echo t("right"); ?>:</TD>
	   <td valign=top width="80%">
		<select class="formulari" name="BANNER2" style="width:250px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
option_dinamic('');
			?>
		</select>
		</td>
	</tr>
	<tr>
	   <td class=text valign=top width="20%"><?php echo t("up"); ?>:</TD>
	   <td valign=top width="80%">
		<select class="formulari" name="BANNER3" style="width:250px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
option_dinamic('');
			?>
		</select>


		</td>
	</tr>


<!-- METAS bloc -->
	<tr>
		<td class="text10" style="padding:5px;" colspan="2"><img src="../comu/ico_fletxa_opcions.gif" width="12" height="10" border="0" align="absmiddle"><b>Metas</b></td>

	</tr>

	<tr>
		<td class="text10" style="padding-left:5px;padding-bottom:5px;"><?php echo t("title"); ?></td>
		<td width="60%"  style="padding-left:5px;padding-bottom:5px;"><input type="text" name="METATITOL" value="" maxlength="500" class="formulari" style="width:430px;"></b></td>
	</tr>
	<tr>
		<td class="text10" style="padding-left:5px;padding-bottom:5px;"><?php echo t("description"); ?></td>
		<td width="60%"  style="padding-left:5px;padding-bottom:5px;"><input type="text" name="METADESCRIPCIO" value="" maxlength="500" class="formulari" style="width:430px;"></b></td>
	</tr>
	<tr>
		<td class="text10" style="padding-left:5px;padding-bottom:5px;"><?php echo t("keywords"); ?></td>
		<td width="60%" style="padding-left:5px;padding-bottom:5px;"><input type="text" name="METAKEYS" value="" maxlength="500" class="formulari" style="width:430px;"></td>
	</tr>
<!-- /METAS bloc -->


</table>




<?php
}
?>

</div>
<?php
}
?>


   </TD>
</TR>





			<TR>
			   <TD valign=top align=center colspan=2>

			   <INPUT TYPE="submit" NAME="accion" VALUE="<?php echo t("create")." ".t("form"); ?>" class=boto>
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
