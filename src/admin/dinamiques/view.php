<?php

// ============================================================================
// ============================================================================
// CARDS ADMIN: VIEW.PHP
// - Shows a template (form or html) of a card record
// by Asterisc.web
// Version: beta 1.0
// Start: May 2002 - Last: May 2003
// ============================================================================
// ============================================================================

require ('../config_admin.inc');
accessGroupPermCheck('dinamic_edit');

include_once("dinamiques.php");
include_once('categories/funcions.inc');

   //COMPROVEM SI TE ACCES A AQUEST MODUL
   include("check_moduls.php");
   //FI COMPROVEM SI TE ACCES A AQUEST MODUL
$ITEMS['CARDS_CATEGORY2']['ESP'] =cat2items($DIN);
if (count($ITEMS['CARDS_CATEGORY2']['ESP']) == 0){
  $ITEMS['CARDS_CATEGORY2']['ESP'] =array('0_'.t("notcategoriesdefined"));
}

// --------------------
// PARAMETERS FILTERING
// --------------------

   if (empty($LANG))  { $LANG=$DEFAULT_LANG; }
   if (empty($ECLASS)) { $ECLASS=$DEFAULT_ECLASS; }

   if (empty($ID)) {
     htmlPageError(t("errordbcardscodi"));
   }

// ------------------
// CARDS INSTANTATION
// ------------------

   $dbCards = new dbCards($CARDS_TABLE);

   if (!$dbCards->Ok) {
     htmlPageBasicError(t("errordbcards"));
   }
// -----------------
// DATA READING
// -----------------

   // Llegim les dades
   $card = $dbCards->readCard($ID);
   if (empty($card)) {
     htmlPageBasicError(t("errordbcardscodinotfound"));
   }// no existeix l'id demanat
// -----------------
// TEMPLATE SCANNING
// -----------------

   // Si no ens la donen a l'url o config -> utilitzem la individual

   // Create and define Template
   $Tpl = new awTemplate();
   //comprovar si existeix el tpl si no agafem el base
   $filename="view".$tipuseditora.".tpl";
   if (file_exists($filename)) {
   		$Tpl->scanFile("view".$tipuseditora.".tpl");
   }else{
   		$Tpl->scanFile("view0.tpl");
   }

   // Si hi ha cap problema -> Error
   if (!$Tpl->Ok) {
     htmlPageBasicError(t("plantillanotrobada")." view".$tipuseditora.".tpl");
   }


// ------------------
// CONTENT MERGING
// ------------------

   unset($data);

   // GENERAL DATA =====================================================

   $data['LANG'] = $LANG;

   $data['ECLASS'] = $ECLASS;
   $data['ECLASS_X'] = ITEMS_GetValue( 'CARDS_ECLASS', $ECLASS, $LANG );
   $data['SELECT_ECLASS'] = ITEMS_HTMLSelect( 'ECLASS', 'CARDS_ECLASS', $DEFAULT_SKIN, $LANG);

   // CURRENT CARD DATA ================================================

       // Generem totes les dades de cada un dels camps
       foreach ($card as $name=>$value)
       {
          // Les dades en brut de tots els camps
          $data[$name] = strip_tags($value);

          // Filtrem només els camps definits
          if (!isset($CARDS_FIELDS[$name])) { continue; }
          $type = $CARDS_FIELDS[$name][1];

          // Generem les ampliades dels tipus necesaris
               if ($type=='NUMBER') { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='DATE')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='FLAG')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='ITEM')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='CHAR')   { $data = filtreQuote($dbCards->GenerateData($data, $name, $value)); }
          else if ($type=='TEXT')   { $data = filtreQuote($dbCards->GenerateData($data, $name, $value)); }
          else if ($type=='FILE')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='IMAGE')  { $data = $dbCards->GenerateData($data, $name, $value); }
       }

    $data['DESCRIPCIO'] = db_select_text($TAULA, 'DESCRIPCIO', 'ID = '.$data['ID']);
    $data['DESCRIPCIO2'] = db_select_text($TAULA, 'DESCRIPCIO2', 'ID = '.$data['ID']);
    $data['RESUM'] = db_select_text($TAULA, 'RESUM', 'ID = '.$data['ID']);


  for ($i = 1; $i <= 3; $i++) {
    //creem la imatge
	  $imatge=$data['IMATGE'.$i];
	  $data['NOMIMATGEEXIS'.$i]=$imatge;
	  if ($data['IMATGE'.$i] != ""){
		  $data['IMATGE'.$i]="<img src=\"".$CONFIG_URLUPLOADIM."/thumb-$imatge\" border=\"0\" style=\"zoom:50%;margin-bottom:5px;\" ><br><a href=\"eliminar_img.php?DIN=$DIN&file=$imatge&categoria=0&ID=$ID&PAGE=$pagina&camptaula=IMATGE$i\"><img src=\"../comu/ico_paperera.gif\" width=\"11\" height=\"13\" alt=\"Eliminar\" border=\"0\" align=\"absmiddle\" style=\"margin-right:5px;\">".t('delete')."</a>";
	  }
  }

  for ($i = 1; $i <= 3; $i++) {
	//creem adjunt
	$adjunt=$data['ADJUNT'.$i];
	$data['NOMADJUNTEXIS'.$i]=$adjunt;
	if ($data['ADJUNT'.$i] != ""){
		$data['ADJUNT'.$i]="<a href=\"".$CONFIG_URLUPLOADAD."/$adjunt\" target=\"_blank\" class=\"text10\"><b>".t("view")." ".t("file")."</b></a><br><a href=\"eliminar_img.php?DIN=$DIN&file=$adjunt&categoria=1&ID=$ID&PAGE=$pagina&camptaula=ADJUNT$i\"><img src=\"../comu/ico_paperera.gif\" width=\"11\" height=\"13\" alt=\"Eliminar\" border=\"0\" align=\"absmiddle\" style=\"margin-right:5px;\">".t('delete')."</a>";
	}
  }

	//creem modificacio
	$modificat=$data['MODIFICAT'];
	if ($data['MODIFICAT'] != '0000-00-00 00:00:00'){
		$dataexpl=split(" ",$data['MODIFICAT']);
		$dataexpl=split("-",$dataexpl[0]);
		$usuarimodi=$data['USUARIMODI'];
		$data['MODIFICAT']=t("staticpagemodify")." $dataexpl[2]-$dataexpl[1]-$dataexpl[0] ".t("for")." $usuarimodi";
	}else{
		$data['MODIFICAT']="";
	}
	if ($data['VISIBILITY'] == '2'){
		$data['ACTIVAR']="<input type=\"radio\" name=\"VISIBILITY\" value=\"2\" checked>".t("yes")." <input type=\"radio\" name=\"VISIBILITY\" value=\"1\">".t("no");
	}else{
		$data['ACTIVAR']="<input type=\"radio\" name=\"VISIBILITY\" value=\"2\">".t("yes")." <input type=\"radio\" name=\"VISIBILITY\" value=\"1\"  checked>".t("no");
	}


    $data['AVUI'] = date('Y-m-d H:i:s', time());
	$data['TAULA']=$TAULA;
	$data['DIN']=$DIN;
	$data['USUARI']=accessGetLogin();

	$numdecaracters=strlen($descripciocarpeta);
	if($numdecaracters<58){
		$data['DESCRIPCIOCARPETA']= $descripciocarpeta;
	}else{
		$descripciocarpeta = substr ($descripciocarpeta, 0, 55);
		$data['DESCRIPCIOCARPETA']= $descripciocarpeta."...";
	}
    $data['NOMCARPETA']= $nomcarpeta;


	$data['METAS'] = htmlMetas();

	$data['EDITOR_HEAD'] = editor_head($idiomaEditora);
    $data['EDITOR_RESUM'] = editor_entry('RESUM', $data['RESUM'],'Antavianabasic');
    $data['EDITOR_DESCRIPCIO'] = editor_entry('DESCRIPCIO', $data['DESCRIPCIO'],'Antaviana');
    $data['EDITOR_DESCRIPCIO2'] = editor_entry('DESCRIPCIO2', $data['DESCRIPCIO2'],'Antaviana');




	//CODI HTML CAPCELERA
    $data['CAPCELERA'] = htmlHeader();
    $data['CONFIG_URLADMIN'] = $CONFIG_URLADMIN;
	//CODI HTML PEU
   $data['PEU'] = htmlFoot();



    ///variables de text idioma
   $data['LANGETSA'] = t("youarein");
   $data['LANGTITOL'] = t("dinamicstitle");
   $data['LANGHOME'] = t("home");
   $data['LANGWAIT'] = t("wait");
   $data['LANGUPDATE'] = t("update");
   $data['LANGLOADING'] = t("loading");
   $data['LANGWEBMAP'] = t("viewmapweb");
   $data['LANGFORMTITLE'] = t("dinamicsformtitle");
   $data['LANGFORMSUBTITLE'] = t("dinamicsformsubtitle");
   $data['LANGFORMRESUM'] = t("dinamicsformresum");
   $data['LANGPATHFCK'] = $CONFIG_URLADMIN;
   $data['LANGFORMTEXT'] = t("dinamicsformtext");
   $data['LANGFORMDATE'] = t("date");
   $data['LANGFORMLINK'] = t("link");
   $data['LANGFORMURL'] = t("url");
   $data['LANGFORMTEXT'] = t("text");
   $data['LANGFORMNEWWINDOW'] = t("newwindow");
   $data['LANGFORMIMAGE'] = t("image");
   $data['LANGFORMFILE'] = t("file");
   $data['LANGFORMPUBLISH'] = t("publish");
   $data['LANGFORMSTART'] = t("start");
   $data['LANGFORMDATEFORMAT'] = t("dateformat");
   $data['LANGFORMEND'] = t("end");
   $data['LANGFORMACTIVATE'] = t("activate");
   $data['LANGFORMSELECTCATEGORY'] = t("dinamicsselectcategory");
   $data['LANGFORMCREATE'] = t("staticpagescreate");
   $data['LANGFOR'] = t("for");
   $data['LANGFORMAUTHOR'] = t("author");

	$data['PAGE'] = $pagina;

   // fi

   // OUTPUT ALL

   echo $Tpl->mergeBlock('ALL',$data);

   // OUTPUT BLOCS
   //echo $Tpl->mergeBlock('HEAD',$data);
   //if (isset($data['RECIPETITLE'])) { echo $Tpl->mergeBlock('RECIPE',$data); }
   // echo $Tpl->mergeBlock('FOOT',$data);


?>
