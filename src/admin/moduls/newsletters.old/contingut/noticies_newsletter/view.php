<?php
include("../newsletters/config.php");

$result = mysql_query("SELECT * FROM NOTICIES_NEWSLETTER WHERE ID=".$_GET['ID']);
$row = mysql_fetch_array($result);

/*
foreach ($ITEMS['CARDS_SKIN']['ESP'] as $index => $valor)
{
	$tall = explode("_", $valor);
	$id_model = $tall[0];
	$nom_model = $tall[1];

	if($id_model == $row['MODEL'])
	{
		$model .= "<option value=".$id_model." selected=\"selected\">".$nom_model."</option>";
	}
	else{
		$model .= "<option value=".$id_model.">".$nom_model."</option>";
	}
}
*/
foreach ($ITEMS['CARDS_SKIN']['ESP'] as $index => $valor){
	
	$tall[$index] = explode("_", $valor);
	$id_model[$index] = $tall[$index][0];
	$nom_model[$index] = $tall[$index][1];
	
	$final=$index;
	$final=$final+1;
}



   include("config.php");


   accessCheckLevel(2, $CONFIG_NOMCARPETA2.'/admin/');
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



// --------------------
// PARAMETERS FILTERING
// --------------------

   if (empty($LANG))  { $LANG=$DEFAULT_LANG; }
   if (empty($CLASS)) { $CLASS=$DEFAULT_CLASS; }
   if (empty($SKIN))  { $SKIN=0; }

   if (empty($ID)) { echo "<B>".t("error1").".</B><br>\n"; exit; }

// ------------------
// CARDS INSTANTATION
// ------------------

   $dbCards = new dbCards($CARDS_TABLE);
   if (!$dbCards->Ok) { echo "<B>".t("error2").".</B><br>\n"; exit; }

// -----------------
// DATA READING
// -----------------

   // Llegim les dades
   $card = $dbCards->readCard($ID);

   if ($SKIN==0) { $SKIN=$card['SKIN']; }

// -----------------
// TEMPLATE SCANNING
// -----------------

   // Create and define Template
   $Tpl = new awTemplate();
   $Tpl->scanFile("view$SKIN.tpl");

   // Si hi ha cap problema -> Error
   if (!$Tpl->Ok) { echo "<B>".t("error3").".</B><br>\n"; exit; }


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



	//creem les imatges
	$imatge1 = $data['IMATGE1'];
	if(($SKIN == '1') OR ($SKIN == '2'))
	{
		if($data['LLOC'] == '')
		{
			if ($data['IMATGE1'] != ""){
				$data['IMATGE1'] = "<img src=\"". $CONFIG_URLUPLOADIM."p$imatge1\" border=\"0\" style=\"float:left;margin:0 5 5 0;\" >";
			}
		}
		else{
			if ($data['IMATGE1'] != ""){
				$data['IMATGE1'] = "<img src=\"". $CONFIG_NOMCARPETA2."/media/upload/gif/".$imatge1."\"  width=\"62\" border=\"0\" style=\"float:left;margin:0 5 5 0;\" >";
			}
		}
	}
	else
	{
		if ($data['IMATGE1'] != ""){
			$data['IMATGE1'] = "<img src=\"". $CONFIG_URLUPLOADIM."p$imatge1\" border=\"0\"  ><br><a href=\"eliminar_img.php?categoria=0&file=$imatge1&ID=$ID&camptaula=IMATGE1\"><img src=\"../../../../../public/media/comu/admin/ico_paperera.gif\" width=\"11\" height=\"13\" border=\"0\" align=\"absmiddle\" style=\"margin-right:5px;\">".t("eliminar")."</a>";
		}
	}

	$data['PIXELS_IMG'] = '<select name="IMATGE2">';

	switch ($data['IMATGE2']) {
		case 85:
			$data['PIXELS_IMG'] .= '<option value="85" selected="selected">85px</option>
						   			<option value="170">170px</option>
						   			<option value="380">380px</option>';
			break;
		case 170:
			$data['PIXELS_IMG'] .= '<option value="85">85px</option>
						   			<option value="170" selected="selected">170px</option>
						   			<option value="380">380px</option>';
			break;
		case 380:
			$data['PIXELS_IMG'] .= '<option value="85">85px</option>
						   			<option value="170">170px</option>
						   			<option value="380" selected="selected">380px</option>';
			break;
		default:
			$data['PIXELS_IMG'] .= '<option value="85" selected="selected">85px</option>
						   			<option value="170">170px</option>
						   			<option value="380">380px</option>';
			break;
	}


	$data['PIXELS_IMG'] .= '</select>';




	//creem adjunts
	$adjunt1 = $data['ADJUNT1'];
	if($SKIN == '1')
	{
		if($data['LLOC'] == '')
		{
			if ($data['ADJUNT1'] != ""){

				$nom_adjunt1 = $data['NOMAD1'];
				if ($nom_adjunt1 != ""){
					$data['ADJUNT1'] = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"". $CONFIG_URLUPLOADAD."$adjunt1\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".$nom_adjunt1."</a></td></tr>";
				}else{
					$data['ADJUNT1'] = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"". $CONFIG_URLUPLOADAD."$adjunt1\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".t("enllac")." 1</a></td></tr>";
				}

			}else{
				$data['ADJUNT1'] = "";
			}
		}
		else
		{
			if ($data['ADJUNT1'] != ""){

				$nom_adjunt1 = $data['NOMAD1'];
				if ($nom_adjunt1 != ""){
					$data['ADJUNT1'] = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"". $CONFIG_NOMCARPETA2."/media/upload/pdf/".$adjunt1."\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".$nom_adjunt1."</a></td></tr>";
				}else{
					$data['ADJUNT1'] = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"". $CONFIG_NOMCARPETA2."/media/upload/pdf/".$adjunt1."\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".t("enllac")." 1</a></td></tr>";
				}

			}else{
				$data['ADJUNT1'] = "";
			}
		}
	}
	else
	{
		if ($data['ADJUNT1'] != ""){
			$data['ADJUNT1'] = "<a href=\"". $CONFIG_URLUPLOADAD."$adjunt1\" target=\"_blank\" class=\"blautitol10\"><b>".t("veurearx")." 1</b></a><br><br><a href=\"eliminar_img.php?categoria=1&file=$adjunt1&ID=$ID&camptaula=ADJUNT1\"><img src=\"../../../../../public/media/comu/admin/ico_paperera.gif\" width=\"11\" height=\"13\"  border=\"0\" align=\"absmiddle\" style=\"margin-right:5px;\">".t("eliminar")."</a>";
		}
	}

	$adjunt2 = $data['ADJUNT2'];
	if($SKIN == '1'){
		if($data['LLOC'] == '')
		{
			if ($data['ADJUNT2'] != ""){

				$nom_adjunt2 = $data['NOMAD2'];
				if ($nom_adjunt2 != ""){
					$data['ADJUNT2'] = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"". $CONFIG_URLUPLOADAD."$adjunt2\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".$nom_adjunt2."</a></td></tr>";
				}else{
					$data['ADJUNT2'] = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"". $CONFIG_URLUPLOADAD."$adjunt2\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".t("enllac")." 2</a></td></tr>";
				}

			}else{
				$data['ADJUNT2'] = "";
			}
		}
		else{
			$data['ADJUNT2'] = "";
		}
	}else{
		if ($data['ADJUNT2'] != ""){
			$data['ADJUNT2'] = "<a href=\"". $CONFIG_URLUPLOADAD."$adjunt2\" target=\"_blank\" class=\"blautitol10\"><b>".t("veurearx")." 2</b></a><br><br><a href=\"eliminar_img.php?categoria=1&file=$adjunt2&ID=$ID&camptaula=ADJUNT2\"><img src=\"../../../../../public/media/comu/admin/ico_paperera.gif\" width=\"11\" height=\"13\"  border=\"0\" align=\"absmiddle\" style=\"margin-right:5px;\">".t("eliminar")."</a>";
		}
	}

	$adjunt3 = $data['ADJUNT3'];
	if($SKIN == '1'){
		if($data['LLOC'] == '')
		{
			if ($data['ADJUNT3'] != ""){

				$nom_adjunt3 = $data['NOMAD3'];
				if ($nom_adjunt3 != ""){
					$data['ADJUNT3'] = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"". $CONFIG_URLUPLOADAD."$adjunt3\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".$nom_adjunt3."</a></td></tr>";
				}else{
					$data['ADJUNT3'] = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"". $CONFIG_URLUPLOADAD."$adjunt3\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".t("enllac")." 3</a></td></tr>";
				}

			}else{
				$data['ADJUNT3'] = "";
			}
		}
		else{
			$data['ADJUNT3'] = "";
		}
	}else{
		if ($data['ADJUNT3'] != ""){
			$data['ADJUNT3'] = "<a href=\"". $CONFIG_URLUPLOADAD."$adjunt3\" target=\"_blank\" class=\"blautitol10\"><b>".t("veurearx")." 3</b></a><br><br><a href=\"eliminar_img.php?categoria=1&file=$adjunt3&ID=$ID&camptaula=ADJUNT3\"><img src=\"../../../../../public/media/comu/admin/ico_paperera.gif\" width=\"11\" height=\"13\"  border=\"0\" align=\"absmiddle\" style=\"margin-right:5px;\">".t("eliminar")."</a>";
		}
	}

	$adjunt4 = $data['ADJUNT4'];
	if($SKIN == '1'){
		if($data['LLOC'] == '')
		{
			if ($data['ADJUNT4'] != ""){

				$nom_adjunt4 = $data['NOMAD4'];
				if ($nom_adjunt4 != ""){
					$data['ADJUNT4'] = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"". $CONFIG_URLUPLOADAD."$adjunt4\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".$nom_adjunt4."</a></td></tr>";
				}else{
					$data['ADJUNT4'] = "<tr><td style=\"padding:10 5 5 25;\"><a href=\"". $CONFIG_URLUPLOADAD."$adjunt4\" target=\"_blank\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_clip_petit.gif\" border=0 align=\"absmiddle\">".t("enllac")." 4</a></td></tr>";
				}

			}else{
				$data['ADJUNT4'] = "";
			}
		}
		else{
			$data['ADJUNT4'] = "";
		}
	}else{
		if ($data['ADJUNT4'] != ""){
			$data['ADJUNT4'] = "<a href=\"". $CONFIG_URLUPLOADAD."$adjunt4\" target=\"_blank\" class=\"blautitol10\"><b>".t("veurearx")." 4</b></a><br><br><a href=\"eliminar_img.php?categoria=1&file=$adjunt4&ID=$ID&camptaula=ADJUNT4\"><img src=\"../../../../../public/media/comu/admin/ico_paperera.gif\" width=\"11\" height=\"13\"  border=\"0\" align=\"absmiddle\" style=\"margin-right:5px;\">".t("eliminar")."</a>";
		}
	}

	//ADJUNT 5 --> Aneu al document
	$adjunt5 = $data['ADJUNT5'];
	if($SKIN == '0'){
		if ($data['ADJUNT5'] != ""){
			$data['ADJUNT5'] = "<a href=\"". $CONFIG_URLUPLOADAD."$adjunt5\" target=\"_blank\" class=\"blautitol10\"><b>".t("veuredoc")."</b></a><br><br><a href=\"eliminar_img.php?categoria=1&file=$adjunt5&ID=$ID&camptaula=ADJUNT5\"><img src=\"../../../../../public/media/comu/admin/ico_paperera.gif\" width=\"11\" height=\"13\" border=\"0\" align=\"absmiddle\" style=\"margin-right:5px;\">".t("eliminar")."</a>";
		}
	}

	//MES INFO
	$data['MESINFO'] = "<input type=\"hidden\" name=\"MESINFO\" value=\"1\">";


	//cap�alera dels arxius adjunts + signatura...
	if($SKIN == '1'){
		if($data['LLOC'] == '')
		{
			if( ($data['ADJUNT1'] != "") OR ($data['ADJUNT2'] != "") OR ($data['ADJUNT3'] != "") OR ($data['ADJUNT4'] != "") ){
				$data['CAP_AD'] = "<tr><td style=\"padding:8px;border-bottom:solid #CCCCCC 1px;\" class=\"gris10b\"><img src=\"../../../../../public/media/comu/admin/icon_clip_gran.gif\" border=0 align=\"absmiddle\">".t("enllacosrelacionats")."</td></tr>";
			}
		}
		else{
			if($data['ADJUNT1'] != ""){
				$data['CAP_AD'] = "<tr><td style=\"padding:8px;border-bottom:solid #CCCCCC 1px;\" class=\"gris10b\"><img src=\"../../../../../public/media/comu/admin/icon_clip_gran.gif\" border=0 align=\"absmiddle\">".t("enllacosrelacionats")."</td></tr>";
			}
		}

		if( ($data['NOM'] != "") AND ($data['CARREC'] != "") ){
			$nom = $data['NOM'];
			$carrec = $data['CARREC'];
			$data['SIGNATURA'] = "<tr><td style=\"padding-top:8px;padding-bottom:8px;border-top:solid #CCCCCC 1px;\" class=\"text9\"><font class=\"blautitol9b\">$nom</font><br>$carrec</td></tr>";
		}

		$data['RESUM'] = nl2br($data['RESUM']);
	}

	//enlla�os mesinfo, ...
	if($SKIN == '2'){
		$data['RESUM'] = nl2br($data['RESUM']);

		//if($data['MESINFO'] == '1'){
		if($data['DESCRIPCIO'] != ''){
			$data['MESINFO'] = "<a href=\"../../contingut/noticies_newsletter/view.php?ID=$ID&SKIN=1\" class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_mesinfo.gif\" width=13 height=11 border=0>".t("mesinfo")."</a>";
		}else{
			$data['MESINFO'] = "";
		}

		//ADJUNT 5 --> Aneu al document
		if ($data['ADJUNT5']) {
			$adjunt5 = $data['ADJUNT5'];
			$data['MOSTRALINK1'] = "<a href=\"$CONFIG_URLUPLOADAD$adjunt5\" target=\"_blank\"><font class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_anar_doc.gif\" width=11 height=14 border=0> ".t("aneualdoc")."</a></font>";
		} else {
			$data['MOSTRALINK1'] = "";
		}

		if ($data['LINK2']) {
			$link2 = $data['LINK2'];
			$data['MOSTRALINK2'] = "<a href=\"$link2\" target=\"_blank\"><font class=\"blautitol10\"><img src=\"../../../../../public/media/comu/admin/icon_anar_doc.gif\" width=11 height=14 border=0> ".t("aneualweb")."</a></font>";
		} else {
			$data['MOSTRALINK2'] = "";
		}

	}

	if($SKIN != '0'){
		//subtitol
		if($data['SUBTITOL'] != ""){
			$subtitol = $data['SUBTITOL'];
			$data['SUBTITOL'] = "<br><font class=\"gris10b\">$subtitol</font>";
		}

		//info del lloc
		if($data['DATA_LLOC'] != ""){
			$data_lloc = $data['DATA_LLOC'];
			$data['INFO_LLOC'] = "<br><br><font class=\"gris10b\">$data_lloc</font>";
		}
	}


//	include("editor.inc");
	$data['FCK1'] = editor_head();
	$data['FCK2'] = editor_entry('DESCRIPCIO', $data['DESCRIPCIO'],'AntavianaNL');
	$data['FCK3'] = editor_entry('RESUM', $data['RESUM'],'AntavianaNL');


	//$data['MODEL'] = $model;
	for($index=0;$index<$final;$index++){
		if($id_model[$index] == $data['MODEL']) $data['NOM_MODEL'] = $nom_model[$index];
	}
	$data['MODEL'] = $data['MODEL'] + 1;


	$data['USUARI_HOUDINI'] = $_SESSION['access']['login'];


	if($data['MODEL'] == 1)
	{
		$data['MESCAMPS'] = '<TR> 
					<TD class=text valign=top width="20%">'.$messages['subtitol'].':</TD> 
					<TD valign=top width="80%"><INPUT TYPE="text" NAME="SUBTITOL" SIZE="60" MAXLENGTH="150" value="'.$data['SUBTITOL'].'"></TD> 
				</TR> 
				<TR> 
					<TD class=text valign=top width="20%">'.$messages['datalloc'].':</TD> 
					<TD valign=top width="80%"><INPUT TYPE="text" NAME="DATA_LLOC" SIZE="60" MAXLENGTH="150" value="'.$data['DATA_LLOC'].'"></TD> 
				</TR> ';
		
		include("camps.php");
	}
	else{
		$data['CAMPS'] = '';
		$data['MESCAMPS'] = '';
	}




   if($SKIN==0){
   	include ('houdini_cap.inc');
   }

   // OUTPUT ALL
   echo $Tpl->mergeBlock('ALL',$data);

   // OUTPUT BLOCS
   //echo $Tpl->mergeBlock('HEAD',$data);
   //if (isset($data['RECIPETITLE'])) { echo $Tpl->mergeBlock('RECIPE',$data); }
   // echo $Tpl->mergeBlock('FOOT',$data);

   if($SKIN==0){
   	include ('houdini_peu.inc');
   }
?>
