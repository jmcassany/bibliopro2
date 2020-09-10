<?php
header("Expires: Mon, 6 Jan 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate"); // Compatibilidad con HTTP/1.1
header("Pragma: no-cache"); // Compatibilidad con HTTP/1.0


require ('../config_admin.inc');
accessGroupPermCheck('dinamic_read');

include_once("dinamiques.php");
include_once('categories/funcions.inc');

//resultats informe
if($log == 1) $log=t('uploadimageslognone');
if($log == 2) $log=t('uploadimageslogtoobig');
if($log == 3) $log=t('uploadimageslogerrorcopy');
if($log == 4) $log=t('uploadimageslogok');
if($log == 5) $log=t('uploadimagesloginvalidformat');
if($log2 == 1) $log2=t('uploadfileslognone');
if($log2 == 2) $log2=t('uploadfileslogtoobig');
if($log2 == 3) $log2=t('uploadfileslogerrorcopy');
if($log2 == 4) $log2=t('uploadfileslogok');
if($log2 == 5) $log2=t('uploadfilesloginvalidformat');

//COMPROVEM SI TE ACCES A AQUEST MODUL
include("check_moduls.php");
//FI COMPROVEM SI TE ACCES A AQUEST MODUL


$result = db_query("SELECT * FROM $TAULA Where ID='$ID'");
$row = db_fetch_array($result);
$row['DESCRIPCIO'] = db_select_text($TAULA, 'DESCRIPCIO', 'ID = '.$row['ID']);
$row['RESUM'] = db_select_text($TAULA, 'RESUM', 'ID = '.$row['ID']);
?>
<html>
<head>
<?php echo htmlMetas(); ?>
<link rel="STYLESHEET" type="text/css" href="<?php echo $CONFIG_URLCSS ?>/estils.css">
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="5" rightmargin="5" marginheight="0" marginwidth="0">
<table border="0" cellpadding="0" cellspacing="0" width="100%">

	<tr>
		<td  bgcolor="#0E449A" width="132"><img src="../comu/logo.gif" alt="Houdini" width="132" height="52" border="0"></td>
		<td  bgcolor="#0E449A" class="titblanc" style="padding-left:10px;"><?php echo t("preview"); ?></td>
	</tr>
<!-- tr/3 -->


<!-- ///tr/3 -->
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#D6D6D6">
	<tr>
<?php
if (accessGroupPerm('dinamic_publish')) {
?>
<td style="padding-left:10px;padding-right:40px;" width="75" height="27"><a href="publicar.php?ID=<?php echo $ID; ?>&amp;DIN=<?php echo $DIN; ?>&amp;PAGE=<?php echo $pagina; ?>" class="menupreview"><img src="../comu/bot_generar.gif" alt="<?php echo t("publish"); ?>" width="28" height="19" align="absmiddle" border="0"><?php echo t("publish"); ?></a></td>
<?php
}
?>
<td style="padding-left:10px;padding-right:10px;" height="27"><a href="view.php?ID=<?php echo $ID; ?>&amp;DIN=<?php echo $DIN; ?>&amp;PAGE=<?php echo $pagina; ?>" class="menupreview"><img src="../comu/bot_edita.gif" alt="<?php echo t("modify"); ?>" width="28" height="19"  border="0" align="absmiddle"><?php echo t("modify"); ?></a></td>
<?php
if (accessGroupPerm('dinamic_publish')) {
?>
<td align="right"  style="padding-left:10px;padding-right:10px;" height="27"><a href="nopublicar.php?ID=<?php echo $ID; ?>&amp;DIN=<?php echo $DIN; ?>&amp;PAGE=<?php echo $pagina; ?>" class="menupreview"><img src="../comu/bot_cancela.gif" alt="<?php echo t("notpublish"); ?>" width="27" height="19" align="absmiddle" border="0"><?php echo t("notpublish"); ?></a></td>
<?php
}
?>
	</tr>
</table>
<?php


   echo ("<table width=\"550\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"  align=\"center\">\n");
	echo ("<tr>\n");

	// mostrem les miniatures de les imatges
	for($i = 1; $i <=3; $i++) {

		if($row['IMATGE'.$i] != "") echo ("<td valign=\"top\" style=\"padding-top:10px;padding-bottom:10px;padding-right:10px;\"><img src=\"".$CONFIG_URLUPLOADIM."/thumb-".$row['IMATGE'.$i]."\" border=\"0\"></td>");

	}

	echo ("<td  valign=\"top\" style=\"padding-top:10px;padding-bottom:10px;\" >
						<font class=\"grisc9\">".$row['DATA']."</font><br>
						<font color=\"#E38C00\">&#149;&nbsp;</font><a href=\"#\" class=\"blauf10b\" target=\"_top\">".$row['TITOL']."</a><br><img src=\"../../comu/bl.gif\" width=1 height=2><br>
						<font class=\"grisc9\">".$row['SUBTITOL']."</font>
						<br><br>
						".$row['RESUM']."<br>
						".$row['DESCRIPCIO']."
					</td>
				</tr>

			</table>
			<!-- fi entrada notícia -->
	");
	db_free_result($result);
?>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<!-- tr/3 -->
	<tr>
		<td class="text" bgcolor="#0E449A" width="50" valign="top" style="padding:3px;"><font color="#FFFFFF"><b>Informe:</b></font></td>
		<td class="text10" height="28" bgcolor="#0E449A"  valign="top" style="padding:3px;"><font color="#FFFFFF"><?php echo $log; ?><br><?php echo $log2; ?></font></td>
	</tr>
	<tr><td height="1"  bgcolor="#ffffff" colspan="2"><spacer type="block" width="1" height="1"></td></tr>
	<tr><td height="1" bgcolor="#D6D6D6" colspan="2"><spacer type="block" width="1" height="1"></td></tr>
<!-- ///tr/3 -->
</table>
</body>
</html>
