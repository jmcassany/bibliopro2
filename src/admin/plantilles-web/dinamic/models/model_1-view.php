<?php
include_once ("config.inc"); // Cards Configuration

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
	goto_url($CONFIG_NOMCARPETA.'/404.html');
    //echo "<strong>Error: No se ha recibido el codigo de card.</strong><br />\n";
    exit;
}

// ------------------
// CARDS INSTANTATION

// ------------------

$dbCards = new dbCards($CARDS_TABLE);

if (!$dbCards->Ok) {
    echo "<strong>Error: No se ha podido crear dbCards.</strong><br />\n";
    exit;
}

// -----------------
// DATA READING

// -----------------

// Llegim les dades

$card = $dbCards->readCard($ID);

if ($card['VISIBILITY'] == '2' && (strtotime($card['START_TIME']) > time() || strtotime($card['END_TIME']) < time())) {
	goto_url($CONFIG_NOMCARPETA.'/404.html');
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
	goto_url($CONFIG_NOMCARPETA.'/404.html');
//    echo "<strong>Error: No se ha encontrado la plantilla 'edit.tpl'.</strong><br />\n";
    exit;
}

// ------------------
// CONTENT MERGING

// ------------------

unset($data);


// info altres variables
$data['CONFIG_NOMCARPETA'] = $CONFIG_NOMCARPETA;

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

// CURRENT CARD DATA ================================================
// Generem totes les dades de cada un dels camps


foreach($card as $name => $value) {

    // Les dades en brut de tots els camps
    //$data[$name] = strip_tags($value);

    $data[$name] = $value;
}

if ($data['TITOL'] != '') {
	$data['METAS_TITLE'] = $data['TITOL'].' - ';
}




// SITUACIO
//posem link al nom carpeta xq retorni a l'index;
$arraySituacio[count($arraySituacio)-1]['link'] = $pathEditora.'index.php';
$arraySituacio[] = array('link' => '', 'nom' => $data['TITOL'], 'title' => $data['TITOL']);
$data['SITUACIO'] = fil_ariadna_build($arraySituacio);


// CREATION DATA
ereg("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $data['CREATION'], $regs_data);

// Per imprimir data en format literal: Dimecres, 8 d'octubre de 2007
$timestamp_creation = mktime(0, 0, 0, $regs_data[2], $regs_data[3], $regs_data[1]);
setlocale(LC_ALL, 'ca_ES');
$data['CREATION'] = (ereg("^[aeiou]", strftime("%B", $timestamp_creation))) ? strftime("%A, %e d'%B de %Y", $timestamp_creation) : strftime("%A, %e de %B de %Y", $timestamp_creation);
$data['CREATION'] = ucfirst($data['CREATION']);

// CATEGORIA
$data['CATEGORIA'] = '';

if ($data['CATEGORY2'] != 0) {
	if ($urlFriendly) {
		$infocat = getInfoCategoria($data['CATEGORY2']);
		$data['CATEGORIA'] = '<p class="categoria"><a href="'.$pathEditora.'cat/' . $data['CATEGORY2'] . '/'.$infocat['URL_NOM'].'" title="Veure totes les activitats de la categoria ' . getNomCategoria($data['CATEGORY2']) . '">' . getNomCategoria($data['CATEGORY2']) . '</a></p>';
	}
	else {
		$data['CATEGORIA'] = '<p class="categoria"><a href="'.$pathEditora.'index.php?CATEGORY2=' . $data['CATEGORY2'] . '" title="Veure totes les activitats de la categoria ' . getNomCategoria($data['CATEGORY2']) . '">' . getNomCategoria($data['CATEGORY2']) . '</a></p>';
	}
}

//IMATGES

if ($data['IMATGE1'] != '') {
    $data['IMATGE1'] = '<img src="' . $CONFIG_URLUPLOADIM . '/' . $data['IMATGE1'] . '" alt="" />';

    if ($data['PEU_IMATGE1'] != '') {
        $data['PEU_IMATGE1'] = '<p>' . $data['PEU_IMATGE1'] . '</p>';
    }
}

if ($data['IMATGE2'] != '') {
    $data['IMATGE2'] = '<img src="' . $CONFIG_URLUPLOADIM . '/' . $data['IMATGE2'] . '" alt="" />';

    if ($data['PEU_IMATGE2'] != '') {
        $data['PEU_IMATGE2'] = '<p>' . $data['PEU_IMATGE2'] . '</p>';
    }
}

if ($data['IMATGE3'] != '') {
    $data['IMATGE3'] = '<img src="' . $CONFIG_URLUPLOADIM . '/' . $data['IMATGE3'] . '" alt="" />';

    if ($data['PEU_IMATGE3'] != '') {
        $data['PEU_IMATGE3'] = '<p>' . $data['PEU_IMATGE3'] . '</p>';
    }
}

//SUBTITOL

if ($data['SUBTITOL'] != '') {
    $data['SUBTITOL'] = '<p id="entradeta">' . $data['SUBTITOL'] . '</p>';
}


if ($urlFriendly) {
	$urlAbs = $pathEditoraAbs.''.$id.'/'.$data['URL_TITOL'];
}
else {
	$url = $pathEditora.'view.php?ID=' . $id;
	$urlAbs = $pathEditoraAbs.'view.php?ID=' . $id;
}
$data['SOCIABLE'] = sociable($urlAbs, $data['TITOL'], $CONFIG_SESSIONNAME, $pathEditora.'index.xml', $data['RESUM']);

// INFO RELACIONADA
// LINKS

$links = '';

for ($j = 1;$j < 4;$j++) {

    if (empty($data['LINK' . $j])) {
        continue;
    }
    $novafinestra = ($data['FINESTRA' . $j] == 1) ? 'rel="external"' : '';
    $data['TEXTLINK' . $j] = (empty($data['TEXTLINK' . $j])) ? $data['LINK' . $j] : $data['TEXTLINK' . $j];
    $data['TEXTLINK' . $j] = '<a href="' . $data['LINK' . $j] . '" ' . $novafinestra . '>' . $data['TEXTLINK' . $j] . '</a>';
    $links.= '<li>' . $data['TEXTLINK' . $j] . '</li>';
}

// ADJUNTS

for ($j = 1;$j < 4;$j++) {

    if (empty($data['ADJUNT' . $j])) {
        continue;
    }
	if (file_exists($CONFIG_PATHUPLOADAD . '/' . $data['ADJUNT' . $j])) {
		$data['TEXT_ADJUNT' . $j] = ($data['TEXT_ADJUNT' . $j] != '') ? $data['TEXT_ADJUNT' . $j] : 'Descarregar document';
		$mida_fitxer = number_format(filesize($CONFIG_PATHUPLOADAD . '/' . $data['ADJUNT' . $j]) /1024, 2, ',', '.');
		$parts_nom = explode(".", $data['ADJUNT' . $j], 2);
		$classe = strtolower($parts_nom[1]);
		$tipus_doc = strtoupper($parts_nom[1]);
		$adjunts.= '<li><a href="' . $CONFIG_URLUPLOADAD . '/' . $data['ADJUNT' . $j] . '" class="' . $classe . '">' . $data['TEXT_ADJUNT' . $j] . '</a> (' . $tipus_doc . ' ' . $mida_fitxer . ' Kb)</li>';
	}
}
$data['INFO_REL'] = '';

if ($links != '' || $adjunts != '') {
    $data['INFO_REL'] = '<div id="enllacos">
    						<h4>Enllaços relacionats</h4>
    						<ul>
    							' . $links . $adjunts . '
    						</ul>
					</div>';
}

// fi
// OUTPUT ALL

$content = $Tpl->mergeBlock('ALL', $data);
echo phpEval($content);
?>
