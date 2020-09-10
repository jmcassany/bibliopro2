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
    $situacio .="<img src=\"../comu/kland_etsa.gif\" border=\"0\"><a href='index.php?carpeta=$key' class='text10'>".$value."</a>";
  }
  $situacio="<img src=\"../comu/kland_etsa.gif\" width=\"19\" height=\"5\"  border=\"0\" ><a href='index.php' class='text10'>".t("folderstitle")."</a>".$situacio;

?>
<html>
<head>
<?php echo htmlMetas(); ?>
<script>
function validar() {
  if (mainform.NOMCARPETA.value=='') {
    mainform.NOMCARPETA.focus();
    result = missatge("../php/missatge.php?missatge=<?php echo t("foldersformerrorname"); ?>");
    return false;
  }
}

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

<form method="post" action="crear_estatic.php"  name="mainform" onsubmit="return validar();">
  <INPUT TYPE="hidden" NAME="urlnavegacio" SIZE=50 MAXLENGTH=100 value="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="formulari" >

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;margin-bottom:0px">

	<!-- situacio Sou a -->
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../index.php" class='text10'><?php echo t("home"); ?></a><?php echo $situacio; ?><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b"><?php echo t("create")." ".t("foldersstatictitle"); ?></font></td>

				</tr>
			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="100%" style="padding:5px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom"><?php echo t("create")." ".t("foldersstatictitle"); ?></td>

				</tr>
				<tr>
					<td width="100%" style="padding:5px;"  class="gris10" valign="top">
						<table>
							<TR>
							   <TD class="gris10" valign=top width="20%"><strong><?php echo t("name")." ".t("folder"); ?>:</strong></TD>
							   <TD valign=top width="80%"><INPUT TYPE="text" NAME="NOMCARPETA" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
							</TR>
							<TR>
							   <TD class="gris10" valign=top width="20%"><?php echo t("description"); ?>:</TD>
							   <TD valign=top width="80%"><INPUT TYPE="text" NAME="DESCRIPCIO" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
							</TR>

							<?php
							for($i=0;$i<count($CONFIG_idiomes[$CONFIG_IDIOMA]);$i++){
								$trozos = explode ("_", $CONFIG_idiomes[$CONFIG_IDIOMA][$i]);
								$numerocategoria=$trozos['0'];
								$idioma=$trozos['1'];
								$codiidioma=$trozos['2'];
							?>
							<TR>
							   <TD class="gris10" valign=top width="20%"><?php echo t("youarein")." (".$idioma.")"; ?>:</TD>
							   <TD valign=top width="80%"><INPUT TYPE="text" NAME="TITOL_<?php echo $codiidioma; ?>" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
							</TR>
							<?php
							}
							?>

							
						
	<tr>
		<td colspan="2" class="gris10">
			<?php echo t("folderisinitial"); ?><br>
			<input type="radio" name="CARPETAINICI" value="0" checked><?php echo t("no"); ?>&nbsp;&nbsp;&nbsp;
			<input type="radio" name="CARPETAINICI" value="1"><?php echo t("yes"); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
		
<?php
if (accessGroupPerm('avanced_options')) {
?>							
<!-- ultim bloc OPCIONS AVANÇADES -->
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
<div id="opcionsavan" style="display: none;" >
<div  style="background-color:#ECECEC;margin-right:15px;padding:10px;">

	<table>
	
							<?php
							for($i=0;$i<count($CONFIG_idiomes[$CONFIG_IDIOMA]);$i++){
								$trozos = explode ("_", $CONFIG_idiomes[$CONFIG_IDIOMA][$i]);
								$numerocategoria=$trozos['0'];
								$idioma=$trozos['1'];
								$codiidioma=$trozos['2'];
							?>
							<TR>
							   <TD class="gris10" valign=top width="20%"><?php echo t("keywords")." (".$idioma.")"; ?>:</TD>
							   <TD valign=top width="80%"><INPUT TYPE="text" NAME="METAKEYS_<?php echo $codiidioma; ?>" SIZE="50" MAXLENGTH="250" class="formulari" /></TD>
							</TR>

		
						
							<?php
							}
							?>
	</table>							
</div>	
</div>							
<?php
}
?>			
		</td>
	</tr>

							<TR>
							   <TD valign=top align=center colspan=2>
							   	   <INPUT TYPE="hidden" NAME="PARE"  class="formulari" value="<?php echo $pare; ?>">
							   	   <input type="hidden" name="CATEGORY1" value="0">
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