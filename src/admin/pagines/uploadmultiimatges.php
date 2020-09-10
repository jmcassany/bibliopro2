<?php

require ('../config_admin.inc');
accessGroupPermCheck('page_read');

if (isset($_POST['imatges'])) {
  $imatges = $_POST['imatges'];
}
elseif (isset($_GET['imatges'])) {
  $imatges = $_GET['imatges'];
}
else {
  $imatges = 0;
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


/*pujar imatge*/
if (isset($_POST['submitted'])) {
  $log = array();
  for ($i = 1; $i <= $imatges; $i++) {
    if(isset($_FILES['img'.$i]) && $_FILES['img'.$i]['name'] != '') {
      $nom_fitxer = normalizeFileAndExtension($_FILES['img'.$i]['name']);
      $extensio = explode (".", $nom_fitxer);
      $destName = $extensio['0'].'_pag_'.$ID.'_'.$i.'.'.$extensio['1'];
      $log[$i] = upload('img'.$i, $CONFIG_PATHUPLOADIM, $UPLOAD_imgsize, $UPLOAD_imgtype, $destName);
      if ($log[$i] == 4) {
        db_query('update ESTATICA set IMATGE'.$i.' = \''.$destName.'\' where ID = '.$ID);
      }
    }
  }

?>

<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff"  >
<table align="center" cellpadding="0" cellspacing="0" style="border:solid #0A2082 1px;padding-left:10px;padding-right:10px;padding-bottom:5px;" width="460" border="0">
	<tr>
		<td width="133" style="padding-right:0px;"><img src="../comu/houdini_popup.gif" alt="Houdini" width="133" height="44" vspace="5" border="0"></td>
		<td class="text"  style="padding-left:8px;" width="327">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td bgcolor="#FDDBCA" width="60"><img src="../comu/upload_imatges.gif" width="60" height="44" alt="<?php echo t("upload")." ".t("images"); ?>" border="0"></td>
					<td class="text" bgcolor="#FDDBCA"><b><?php echo t("images"); ?></b></td>
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
  if($value == 1) echo '<img src="../comu/ico_alerta.gif" border="0" hspace="5">'.t('uploadimageslognone').'<br>';
  if($value == 2) echo '<img src="../comu/ico_alerta.gif" border="0" hspace="5">'.t('uploadimageslogtoobig').'<br>';
  if($value == 3) echo '<img src="../comu/ico_alerta.gif" border="0" hspace="5">'.t('uploadimageslogerrorcopy').'<br>';
  if($value == 4) echo '<img src="../comu/ico_upodatedok.gif" border="0" hspace="5">'.t('uploadimageslogok').'<br>';
  if($value == 5) echo '<img src="../comu/ico_alerta.gif" border="0" hspace="5">'.t('uploadimagesloginvalidformat').'<br>';
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
<form method=POST action=uploadmultiimatges.php enctype=multipart/form-data>
<div id="carregant" style="width: 100%; height: 100%; text-align: center;display: none"><br><br><?php echo t("sending")." ".t("images") ?> ...</div>
<div id="contingut">
<table align="center" cellpadding="0" cellspacing="0" style="border:solid #0A2082 1px;padding-left:10px;padding-right:10px;padding-bottom:5px;" width="460" border="0">
	<tr>
		<td width="133" style="padding-right:0px;"><img src="../comu/houdini_popup.gif" alt="Houdini" width="133" height="44" vspace="5" border="0"></td>
		<td class="text"  style="padding-left:8px;" width="327">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td bgcolor="#FDDBCA" width="60"><img src="../comu/upload_imatges.gif" alt="<?php echo t("upload")." ".t("images"); ?>" width="60" height="44" border="0"></td>
					<td class="text" bgcolor="#FDDBCA"><b><?php echo t("images"); ?></b></td>
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
$PLANTILLAID=$_GET['PLANTILLAID'];
echo ("<input type=\"hidden\" name=\"ID\" value=\"$ID\">");
echo ("<input type=\"hidden\" name=\"imatges\" value=\"$imatges\">");
//saber titols plantilla
$result=db_query("select IMATGE1,IMATGE2,IMATGE3,IMATGE4,IMATGE5,IMATGE6,IMATGE7,IMATGE8,IMATGE9,IMATGE10,IMATGE11,IMATGE12,IMATGE13,IMATGE14,IMATGE15,IMATGE16,IMATGE17,IMATGE18,IMATGE19,IMATGE20  from PLANTILLA_DESC where PLANTILLA = '$PLANTILLAID'");
$row = db_fetch_array($result);
$row = str_replace("|", "", $row);


for ($j=1; $j<=$imatges; $j++) {
?>
<tr><td width="15%" class="text10">
<?php echo $row['IMATGE'.$j] ?>
</td>
<td width="85%"><input type="file" name="img<?php echo $j ?>" size=50 class="formulari"  style="width:300px;"></td></tr>
<?php
}
?>
</table>
<br><input type="hidden" name="submitted" value="true">
<center><input type="submit" name="submit" value="<?php echo t("send"); ?>"  onclick="enviarimatges()"> </center>
</div>
</td>
	</tr>
</table>

<p class="text9">
<?php echo t('uploadvalidformat'); ?>: jpg,gif,png,swf<br>
<?php
if ($UPLOAD_filesize >0) {
  echo t('uploadmaxsize').': '.($UPLOAD_imgsize/1000).'kb<br>';
}
?>
</p>
</div>
</form>
</body>
</html>