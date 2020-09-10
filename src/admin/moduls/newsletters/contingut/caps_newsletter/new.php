<?php

// ============================================================================
// ============================================================================
// CARDS: NEW.PHP
// - Shows a form page to create a new card (it will call 'create.php')
// by Asterisc.web
// Version: beta 1.0
// Start: May 2002 - Last: June 2002
// ============================================================================
// ============================================================================
include_once '../../selconfig.php';
include_once 'config.php';
 
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
if (!$Tpl->Ok) { htmlNewsletterError($messages["error3"]); }

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
 
 
$data['USUARI_HOUDINI'] = $_SESSION['access']['login'];
 

//gestio submenu
if ($_SESSION['access']['level'] == 5) {
    $orig = '<li><a href="../origens_rss_noticies/index.php">Origens RSS</a></li>';
}
else {
    $orig = '';
}
$data['SUBMENU'] = '<li><a href="../noticies_newsletter/list.php">Notícies</a></li>
				<li><a href="../banners_newsletter/list.php">Banners</a></li>
				<li>Capçaleres</li>
				<li><a href="../caixes_newsletter/list.php">Caixes</a></li>
				'.$orig;

 
include_once $CONFIG_NLADMINPATHBASE . '/media/php/lang_ca.php';
 
setCurrent('contingut');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
// OUTPUT ALL
echo $Tpl->mergeBlock('ALL',$data);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');
?>
