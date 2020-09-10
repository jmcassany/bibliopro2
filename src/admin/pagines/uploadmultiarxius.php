<?php

require ('../config_admin.inc');
accessGroupPermCheck('page_read');

if (isset($_POST['arxius'])) {
  $arxius = $_POST['arxius'];
}
elseif (isset($_GET['arxius'])) {
  $arxius = $_GET['arxius'];
}
else {
  $arxius = 0;
}
if (isset($_POST['ID'])) {
  $ID = $_POST['ID'];
}
elseif (isset($_GET['ID'])) {
  $ID = $_GET['ID'];
}
else {
  exit;
}


/*pujar fitxer*/
if (isset($_POST['submitted'])) {
  $log = array();
  for ($i = 1; $i <= $arxius; $i++) {
    if(isset($_FILES['file'.$i]) && $_FILES['file'.$i]['name'] != '') {
      $nom_fitxer = normalizeFileAndExtension($_FILES['file'.$i]['name']);
      $extensio = explode (".", $nom_fitxer);
      $destName = $extensio['0'].'_pag_'.$ID.'_'.$i.'.'.$extensio['1'];
      $log[$i] = upload('file'.$i, $CONFIG_PATHUPLOADAD, $UPLOAD_filesize, $UPLOAD_filetype, $destName);
      if ($log[$i] == 4) {
        db_query('update ESTATICA set ADJUNT'.$i.' = \''.$destName.'\' where ID = '.$ID);
      }
    }
  }

?>

<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body >
<table align="center" cellpadding="0" cellspacing="0" style="border:solid #0A2082 1px;padding-left:10px;padding-right:10px;padding-bottom:5px;" width="460" border="0">
	<tr>
		<td width="133" style="padding-right:0px;"><img src="../comu/houdini_popup.gif" alt="Houdini" width="133" height="44" vspace="5" border="0"></td>
		<td class="text"  style="padding-left:8px;" width="327">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td bgcolor="#FDDBCA" width="60"><img src="../comu/upload_attach.gif" width="60" height="44" alt="<?php echo t("upload")." ".t("files"); ?>" border="0"></td>
					<td class="text" bgcolor="#FDDBCA"><b><?php echo t("files"); ?></b></td>
					<td align="right" valign="top" bgcolor="#C0CEE4" width="27" style="border-left:solid #FFFFFF 10px;"><a href="javascript:window.close();"><img src="../comu/icon_tanca.gif" alt="<?php echo t("close"); ?>" width="27" height="15"  vspace="6" border="0"></a>&nbsp;</td>
				</tr>
			</table>
		</td>


	</tr>
	<tr>
		<td colspan="2" class="text" >
		<div style="border:solid #000000 1px;padding:15px;">
<?php
foreach ($log as $value) {
  if($value == 1) echo '<img src="../comu/ico_alerta.gif" border="0" hspace="5">'.t('uploadfileslognone').'<br>';
  if($value == 2) echo '<img src="../comu/ico_alerta.gif" border="0" hspace="5">'.t('uploadfileslogtoobig').'<br>';
  if($value == 3) echo '<img src="../comu/ico_alerta.gif" border="0" hspace="5">'.t('uploadfileslogerrorcopy').'<br>';
  if($value == 4) echo '<img src="../comu/ico_upodatedok.gif" border="0" hspace="5">'.t('uploadfileslogok').'<br>';
  if($value == 5) echo '<img src="../comu/ico_alerta.gif" border="0" hspace="5">'.t('uploadfilesloginvalidformat').'<br>';
}
?>
<br><br><b><a href="javascript:history.back();" class="vinclenoticia"><?php echo t("back"); ?></a> | <a href="javascript:window.close();" class="vinclenoticia"><?php echo t("close"); ?></a></b>
		</div>
		</td>
	</tr>
</table>

</body>
</html>
<?php
exit;
} // End processing portion of script
?>

<html>
<head>
<?php echo htmlMetas(); ?>
<script type="text/javascript">
function enviarimatges(){
  document.getElementById('carregant').style.display='inline';
  document.getElementById('contingut').style.display='none';
}
</script>
</head>
<body>
<form method=POST action=uploadmultiarxius.php enctype=multipart/form-data>
<div id="carregant" style="width: 100%; height: 100%; text-align: center;display: none"><br><br><?php echo t("sending")." ".t("files") ?>...</div>
<div id="contingut">
<table align="center" cellpadding="0" cellspacing="0" style="border:solid #0A2082 1px;padding-left:10px;padding-right:10px;padding-bottom:5px;" width="460" border="0">
	<tr>
		<td width="133" style="padding-right:0px;"><img src="../comu/houdini_popup.gif" alt="Houdini" width="133" height="44" vspace="5" border="0"></td>
		<td class="text"  style="padding-left:8px;" width="327">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td bgcolor="#FDDBCA" width="60"><img src="../comu/upload_attach.gif" width="60" height="44" alt="<?php echo t("upload")." ".t("files"); ?>" border="0"></td>
					<td class="text" bgcolor="#FDDBCA"><b><?php echo t("files"); ?></b></td>
					<td align="right" valign="top" bgcolor="#C0CEE4" width="27" style="border-left:solid #FFFFFF 10px;"><a href="javascript:window.close();"><img src="../comu/icon_tanca.gif" alt="<?php echo t("close"); ?>" width="27" height="15"  vspace="6" border="0"></a>&nbsp;</td>
				</tr>
			</table>
		</td>


	</tr>
	<tr>
		<td colspan="2" class="text" >
		<div style="border:solid #000000 1px;padding:15px;">
<table>
<?php
$ID=$_GET['ID'];
$PLANTILLAID=$_GET['PLANTILLAID'];
echo ("<input type=\"hidden\" name=\"ID\" value=\"$ID\">");
echo ("<input type=\"hidden\" name=\"arxius\" value=\"$arxius\">");
//saber titols plantilla
$result=db_query("select ADJUNT1,ADJUNT2,ADJUNT3,ADJUNT4,ADJUNT5,ADJUNT6,ADJUNT7,ADJUNT8,ADJUNT9,ADJUNT10  from PLANTILLA_DESC where PLANTILLA = '$PLANTILLAID'");
$row = db_fetch_array($result);
$row = str_replace("|", "", $row);

for ($j=1; $j<=$arxius; $j++) {
?>
<tr><td width="15%" class="text10"><?php echo $row['ADJUNT'.$j] ?></td>
<td width="85%"><input type=file name=file<?php echo $j ?> size=50 class="formulari"  style="width:300px;"></td></tr>
<?php
}
?>
</table>
<br><input type="hidden" name="submitted" value="true">
<center><input type="submit" name="submit" value="<?php echo t("send"); ?>"> </center>

		</div>
		</td>
	</tr>
</table>
<p class="text9">
<?php echo t('uploadvalidformat'); ?>: pdf,doc,zip,xls,ppt<br>
<?php
if ($UPLOAD_filesize >0) {
  echo t('uploadmaxsize').': '.($UPLOAD_filesize/1000).'kb<br>';
}
?>
</p>
</div>
</form>
</body>
</html>