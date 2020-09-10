<?php

header("Expires: Mon, 6 Jan 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate"); // Compatibilidad con HTTP/1.1
header("Pragma: no-cache"); // Compatibilidad con HTTP/1.0


include("config.php");
include_once("../../../../../public/media/lang/lang_".$CONFIG_IDIOMA.".php");


//resultats informe
if($log == 1) $log = $messages["capimgsel"];
if($log == 2) $log = $messages["imgmassagran"];
if($log == 3) $log = $messages["noespotcopiarimg"];
if($log == 4) $log = $messages["shapujatimg"];
if($log == 5) $log = $messages["imgnovalida"];


$result = mysql_query("SELECT * FROM newsletter_banners Where ID='$ID'");
$row = mysql_fetch_array($result);

?>
<html>

<head>
	<title><?php echo $messages["website"]; ?></title>
    <link rel="stylesheet" href="../../media/css/style-admin.css" type="text/css" media="screen"/>
</head>

<body bgcolor="#ffffff" topmargin="0" leftmargin="5" rightmargin="5" marginheight="0" marginwidth="0">
<table border="0" cellpadding="0" cellspacing="0" width="100%">

	<tr>

		<td  bgcolor="#0E449A" class="titblanc" style="padding:20 0 20 10;"><?php echo $messages["previsualitzacio"]; ?></td>
	</tr>
<!-- tr/3 -->


<!-- ///tr/3 -->
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#D6D6D6">
	<tr>
		<td style="padding-left:10px;padding-right:40px;" height="27"><a href="list.php" class="menupreview"><img src="../../../../../public/media/comu/admin/bot_generar.gif" alt="Publicar" width="28" height="19" align="absmiddle" border="0"><?php echo $messages["confirmar"]; ?></a></td>
		<td style="padding-right:10px;" align="right"><a href="view.php?ID=<?php echo $ID ?>" class="menupreview"><img src="../../../../../public/media/comu/admin/bot_edita.gif" alt="Modificar dades" width="28" height="19"  border="0" align="absmiddle"><?php echo $messages["modificar"]; ?></a></td>
	</tr>
</table>
<?php
    $titol = $row['TITOL'];
	$link = $row['LINK'];

	//imatge
	$imatge = $row['IMATGE'];
    if ($row['IMATGE'] != "") $img = "<img src=\"/public/media/upload/banners_newsletter/$imatge\" border=\"0\">";

	//maquetaci�
	echo ("<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">");
	echo ("<tr><td valign=\"top\" style=\"padding:10px;\" align=\"center\"><a href=\"$link\" target=\"_blank\">$img</a></td></tr>");
	echo ("</table>");
	//fi maquetaci�

	mysql_free_result($result);
	mysql_close();
?>

<br>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<!-- tr/3 -->
	<tr>
		<td class="text" bgcolor="#0E449A" width="50" valign="top" style="padding:3px;"><font color="#FFFFFF"><b><?php echo $messages["informe"]; ?>:</b></font></td>
		<td class="text10" height="28" bgcolor="#0E449A"  valign="top" style="padding:3px;">
			<font color="#FFFFFF">
			<?php echo $log; ?>
			</font>
		</td>
	</tr>
	<tr><td height="1"  bgcolor="#ffffff" colspan="2"><spacer type="block" width="1" height="1"></td></tr>
	<tr><td height="1" bgcolor="#D6D6D6" colspan="2"><spacer type="block" width="1" height="1"></td></tr>
<!-- ///tr/3 -->
</table>
</body>
</html>
