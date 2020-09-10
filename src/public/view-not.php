<?php
session_start();

include("config.php");

include_once("../admin/config/nl-html-public.inc");

//CONTROL DE CLICKS
//if (empty($_SERVER['HTTP_REFERER'])) {

	$_SESSION['id'] = session_id();

	$result_cookie = mysql_query("SELECT * FROM newsletter_clicsnoticies WHERE ID_NL=".$_GET['ID']." AND ID_NNL=".$_GET['idnot']);
	$num_cookie = mysql_num_rows($result_cookie);
	if($num_cookie != 0)
	{
		$exit = 0;
		while ($row_cookie = mysql_fetch_array($result_cookie))
		{
			if($_SESSION['id'] == $row_cookie['GALETA']) $exit = 1;
		}
		if($exit==0)
		{
			$result_links = mysql_query("SELECT * FROM newsletter_nltonoticies WHERE ID_NL=".$_GET['ID']." AND ID_NNL=".$_GET['idnot']);
			$row_links = mysql_fetch_array($result_links);
			$links = $row_links['LINKS']+1;

			$result_links2 = mysql_query("UPDATE newsletter_nltonoticies SET LINKS=".$links." WHERE ID_NL=".$_GET['ID']." AND ID_NNL=".$_GET['idnot']);

			$result_cookie2 = mysql_query("INSERT INTO newsletter_clicsnoticies (ID_NNL,ID_NL,GALETA) VALUES (".$_GET['idnot'].",".$_GET['ID'].",'".$_SESSION['id']."')");
		}
	}
	else {
		$result_links = mysql_query("SELECT * FROM newsletter_nltonoticies WHERE ID_NL=".$_GET['ID']." AND ID_NNL=".$_GET['idnot']);
		$row_links = mysql_fetch_array($result_links);
		$links = $row_links['LINKS']+1;

		$result_links2 = mysql_query("UPDATE newsletter_nltonoticies SET LINKS=".$links." WHERE ID_NL=".$_GET['ID']." AND ID_NNL=".$_GET['idnot']);

		$result_cookie2 = mysql_query("INSERT INTO newsletter_clicsnoticies (ID_NNL,ID_NL,GALETA) VALUES (".$_GET['idnot'].",".$_GET['ID'].",'".$_SESSION['id']."')");
	}
//}



if($_GET['ID']){
	$ID=$_GET['ID'];
}

if($_GET['idnot']){
	$idnot=$_GET['idnot'];
}



// --------------------
// PARAMETERS FILTERING
// --------------------

   if (empty($LANG))  { $LANG=$DEFAULT_LANG; }
   if (empty($CLASS)) { $CLASS=$DEFAULT_CLASS; }
   if (empty($SKIN))  { $SKIN=0; }

   if (empty($ID)) { echo "<B>".$messages["error1"].".</B><br>\n"; exit; }

// ------------------
// CARDS INSTANTATION
// ------------------

   $dbCards = new dbCards($CARDS_TABLE);
   if (!$dbCards->Ok) { echo "<B>".$messages["error2"].".</B><br>\n"; exit; }

// -----------------
// DATA READING
// -----------------

   // Llegim les dades
   $card = $dbCards->readCard($ID);

   if (empty($SKIN)) { $SKIN=0; }

// -----------------
// TEMPLATE SCANNING
// -----------------

   // Create and define Template
   $Tpl = new awTemplate();
   $Tpl->scanFile("view-not$SKIN.tpl");


   // Si hi ha cap problema -> Error
   if (!$Tpl->Ok) { echo "<B>".$messages["error3"].".</B><br>\n"; exit; }


// ------------------
// CONTENT MERGING
// ------------------

   unset($data);

   // GENERAL DATA =====================================================

   $data['LANG'] = $LANG;
   $data['LANG_X'] = ITEMS_GetValue( 'LANG', $LANG, $LANG );
   $data['SELECT_LANG'] = ITEMS_HTMLSelect( 'LANG', 'LANG', $DEFAULT_SKIN, $LANG);

   $data['CLASS'] = $CLASS;
   $data['CLASS_X'] = ITEMS_GetValue( 'CARDS_CLASS', $CLASS, $LANG );
   $data['SELECT_CLASS'] = ITEMS_HTMLSelect( 'CLASS', 'CARDS_CLASS', $DEFAULT_SKIN, $LANG);

   // CURRENT CARD DATA ================================================

       // Generem totes les dades de cada un dels camps
       foreach ($card as $name=>$value)
       {
          // Les dades en brut de tots els camps
          $data[$name] = strip_tags($value);

          // Filtrem nom�s els camps definits
          if (!isset($CARDS_FIELDS[$name])) { continue; }
          $type = $CARDS_FIELDS[$name][1];

          // Generem les ampliades dels tipus necesaris
               if ($type=='NUMBER') { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='DATE')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='FLAG')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='ITEM')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='CHAR')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='TEXT')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='LIST')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='FILE')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='IMAGE')  { $data = $dbCards->GenerateData($data, $name, $value); }
       }

	$ID = $data['ID'];


	//veure noticia del newsletter
	$sql = "SELECT * FROM newsletter_nltonoticies WHERE ID_NL=$ID AND ID_NNL='$idnot'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);

	switch ($row['SECCIO'])
	{
		case '-1':	$data['NOM_CATEGORIA'] = 'Premsa';break;
		case '0':	$data['NOM_CATEGORIA'] = 'Agenda';break;
		case '1':	$data['NOM_CATEGORIA'] = '&nbsp;';break;
		default:	//amb categoria
				$sql2 = "SELECT * FROM CATEGORIES_NOTICIES WHERE ID=".$row['SECCIO'];
				$resultresult = mysql_query($sql2);
				$rowrow = mysql_fetch_array($resultresult);

				$data['NOM_CATEGORIA'] = $rowrow['TITOL'];
				break;
	}


	$result2 = mysql_query("SELECT * FROM newsletter_noticies WHERE ID='$idnot'");
	$row2 = mysql_fetch_array($result2);

	$data['BR'] = '';

	//titol
	$data['TITOL_NOT'] = '<h3 style="margin:0; color: #8e003d; font-weight: normal;">'.$row2['TITOL'].'</h3>';



	//subtitol
	if($row2['SUBTITOL'] != ""){
		$subtitol = $row2['SUBTITOL'];
		$data['SUBTITOL_NOT'] = '<p style="margin:0; padding:10px 0 10px 0; font-size:.9em; border-bottom:dotted 1px #333"><strong>'.$subtitol.'</strong></p>';
		$data['BR'] = '<br />';
	}

	//data
	if($row2['DATA_LLOC'] != ""){
		$data_lloc = $row2['DATA_LLOC'];
		$data['INFO_LLOC_NOT'] = '<p style="margin:0 0 10px; font-size:.75em">'.$data_lloc.'</p>';
		$data['BR'] = '<br />';
	}

	//descripcio
	$data['DESCRIPCIO_NOT'] = $row2['DESCRIPCIO'];
	$data['DESCRIPCIO_NOT'] = ereg_replace('<p>', '<p style="font-size:.75em; line-height:1.5em">', $data['DESCRIPCIO_NOT']);

	//creem imatges
	$imatge1 = $row2['IMATGE1'];
	if ($row2['IMATGE1'] != "")
	{
		if($row2['IMATGE3'] != "") $textimg = $row2['IMATGE3'];
		else $textimg = $row2['TITOL'];

		$data['IMATGE_NOT1'] = '<a href="'.$CONFIG_URLUPLOADIM.$imatge1.'" rel="lightbox" title="'.$textimg.'"><img src="'.$CONFIG_URLBASE.'/media/upload/noticies_newsletter/imgs/p'.$imatge1.'" alt="Ampliar imatge" style="float: left;margin: 20px 20px 10px 0" border="0" /></a>';
	}


	//creem adjunts
	for ($i=1;$i<5;$i++) {

		$adjunt = $row2['ADJUNT'.$i];

		if ($row2['ADJUNT'.$i] != ""){

			$nom_adjunt = $row2['NOMAD'.$i];

			if ($nom_adjunt != ""){

				$data['ADJUNT_NOT'.$i] = '
				<tr>
					<td style="padding:5px 10px 10px 10px;background:#333">
						<table border="0" cellspacing="0" cellpadding="0" style="width:100%">
						<tr>
							<td style="padding:5px 5px 5px 10px;background:#fff">
								<a href="'.$CONFIG_URLUPLOADAD.$adjunt.'" target="_blank" style="font-size:.75em;text-decoration:none;"><img src="media/comu/images/kland-enllacos-relacionats.gif" border="0" style="vertical-align:middle;" /> '.$nom_adjunt.'</a>
							</td>
						</tr>
						</table>
					</td>
				</tr>
				';
			}
			else{
				$data['ADJUNT_NOT'.$i] = '
				<tr>
					<td style="padding:5px 10px 10px 10px;background:#333">
						<table border="0" cellspacing="0" cellpadding="0" style="width:100%">
						<tr>
							<td style="padding:5px 5px 5px 10px;background:#fff">
								<a href="'.$CONFIG_URLUPLOADAD.$adjunt.'" target="_blank" style="font-size:.75em;text-decoration:none;"><img src="media/comu/images/kland-enllacos-relacionats.gif" border="0" style="vertical-align:middle;" /> '.$messages["enllac"].' 1</a>
							</td>
						</tr>
						</table>
					</td>
				</tr>
				';
			}
		}else{
			$data['ADJUNT_NOT'.$i] = "";
		}
	}


	//signatura
	if( ($row2['NOM'] != "") AND ($row2['CARREC'] != "") ){
		$nom = $row2['NOM'];
		$carrec = $row2['CARREC'];
		$data['SIGNATURA_NOT'] = '<p style="padding-top:8px;padding-bottom:8px;border-top:solid #CCCCCC 1px;font-size:.75em;">
						<strong>'.$nom.'</strong>
						<br />
						<em>'.$carrec.'</em>
					</p>';
	}


	//capcalera fitxers adjunts + ADJUNTS
	if( ($row2['ADJUNT1'] != "") OR ($row2['ADJUNT2'] != "") OR ($row2['ADJUNT3'] != "") OR ($row2['ADJUNT4'] != "") )
	{
		$data['ADJUNTS'] = '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background:#333">
					<tr>
						<td style="padding:5px 8px 10px 10px;font-size:.9em;color:#fff;font-weight: bold;">
							'.$messages["enllacosrelacionats"].'
						</td>
					</tr>';

		$data['ADJUNTS'] .= $data['ADJUNT_NOT1'].$data['ADJUNT_NOT2'].$data['ADJUNT_NOT3'].$data['ADJUNT_NOT4'];

		$data['ADJUNTS'] .= '</table>';
	}






	//titoll de la newsletter
	$consulta_titol_nl = mysql_query("select * from newsletter_campanyes where IdCam=".$data['IdCam']);
	$resposta_titol_nl = mysql_fetch_array($consulta_titol_nl);
	$data['TITOL'] = $resposta_titol_nl['titol'];





	$data['HTML_CAP'] = capHTML($SKIN, $data['ID'], $data['TITOL'], $data['IDNL'], '', '', '', $data['CAP']);
	$data['HTML_PEU'] = peuHTML($SKIN, $data['ID'], '', '', $data['CAP']);





   // OUTPUT ALL
   echo $Tpl->mergeBlock('ALL',$data);
?>
