<?php
	include("config.php");

	accessCheckLevel(2, $CONFIG_PRE_NOMCARPETA.'/admin/');
	function accessCheckLevel($level,$url){
		global $level_user;

		$level_user = $_SESSION['access']['level'];

		if($level_user >= $level){
			return true;
		}else{
			header("Location: $url");
			exit;
		}
	}



	if($_GET['IdCam']){
		$id_campanya = $_GET['IdCam'];
	}

	// extracció de les dades del newsletter
	if($_GET['id']){
		$query = mysql_query("SELECT * FROM NEWSLETTERS WHERE IdCam=".$_GET['id']);
		$dades = mysql_fetch_array($query);
		$ID=$dades['ID'];
		$id_campanya = $_GET['id'];
	}else{
		$query = mysql_query("SELECT * FROM NEWSLETTERS WHERE ID=".$ID);
		$dades = mysql_fetch_array($query);
	}

	//dades x defecte: contacte i centres
	if($dades['CONTACTE']==''){
		$dades['CONTACTE'] = '<p>
					Mireya García-Durán Huet<br /><br />
					C/ Doctor Aigüader 88<br />
					08003 Barcelona<br />
					Fax: 93 316 0797<br />
					<a href="mailto:mgarciaduran@imim.es">Correo electr&oacute;nico</a>
				</p>';
	}
	if($dades['STAFF']==''){
		$dades['STAFF'] = '<p>
					<strong>Director:</strong><br />
					Jordi Alonso<br /><br />
					<strong>Comité Científico:</strong><br />
					Alonso, Jordi<br />
					Alonso Coello, Pablo<br />
					Arrarás, Juan Ignacio<br />
					Escobar, Antonio<br />
					Ferrer, Montserrat<br />
					Herdman, Michael<br />
					Lucas, Ramona<br />
					Ochoa, Susana<br />
					Permanyer, Gaietà<br />
					Quintana, José María<br />
					Rajmil, Luis<br />
					Rebollo, Pablo<br />
					Ribera, Aida<br />
					Valderas, José María
				</p>';
	}
	if($dades['PEU_FITXA']==''){
		$dades['PEU_FITXA'] = '<p>
					<strong>Fundació IMIM</strong><br />
					IMIM-Hospital del Mar<br />
					Doctor Aiguader, 88 - 08003 Barcelona<br />
					Tel.: 93 316 04 00 - Fax: 93 316 04 10<br />
					<a href="http://www.imim.es" target="_blank">Web IMIM</a>
				</p>';
	}
	if($dades['QUESTIONARIS']==''){
		$dades['QUESTIONARIS'] = '<p><strong>Identificados:</strong> 530</p>
					<p><strong>Disponibles:</strong> 200</p>
					<p><strong>Evaluados:</strong> 30</p>';
	}










?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ca">
<head>
	<title>Houdini v2.0</title>
	<link rel="STYLESHEET" type="text/css" href="../../../../../public/media/css/estils.css">
	<link rel="STYLESHEET" type="text/css" href="../../../../css/estils.css">
	<link rel="STYLESHEET" type="text/css" href="../../media/css/estils-newsletter.css" />
	<!--[if IE]>
	<link rel="stylesheet" type="text/css" media="all" href="../../../../../public/media/css/estils-newsletter-ie.css" />
	<![endif]-->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<script language="javascript">
		//Testeig camps de text
		function dades1()
		{
			if (checkit_ins(document.env_dades)==0)
				return;

			document.forms.env_dades.ACCIO.value='1';
			document.env_dades.submit();
		}

		function dades2()
		{
			if (checkit_ins(document.env_dades)==0)
				return;

			document.forms.env_dades.ACCIO.value='2';
			document.env_dades.submit();
		}

		function checkit_ins(form){
		    	if(form.IDNL.value == ""){
				alert("<?php echo t("numobligatori"); ?>");
                		return (0);
			}else{
                		return (1);
        		}
		}

		//Obrir finestra (fill)... quan es tanqui,  actualitza la pagina (mare)...
      		function afegir_noticia(ID,SKIN,IdCam){
			url= 'afegir_noticia.php?ID='+ID+'&MODEL_NL='+SKIN+'&IdCam='+IdCam;
			result = window.open(url,"novafinestra","left=0,top=100,screenX=0,screenY=100,status=no,toolbar=no,width=460,height=600,directory=no,resize=no,scrollbars=yes");
		}
     	 	function afegir_noticia_propia(ID,SKIN,IdCam){
			url= 'afegir_noticia_propia.php?ID='+ID+'&MODEL_NL='+SKIN+'&IdCam='+IdCam;
			result = window.open(url,"novafinestra","left=0,top=100,screenX=0,screenY=100,status=no,toolbar=no,width=460,height=600,directory=no,resize=no,scrollbars=yes");
		}
		function afegir_noticia2(ID,SKIN,IdCam){
			url= 'afegir_noticia2.php?ID='+ID+'&MODEL_NL='+SKIN+'&IdCam='+IdCam;
			result = window.open(url,"novafinestra","left=0,top=100,screenX=0,screenY=100,status=no,toolbar=no,width=460,height=600,directory=no,resize=no,scrollbars=yes");
		}
		function afegir_noticia3(ID,SKIN,IdCam){
			url= 'afegir_noticia3.php?ID='+ID+'&MODEL_NL='+SKIN+'&IdCam='+IdCam;
			result = window.open(url,"novafinestra","left=0,top=100,screenX=0,screenY=100,status=no,toolbar=no,width=460,height=600,directory=no,resize=no,scrollbars=yes");
		}
		function afegir_banner(ID,IdCam){
			url= 'afegir_banner.php?ID='+ID+'&IdCam='+IdCam;
			result = window.open(url,"novafinestra","left=0,top=100,screenX=0,screenY=100,status=no,toolbar=no,width=460,height=600,directory=no,resize=no,scrollbars=yes");
		}

		//popup per veure el newsletter
		function veure(id){
			url= '../../../../../public/view.php?ID='+id;
			result = window.open(url,"flotant","left=01,top=20,screenX=01,screenY=20,status=no,toolbar=no,width=750,height=600,directory=no,resize=no,scrollbars=yes");
		}
	</script>
	<?php
		//editor FCK
//		include("editor.inc");
		echo editor_head();
	?>
</head>

<?php
	///////////////////////tractament noticies...

	if($noticia_newsletter){

		//busco la noticia
		$result = mysql_query("SELECT * FROM NOTICIES_NEWSLETTER WHERE ID=".$noticia_newsletter);
		$row = mysql_fetch_array($result);

		//categoria
		$seccio = $id_cat;

		//busco l'ultima noticia d'aquesta secci� per l'ordre
		$result2 = mysql_query("SELECT MAX(ORDRE) FROM TE_NNL_NL WHERE ID_NL=".$ID);
		$row2 = mysql_fetch_array($result2);
		$ordre = $row2[0]+1;

		//busco si hi ha una entrada a la mateixa secci� pel tema de columnes o files...
		$result222 = mysql_query("SELECT * FROM TE_NNL_NL WHERE ID_NL=".$ID." AND SECCIO=".$seccio);

		$num_rows222 = mysql_num_rows($result222);
		if($num_rows222 != 0){

			$row222 = mysql_fetch_array($result222);
			$cof_ent = $row222['COF'];

			$result3 = mysql_query("INSERT INTO TE_NNL_NL (ID_NNL,ID_NL,ORDRE,SECCIO,COF) VALUES($noticia_newsletter,$ID,$ordre,$seccio,'$cof_ent')");
		}else{
			$result3 = mysql_query("INSERT INTO TE_NNL_NL (ID_NNL,ID_NL,ORDRE,SECCIO,COF) VALUES($noticia_newsletter,$ID,$ordre,$seccio,'F')");
		}
	}

	if($opcio == "eliminar"){
		//busco i elimino la noticia de la taula d'enllaç
               $result = mysql_query("DELETE FROM TE_NNL_NL WHERE ID_NL=".$ID." AND ID_NNL=".$id_not);

               //busco la noticia
	       $result = mysql_query("SELECT * FROM NOTICIES_NEWSLETTER WHERE ID=".$id_not);
	       $row = mysql_fetch_array($result);
               //elimino notícia de l'editora, si s'ha agafat de noticies houdini
               if(!empty($row['LLOC'])){
                    $result = mysql_query("DELETE FROM NOTICIES_NEWSLETTER WHERE ID=".$id_not);
               }
	}

	if($opcio == "moure_amunt"){
		//busco la noticia
		$result = mysql_query("SELECT * FROM TE_NNL_NL WHERE ID_NL=".$ID." AND ID_NNL=".$id_not);
		$row = mysql_fetch_array($result);
		$seccio = $row['SECCIO'];

		//busco la proxima noticia d'aquesta secci�
		$result2 = mysql_query("SELECT * FROM TE_NNL_NL WHERE SECCIO=".$seccio." AND ID_NL=".$ID." AND ORDRE < ".$ordre." ORDER BY ORDRE DESC");
		$row2 = mysql_fetch_array($result2);
		$ordre2 = $row2['ORDRE'];
		$ID2 = $row2['ID_NL'];
		$id_not2 = $row2['ID_NNL'];

		//intercanvio els ordres de les noticies
		$modifica1 = mysql_query("UPDATE TE_NNL_NL SET ORDRE=".$ordre2." WHERE ID_NL=".$ID." AND ID_NNL=".$id_not);
		$modifica2 = mysql_query("UPDATE TE_NNL_NL SET ORDRE=".$ordre." WHERE ID_NL=".$ID2." AND ID_NNL=".$id_not2);
	}

	if($opcio == "fila"){
		$fila = mysql_query("UPDATE TE_NNL_NL SET COF='F' WHERE ID_NL=".$ID." AND SECCIO=".$seccio);
	}
	if($opcio == "columna"){
		$columna = mysql_query("UPDATE TE_NNL_NL SET COF='C' WHERE ID_NL=".$ID." AND SECCIO=".$seccio);
	}

	///////////////////////tractament banners...

	if($banner_newsletter){

		//$result = mysql_query("SELECT * FROM BANNERS_NEWSLETTER WHERE ID=".$banner_newsletter);
		//$row = mysql_fetch_array($result);

		$result2 = mysql_query("SELECT MAX(ORDRE) FROM TE_BAN_NL WHERE ID_NL=".$ID);
		$row2 = mysql_fetch_array($result2);
		$ordre = $row2[0]+1;

		$result3 = mysql_query("INSERT INTO TE_BAN_NL (ID_BAN,ID_NL,ORDRE) VALUES($banner_newsletter,$ID,$ordre)");
	}

	if($opcio == "eliminar2"){
		$result = mysql_query("DELETE FROM TE_BAN_NL WHERE ID_NL=".$ID." AND ID_BAN=".$id_ban);
	}

	if($opcio == "moure_amunt2"){

		$result2 = mysql_query("SELECT * FROM TE_BAN_NL WHERE ID_NL=".$ID." AND ORDRE < ".$ordre." ORDER BY ORDRE DESC");
		$row2 = mysql_fetch_array($result2);
		$ordre2 = $row2['ORDRE'];
		$ID2 = $row2['ID_NL'];
		$id_ban2 = $row2['ID_BAN'];

		$modifica1 = mysql_query("UPDATE TE_BAN_NL SET ORDRE=".$ordre2." WHERE ID_NL=".$ID." AND ID_BAN=".$id_ban);
		$modifica2 = mysql_query("UPDATE TE_BAN_NL SET ORDRE=".$ordre." WHERE ID_NL=".$ID2." AND ID_BAN=".$id_ban2);
	}

//veure el newsletter en un popup mentres s'esta editant...
if($ACCIO == '2'){
?>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="javascript:veure(<?php echo $ID; ?>)">
<?php
}else{
?>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<?php
}

include ('houdini_cap.inc');
?>

<form action="update.php" method="POST" name="env_dades" enctype="multipart/form-data">
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;">
	<tr>
		<td colspan="2" style="padding-left:10px;padding-top:10px;padding-right:10px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td class="text10"><img src="../../../../../public/media/comu/admin/icon_plana.gif" alt="" width="33" height="18" border="0" align="absmiddle"><?php echo t("soua"); ?>: <font class="blau10b"><?php echo t("newsletters"); ?></font></td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td colspan="2">
			<div id="contenidor" class="crear pas2">
				<div id="cap">
					<h1>Houdini butlletins</h1>
					<ul id="principal">
						<li><a href="../../campanyes/index.php" class="crear">Gestionar butlletins</a></li>
						<li><a href="../index.php" class="butlletins">Gestionar contingut</a></li>
						<li><a href="../../llistes/index.php" class="llistes">Llistes de subscriptors</a></li>
						<li><a href="../../informes/index.php" class="informes">Informes</a></li>
					</ul>
				</div>
				<div id="contingut">
					<ul id="submenu">
						<li><a href="../../campanyes/index.php">Butlletins pendents d'enviar</a></li>
						<li>Crear nou Butlletí</li>
						<li><a href="../../campanyes/index_enviades.php">Veure els butlletins enviats</a></li>
					</ul>
					<ol id="passos">
						<li class="pas1"><span>Pas 1</span> Definir Newsletter</li>
						<li class="pas2 actiu"><span>Pas 2</span> Contingut</li>
						<li class="pas3"><span>Pas 3</span> Destinataris</li>
						<li class="pas4"><span>Pas 4</span> Testeig final</li>
					</ol>
				</div>
			</div>
				<h2 style="margin-left:40px;"><span>Segon pas.</span> Crear butlletí</h2>
		</td>
	</tr>

	<tr>
		<td colspan="2" style="padding:10px 40px 10px 40px;" valign="top" >

			<table style="padding:0 0 10px 0;border-bottom:solid #0E449A 1px;" cellpadding="0" cellspacing="0" border="0" width="100%">
			<TR>
				<TD align="left">
					<?php if($dades['SKIN'] == 0) { ?>
					<?php echo t("numero"); ?>: <INPUT TYPE="text" NAME="IDNL" SIZE="4" MAXLENGTH="4" value="<?php echo $dades['IDNL']; ?>" />
					<?php } ?>
					<input type="hidden" name="IDNL" value="<?php echo $dades['IDNL']; ?>" />
				</TD>
			    	<TD align="right">
					<INPUT TYPE="Button" NAME="ACCIO2" VALUE="<?php echo t("veurenewsletter"); ?>" onclick="javascript:dades2();">
			    	</TD>
			</tr>
			</table>

			<table style="margin:0 0 0 0;" width="100%" cellpadding="5" cellspacing="0" border="0">

			<!-- NOTICIES COMUNES -->
			<TR>
			   <TD valign=top width="15%" style="padding:10px 0;border-bottom:solid #0E449A 1px;">
                    			<a href="javascript:afegir_noticia_propia('<?php echo $ID; ?>','<?php echo $dades['SKIN']; ?>','<?php echo $id_campanya; ?>')" class=text10b>>> Afegir <?php echo t("afegirnoticia"); ?></a>
			   </TD>
			   <TD valign=top style="padding:15px 0;border-bottom:solid #0E449A 1px;">

					<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<?php
						//consulta amb categories
						$query2 = mysql_query("SELECT TE_NNL_NL.* FROM TE_NNL_NL,NOTICIES_NEWSLETTER WHERE (TE_NNL_NL.ID_NNL=NOTICIES_NEWSLETTER.ID) AND TE_NNL_NL.ID_NL=".$ID." AND TE_NNL_NL.SECCIO != '0' ORDER BY TE_NNL_NL.SECCIO,TE_NNL_NL.ORDRE");

						while($dades2 = mysql_fetch_array($query2)){

							$seccio = $dades2['SECCIO'];

							$ordre = $dades2['ORDRE'];

							$valor_cof = $dades2['COF'];

							//////////////// maquetacio noticia ////////////////
							$result = mysql_query("SELECT * FROM NOTICIES_NEWSLETTER WHERE ID=".$dades2['ID_NNL']);
							$row = mysql_fetch_array($result);

							$titol = stripslashes($row['TITOL']);
							$resum = nl2br($row['RESUM']);
							$id_not = $row['ID'];
							$subtitol = stripslashes($row['SUBTITOL']);
							$lloc = stripslashes($row['LLOC']);
							$data_lloc = stripslashes($row['DATA_LLOC']);

							if($row['LLOC'] == '')
							{
								if ($row['IMATGE1'] != "") { $img1 = "<img src=\"../../../../../public/media/upload/noticies_newsletter/imgs/p$row[IMATGE1]\" border=\"0\" style=\"float:left;margin:0 5 5 0;\">"; } else { $img1 = ""; }
							}
							else{
								if ($row['IMATGE1'] != "") { $img1 = "<img src=\"../../../../../media/upload/gif/$row[IMATGE1]\" width=\"62\" border=\"0\" style=\"float:left;margin:0 5 5 0;\">"; } else { $img1 = ""; }
							}

							//if ($row['MESINFO'] == '1') {
							if ($row['DESCRIPCIO'] != '') {
								$mesinfo = "<img src=\"../../../../../public/media/comu/admin/icon_mesinfo.gif\" width=13 height=11 border=0><font class=\"blautitol10\">".t("mesinfo")."</font>";
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
							}else{
								$subtitol = "";
							}

							//info del lloc
							if($data_lloc != ""){
								$info_lloc = "<br><br><font class=\"gris10b\">$data_lloc</font>";
							}else{
								$info_lloc = "";
							}
							///////////////////////////////////////////////////


							$contador[$seccio] = $contador[$seccio] + 1;

							if($contador[$seccio] == 1){

								if($seccio != 1){
									//amb categories
									$queryX = mysql_query("select * from CATEGORIES_NOTICIES where ID=".$seccio);
									$filaX = mysql_fetch_array($queryX);
									$nom_seccio = stripslashes($filaX['TITOL']);
									$color_seccio = $filaX['COLOR'];

									$res[$seccio] .= "<tr><td style=\"padding:6px;\" class=\"blautitol12b\" bgcolor=\"#ccc\"> $nom_seccio</td></tr>";
								}else{
									//sense categories
									$res[$seccio] .= "";
								}

								//VEURE NOTICIES AMB FILES O COLUMNES
								switch($valor_cof){
									case 'F':	$valor_cof2 = "<b>".t("files")."</b> | <a href=\"edita.php?ID=$ID&opcio=columna&seccio=$seccio&IdCam=$id_campanya\" class=text10> ".t("columnes")."</a>";break;
									case 'C':	$valor_cof2 = "<b>".t("columnes")."</b> | <a href=\"edita.php?ID=$ID&opcio=fila&seccio=$seccio&IdCam=$id_campanya\" class=text10> ".t("files")."</a>";break;
									default :	$valor_cof2 = "<b>".t("files")."</b> | <a href=\"edita.php?ID=$ID&opcio=columna&seccio=$seccio&IdCam=$id_campanya\" class=text10> ".t("columnes")."</a>";break;
								}

								$cof = "<tr>
											<td style=\"padding:5px;border-bottom:solid #CCCCCC 2px;\">
												".t("mostrarnoticiesamb").": $valor_cof2
											</td>
										</tr>";
								$res[$seccio] .= $cof;
								//fi VEURE NOTICIES AMB FILES O COLUMNES

								$maquetacio_noticia = "<tr>
															<td valign=\"top\" style=\"padding:5px;\">
																$img1 <font class=\"klandergris9b\">&#149;</font> <font class=\"blautitol11b\">$titol</font>$subtitol$info_lloc<br><br>$resum<br>
																<br>
																$mesinfo $mostralink1 $mostralink2
															</td>
														</tr>
														<tr><td align=\"right\" style=\"padding-top:5px;padding-bottom:5px;border-bottom:solid #CCCCCC 1px;\"><a href=\"edita.php?ID=$ID&opcio=eliminar&id_not=$id_not&IdCam=$id_campanya\" class=text10><img src=\"../../../../../public/media/comu/admin/bt_eliminar.gif\" width=19 height=18 border=0 align=absmiddle> ".t("eliminar")."</a></td></tr>";
							}else{

								$maquetacio_noticia = "<tr>
															<td valign=\"top\" style=\"padding:5px;\">
																$img1 <font class=\"klandergris9b\">&#149;</font> <font class=\"blautitol11b\">$titol</font>$subtitol$info_lloc<br><br>$resum<br>
																<br>
																$mesinfo $mostralink1 $mostralink2
															</td>
														</tr>
														<tr><td align=\"right\" style=\"padding-top:5px;padding-bottom:5px;border-bottom:solid #CCCCCC 1px;\"><a href=\"edita.php?ID=$ID&opcio=moure_amunt&id_not=$id_not&ordre=$ordre&IdCam=$id_campanya\" class=text10><img src=\"../../../../../public/media/comu/admin/mou_amunt.gif\" width=23 height=12 border=0 align=\"absmiddle\"> ".t("pujar")."</a> <a href=\"edita.php?ID=$ID&opcio=eliminar&id_not=$id_not&IdCam=$id_campanya\" class=text10><img src=\"../../../../../public/media/comu/admin/bt_eliminar.gif\" width=19 height=18 border=0 align=absmiddle> ".t("eliminar")."</a></td></tr>";
							}

							$res[$seccio] .= $maquetacio_noticia;

						}// fi while

						//mostra resultat
						$queryZ = mysql_query("select * from CATEGORIES_NOTICIES order by ORDRECAT ASC");
						while($filaZ = mysql_fetch_array($queryZ)){
							$seccio = $filaZ['ID'];
							echo $res[$seccio];
						}

					?>
					</table>

				</td>
			</tr>

<?php if($dades['SKIN'] == 0) { ?>
	
			<!-- BANNERS -->
			<TR>
			   <TD valign="top" width="15%" style="padding:10px 0;">
					<a href="javascript:afegir_banner('<?php echo $ID; ?>','<?php echo $id_campanya; ?>')" class=text10b>>> Afegir <?php echo t("afegirbanner"); ?></a>
			   </TD>
			   <TD valign="top" style="padding:15px 0;">

					<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<?php
						//mostrar contingut

						$cont2 = 0;

						$query222 = mysql_query("SELECT TE_BAN_NL.* FROM TE_BAN_NL,BANNERS_NEWSLETTER WHERE (TE_BAN_NL.ID_BAN=BANNERS_NEWSLETTER.ID) AND TE_BAN_NL.ID_NL=".$ID." ORDER BY TE_BAN_NL.ORDRE");
						while($dades222 = mysql_fetch_array($query222)){

							$ordre222 = $dades222['ORDRE'];


							//////////////// maquetacio noticia ////////////////
							$result222 = mysql_query("SELECT * FROM BANNERS_NEWSLETTER WHERE ID=".$dades222['ID_BAN']);
							$row222 = mysql_fetch_array($result222);

							$link = stripslashes($row222['LINK']);
							$id_ban = $row222['ID'];

							$imatge = $row222['IMATGE'];
							if ($row222['IMATGE'] != "") { $img = "<img src=\"../../../../../public/media/upload/banners_newsletter/$imatge\" border=\"0\">"; } else { $img = ""; }
							///////////////////////////////////////////////////


							$cont2 = $cont2 + 1;

							if($cont2 == 1){

								$maquetacio_noticia222 = "<tr>
															<td valign=\"top\" style=\"padding:5px;\">
																<a href=\"$link\" target=\"_blank\">$img</a>
															</td>
														</tr>
														<tr><td align=\"right\" style=\"padding-top:5px;padding-bottom:5px;border-bottom:solid #CCCCCC 1px;\"><a href=\"edita.php?ID=$ID&opcio=eliminar2&id_ban=$id_ban&IdCam=$id_campanya\" class=text10><img src=\"../../../../../public/media/comu/admin/bt_eliminar.gif\" width=19 height=18 border=0 align=absmiddle> ".t("eliminar")."</a></td></tr>";
							}else{

								$maquetacio_noticia222 = "<tr>
															<td valign=\"top\" style=\"padding:5px;\">
																<a href=\"$link\" target=\"_blank\">$img</a>
															</td>
														</tr>
														<tr><td align=\"right\" style=\"padding-top:5px;padding-bottom:5px;border-bottom:solid #CCCCCC 1px;\"><a href=\"edita.php?ID=$ID&opcio=moure_amunt2&id_ban=$id_ban&ordre=$ordre222&IdCam=$id_campanya\" class=text10><img src=\"../../../../../public/media/comu/admin/mou_amunt.gif\" width=23 height=12 border=0 align=\"absmiddle\"> ".t("pujar")."</a> <a href=\"edita.php?ID=$ID&opcio=eliminar2&id_ban=$id_ban&IdCam=$id_campanya\" class=text10><img src=\"../../../../../public/media/comu/admin/bt_eliminar.gif\" width=19 height=18 border=0 align=absmiddle> ".t("eliminar")."</a></td></tr>";
							}

							$res222 .= $maquetacio_noticia222;

						}// fi while

						//mostra resultat
						echo "&nbsp;".$res222;
					?>
					</table>

				</td>
			</tr>
<?php } ?>
			<TR>
				<TD colspan="2" >
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr>
						<td style="border-top:solid #0E449A 1px;vertical-align:top;padding:10px 0;">
<?php if($dades['SKIN'] == 0) { ?>
							Mostrar sumari: <select name="VEURESUMARI">
							<?php
								if($dades['VEURESUMARI'] == 0){
							?>
								<option value="1" />Si</option>
								<option value="0" selected="selected" />No</option>
							<?php
								}else{
							?>
								<option value="1" selected="selected"/>Si</option>
								<option value="0" />No</option>
							<?php
								}
							?>
							</select>
							<br /><br />
							Contacte:
							<br />
							<?php echo editor_entry('CONTACTE', stripslashes($dades['CONTACTE']), 'AntavianaNL'); ?>
							<br /><br />
							Staff:
							<br />
							<?php echo editor_entry('STAFF', stripslashes($dades['STAFF']), 'AntavianaNL'); ?>
							<br /><br />
							Qüestionaris:
							<br />
							<?php echo editor_entry('QUESTIONARIS', stripslashes($dades['QUESTIONARIS']), 'AntavianaNL'); ?>
							<br /><br />
							Peu (notícia completa):
							<br />
							<?php echo editor_entry('PEU_FITXA', stripslashes($dades['PEU_FITXA']), 'AntavianaNL'); ?>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<TR>
	<TD style="padding:10px 0;" class=text valign=top width="20%">&nbsp;</TD>
	<TD style="padding:10px 0;" valign="top">
		<?php
		$imatge_anunci = $dades['IMATGE_ANUNCI'];
		if ($dades['IMATGE_ANUNCI'] != ""){
			echo  "<img src=\"".$CONFIG_URLUPLOADAN."".$imatge_anunci."\" border=\"0\"  >
					<br>
					<a href=\"eliminar_img.php?ID=".$ID."&IdCam=".$dades['IdCam']."\">
					<img src=\"../../../../comu/ico_paperera.gif\" width=\"11\" height=\"13\" border=\"0\" align=\"absmiddle\" style=\"margin-right:5px;\">Eliminar
					</a>";
		}else{
			echo 'No hi ha cap imatge carregada al peu de la notícia completa.';
		}
		?>
	</TD>
</TR>
<TR>
	<TD style="padding:10px 0;" class=text valign=top width="20%">&nbsp;</TD>
	<TD style="padding:10px 0;" valign="top">
		<input type="file" name="img[]" size="40" />
		<br />
		(Formats: <b>.jpg</b> <b>.gif</b> | Pes màxim: <b>500K</b> | Mida màxima horitzontal: <b>300px</b>)
	</TD>
</TR>
<TR>
	<TD style="padding:10px 0;" class=text valign=top width="20%">&nbsp;</TD>
	<TD style="padding:10px 0;" valign="top">
		Link imatge del peu de la notícia completa:
		<br />
		<input type="text" name="LINK_ANUNCI" SIZE="50" MAXLENGTH="150" value="<?php echo $dades['LINK_ANUNCI']; ?>" />
	</TD>
</TR>
</table>

<?php } ?>
						</td>
						<td style="border-top:solid #0E449A 1px;vertical-align:top;padding:15px 15px 15px 30px;">
							<?php echo t("model"); ?>:
							<br />
							<img src="../../../../../public/media/models/model<?php echo $dades['SKIN']; ?>.jpg" width="300" alt="" border="0">
							<!--<br /><br />
							Capçalera:
							<br />
							<img src="../../../../../public/media/upload/caps/capsal_newsletter<?php echo $dades['CAP']; ?>.jpg" width="300" alt="" border="0">-->
						</td>
					</tr>
					</table>
				</td>
			</TR>

			<TR>
				<TD colspan="2" style="padding:15px 5px 5px 5px;border-top:solid #0E449A 1px;">
					<div id="botons">
					<a href="../../campanyes/pas2b.php?id=<?php echo $id_campanya; ?>" class="boto anterior">Anterior</a>
					<input type="button"  NAME="ACCIO1" value="<?php echo t("continuar"); ?>" onclick="javascript:dades1();" class="boto continuar" />
					</div>
				</td>
			</TR>
			</table>

		</td>
		<input type="hidden" name="CATEGORY1" value="1" />
		<input type="hidden" name="COD" value="C" />
		<input type="hidden" name="STATUS" value="1">
		<input type="hidden" name="ID" value="<?php echo $ID; ?>">
		<input type="hidden" name="IdCam" value="<?php echo $id_campanya; ?>">
		<input type="hidden" name="ACCIO">
		<input type="hidden" name="USUARI_HOUDINI" value="<?php echo $_SESSION['access']['login']; ?>">
	</tr>
</table>
</form>

<?php include ('houdini_peu.inc'); ?>

</body>
</html>
