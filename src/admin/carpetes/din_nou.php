<?php

require ('../config_admin.inc');
accessGroupPermCheck('folder_create');

if(empty($_POST['PARE'])){
	htmlPageError(t("errordbcardscodinotfound"));
}
$pare=$_POST['PARE'];

  $path = folderPathArray($pare);
  $situacio = '';
  foreach($path as $key => $value) {
    $situacio .="<a href='index.php?carpeta=$key' class='text10'>".$value."</a><img src=\"../comu/kland_etsa.gif\" border=\"0\">";
  }
  $situacio="<a href='index.php' class='text10'>".t("folderstitle")."</a><img src=\"../comu/kland_etsa.gif\" width=\"19\" height=\"5\"  border=\"0\" >".$situacio;
?>
<html>
<head>
<?php echo htmlMetas(); ?>
<script type="text/javascript">
function validar() {
  if (mainform.NOMCARPETA.value=='') {
    mainform.NOMCARPETA.focus();
    result = missatge("../php/missatge.php?missatge=<?php echo t("foldersformerrorname"); ?>");
    return false;
  }
}


</script>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>

<form method="post" action="creardinamic.php"  name="mainform" onsubmit="return validar();">
  <INPUT TYPE="hidden" NAME="urlnavegacio" SIZE=50 MAXLENGTH=100 value="<?php echo $_SERVER['HTTP_REFERER'] ?>" class="formulari"  >

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;margin-bottom:0px">

	<!-- situacio Sou a -->
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td   class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../index.php"><?php echo t("home"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><?php echo $situacio; ?><font class="blau10b"><?php echo t("create")." ".t("foldersdinamictitle"); ?></font></td>

				</tr>
			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="100%" style="padding:5px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t("create")." ".t("foldersdinamictitle"); ?></td>
				</tr>
				<tr>
					<td width="100%" style="padding:5px;"  class="gris10" valign="top">
						<table cellpadding="2" cellspacing="2" width="100%" border="0">
							<TR>
							   <TD class="gris10" valign=top width="20%"><?php echo t("name")." ".t("folder"); ?>:</TD>
							   <TD valign=top width="80%"><INPUT TYPE="text" NAME="NOMCARPETA" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
							</TR>
							<TR>
								<TD class="gris10" valign=top width="20%"><?php echo t("language"); ?>:</TD>
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
							   <TD class="gris10" valign=top width="20%"><?php echo t("description"); ?>:</TD>
							   <TD valign=top width="80%"><INPUT TYPE="text" NAME="DESCRIPCIO" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
							</TR>
							<TR>
							   <TD class="gris10" valign=top width="20%"><?php echo t("foldersdinamicformtitlesection"); ?>:</TD>
							   <TD valign=top width="80%"><INPUT TYPE="text" NAME="TITOL" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
							</TR>
							<TR>
							   <TD class="gris10" valign=top width="20%"><?php echo t("foldersdinamicformsubtitlesection"); ?>:</TD>
							   <TD valign=top width="80%"><INPUT TYPE="text" NAME="SUBTITOL" SIZE="50"  class="formulari"></TD>
							</TR>

							<TR>
							   <TD class="gris10" valign=top width="20%"><?php echo t("foldersdinamicformparagraphsection"); ?>:</TD>
							   <TD valign=top width="80%"><INPUT TYPE="text" NAME="APARTAT" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
							</TR>
							<TR>
							   <TD class="gris10" valign=top width="20%"><?php echo t("foldersdinamicformintro"); ?>:</TD>
							   <TD valign=top width="80%"><textarea NAME="INTRODUCCIO" rows="10" class="formulari"></textarea></TD>
							</TR>

							<TR>
							   <TD class="gris10" valign=top><?php echo t("orderby"); ?>:</TD>
							   <TD valign=top >
							   <select class="formulari" name="CATEGORY2" style="width:150px;">
									<option value="0"><?php echo t("orderenter"); ?></option>
									<option value="1"><?php echo t("title"); ?></option>
									<option value="2"><?php echo t("creationdate"); ?></option>
								</select>
								</TD>
							</TR>
							<TR>
							   <TD class="gris10" valign=top ><?php echo t("model"); ?>:</TD>
							   <TD valign=top >
							   <select class="formulari" name="SKIN" style="width:250px;">
<?php
foreach($tipusdinamiques as $key => $value){
  echo'<option value="'.$key.'" />'.$value['nom'].'</br>';
}
?>
							    </select>



								</TD>

							</TR>
							<TR>
							   <TD class="gris10" valign=top width="20%"><?php echo t("foldersdinamicformrss"); ?>:</TD>
							   <TD valign=top width="80%"><INPUT TYPE="text" NAME="RSS" SIZE="3" MAXLENGTH="3" value="0"></TD>
							</TR>
	<tr>
		<td colspan="2" class="gris10">
			<?php echo t("folderisinitial"); ?><br>
			<input type="radio" name="CARPETAINICI" value="0" checked><?php echo t("no"); ?>&nbsp;&nbsp;&nbsp;
			<input type="radio" name="CARPETAINICI" value="1"><?php echo t("yes"); ?>
		</td>
	</tr>


                            <tr>
                                <td colspan="2">
<br><br>


<!-- METAS bloc -->
<table cellpadding="0"  cellspacing="0" border="0" width="98%" style="border:solid  #CCCCCC 1px;">

	<tr>
		<td class="text10" style="padding:5px;" colspan="2"><img src="../comu/kl_blau.gif" width="12" height="10" border="0" align="absmiddle"><b>Metas</b></td>

	</tr>

	<tr>
		<td class="text10" style="padding-left:5px;padding-bottom:5px;"><?php echo t("title"); ?></td>
		<td width="80%"  style="padding-left:5px;padding-bottom:5px;"><input type="text" name="METATITOL" value="" maxlength="500" class="formulari" style="width:450px;"></b></td>
	</tr>
	<tr>
		<td class="text10" style="padding-left:5px;padding-bottom:5px;"><?php echo t("description"); ?></td>
		<td width="80%"  style="padding-left:5px;padding-bottom:5px;"><input type="text" name="METADESCRIPCIO" value="" maxlength="500" class="formulari" style="width:450px;"></b></td>
	</tr>
	<tr>
		<td class="text10" style="padding-left:5px;padding-bottom:5px;"><?php echo t("keywords"); ?></td>
		<td width="80%" style="padding-left:5px;padding-bottom:5px;"><input type="text" name="METAKEYS" value="" maxlength="500" class="formulari" style="width:450px;"></td>
	</tr>
</table>
<!-- /METAS bloc -->


<table cellpadding="0" cellspacing="0" border="0" width="98%" style="margin-top:10px;border:solid #CCCCCC 1px;padding:5px;">

<?php
if (file_exists($CONFIG_PATHADMIN.'/moduls/menus')) {
  require_once($CONFIG_PATHADMIN.'/moduls/menus/funcions.inc');
?>
	<tr>
		<td class="text10" style="padding-bottom:5px;"><img src="../comu/kl_blau.gif" width="12" height="10" border="0" align="absmiddle"><b><?php echo t("staticpagesselectoptions"); ?></b></td>
	</tr>
	<tr>
		<td class="text10">
		<?php echo t("left"); ?>:
		<select class="formulari" name="MENU1" style="width:150px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
echo menu_list('', 0, $pare);
			?>
		</select>
		&nbsp;&nbsp;&nbsp;
		<?php echo t("right"); ?>:
		<select class="formulari" name="MENU2" style="width:150px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
echo menu_list('', 0, $pare);
			?>
		</select>
		&nbsp;&nbsp;&nbsp;
		<?php echo t("up"); ?>:
		<select class="formulari" name="MENU3" style="width:150px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
echo menu_list('', 1, $pare);
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
		<td class="text10" style="padding-top:8px;padding-bottom:5px;"><img src="../comu/kl_blau.gif" width="12" height="10" border="0" align="absmiddle"><b><?php echo t("staticpagesselectoptionsbanner"); ?></b></td>

	</tr>

	<tr>
		<td class="text10">
		<?php echo t("left"); ?>:
		<select class="formulari" name="BANNER1" style="width:150px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
option_dinamic('');
			?>
		</select>
		&nbsp;&nbsp;&nbsp;
		<?php echo t("right"); ?>:
		<select class="formulari" name="BANNER2" style="width:150px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
option_dinamic('');
			?>
		</select>
		&nbsp;&nbsp;&nbsp;
		<?php echo t("up"); ?>:
		<select class="formulari" name="BANNER3" style="width:150px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
option_dinamic('');
			?>
		</select>


		</td>
	</tr>
<?php
}
?>
</table>
                                </td>
                            </tr>


							<TR>
							   <TD valign=top align=center colspan=2>
							   	   <INPUT TYPE="hidden" NAME="PARE"  class="formulari" value="<?php echo $pare; ?>">
							   	   <input type="hidden" name="CATEGORY1" value="1">
								   <input type="hidden" name="ECLASS" value="1">
								   <INPUT TYPE="submit" NAME="accion" VALUE="<?php echo t("create"); ?>" class=boto>
							   </TD>
							</TR>
						</table>

					</td>

				</tr>

			</table>
		</td>
	</tr>



</table>
<!-- /PART CENTRAL -->
<?php echo htmlFoot(); ?>
</form>
</body>
</html>