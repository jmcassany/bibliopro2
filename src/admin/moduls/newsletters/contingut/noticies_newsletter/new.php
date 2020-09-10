<?php

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


//gestio user 1 model
$result_user = db_query("select * from " . TAULA_USUARIS . " where LOGIN='".$_SESSION['access']['login']."'");
$row_user = db_fetch_array($result_user);

$models_user = explode(",", $row_user['TELEPHONE']);
$gestio_model_user = $models_user[0] - 1;
if (count($models_user) == 2) {
    header("Location: create.php?MODEL=".$gestio_model_user."&USUARI_HOUDINI=".$_SESSION['access']['login']."&STATUS=1");
    exit;
}

foreach ($ITEMS['CARDS_SKIN']['ESP'] as $index => $valor) {

    $tall = explode("_", $valor);
    $id_model = $tall[0]+1;
    $nom_model = $tall[1];

    $tall2 = explode(",", $row_user['TELEPHONE']);
    if (in_array($id_model, $tall2)) {
        $model .= "<option value=".$tall[0].">".$nom_model."</option>";
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
 
include_once $CONFIG_NLADMINPATHBASE . '/media/php/lang_ca.php';

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
if(function_exists(editor_head)){
    $data['FCK1'] = editor_head();
    $data['FCK2'] = editor_entry('DESCRIPCIO', '', 'Antaviana');
    $data['FCK3'] = editor_entry('RESUM', '', 'Antaviana');
} else {
    $data['FCK1'] = '<link rel="stylesheet" href="/admin/media/css/ckeditorfix.css" type="text/css" media="all"/>
        <script type="text/javascript" src="/admin/media/js/ck/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="/admin/media/js/ck/ckeditor/adapters/jquery.js"></script>
        <script type="text/javascript" src="/admin/media/js/ck/editor.php"></script>';
    $data['FCK2'] = '<textarea id="DESCRIPCIO" class="editorBasic" name="DESCRIPCIO"></textarea>';
    $data['FCK3'] = '<textarea id="RESUM" class="editorBasic" name="RESUM"></textarea>';
}


$data['MODEL'] = $model;

$data['USUARI_HOUDINI'] = $_SESSION['access']['login'];


 
//gestio submenu
if ($_SESSION['access']['level'] == 5) {
    $orig = '<li><a href="../origens_rss_noticies/index.php">Origens RSS</a></li>';
}
else {
    $orig = '';
}
$data['SUBMENU'] = '<li>Notícies</li>
				<li><a href="../banners_newsletter/list.php">Banners</a></li>
				<li><a href="../caps_newsletter/list.php">Capçaleres</a></li>
				<li><a href="../caixes_newsletter/list.php">Caixes</a></li>
				'.$orig;
 
 

setCurrent('contingut');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');

// OUTPUT ALL
echo $Tpl->mergeBlock('ALL',$data);

include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');
?>
