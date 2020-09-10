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


// info altres variables
$data['CONFIG_NOMCARPETA'] = $CONFIG_NOMCARPETA;

// OUTPUT HEAD =====================================================
$content = $Tpl->mergeBlock('HEAD', $data);

// llistat de categories arrel

if ($CATEGORY2 == 0 && cat_num_Descendents($ID_CARPETA) > 0) {

    // capçalera de la categoria
    $data['NUM_SUB_CATEGORIES'] = '<p>Número de categories : ' . cat_num_Descendents($ID_CARPETA) . '</p>';

    // OUTPUT =====================================================
    $content.= $Tpl->mergeBlock('INDEX_CATEGORIA', $data);

    // llistat de subcategories
    $ARRAY_CATEGORIES = getArrayCategories($ID_CARPETA, "levels=1&category_id=$CATEGORY2");

    foreach($ARRAY_CATEGORIES as $info_categoria) {
        $data['ID'] = $info_categoria['ID'];
        $data['NOM'] = $info_categoria['NOM'];
        $data['DESCRIPCIO'] = $info_categoria['DESCRIPCIO'];
        $data['IMATGE'] = $info_categoria['IMATGE'];
        $data['NUM_SUBCATEGORIES'] = '<p>Número de subcategories : ' . cat_num_Descendents($ID_CARPETA, "category_id=" . $info_categoria['ID']) . '</p>';
        $data['NUM_ELEMENTS'] = '<p>Número d\'elements : ' . cat_num_Items($ID_CARPETA, "category_id=" . $info_categoria['ID']) . '</p>';

        if ($data['IMATGE'] != '') {
            $data['IMATGE'] = '<img src="' . $CONFIG_URLUPLOADIM . '/' . $data['IMATGE'] . '" alt=""/>';
        }
        $content.= $Tpl->mergeBlock('INDEX_ITEM_CATEGORIA', $data);
    }

    // OUTPUT =====================================================
    $content.= $Tpl->mergeBlock('FI_INDEX_CATEGORIA', $data);

    // OUTPUT FOOT =====================================================
    $content.= $Tpl->mergeBlock('FOOT', $data);
} else
if ($CATEGORY2 != 0 && cat_num_Descendents($ID_CARPETA, "category_id=$CATEGORY2") > 0) {

    // capçalera de la categoria
    $info_categoria = getInfoCategoria($CATEGORY2);

    if ($info_categoria['PARE'] == 0) {
		$data['LINK_CATEGORIA_PARE'] = '<p><a href="'.$pathEditora.'index.php">Enrera</a></p>';
    } else {
		if ($urlFriendly) {
			$data['LINK_CATEGORIA_PARE'] = '<p>&#x2190; <a href="'.$pathEditora.'cat/' . $info_categoria['PARE'] . '/'.$info_categoria['URL_NOM'].'">' . getNomCategoria($info_categoria['PARE']) . '</a></p>';
		}
		else {
			$data['LINK_CATEGORIA_PARE'] = '<p>&#x2190; <a href="'.$pathEditora.'index.php?CATEGORY2=' . $info_categoria['PARE'] . '">' . getNomCategoria($info_categoria['PARE']) . '</a></p>';
		}

    }
    $data['ID'] = $info_categoria['ID'];
    $data['NOM'] = $info_categoria['NOM'];
    $data['DESCRIPCIO'] = $info_categoria['DESCRIPCIO'];
    $data['IMATGE'] = $info_categoria['IMATGE'];

    if ($data['IMATGE'] != '') {
        $data['IMATGE'] = '<img src="' . $CONFIG_URLUPLOADIM . '/' . $data['IMATGE'] . '" alt=""/>';
    }
    $data['N_ELEMENTS'] = cat_num_Descendents($ID_CARPETA, "category_id=" . $data['ID']) . ' galeries';

    // OUTPUT =====================================================
    $content.= $Tpl->mergeBlock('INDEX_SUB_CATEGORIA', $data);

    // llistat de subcategories
    $ARRAY_CATEGORIES = getArrayCategories($ID_CARPETA, "levels=1&category_id=$CATEGORY2");

    foreach($ARRAY_CATEGORIES as $info_categoria) {
        $data['ID'] = $info_categoria['ID'];
        $data['NOM'] = $info_categoria['NOM'];
        $data['DESCRIPCIO'] = $info_categoria['DESCRIPCIO'];
        $data['IMATGE'] = $info_categoria['IMATGE'];
        $data['NUM_SUBCATEGORIES'] = '<p>Número de subcategories : ' . cat_num_Descendents($ID_CARPETA, "category_id=" . $data['ID']) . '</p>';
        $data['NUM_ELEMENTS'] = '<p>Número d\'elements : ' . cat_num_Items($ID_CARPETA, "category_id=" . $data['ID']) . '</p>';

        if ($data['IMATGE'] != '') {
            $data['IMATGE'] = '<img src="' . $CONFIG_URLUPLOADIM . '/' . $data['IMATGE'] . '" alt=""/>';
        }

        // OUTPUT =====================================================
        $content.= $Tpl->mergeBlock('INDEX_ITEM_SUB_CATEGORIA', $data);
    }

    // OUTPUT =====================================================
    $content.= $Tpl->mergeBlock('FOOT', $data);
} else {

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

    // READ DATA =======================================================
    $cards = $dbCards->listCards($PAGE, $CATEGORY1, $CATEGORY2);
    $data['N'] = 0;
    $total = count($cards);

    // info mostrant pàgines
    $data['ITEMS_TOTAL'] = $total;
    $data['ITEMS_INICI'] = ($data['ITEMS_TOTAL'] == 0) ? 0 : ($PAGE-1) *$CARDS_LISTLENGTH+1;
    $data['ITEMS_FI'] = $PAGE*$CARDS_LISTLENGTH;
    (($PAGE*$CARDS_LISTLENGTH) > $data['ITEMS_TOTAL']) ? $data['ITEMS_FI'] = $data['ITEMS_TOTAL'] : $data['ITEMS_FI'] = $PAGE*$CARDS_LISTLENGTH;

    // capçalera de la categoria
    $info_categoria = getInfoCategoria($CATEGORY2);
    $data['ID'] = $info_categoria['ID'];
    $data['NOM'] = $info_categoria['NOM'];
    $data['DESCRIPCIO'] = $info_categoria['DESCRIPCIO'];
    $data['IMATGE'] = ($info_categoria['IMATGE'] != '') ? '<img src="' . $CONFIG_URLUPLOADIM . '/' . $info_categoria['IMATGE'] . '" alt=""/>' : '<img src="' . $CONFIG_NOMCARPETA . '/media/comu/carpeta_fotos.jpg" alt=""/>';
    $data['N_ELEMENTS'] = cat_num_Items($ID_CARPETA, "category_id=" . $data['ID']) . ' items';

    // OUTPUT =====================================================
    $content.= $Tpl->mergeBlock('INDEX_LLISTAT_INTRO_CATEGORIA', $data);

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

        // IMATGE1

        if ($data['IMATGE1'] != '') {
            $data['IMATGE1'] = '<img src="' . $CONFIG_URLUPLOADIM . '/' . $data['IMATGE1'] . '" alt="' . $data['PEU_IMATGE1'] . '" />';
        }

        // OUTPUT ROW =====================================================
        $content.= $Tpl->mergeBlock('INDEX_LLISTAT_ROW', $data);
    }

    // OUTPUT PAGINADOR =====================================================
    $content.= $Tpl->mergeBlock('PAGINADOR', $data);

    // OUTPUT FOOT =====================================================
    $content.= $Tpl->mergeBlock('FOOT', $data);
}
echo phpEval($content);
?>
