<?php
include_once ("config.inc"); // Cards Configuration

//tipo d'ordre

if (empty($ORDENAPER)) $ORDENAPER = '0';

if ($ORDENAPER == '0') $CARDS_LISTSORTBY = 'ORDRE DESC,ID desc, TITOL asc';

if ($ORDENAPER == '1') $CARDS_LISTSORTBY = 'TITOL asc,ID desc';

if ($ORDENAPER == '2') $CARDS_LISTSORTBY = 'CREATION desc,TITOL asc';

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
    $SKIN = $DEFAULT_SKIN;
}

if (empty($PAGE)) {
    $PAGE = '1';
} // Primera pagina


if (empty($CATEGORY1)) {
    $CATEGORY1 = '';
} // No filtre CATEGORY1


if (empty($CATEGORY2)) {
    $CATEGORY2 = '0';
} // No filtre CATEGORY2


if ($CATEGORY2 == '0') {
    $CARDS_LISTFILTER.= " AND (CATEGORY2='0')";
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
// TEMPLATE SCANNING

// -----------------

// Create and define Template

$Tpl = new awTemplate('!');
$Tpl->scanFile("index.tpl");

// Si hi ha cap problema -> Error

if (!$Tpl->Ok) {
    echo "<strong>Error: No se ha encontrado la plantilla 'index.tpl'.</strong><br />\n";
    exit;
}

// ------------------
// CONTENT MERGING

// ------------------

unset($data);

// NAVEGATION DATA ==================================================

function getPageLink($page) {
    global $CATEGORY1, $CATEGORY2, $SKIN, $PAGE;

    return 'index.php?CATEGORY2=' . $CATEGORY2 . '&amp;PAGE=' . $page;
}

// Acotem $PAGE
$pagemin = 1;
$pagemax = $dbCards->countCardPages($CATEGORY1, $CATEGORY2);

if ($PAGE < $pagemin) {
    $PAGE = $pagemin;
}

if ($PAGE > $pagemax) {
    $PAGE = $pagemax;
}
$data['PAGE'] = $PAGE;
$data['PMAX'] = $pagemax;

// Next page link
$pagenext = $PAGE+1;

if ($pagenext > $pagemax) {
    $data['PAGENEXT'] = '';
} else {
    $data['PAGENEXT'] = '<a href="' . getPageLink($pagenext) . '">' . $CARDS_LISTPAGENEXT . '</a>';
}

// Previous page link
$pageprev = $PAGE-1;

if ($pageprev < $pagemin) {
    $data['PAGEPREV'] = '';
} else {
    $data['PAGEPREV'] = '<a href="' . getPageLink($pageprev) . '">' . $CARDS_LISTPAGEPREV . '</a>';
}

// List Page links
$dec = floor(($PAGE-1) /$CARDS_LISTSKIP);
$decmax = floor(($pagemax-1) /$CARDS_LISTSKIP);
$min = 1+($dec*$CARDS_LISTSKIP);
$max = $min+$CARDS_LISTSKIP-1;

if ($max > $pagemax) {
    $max = $pagemax;
}
$skipright = $PAGE+$CARDS_LISTSKIP;

if ($skipright > $pagemax) {
    $skipright = $pagemax;
}
$skipleft = $PAGE-$CARDS_LISTSKIP;

if ($skipleft < 1) {
    $skipleft = 1;
}
$pagelist = ' ';

if ($dec > 0) {
    $pagelist.= '<a href="' . getPageLink($skipleft) . '">...</a> ';
}

for ($i = $min;$i <= $max;$i++) {

    if ($i == $PAGE) {
        $pagelist.= " <strong>$i</strong>";
    } else {
        $pagelist.= ' <a href="' . getPageLink($i) . '">$i</a>';
    }
}

if ($dec < $decmax) {
    $pagelist.= '<a href="' . getPageLink($skipright) . '">...</a>';
}
$data['PAGELIST'] = $pagelist . ' ';

// GENERAL DATA HEAD =================================================
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

// READ DATA =======================================================
$cards = $dbCards->listCards($PAGE, $CATEGORY1, $CATEGORY2);
$data['N'] = 0;
$total = count($cards);

// OUTPUT HEAD =====================================================
$content = $Tpl->mergeBlock('HEAD', $data);

for ($i = 0;$i < $total;$i++) {
    $data['N'] = 1+$i+($PAGE-1) *$CARDS_LISTLENGTH;

    foreach($cards[$i] as $name => $value) {

        // Les dades en brut de tots els camps
        $data[$name] = strip_tags($value);
    }

    // TITOL i MES
    $idnow = $data['ID'];

    if ($data['DESCRIPCIO'] != '') {


        if ($urlFriendly) {
           $data['MES'] = '<br /><a href="' . $idnow . '/'.$data['URL_TITOL'].'">Més</a><br />';
           $data['TITOL'] = '<a href="' . $idnow . '/'.$data['URL_TITOL'].'">' . $data['TITOL'] . '</a><br />';
        }
        else {
           $data['MES'] = '<br /><a href="view.php?ID=' . $idnow . '">Més</a><br />';
           $data['TITOL'] = '<a href="view.php?ID=' . $idnow . '">' . $data['TITOL'] . '</a><br />';
        }


    } else {
        $data['MES'] = '';
        $data['TITOL'] = $data['TITOL'] . '<br />';
    }

    //DATA

    if ($data['DATA'] != '') {
        $data['DATA'] = $data['DATA'] . '<br />';
    }

    //SUBTITOL

    if ($data['SUBTITOL'] != '') {
        $data['SUBTITOL'] = $data['SUBTITOL'] . '<br /><br />';
    }

    // OUTPUT ROW =====================================================

    // bloc segons l'skin de la fitxa
    $content.= $Tpl->mergeBlock('ROW' . $cards[$i]['SKIN'], $data);
}

// OUTPUT FOOT =====================================================
$content.= $Tpl->mergeBlock('FOOT', $data);
echo phpEval($content);
?>
