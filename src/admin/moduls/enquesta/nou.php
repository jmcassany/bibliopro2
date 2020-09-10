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
accessGroupPermCheck('poll');

require('enquesta.php');



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

   $data['SELECT_STATUS'] = ITEMS_HTMLSelect( 'STATUS', 'CARDS_STATUS', 1, $LANG);


   $data['START_TIME_DAY']=date('d');
   $data['START_TIME_MONTH']=date('m');
   $data['START_TIME_YEAR']=date('Y');
   $data['END_TIME_DAY']=date('d');
   $data['END_TIME_MONTH']=date('m');
   $data['END_TIME_YEAR']=date('Y');

   $data['ACTIVAR']="<input type=\"radio\" name=\"VISIBILITY\" value=\"2\">Si <input type=\"radio\" name=\"VISIBILITY\" value=\"1\"  checked>No";


   // CURRENT CARD DATA ================================================

   // Creem el SELECT pels CUSTOM de tipus ITEM
   foreach ($CARDS_FIELDS as $name=>$field)
   {
     list ($scope, $type, $style) = $field;
     if ($scope=='CUSTOM' && $type=='ITEM')
     { $data['SELECT_'.$name] = ITEMS_HTMLSelect( $name, $style, '', $LANG); }
   }

   $templates = file_list($CONFIG_PATHTEMPLATEPOLL);
   $data['SELECT_PLANTILLA'] = '';
   foreach ($templates as $value) {
     $data['SELECT_PLANTILLA'] .= '
<option value="'.$value.'">'.$value.'</option>
';
   }
   $data['SELECT_PLANTILLA'] = '
<select name="PLANTILLA">
'.$data['SELECT_PLANTILLA'].'
</select>
';


	$data['MODIFICAT']="";

    $data['AVUI'] = date('Y-m-d H:i:s', time());
	$data['USUARI']=accessGetLogin();


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
