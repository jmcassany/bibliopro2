<?php
header("Expires: Mon, 6 Jan 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate"); // Compatibilidad con HTTP/1.1
header("Pragma: no-cache"); // Compatibilidad con HTTP/1.0

require ('../../config_admin.inc');
accessGroupPermCheck('boxes');

require('caixetes.php');

include('variables.php');


$log = '';
if (!empty($_GET['log'])) {
  $log = $_GET['log'];
}
$log2 = '';
if (!empty($_GET['log2'])) {
  $log2 = $_GET['log2'];
}


//resultats informe
if($log == 1) $log="Cap imatge seleccionada";
if($log == 2) $log="La imatge és massa gran";
if($log == 3) $log="No és pot copia la imatge al servidor";
if($log == 4) $log="La imatge ha estat pujada al servidor";
if($log == 5) $log="La imatge  no és vàlida";
if($log2 == 1) $log2="Cap arxiu seleccionat";
if($log2 == 2) $log2="L'arxiu és massa gran";
if($log2 == 3) $log2="No és pot copia l'arxiu al servidor";
if($log2 == 4) $log2="L'arxiu ha estat pujat al servidor";
if($log2 == 5) $log2="L'arxiu  no és vàlid";


$result = db_query("SELECT * FROM CAIXETES Where ID='$ID'");
$row = db_fetch_array($result);

$tipo=$row['TIPO'];

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="STYLESHEET" type="text/css" href="<?php echo $CONFIG_URLADMIN ?>/css/estils.css">
	<link rel="STYLESHEET" type="text/css" href="<?php echo $CONFIG_URLCSS ?>/estils.css">
  <style>
    html {
      background-color: #ffffff;
    }
    body {
      background-color: #ffffff;
      margin: 0px;
      padding: 0px;
      text-align: left;
    }
  </style>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0"  width="760" style="margin-left:10px;margin-right:10px;" >

	<tr>
		<td  bgcolor="#0E449A" width="132"><img src="<?php echo $CONFIG_URLADMIN ?>/comu/logo.gif" alt="Houdini" width="132" height="52" border="0"></td>
		<td  bgcolor="#0E449A" class="titblanc" style="padding-left:10px;"><?php echo t('bannerspreview') ?></td>
	</tr>
<!-- tr/3 -->


<!-- ///tr/3 -->
</table>

<table cellpadding="0" cellspacing="0" border="0" width="760" style="margin-left:10px;margin-right:10px;" bgcolor="#D6D6D6">
	<tr>
		<td style="padding-left:10px;padding-right:40px;" width="80" height="27"><a href="crearestatic.php?ID=<?php echo $ID ?>" class="menupreview"><img src="<?php echo $CONFIG_URLADMIN ?>/comu/ico_generat_on.gif" alt="<?php echo t("generate"); ?>" width="28" height="19" border="0" align="absmiddle"><?php echo t("generate"); ?></a></td>
		<td style="padding-right:10px;"><a href="view.php?ID=<?php echo $ID ?>&SKIN=<?php echo $tipo ?>" class="menupreview"><img src="<?php echo $CONFIG_URLADMIN ?>/comu/bot_edita.gif" alt="<?php echo t("modify"); ?>" width="28" height="19"  border="0" align="absmiddle"><?php echo t("modify"); ?></a></td>
		<td align="right"  style="padding-right:10px;" ><a href="index.php" class="menupreview"><img src="<?php echo $CONFIG_URLADMIN ?>/comu/ico_generat_off.gif" alt="<?php echo t("waitgenerate"); ?>" width="28" height="19" border="0" align="absmiddle"><?php echo t("waitgenerate"); ?></a></td>
	</tr>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="0"  width="760" style="margin-left:10px;margin-right:10px;" >
	<tr>
		<td style="vertical-align: middle; text-align: center">

<?php

echo caixeta_preview($row);


?>
		</td>
	</tr>
</table>
<br>
<table border="0" cellpadding="0" cellspacing="0"  width="760" style="margin-left:10px;margin-right:10px;" >
<!-- tr/3 -->
	<tr>
		<td class="text" bgcolor="#0E449A" width="50" valign="top" style="padding:3px;"><font color="#FFFFFF"><b><?php echo t("previewlog") ?></b></font></td>
		<td class="text10" height="28" bgcolor="#0E449A"  valign="top" style="padding:3px;"><font color="#FFFFFF"><?php echo $log; ?><br><?php echo $log2; ?></font></td>
	</tr>
	<tr><td height="1"  bgcolor="#ffffff" colspan="2"><spacer type="block" width="1" height="1"></td></tr>
	<tr><td height="1" bgcolor="#D6D6D6" colspan="2"><spacer type="block" width="1" height="1"></td></tr>
<!-- ///tr/3 -->
</table>
</body>
</html>
