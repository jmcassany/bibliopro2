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

// filtre de dates per al calendari

$filtre_data = false;

if (isset($_GET['day']) && isset($_GET['month']) && isset($_GET['year'])) {
    $day = $_GET['day'];
    $month = $_GET['month'];
    $year = $_GET['year'];
    $date_str = $year . '-' . $month . '-' . $day;
    $CARDS_LISTFILTER.= " AND ( ( CALENDAR_START_TIME LIKE '" . $date_str . "%' OR CALENDAR_END_TIME LIKE '" . $date_str . "%' ) OR (CALENDAR_START_TIME < '" . $date_str . "' AND CALENDAR_END_TIME > '" . $date_str . "') )";
    $filtre_data = true;
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

    return $pathEditora.'index.php?CATEGORY2=' . $CATEGORY2 . '&amp;PAGE=' . $page;
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
    $data['PAGENEXT'] = '<a class="seguent">' . $CARDS_LISTPAGENEXT . '</a>';
} else {
    $data['PAGENEXT'] = '<a class="seguent" href="' . getPageLink($pagenext) . '">' . $CARDS_LISTPAGENEXT . '</a>';
}

// Previous page link
$pageprev = $PAGE-1;

if ($pageprev < $pagemin) {
    $data['PAGEPREV'] = '<a class="anterior">' . $CARDS_LISTPAGEPREV . '</a>';
} else {
    $data['PAGEPREV'] = '<a class="anterior" href="' . getPageLink($pageprev) . '">' . $CARDS_LISTPAGEPREV . '</a>';
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
    $pagelist.= '<li><a href="' . getPageLink($skipleft) . '">...</a></li>';
}

for ($i = $min;$i <= $max;$i++) {

    if ($i == $PAGE) {
        $pagelist.= " <li><strong>$i</strong></li>";
    } else {
        $pagelist.= '<li><a href="' . getPageLink($i) . '">' . $i . '</a></li>';
    }
}

if ($dec < $decmax) {
    $pagelist.= '<li><a href="' . getPageLink($skipright) . '">...</a></li>';
}
$data['PAGELIST'] = '<ul>' . $pagelist . '</ul>';

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

// READ DATA =======================================================
$cards = $dbCards->listCards($PAGE, $CATEGORY1, $CATEGORY2);
$data['N'] = 0;
$total = count($cards);

// info mostrant pàgines
$data['ITEMS_TOTAL'] = $total;
$data['ITEMS_INICI'] = ($data['ITEMS_TOTAL'] == 0) ? 0 : ($PAGE-1) *$CARDS_LISTLENGTH+1;
$data['ITEMS_FI'] = $PAGE*$CARDS_LISTLENGTH;
(($PAGE*$CARDS_LISTLENGTH) > $data['ITEMS_TOTAL']) ? $data['ITEMS_FI'] = $data['ITEMS_TOTAL'] : $data['ITEMS_FI'] = $PAGE*$CARDS_LISTLENGTH;

// info altres variables
$data['CONFIG_NOMCARPETA'] = $CONFIG_NOMCARPETA;

// llista de categories
$data['LLISTA_CATEGORIES'] = getLlistaCategories($ID_CARPETA, "levels=1&display_childs_from_category=" . $CATEGORY2);

if ($data['LLISTA_CATEGORIES'] != '') {
    $data['LLISTA_CATEGORIES'] = '<h2>Categories</h2><ul>' . $data['LLISTA_CATEGORIES'] . '<li><a href="'.$pathEditora.'index.php">Totes les categories</a></li></ul>';
}

// calendari
$IDIOMA_CALENDARI = $IDIOMA_PAG;
ob_start();
include_once ($CONFIG_PATHPHP . "/calendari_agenda.php");
$data['CALENDARI'] = ob_get_contents();
ob_end_clean();

// si hi ha filtre de data mostrem la data
setlocale(LC_TIME, "ca_ES");

if (isset($year) && isset($month) && isset($day) && $filtre_data == true) {
    $literal_mes = strftime("%B", mktime(0, 0, 0, $month, $day, $year));
    $literal_mes = ereg("^[aeiou]", $literal_mes) ? "d'" . $literal_mes : "de " . $literal_mes;
    $data['DATA_ACTUAL'] = '<p class="data">' . ucfirst(strftime("%A %e " . $literal_mes . " de " . $year, mktime(0, 0, 0, $month, $day, $year))) . '</p>';
}

// OUTPUT HEAD =====================================================
$content = $Tpl->mergeBlock('HEAD', $data);

for ($i = 0;$i < $total;$i++) {
    $data['N'] = 1+$i+($PAGE-1) *$CARDS_LISTLENGTH;

    foreach($cards[$i] as $name => $value) {

        // Les dades en brut de tots els camps
        // $data[$name] = strip_tags($value);

        $data[$name] = $value;
    }

    // TITOL i MES
    $idnow = $data['ID'];
    $data['MES'] = '';

    if ($data['DESCRIPCIO'] != '') {
        if ($urlFriendly) {
           $data['MES'] = '<p class="mes"><a href="'.$pathEditora.''.$idnow.'/'.$data['URL_TITOL'].'">Més <span>informació sobre "' . $data['TITOL'] . '"</span></a></p>';
           $data['TITOL'] = '<a href="'.$pathEditora.''.$idnow.'/'.$data['URL_TITOL'].'">' . $data['TITOL'] . '</a>';
        }
        else {
           $data['MES'] = '<p class="mes"><a href="'.$pathEditora.'view.php?ID=' . $idnow . '">Més <span>informació sobre "' . $data['TITOL'] . '"</span></a></p>';
           $data['TITOL'] = '<a href="'.$pathEditora.'view.php?ID=' . $idnow . '">' . $data['TITOL'] . '</a>';
        }
    }

    // CREATION DATA
    ereg("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $data['CREATION'], $regs_data);

    // Per imprimir data en format literal: Dimecres, 8 d'octubre de 2007
    $timestamp_creation = mktime(0, 0, 0, $regs_data[2], $regs_data[3], $regs_data[1]);
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

    // IMATGE1

    if ($data['IMATGE1'] != '') {
        $data['IMATGE1'] = '<img src="' . $CONFIG_URLUPLOADIM . '/' . $data['IMATGE1'] . '" alt="' . $data['PEU_IMATGE1'] . '" />';
    }
    $content.= $Tpl->mergeBlock('ROW', $data);
}

// OUTPUT FOOT =====================================================
$content.= $Tpl->mergeBlock('FOOT', $data);
echo phpEval($content);
?>
