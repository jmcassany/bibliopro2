<?php

header("Expires: Mon, 6 Jan 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate"); // Compatibilidad con HTTP/1.1
header("Pragma: no-cache"); // Compatibilidad con HTTP/1.0


include("config.php");
include_once("../../../../../public/media/lang/lang_".$CONFIG_IDIOMA.".php");


//resultats informe
if($log10 == 1) $log10 = $messages["capimgsel"]." 1";
if($log10 == 2) $log10 = $messages["imgmassagran"]." 1";
if($log10 == 3) $log10 = $messages["noespotcopiarimg"]." 1";
if($log10 == 4) $log10 = $messages["shapujatimg"]." 1";
if($log10 == 5) $log10 = $messages["imgnovalida"]." 1";

if($log11 == 1) $log11 = $messages["capimgsel"]." 2";
if($log11 == 2) $log11 = $messages["imgmassagran"]." 2";
if($log11 == 3) $log11 = $messages["noespotcopiarimg"]." 2";
if($log11 == 4) $log11 = $messages["shapujatimg"]." 2";
if($log11 == 5) $log11 = $messages["imgnovalida"]." 2";

if($log12 == 1) $log12 = $messages["capimgsel"]." 3";
if($log12 == 2) $log12 = $messages["imgmassagran"]." 3";
if($log12 == 3) $log12 = $messages["noespotcopiarimg"]." 3";
if($log12 == 4) $log12 = $messages["shapujatimg"]." 3";
if($log12 == 5) $log12 = $messages["imgnovalida"]." 3";

if($log20 == 1) $log20 = $messages["caparxsel"]." 1";
if($log20 == 2) $log20 = $messages["arxmassagran"]." 1";
if($log20 == 3) $log20 = $messages["noespotcopiararx"]." 1";
if($log20 == 4) $log20 = $messages["shapujatarx"]." 1";
if($log20 == 5) $log20 = $messages["arxnovalid"]." 1";

if($log21 == 1) $log21 = $messages["caparxsel"]." 2";
if($log21 == 2) $log21 = $messages["arxmassagran"]." 2";
if($log21 == 3) $log21 = $messages["noespotcopiararx"]." 2";
if($log21 == 4) $log21 = $messages["shapujatarx"]." 2";
if($log21 == 5) $log21 = $messages["arxnovalid"]." 2";

if($log22 == 1) $log22 = $messages["caparxsel"]." 3";
if($log22 == 2) $log22 = $messages["arxmassagran"]." 3";
if($log22 == 3) $log22 = $messages["noespotcopiararx"]." 3";
if($log22 == 4) $log22 = $messages["shapujatarx"]." 3";
if($log22 == 5) $log22 = $messages["arxnovalid"]." 3";

if($log23 == 1) $log23 = $messages["caparxsel"]." 4";
if($log23 == 2) $log23 = $messages["arxmassagran"]." 4";
if($log23 == 3) $log23 = $messages["noespotcopiararx"]." 4";
if($log23 == 4) $log23 = $messages["shapujatarx"]." 4";
if($log23 == 5) $log23 = $messages["arxnovalid"]." 4";

if($log24 == 1) $log24 = $messages["capdocsel"];
if($log24 == 2) $log24 = $messages["docmassagran"];
if($log24 == 3) $log24 = $messages["noespotcopiardoc"];
if($log24 == 4) $log24 = $messages["shapujatdoc"];
if($log24 == 5) $log24 = $messages["docnovalid"];


$result = mysql_query("SELECT * FROM newsletter_noticies Where ID='$ID'");
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
	$subtitol = $row['SUBTITOL'];
	$lloc = $row['LLOC'];
	$data_lloc = $row['DATA_LLOC'];
	$resum = nl2br($row['RESUM']);
	$descripcio = $row['DESCRIPCIO'];
	$nom = $row['NOM'];
	$carrec = $row['CARREC'];


	$adjunt1 = $row['ADJUNT1'];
	if ($adjunt1 != ""){

		$nom_adjunt1 = $row['NOMAD1'];
		if ($nom_adjunt1 != ""){
			$adjunt1 = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"$CONFIG_URLUPLOADAD$adjunt1\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".$nom_adjunt1."</a></td></tr>";
		}else{
			$adjunt1 = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"$CONFIG_URLUPLOADAD$adjunt1\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".$messages["enllac"]." 1</a></td></tr>";
		}

	}else{
		$adjunt1 = "";
	}

	$adjunt2 = $row['ADJUNT2'];
	if ($adjunt2 != ""){

		$nom_adjunt2 = $row['NOMAD2'];
		if ($nom_adjunt2 != ""){
			$adjunt2 = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"$CONFIG_URLUPLOADAD$adjunt2\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".$nom_adjunt2."</a></td></tr>";
		}else{
			$adjunt2 = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"$CONFIG_URLUPLOADAD$adjunt2\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".$messages["enllac"]." 2</a></td></tr>";
		}

	}else{
		$adjunt2 = "";
	}

	$adjunt3 = $row['ADJUNT3'];
	if ($adjunt3 != ""){

		$nom_adjunt3 = $row['NOMAD3'];
		if ($nom_adjunt3 != ""){
			$adjunt3 = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"$CONFIG_URLUPLOADAD$adjunt3\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".$nom_adjunt3."</a></td></tr>";
		}else{
			$adjunt3 = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"$CONFIG_URLUPLOADAD$adjunt3\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".$messages["enllac"]." 3</a></td></tr>";
		}

	}else{
		$adjunt3 = "";
	}

	$adjunt4 = $row['ADJUNT4'];
	if ($adjunt4 != ""){

		$nom_adjunt4 = $row['NOMAD4'];
		if ($nom_adjunt4 != ""){
			$adjunt4 = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"$CONFIG_URLUPLOADAD$adjunt4\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".$nom_adjunt4."</a></td></tr>";
		}else{
			$adjunt4 = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"$CONFIG_URLUPLOADAD$adjunt4\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".$messages["enllac"]." 4</a></td></tr>";
		}

	}else{
		$adjunt4 = "";
	}

	//subtitol
	if($subtitol != ""){
		$subtitol = "<br><font class=\"gris10b\">$subtitol</font>";
	}

	//info del lloc
	if($data_lloc != ""){
		$info_lloc = "<br><br><font class=\"gris10b\">$data_lloc</font>";
	}

	//cap�alera dels arxius adjunts
	if( ($adjunt1 != "") OR ($adjunt2 != "") OR ($adjunt3 != "") OR ($adjunt4 != "") ){
		$cap_ad = "<tr><td style=\"padding:8px;border-bottom:solid #CCCCCC 1px;\" class=\"gris10b\"><img src=\"../../../../../public/media/comu/admin/icon_clip_gran.gif\" border=0 align=\"absmiddle\">".$messages["enllacosrelacionats"]."</td></tr>";
	}

	//signatura
	if( ($nom != "") AND ($carrec != "") ){
		$signatura = "<tr><td style=\"padding-top:8px;padding-bottom:8px;border-top:solid #CCCCCC 1px;\" class=\"text9\"><font class=\"blautitol9b\">$nom</font><br>$carrec</td></tr>";
	}

	//imatge 1
	$imatge1 = $row['IMATGE1'];
    if ($row['IMATGE1'] != "") $img1 = "<img src=\"". $CONFIG_URLUPLOADIM_NL."/p$imatge1\" border=\"0\" style=\"float:left;margin:0 5 5 0;\">";

	//imatge 2
	//$imatge2 = $row['IMATGE2'];
    //if ($row['IMATGE2'] != "") $img2 = "<img src=\"../../../../../public/media/upload/noticies_newsletter/imgs/p$imatge2\" border=\"0\" style=\"float:left;margin:0 5 5 0;\">";

	//imatge 3
	//$imatge3 = $row['IMATGE3'];
    //if ($row['IMATGE3'] != "") $img3 = "<img src=\"../../../../../public/media/upload/noticies_newsletter/imgs/p$imatge3\" border=\"0\" style=\"float:left;margin:0 5 5 0;\">";

	//mes info, ...
	//if($row['MESINFO'] == '1'){
	if($row['DESCRIPCIO'] != ''){
		$mesinfo = "<font class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_mesinfo.gif\" width=13 height=11 border=0>Llegir més</font>";
	}else{
		$mesinfo = "";
	}

	//link anar al document --> ADJUNT5
	if($row['ADJUNT5'] != ""){
		$adjunt5 = $row['ADJUNT5'];
		$mostralink1 = "<a href=\"$CONFIG_URLUPLOADAD$adjunt5\" target=\"_blank\"><font class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_anar_doc.gif\" width=11 height=14 border=0> ".$messages["aneualdoc"]."</a></font>";
	}else{
		$mostralink1 = "";
	}

	//link anar al web
	if($row['LINK2'] != ""){
		$link2 = $row['LINK2'];
		$mostralink2 = "<a href=\"$link2\" target=\"_blank\"><font class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_anar_doc.gif\" width=11 height=14 border=0> ".$messages["aneualweb"]."</a></font>";
	}else{
		$mostralink2 = "";
	}

	//maquetaci� noticies
    echo ("<br><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"  align=\"center\">");
	echo ("<tr><td valign=\"top\" width=\"40%\" style=\"padding:5px;\">");

		//noticia butllet�
		echo ("<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"  align=\"center\">");
		echo ("<tr><td class=\"blanc11b\" style=\"padding:5px;\" bgcolor=\"#0E449A\"> ".$messages["noticiabutlleti"]."</td><tr>");
		echo ("<tr><td valign=\"top\" style=\"padding:10px;\">$img1 <font class=\"klandergris9b\">&#149;</font> <font class=\"blautitol11b\">$titol</font>$subtitol$info_lloc<br><br>$resum<br><br>$mesinfo $mostralink1 $mostralink2</td></tr>");
		echo ("</table>");

	echo ("</td><td valign=\"top\" width=\"60%\" style=\"padding:5px;border-left:solid #CCCCCC 1px;\">");

		if($row['DESCRIPCIO'] != ''){
			//noticia completa
			echo ("<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"  align=\"center\">");
			echo ("<tr><td colspan=\"2\" class=\"blanc11b\" style=\"padding:5px;\" bgcolor=\"#0E449A\"> ".$messages["noticiacomplerta"]."</td><tr>");
			echo ("<tr>
					<td valign=\"top\" style=\"padding:10px;\">
						$img1
						<font class=\"klandergris9b\">&#149;</font> <font class=\"blautitol11b\">$titol</font>
						$subtitol
						$info_lloc
						<br>
						<br>
						$descripcio
						<br>
						<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
						$signatura
						</table>
						<br>
						<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border:solid #CCCCCC 1px;\">
						$cap_ad
						$adjunt1
						$adjunt2
						$adjunt3
						$adjunt4
						</table>
					</td>
				</tr>");
			echo ("</table>");
		}else{
			echo "No hi ha més informació!";
		}

	echo ("</td></tr>");
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
			<?php
				echo $log10."<br>";
				//echo $log11."<br>";
				//echo $log12."<br>";
				echo $log20."<br>";
				echo $log21."<br>";
				echo $log22."<br>";
				echo $log23."<br>";
				//echo $log24;
			?>
			</font>
		</td>
	</tr>
	<tr><td height="1"  bgcolor="#ffffff" colspan="2"><spacer type="block" width="1" height="1"></td></tr>
	<tr><td height="1" bgcolor="#D6D6D6" colspan="2"><spacer type="block" width="1" height="1"></td></tr>
<!-- ///tr/3 -->
</table>
</body>
</html>
