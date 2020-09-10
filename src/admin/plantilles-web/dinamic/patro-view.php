<?php

	include_once ("config.inc"); // Cards Configuration

	// gestió usuaris
	$LOGIN_page = $CONFIG_NOMCARPETA.'/login.php';
	$rutainc = $CONFIG_PATHPHP."/gestio_usuaris.php";
	include_once($rutainc);

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
		exit;
	}

// 	if (empty($CATEGORY1)) {
// 		$CATEGORY1 = '';
// 	} // No filtre CATEGORY1
// 	if (empty($CATEGORY2)) {
// 		$CATEGORY2 = '0';
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

	$data['CONFIG_NOMCARPETA'] = $CONFIG_NOMCARPETA;

	$data['RUTA'] = $pathEditora;

	// CURRENT CARD DATA ================================================
	// Generem totes les dades de cada un dels camps
	foreach($card as $name => $value) { $data[$name] = $value; }

	// nom
	if ($data['TITOL'] != '') { $data['TITOL'] = '<h4 class="news">' . htmlspecialchars($data['TITOL']) . '</h4>'; }

	// imatge patrocinador
	if ($data['IMATGE1'] != '') {
		if (!empty($data['LINK1'])) {
			$data['IMATGE1'] = '<a href="' . htmlspecialchars($data["LINK1"]) . '" rel="external" title="' . htmlspecialchars($data["TEXTLINK1"]) . '"><img src="' . $CONFIG_URLUPLOADIM . '/thumb-' . $data['IMATGE1'] . '" alt="" class="right" /></a>';
		}
		else {
			$data['IMATGE1'] = '<img src="' . $CONFIG_URLUPLOADIM . '/' . $data['IMATGE1'] . '" alt="" class="right" />';
		}
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