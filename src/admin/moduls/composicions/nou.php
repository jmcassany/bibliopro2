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

require ('../../config_admin.inc');
accessGroupPermCheck('composition');

require('compositions.php');

   include("variables.php");


// --------------------
// PARAMETERS FILTERING
// --------------------

   if (empty($LANG))  { $LANG=$DEFAULT_LANG; }
   if (empty($ECLASS)) { $ECLASS=$DEFAULT_ECLASS; }
   if (!isset($SKIN))  {$SKIN=$DEFAULT_SKIN; }


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

   $data['ACCIO_FORM'] = 'create';

   $data['METAS'] = htmlMetas();

   // GENERAL DATA =====================================================

   $data['LANG'] = $LANG;

   $data['ECLASS'] = $ECLASS;
   $data['ECLASS_X'] = ITEMS_GetValue( 'CARDS_ECLASS', $ECLASS, $LANG );
   $data['SELECT_ECLASS'] = ITEMS_HTMLSelect( 'ECLASS', 'CARDS_ECLASS', $DEFAULT_SKIN, $LANG);

   // CURRENT CARD DATA ================================================

   // Creem el SELECT pels CUSTOM de tipus ITEM
   foreach ($CARDS_FIELDS as $name=>$field)
   {
     list ($scope, $type, $style) = $field;
     if ($scope=='CUSTOM' && $type=='ITEM')
     { $data['SELECT_'.$name] = ITEMS_HTMLSelect( $name, $style, '', $LANG); }
   }


	$data['MODIFICAT']="";

    $data['AVUI'] = date('Y-m-d H:i:s', time());
	$data['USUARI']=accessGetLogin();


$data['CAIXETES'] = '1';

$data['RADIO_TIPO'] = '';
foreach ($tipus_banners as $key => $value) {
    if (isset($value['defecte'])) {
       $checked = 'checked';
    }
    else {
       $checked = '';
    }
    $data['RADIO_TIPO'] .= '<input type="radio" name="TIPO" value="'.$key.'" '.$checked.'>'.$value['nom'].'<br>';
}


	//CODI HTML CAPCELERA
 $data['CAPCELERA'] = htmlHeader();
	//CODI HTML PEU
   $data['PEU'] = htmlFoot();


   // OUTPUT ALL

   echo $Tpl->mergeBlock('ALL',$data);

   // OUTPUT BLOCS
   //echo $Tpl->mergeBlock('HEAD',$data);
   //if (isset($data['RECIPETITLE'])) { echo $Tpl->mergeBlock('RECIPE',$data); }
   // echo $Tpl->mergeBlock('FOOT',$data);


?>
