<?php

	include_once ("config.inc"); // Cards Configuration
	include_once ('funcions_cat.inc');

	// gestió usuaris
	$LOGIN_page = $CONFIG_NOMCARPETA.'/login.php';
	$rutainc = $CONFIG_PATHPHP."/gestio_usuaris.php";
	include_once($rutainc);

	// tipo d'ordre
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
// 	if ($CATEGORY2 == '0') {
// 		$CARDS_LISTFILTER.= " AND (CATEGORY2='0')";
// 	}

	// ------------------
	// CARDS INSTANTATION
	// ------------------
	$dbCards = new dbCards($CARDS_TABLE);
	if (!$dbCards->Ok) {
		redirectTo($CONFIG_NOMCARPETA.'/404.html');
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
		redirectTo($CONFIG_NOMCARPETA.'/404.html');
		exit;
	}

	// ------------------
	// CONTENT MERGING
	// ------------------
	unset($data);

	// NAVEGATION DATA ==================================================
	if (($pages = $dbCards->countCardPages($CATEGORY1, $CATEGORY2)) > 1) {
		$data['PAGELIST'] = '<div class="pager clearfix">' . pager($pages) . '</div>';
	}
	else { $data['PAGELIST'] = ''; }

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

	$data['RUTA'] = $pathEditora;

	// READ DATA =======================================================
	if ($CATEGORY2 != 0 && cat_te_Descendents($CATEGORY2)) {
		$cards = $dbCards->listCards($PAGE, $CATEGORY1, 0);
		$data['ITEMS_TOTAL'] = $dbCards->countCards($CATEGORY1, 0);
	} else {
		$cards = $dbCards->listCards($PAGE, $CATEGORY1, $CATEGORY2);
		$data['ITEMS_TOTAL'] = $dbCards->countCards($CATEGORY1, $CATEGORY2);
	}

	$data['N'] = 0;
	$total = count($cards);

	$data['ITEMS_INICI'] = ($data['ITEMS_TOTAL'] == 0) ? 0 : ($PAGE-1) *$CARDS_LISTLENGTH+1;
	$data['ITEMS_FI'] = $PAGE*$CARDS_LISTLENGTH;
	(($PAGE*$CARDS_LISTLENGTH) > $data['ITEMS_TOTAL']) ? $data['ITEMS_FI'] = $data['ITEMS_TOTAL'] : $data['ITEMS_FI'] = $PAGE*$CARDS_LISTLENGTH;

	// OUTPUT HEAD =====================================================
	$content = $Tpl->mergeBlock('HEAD', $data);

	for ($i = 0;$i < $total;$i++) {

		$data['N'] = 1+$i+($PAGE-1) *$CARDS_LISTLENGTH;

		foreach($cards[$i] as $name => $value) {
			// Les dades en brut de tots els camps
			$data[$name] = $value;
		}

		$idnow = $data['ID'];

		$data['TITOL'] = '<h4>' . htmlspecialchars($data['TITOL']) . '</h4>';

		// imatge patrocinador
		if ($data['IMATGE1'] != '') {
			if (!empty($data['LINK1'])) {
				$data['IMATGE1'] = '<a href="' . htmlspecialchars($data["LINK1"]) . '" rel="external" title="' . htmlspecialchars($data["TEXTLINK1"]) . '"><img src="' . $CONFIG_URLUPLOADIM . '/thumb-' . $data['IMATGE1'] . '" alt="" class="right" /></a>';
			}
			else {
				$data['IMATGE1'] = '<img src="' . $CONFIG_URLUPLOADIM . '/' . $data['IMATGE1'] . '" alt="" class="right" />';
			}
		}

		// OUTPUT ROW =====================================================
		$content .= $Tpl->mergeBlock('ROW', $data);

	}

	// OUTPUT FOOT =====================================================
	$content .= $Tpl->mergeBlock('FOOT', $data);

	echo phpEval($content);

?>