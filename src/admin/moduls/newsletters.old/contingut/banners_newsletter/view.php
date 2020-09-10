<?php

// ============================================================================
// ============================================================================
// CARDS ADMIN: VIEW.PHP
// - Shows a template (form or html) of a card record
// by Asterisc.web
// Version: beta 1.0
// Start: May 2002 - Last: June 2002
// ============================================================================
// ============================================================================

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

   if ($SKIN==0) { $SKIN=$card['SKIN']; }

// -----------------
// TEMPLATE SCANNING
// -----------------

   // Create and define Template
   $Tpl = new awTemplate();
   $Tpl->scanFile("view$SKIN.tpl");

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
	
	
	$imatge = $data['IMATGE'];
	$link = $data['LINK'];
	if ($data['IMATGE'] != ""){
		$data['IMATGE'] = "<a href=\"".$link."\" target=\"_blank\"><img src=\"".$CONFIG_URLBASE."/media/upload/banners_newsletter/".$imatge."\" border=\"0\"></a>";
	}
	

	if($SKIN==0){
		include ('houdini_cap.inc');
	}

	$data['USUARI_HOUDINI'] = $_SESSION['access']['login'];
	
	
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
