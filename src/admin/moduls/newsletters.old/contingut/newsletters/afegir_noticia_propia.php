<html>

<?php
	include("config.php");
?>

<head>
	<title><?php echo t("website"); ?></title>
	<link rel="STYLESHEET" type="text/css" href="../../../../../public/media/css/estils.css">
</head>

<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="margin:5px;">

<a name="top"></a>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td class="text10" height="32" bgcolor="#FDDBCA"><img src="../../../../../public/media/comu/admin/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("selecnoticies"); ?></b></td>
</tr>
</table>

<?php
	if ($_REQUEST['add']){

		echo "<script>
			function envia_tanca(){
				id_cat = document.form_sel.cat.value;
				ID = document.form_sel.ID.value;
				IdCam = document.form_sel.IdCam.value;
				noticia_newsletter = document.form_sel.noticia_newsletter.value;

				parent.opener.location='edita.php?ID='+ID+'&noticia_newsletter='+noticia_newsletter+'&id_cat='+id_cat+'&IdCam='+IdCam;
				self.close();
			}
			</script>";

		//mostrar noticia
		$result = mysql_query("SELECT * FROM NOTICIES_NEWSLETTER WHERE ID=".$noticia_newsletter." AND (STATUS='1')  AND (USUARI_HOUDINI='".$_SESSION['access']['login']."')");
		$row = mysql_fetch_array($result);

		$titol = stripslashes($row['TITOL']);
		$resum = nl2br($row['RESUM']);
		$subtitol = $row['SUBTITOL'];
		$lloc = $row['LLOC'];
		$data_lloc = $row['DATA_LLOC'];

		if ($row['IMATGE1'] != "") { $img1 = "<img src=\"../../../../../public/media/upload/noticies_newsletter/imgs/p$row[IMATGE1]\" border=\"0\" style=\"float:left;margin:0 5 5 0;\">"; } else { $img1 = ""; }

		//if ($row['MESINFO'] == '1') {
		if ($row['DESCRIPCIO'] != '') {
			$mesinfo = "<img src=\"../../../../../public/media/comu/admin/icon_mesinfo.gif\" width=13 height=11 border=0> <font class=\"blautitol10\">".t("mesinfo")."</font>";
		} else {
			$mesinfo = "";
		}

		//link anar al document
		if($row['ADJUNT5'] != ""){
			$adjunt5 = $row['ADJUNT5'];
			$mostralink1 = "<a href=\"$CONFIG_URLUPLOADAD$adjunt5\" target=\"_blank\"><font class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_anar_doc.gif\" width=11 height=14 border=0> ".t("aneualdoc")."</a></font>";
		}else{
			$mostralink1 = "";
		}

		//link anar al web
		if($row['LINK2'] != ""){
			$link2 = $row['LINK2'];
			$mostralink2 = "<a href=\"$link2\" target=\"_blank\"><font class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_anar_doc.gif\" width=11 height=14 border=0> ".t("aneualweb")."</a></font>";
		}else{
			$mostralink2 = "";
		}

		//subtitol
		if($subtitol != ""){
			$subtitol = "<br><font class=\"gris10b\">$subtitol</font>";
		}

		//info del lloc
		if( ($lloc != "") AND ($data_lloc != "") ){
			$info_lloc = "<br><br><font class=\"roig10b\">$lloc</font><br><font class=\"gris10b\">$data_lloc</font>";
		}

		$maquetacio_noticia = "<table cellpadding=0 cellspacing=0 border=0 width=\"100%\" >
								<tr>
									<td valign=\"top\" style=\"padding:5px;\">
										$img1 <font class=\"klandergris9b\">&#149;</font> <font class=\"blautitol11b\">$titol</font>$subtitol$info_lloc<br><br>$resum<br>
										<br>
										$mesinfo $mostralink1 $mostralink2
									</td>
								</tr>
							</table>";

		$opcions = "<form action=\"afegir_noticia_propia.php\" method=\"post\" name=\"form_sel\">
					<br>
					<table cellpadding=0 cellspacing=0 border=0 width=\"100%\">
					<tr>
						<td class=text11 style=\"padding:5px;\">
							<img src=\"../../../../../public/media/comu/admin/icon_docs.gif\" width=15 height=18 border=0> <b>".t("elegircategoria")."</b>
						</td>
					</tr>
					</table>
					<table cellpadding=0 cellspacing=0 border=0 width=\"100%\" style=\"border:solid #0E449A 1px;\">
					<tr>
						<td colspan=\"2\" class=\"text11\" style=\"padding:10px;border-bottom:solid #0E449A 1px;\">
							<SELECT name=cat>";

							if($MODEL_NL==0){
								$query = mysql_query("select * from CATEGORIES_NOTICIES where (STATUS='1')  AND ((USUARI_HOUDINI='".$_SESSION['access']['login']."') OR (USUARI_HOUDINI IS NULL)) order by ORDRECAT ASC");
								while ($fila = mysql_fetch_array($query)){
									$id_cat = $fila['ID'];
									$titol_cat = stripslashes($fila['TITOL']);
	
									$opcions .= "<option value=\"$id_cat\">$titol_cat</option>";
								}
							}
							else{
									$opcions .= "<option value=\"1\">------------</option>";
							}
		$opcions .= "</SELECT>
						</td>
					</tr>
					<tr>
						<td class=\"gris11\" style=\"padding:10px;\">
							<input type=button name=add value=\"".t("seleccionar")."\" onclick=\"javascript:envia_tanca();\">
							<input type=hidden name=ID value=$ID>
							<input type=hidden name=IdCam value=$IdCam>
							<input type=hidden name=noticia_newsletter value=$noticia_newsletter>
							<input type=hidden name=MODEL_NL value=$MODEL_NL>
						</td>
						<td align=\"right\" class=\"gris11\" style=\"padding:10px;\">
							<a href=\"javascript:history.go(-1)\" class=text10><img src=\"../../../../../public/media/comu/admin/bot_enrera_blau.gif\" width=10 height=8 border=0> ".t("tornar")."</a>
						</td>
					</tr>
					</table></form>";

		echo "<br>".$maquetacio_noticia.$opcions;

		exit();
	}
?>

<!-- CERCADOR -->
<form action="afegir_noticia_propia.php">
<table cellpadding="0" cellspacing="0" border="0" width="100%" style="padding:5px;">
<tr>
	<td class="text11" style="padding:5px;">
		<img src="../../../../../public/media/comu/admin/lupa_icon.gif" alt="" width="15" height="15" border="0"> <b><?php echo t("cercarnoticies"); ?></b>
	</td>
</tr>
<tr>
	<td style="padding:10px;border:solid #0E449A 1px;" class="text10">
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td style="padding-top:5px;padding-bottom:10px;border-bottom:solid #CCCCCC 1px;" class="text10">
			<?php echo t("perparaulaclau"); ?>: <input type="text" name="recerca" maxlength="30" size="30" class="formulari2" value="<?php echo $recerca; ?>">
			</td>
		</tr>
		<tr>
			<td style="padding-top:10px;padding-bottom:10px;border-bottom:solid #CCCCCC 1px;" class="text10">
			<?php echo t("perdata"); ?>.&nbsp;&nbsp;&nbsp;De: <input type="text" name="data_inici_dia" maxlength="2" size="2" class="formulari2" value="<?php echo $data_inici_dia; ?>"> / <input type="text" name="data_inici_mes" size="2" maxlength="2" class="formulari2" value="<?php echo $data_inici_mes; ?>"> / <input type="text" name="data_inici_any" size="4" maxlength="4" class="formulari2" value="<?php echo $data_inici_any; ?>">&nbsp;&nbsp;A: <input type="text" name="data_fi_dia" size="2" maxlength="2" class="formulari2" value="<?php echo $data_fi_dia; ?>"> / <input type="text" name="data_fi_mes" size="2" maxlength="2" class="formulari2" value="<?php echo $data_fi_mes; ?>"> / <input type="text" name="data_fi_any" size="4" maxlength="4" class="formulari2" value="<?php echo $data_fi_any; ?>">
			</td>
		</tr>
		<input type="hidden" name="ID" value="<?php echo $ID; ?>">
		<input type="hidden" name="IdCam" value=<?php echo $IdCam; ?>>
		<input type="hidden" name="MODEL_NL" value="<?php echo $MODEL_NL; ?>">
		<tr>

			<td style="padding-top:10px;padding-bottom:5px;" class="text10">
				<input type="submit" name="accion" value="<?php echo t("llistar"); ?>">
			</td>
		</tr>
		</table>
	</td>
</tr>
</form>
</table>
<!-- /CERCADOR -->



<!-- RESULTATS DE LA CERCA -->
<?php
	if ($_REQUEST['accion']){

		echo "<form action=\"afegir_noticia_propia.php\">";
		echo "<table cellpadding=0 cellspacing=0 border=0 width=\"100%\" style=\"padding:5px;\">
				<tr>
					<td class=text11 style=\"padding:5px;\">
						<img src=\"../../../../../public/media/comu/admin/icon_docs.gif\" width=15 height=18 border=0> <b>".t("elegirnoticia")."</b>
					</td>
				</tr>
				<tr>
					<td style=\"padding:10px;border:solid #0E449A 1px;\" class=\"text10\">
						<table cellpadding=0 cellspacing=0 border=0 width=\"100%\">";

		if ( ($data_inici_any) AND ($data_inici_mes) AND ($data_inici_dia) AND ($data_fi_any) AND ($data_fi_mes) AND ($data_fi_dia) ) {
	    	$data_inici = $data_inici_any."-".$data_inici_mes."-".$data_inici_dia;
			$data_fi = $data_fi_any."-".$data_fi_mes."-".$data_fi_dia;
		} else {
			$data_inici = "";
			$data_fi = "";
		}

		$recerca = addslashes($recerca);

		$QUERY = "";

		if ($recerca) {
			$QUERY = "(TITOL LIKE '%$recerca%' OR RESUM LIKE '%$recerca%' OR DESCRIPCIO LIKE '%$recerca%')";
		}
		if ( ($data_inici) AND ($data_fi) ) {
			$QUERY = "(CREATION > '$data_inici' AND CREATION < '$data_fi')";
		}
		if ( ($data_inici) AND ($data_fi) AND ($recerca) ) {
			$QUERY = "(TITOL LIKE '%$recerca%' OR RESUM LIKE '%$recerca%' OR DESCRIPCIO LIKE '%$recerca%') AND (CREATION > '$data_inici' AND CREATION < '$data_fi')";
		}

		if($QUERY != ""){
			$result = mysql_query("SELECT * FROM NOTICIES_NEWSLETTER WHERE $QUERY AND (STATUS='1')  AND (USUARI_HOUDINI='".$_SESSION['access']['login']."') AND (MODEL=$MODEL_NL) ORDER BY TITOL ASC");
		}else{
			$result = mysql_query("SELECT * FROM NOTICIES_NEWSLETTER WHERE (STATUS='1')  AND (USUARI_HOUDINI='".$_SESSION['access']['login']."') AND (MODEL=$MODEL_NL) ORDER BY TITOL ASC");
		}


		$num_rows = mysql_num_rows($result);
		if($num_rows != 0){

			echo "<tr>
					<td style=\"padding-bottom:10px;border-bottom:solid #0E449A 1px;\" class=\"text10\">
						<input type=submit name=add value=".t("seleccionar").">
						<br><br>
						<font class=\"vermell10\"><b>*</b> ".t("noticiesjaintroduides")."</font>
					</td>
				</tr>
				<tr><td style=\"padding:5px;\"></td></tr>";

			$jaexisteix = '0';

			while($row = mysql_fetch_array($result)) {

				//consulta pq no apareguin les noticies ja introduides al newsletter
				$xxx = mysql_query("SELECT * FROM TE_NNL_NL WHERE ID_NL=".$ID." AND ID_NNL=".$row['ID']);
				$num_rows_xxx = mysql_num_rows($xxx);
				if($num_rows_xxx == 0){

					//marco la noticia si ha sigut introduida en algun newsletter...
					$ppp = mysql_query("SELECT * FROM TE_NNL_NL WHERE ID_NNL=".$row['ID']);
					$num_rows_ppp = mysql_num_rows($ppp);
					if($num_rows_ppp == 0){
						echo "<tr>
							<td style=\"padding-bottom:5px;\" class=\"text10\">
								<input type=\"radio\" name=\"noticia_newsletter\" value=".$row['ID'].">".stripslashes($row['TITOL'])."
							</td>
						</tr>";
					}else{
						echo "<tr>
							<td style=\"padding-bottom:5px;\" class=\"text10\">
								<font class=\"vermell10\"><b>*</b></font><input type=\"radio\" name=\"noticia_newsletter\" value=".$row['ID'].">".stripslashes($row['TITOL'])."
							</td>
						</tr>";
					}

					$jaexisteix = '1';
				}
			}

			if($jaexisteix == '0'){
				echo "<tr>
						<td style=\"padding-bottom:5px;\" class=\"text10\">
							<b>".t("noexist")."</b>
						</td>
					</tr>";
			}

			echo "<tr><td style=\"padding:5px;\">";
			echo "<input type=hidden name=ID value=".$ID.">";
			echo "<input type=hidden name=IdCam value=".$IdCam.">";
			echo "<input type=hidden name=MODEL_NL value=".$MODEL_NL.">";
			echo "</td></tr>";

			echo "<tr>
					<td style=\"padding-top:10px;padding-bottom:5px;border-top:solid #0E449A 1px;\" class=\"text10\">
						<font class=\"vermell10\"><b>*</b> ".t("noticiesjaintroduides")."</font>
						<br><br>
						<input type=submit name=add value=".t("seleccionar").">
					</td>
				</tr>";

		}else{

			echo "<tr>
					<td style=\"padding-bottom:5px;\" class=\"roig11\">
						<b>".t("noresul")."</b>
					</td>
				</tr>";
		}

		mysql_free_result($result);
	    mysql_close();

		echo "</table></td></tr></form></table>";

	}
?>


</body>
</html>
