<?php
   include("config.php");
    include_once("../../../../../public/media/php/newsletters.php");


foreach ($ITEMS['CARDS_SKIN']['ESP'] as $index => $valor){

	$tall = explode("_", $valor);
	$id_model = $tall[0];
	$nom_model = $tall[1];

	$model .= "<option value=".$id_model.">".$nom_model."</option>";
}



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


   // Variables per defecte definides al config
   if (empty($LANG))  { $LANG=$DEFAULT_LANG; }
   if (empty($CLASS)) { $CLASS=$DEFAULT_CLASS; }
   if (empty($SKIN))  { $SKIN=0; }

// -----------------
// TEMPLATE SCANNING
// -----------------

   // Create and define Template
   $Tpl = new awTemplate();
   $Tpl->scanFile("new$SKIN.tpl");

   // Si hi ha cap problema -> Error
   if (!$Tpl->Ok) { echo "<B>".$messages["error3"].".</B><br>\n"; exit; }

// ------------------
// CONTENT MERGING
// ------------------

   unset($data);

   // Valors de contexte: tipus de card i idioma
   $data['LANG'] = $LANG;
   $data['LANG_X'] = ITEMS_GetValue( 'LANG', $LANG, $LANG );

   $data['CLASS'] = $CLASS;
   $data['CLASS_X'] = ITEMS_GetValue( 'CARDS_CLASS', $CLASS, $LANG );

   // Creem els SELECT pels camps basics de tipus ITEM
   $data['SELECT_LANG'] = ITEMS_HTMLSelect( 'LANG', 'LANG', $DEFAULT_SKIN, $LANG);
   $data['SELECT_CLASS'] = ITEMS_HTMLSelect( 'CLASS', 'CARDS_CLASS', $DEFAULT_SKIN, $LANG);
   $data['SELECT_SKIN'] = ITEMS_HTMLSelect( 'SKIN', 'CARDS_SKIN', $DEFAULT_SKIN, $LANG);
   $data['SELECT_CATEGORY1'] = ITEMS_HTMLSelect( 'CATEGORY1', 'CARDS_CATEGORY1', $DEFAULT_CATEGORY1, $LANG);
   $data['SELECT_CATEGORY2'] = ITEMS_HTMLSelect( 'CATEGORY2', 'CARDS_CATEGORY2', $DEFAULT_CATEGORY2, $LANG);
   $data['SELECT_STATUS'] = ITEMS_HTMLSelect( 'STATUS', 'CARDS_STATUS', $DEFAULT_STATUS, $LANG);
   $data['SELECT_VISIBILITY'] = ITEMS_HTMLSelect( 'VISIBILITY', 'CARDS_VISIBILITY', $DEFAULT_VISIBILITY, $LANG);

   // Creem el SELECT pels CUSTOM de tipus ITEM
   foreach ($CARDS_FIELDS as $name=>$field)
   {
     list ($scope, $type, $style) = $field;
     if ($scope=='CUSTOM' && $type=='ITEM')
     { $data['SELECT_'.$name] = ITEMS_HTMLSelect( $name, $style, '', $LANG); }
   }


//    include("editor.inc");
	$data['FCK1'] = editor_head();
	$data['FCK2'] = editor_entry('DESCRIPCIO', '', 'AntavianaNL');
	$data['FCK3'] = editor_entry('RESUM', '', 'AntavianaNL');


   $data['MODEL'] = $model;

   $data['USUARI_HOUDINI'] = $_SESSION['access']['login'];



   include ('houdini_cap.inc');

   // OUTPUT ALL
   echo $Tpl->mergeBlock('ALL',$data);

   include ('houdini_peu.inc');
?>
