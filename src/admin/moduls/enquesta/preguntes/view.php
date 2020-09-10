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

require ('../../../config_admin.inc');
accessGroupPermCheck('poll');

require('enquesta_preg.php');

// --------------------
// PARAMETERS FILTERING
// --------------------

   if (empty($LANG))  { $LANG=$DEFAULT_LANG; }
   if (empty($ECLASS)) { $ECLASS=$DEFAULT_ECLASS; }
   if (!isset($SKIN))  { $SKIN=$DEFAULT_SKIN; }

   if (empty($ID)) { echo "<B>Error: No se ha recibido el codigo de card.</B><br>\n"; exit; }

// ------------------
// CARDS INSTANTATION
// ------------------

   $dbCards = new dbCards($CARDS_TABLE);
   if (!$dbCards->Ok) { echo "<B>Error: No se ha podido crear dbCards.</B><br>\n"; exit; }

// -----------------
// DATA READING
// -----------------

   // Llegim les dades
   $card = $dbCards->readCard($ID);

// -----------------
// TEMPLATE SCANNING
// -----------------

   // Si no ens la donen a l'url o config -> utilitzem la individual
   if (!isset($SKIN))  { $SKIN = $card['SKIN']; }

   // Create and define Template
   $Tpl = new awTemplate();
   $Tpl->scanFile("view$SKIN.tpl");

   // Si hi ha cap problema -> Error
   if (!$Tpl->Ok) { echo "<B>Error: No se ha encontrado la plantilla 'edit.tpl'.</B><br>\n"; exit; }


// ------------------
// CONTENT MERGING
// ------------------

   unset($data);

   $data['ACCIO_FORM'] = 'update';



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

	//creem modificacio
	$modificat=$data['MODIFICAT'];
	if ($data['MODIFICAT'] != '0000-00-00 00:00:00'){
		$dataexpl=split(" ",$data['MODIFICAT']);
		$dataexpl=split("-",$dataexpl[0]);
		$usuarimodi=$data['USUARIMODI'];
		$data['TEXTMODIFICAT']=t("bannersmodifydata")." $dataexpl[2]-$dataexpl[1]-$dataexpl[0] ".t("for")." $usuarimodi";
	}else{
		$data['MODIFICAT']="";
	}
	if ($data['VISIBILITY'] == '2'){
		$data['ACTIVAR']="<input type=\"radio\" name=\"VISIBILITY\" value=\"2\" checked>Si <input type=\"radio\" name=\"VISIBILITY\" value=\"1\">No";
	}else{
		$data['ACTIVAR']="<input type=\"radio\" name=\"VISIBILITY\" value=\"2\">Si <input type=\"radio\" name=\"VISIBILITY\" value=\"1\"  checked>No";
	}



    $data['AVUI'] = date('Y-m-d H:i:s', time());
	$data['USUARI']=accessGetLogin();


	//CODI HTML CAPCELERA
 $data['CAPCELERA'] = htmlHeader();
	//CODI HTML PEU
   $data['PEU'] = htmlFoot();

   $data['METAS'] = htmlMetas();

   // OUTPUT ALL

   echo $Tpl->mergeBlock('ALL',$data);

   // OUTPUT BLOCS
   //echo $Tpl->mergeBlock('HEAD',$data);
   //if (isset($data['RECIPETITLE'])) { echo $Tpl->mergeBlock('RECIPE',$data); }
   // echo $Tpl->mergeBlock('FOOT',$data);


?>
