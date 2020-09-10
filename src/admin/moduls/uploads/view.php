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
accessGroupPermCheck('users_edit');

include_once("grups.php");

//include_once("funcions.php");


$ITEMS['CARDS_CATEGORY2']['ESP'] =array('0_'.t("notcategoriesdefined"));
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
   $Tpl->scanFile("view0.tpl");

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
          else if ($type=='FILE')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='IMAGE')  { $data = $dbCards->GenerateData($data, $name, $value); }
       }


	//creem modificacio
	$modificat=$data['MODIFICAT'];
	if ($data['MODIFICAT'] != '0000-00-00 00:00:00'){
		$dataexpl=split(" ",$data['MODIFICAT']);
		$dataexpl=split("-",$dataexpl[0]);
	}else{
		$data['MODIFICAT']="";
	}
	if ($data['VISIBILITY'] == '2'){
		$data['ACTIVAR']="<input type=\"radio\" name=\"VISIBILITY\" value=\"2\" checked>".t("yes")." <input type=\"radio\" name=\"VISIBILITY\" value=\"1\">".t("no");
	}else{
		$data['ACTIVAR']="<input type=\"radio\" name=\"VISIBILITY\" value=\"2\">".t("yes")." <input type=\"radio\" name=\"VISIBILITY\" value=\"1\"  checked>".t("no");
	}


    $data['AVUI'] = date('Y-m-d H:i:s', time());
	$data['USUARI']=accessGetLogin();


	$data['EDITOR_HEAD'] = editor_head();

	//CODI HTML CAPCELERA
    $data['CAPCELERA'] = htmlHeader();
	//CODI HTML PEU
   $data['PEU'] = htmlFoot();



    ///variables de text idioma
   $data['LANGETSA'] = t("youarein");
   $data['LANGTITOL'] = t('uploadgrouptitle');
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

   $data['LANGUTILITATS'] = t("utils");


   $data['GRUP'] = t("uploadgroupgroup");
   $data['FOLDER'] = t("folder");
//   $data['SELECT_GROUP'] = getGroupSelect($data['NOMGRUP']);
   $data['LANGGROUPS'] = t('uploadgrouptitle');
   $data['LANGPERMISOS'] = t("uploadgroupperms");


   // fi

   // OUTPUT ALL

   echo $Tpl->mergeBlock('ALL',$data);

?>
