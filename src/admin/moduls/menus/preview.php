<?php

header("Expires: Mon, 6 Jan 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate"); // Compatibilidad con HTTP/1.1
header("Pragma: no-cache"); // Compatibilidad con HTTP/1.0


require ('../../config_admin.inc');
accessGroupPermCheck('menu_read');

include_once("menus.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ca" lang="ca">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="STYLESHEET" type="text/css" href="../../css/estils.css">
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


<?php
  //crida base de dades
  include_once('variables.php');

?>


<table border="0" cellpadding="0" cellspacing="0"  width="760">

	<tr>
		<td  bgcolor="#0E449A" width="132"><img src="../../comu/logo.gif" alt="Houdini" width="132" height="52" border="0"></td>
		<td  bgcolor="#0E449A" class="titblanc" style="padding-left:10px;"><?php echo t("preview")."&nbsp;".t("menu"); ?></td>
	</tr>
<!-- tr/3 -->


<!-- ///tr/3 -->
</table>
<table cellpadding="0" cellspacing="0" border="0"  width="760" bgcolor="#D6D6D6" >
	<tr>
<?php
if (accessGroupPerm('menu_publish')) {
?>
		<td style="padding-left:10px;padding-right:40px;" width="80" height="27"><a href="crearestatic.php?ID=<?php echo $ID; ?>" class="menupreview"><img src="../../comu/bot_generar.gif" alt="<?php echo t("generate"); ?>" width="28" height="19" align="absmiddle" border="0"><?php echo t("generate"); ?></a></td>
<?php
}
if (accessGroupPerm('menu_edit')) {
?>
		<td style="padding-left:10px;padding-right:10px;" height="27"><a href="edita.php?ID=<?php echo $ID; ?>" class="menupreview"><img src="../../comu/bot_edita.gif" alt="<?php echo t("modify"); ?>" width="28" height="19"  border="0" align="absmiddle"><?php echo t("modify"); ?></a></td>
<?php
}
?>
		<td align="right"  style="padding-right:10px;"  height="27"><a href="index.php" class="menupreview"><img src="../../comu/bot_cancela.gif" alt="<?php echo t("cancel"); ?>" width="27" height="19" align="absmiddle" border="0"><?php echo t("cancel"); ?></a></td>
	</tr>
</table>
<div  style="width:760px;text-align:left">
<br>

<?php


  $ID=$_GET['ID'];
  $resultmenus=db_query("select * from MENUS Where ID = '$ID'");
  $rowmenus = db_fetch_array($resultmenus);

  $nommenu = $rowmenus['NOM'];
  $descripmenu = $rowmenus['DESCRIPCIO'];

  $preview = menu_generate($_GET['ID'], $rowmenus['DESPLEGABLE'], $rowmenus['TIPO'],$rowmenus['ESTIL'], true);
	echo phpEval($preview);


?>
</div>

<?php
 db_free_result($resultmenus);

?>

<br><br>
<table cellpadding="0" cellspacing="0" border="0"  width="760" bgcolor="#D6D6D6">
	<tr>
<?php
if (accessGroupPerm('menu_publish')) {
?>
		<td style="padding-left:10px;padding-right:40px;" width="80" height="27"><a href="crearestatic.php?ID=<?php echo $ID; ?>" class="menupreview"><img src="../../comu/bot_generar.gif" alt="<?php echo t("generate"); ?>" width="28" height="19" align="absmiddle" border="0"><?php echo t("generate"); ?></a></td>
<?php
}
if (accessGroupPerm('menu_edit')) {
?>
		<td style="padding-left:10px;padding-right:10px;" height="27"><a href="edita.php?ID=<?php echo $ID; ?>" class="menupreview"><img src="../../comu/bot_edita.gif" alt="<?php echo t("modify"); ?>" width="28" height="19"  border="0" align="absmiddle"><?php echo t("modify"); ?></a></td>
<?php
}
?>
		<td align="right"  style="padding-right:10px;"  height="27"><a href="index.php" class="menupreview"><img src="../../comu/bot_cancela.gif" alt="<?php echo t("cancel"); ?>" width="27" height="19" align="absmiddle" border="0"><?php echo t("cancel"); ?></a></td>
	</tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
