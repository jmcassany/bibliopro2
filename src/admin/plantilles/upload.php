<?php

require ('../config_admin.inc');
accessGroupPermCheck('template_upload');


if (isset($_FILES['file'])) {
  $log = 1;
  if($_FILES['file']['name'] != '') {
    $log = upload('file', $CONFIG_PATHTEMPLATEEST, $UPLOAD_templatesize, $UPLOAD_templatetype);
    if ($log == 4) {
    }
  }

?>

<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="5" leftmargin="5" marginheight="0" marginwidth="0">
<br><br>
<table align="center" cellpadding="0" cellspacing="0" style="border:solid #0E449A 1px;padding:20px;" width="400">
<tr>
<td><img src="../comu/logo.gif" alt="" width="132" height="52" border="0"></td>
<td class="text">
<?php

if($log == 1) echo '<img src="../comu/ico_alerta.gif" border="0" hspace="5">'.t('uploadtemplatenone').'<br>';
if($log == 2) echo '<img src="../comu/ico_alerta.gif" border="0" hspace="5">'.t('uploadtemplatetoobig').'<br>';
if($log == 3) echo '<img src="../comu/ico_alerta.gif" border="0" hspace="5">'.t('uploadtemplateerrorcopy').'<br>';
if($log == 4) echo '<img src="../comu/ico_upodatedok.gif" border="0" hspace="5">'.t('uploadtemplateok').'<br>';
if($log == 5) echo '<img src="../comu/ico_alerta.gif" border="0" hspace="5">'.t('uploadtemplateginvalidformat').'<br>';

?>

<br><br><b><a href="javascript:history.back();" class="vinclenoticia"><?php echo t("back"); ?></a> | <a href="javascript:window.close();" class="vinclenoticia"><?php echo t("close"); ?></a></b></td>
</tr></table>
</body>
</html>
<?php
exit;
} // End processing portion of script
?>

<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body>
<form method=POST action=upload.php enctype=multipart/form-data>
<link rel="STYLESHEET" type="text/css" href="../css/estils.css">
<table align="center" cellpadding="0" cellspacing="0" style="border:solid #0E449A 2px;padding-left:20px;padding-right:20px;padding-bottom:5px;" width="400">
	<tr>
		<td   width="132" style="padding-right:10px;"><img src="../comu/logo.gif" alt="" width="132" height="52" vspace="5" border="0"></td>
		<td class="text" style="padding-left:0px;" >
		<img src="../comu/ico_upload.gif" width="36" height="18" alt="<?php echo t("uploadtemplatetitol"); ?>" border="0" align="absmiddle"><b><?php echo t("uploadtemplatetitol"); ?></b><br>
		</td>

	</tr>
	<tr>
		<td colspan="2" class="text">

&nbsp;<input type="file" name="file" size="10" class="formulari" style="width:100%"><br>
<br>

<br><input type="hidden" name="submitted" value="true">
<center><input type="submit" name="submit" value="<?php echo t("send"); ?>"> </center>
<br>
</td>
	</tr>
</table>


</form>
</body>
</html>