<?php
include_once ("config.inc"); // Cards Configuration

db_connect($db_url_web);
error_reporting(0);

// --------------------
// PARAMETERS FILTERING

// --------------------


if (empty($LANG)) {
    $LANG = $DEFAULT_LANG;
}

if (empty($ECLASS)) {
    $ECLASS = $DEFAULT_ECLASS;
}

if (empty($SKIN)) {
    $SKIN = 0;
}

if (empty($ID)) {
	redirectTo($CONFIG_NOMCARPETA.'/404.html');
//    echo "<strong>Error: No se ha recibido el codigo de card.</strong><br />\n";
    exit;
}

// ------------------
// CARDS INSTANTATION

// ------------------

$dbCards = new dbCards($CARDS_TABLE);

if (!$dbCards->Ok) {
//    echo "<strong>Error: No se ha podido crear dbCards.</strong><br />\n";
	redirectTo($CONFIG_NOMCARPETA.'/404.html');
    exit;
}

// -----------------
// DATA READING

// -----------------

// Llegim les dades

$card = $dbCards->readCard($ID);

if ($card['VISIBILITY'] == '2' && (strtotime($card['START_TIME']) > time() || strtotime($card['END_TIME']) < time())) {
	redirectTo($CONFIG_NOMCARPETA.'/404.html');
    exit;
}

if ($SKIN == 0) {
    $SKIN = $card['SKIN'];
}

// -----------------
// TEMPLATE SCANNING

// -----------------

// Create and define Template

$Tpl = new awTemplate('!');
$Tpl->scanFile("view$SKIN.tpl");

// Si hi ha cap problema -> Error

if (!$Tpl->Ok) {
	redirectTo($CONFIG_NOMCARPETA.'/404.html');
//    echo "<strong>Error: No se ha encontrado la plantilla 'edit.tpl'.</strong><br />\n";
    exit;
}

// ------------------
// CONTENT MERGING

// ------------------

unset($data);


// GENERAL DATA =====================================================
$data['LANG'] = $LANG;
$data['ECLASS'] = $ECLASS;
$data['ECLASS_X'] = ITEMS_GetValue('CARDS_ECLASS', $ECLASS, $LANG);
$data['CATEGORY1'] = $CATEGORY1;
$data['CATEGORY1_X'] = ITEMS_GetValue('CARDS_CATEGORY1', $CATEGORY1, $LANG);
$data['CATEGORY2'] = $CATEGORY2;
$data['CATEGORY2_X'] = ITEMS_GetValue('CARDS_CATEGORY2', $CATEGORY2, $LANG);
$data['CATEGORY'] = '';
$data['CATEGORY_X'] = '';

if (($CATEGORY1 == '') && ($CATEGORY2 != '')) {
    $data['CATEGORY'] = $data['CATEGORY2'];
    $data['CATEGORY_X'] = $data['CATEGORY2_X'];
}

if (($CATEGORY1 != '') && ($CATEGORY2 == '')) {
    $data['CATEGORY'] = $data['CATEGORY1'];
    $data['CATEGORY_X'] = $data['CATEGORY1_X'];
}
$data['CONFIG_NOMCARPETA'] = $CONFIG_NOMCARPETA;

// CURRENT CARD DATA ================================================
// Generem totes les dades de cada un dels camps


foreach($card as $name => $value) {

    // Les dades en brut de tots els camps
    //$data[$name] = strip_tags($value);

    $data[$name] = $value;
}

//IMATGE

if ($data['IMATGE'] != '') {
    $data['IMATGE'] = '<img src="' . $CONFIG_URLUPLOADIM . '/' . $data['IMATGE'] . '" alt="' . $data['TITOL'] . '" border="0" />';
}

//DATA

if ($data['DATA'] != '') {
    $data['DATA'] = $data['DATA'] . "<br />";
}

/*adjunt*/

if (!empty($data['ADJUNT'])) {
    $extensio = explode('.', $data['ADJUNT']);
    $data['ADJUNT'] = '<table cellpadding="0" cellspacing="0" border="0" width="100%">
						  <tr>
						    <td style="background-color:#ECECEC;padding:5px;padding-left:10px;">
						     Arxius adjunts
						    </td>
						  </tr>
						  <tr>
						    <td style="padding:5px;padding-left:4px;">
						      <a href="' . $CONFIG_URLUPLOADAD . '/' . $data['ADJUNT'] . '">Descarregar</a>
						    </td>
						  </tr>
						</table>';
}

//TITOL

if ($data['TITOL'] != '') {
    $data['TITOL'] = $data['TITOL'] . '<br />';
}

//SUBTITOL

if ($data['SUBTITOL'] != '') {
    $data['SUBTITOL'] = $data['SUBTITOL'] . '<br /><br />';
}

//SUBTITOL

if ($data['DESCRIPCIO'] != '') {
    $data['DESCRIPCIO'] = $data['DESCRIPCIO'] . '<br /><br />';
}

/*links*/

for ($j = 1;$j < 4;$j++) {

    if (empty($data['LINK' . $j])) {
        continue;
    }
    $vincles = '';
    $novafinestra = '';

    if ($data['FINESTRA' . $j] == 1) {
        $novafinestra = 'target="_blank"';
    }

    if (empty($data['TEXTLINK' . $j])) {
        $data['TEXTLINK' . $j] = $data['LINK' . $j];
    }
    $data['TEXTLINK' . $j] = '<a href="' . $data['LINK' . $j] . '" ' . $novafinestra . '>' . $data['TEXTLINK' . $j] . '</a><br />';
}

if ($data['TEXTLINK1'] != '' || $data['TEXTLINK2'] != '' || $data['TEXTLINK3'] != '') {
    $data['LINKS'] = '<table cellpadding="0" cellspacing="0" border="0" width="100%">
					  <tr>
					    <td style="background-color:#ECECEC;padding:5px;padding-left:10px;">
					      Enllaços relacionats
					    </td>
					  </tr>
					  <tr>
					    <td style="padding:5px;padding-left:4px;">
					      ' . $data['TEXTLINK1'] . '
					      ' . $data['TEXTLINK2'] . '
					      ' . $data['TEXTLINK3'] . '
					    </td>
					  </tr>
					</table>';
}

// SITUACIO
//posem link al nom carpeta xq retorni a l'index;
$arraySituacio[count($arraySituacio)-1]['link'] = 'index.php';
$arraySituacio[] = array('link' => '', 'nom' => $data['TITOL'], 'title' => $data['TITOL']);
$data['SITUACIO'] = fil_ariadna_build($arraySituacio);

// fi
// OUTPUT ALL

$content = $Tpl->mergeBlock('ALL', $data);
echo phpEval($content);
?>
