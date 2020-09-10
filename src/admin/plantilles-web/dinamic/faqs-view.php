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
	if ($data['TITOL'] != '') { $data['TITOL'] = '<h4>' . htmlspecialchars($data['TITOL']) . '</h4>'; }

	// categoria
	if ($data['CATEGORY2'] != 0) {

		if ($urlFriendly) {

			$data['CATEGORY'] = '<p class="category"><a href="cat/' . $data['CATEGORY2'] . '">' . htmlspecialchars(getNomCategoria($data['CATEGORY2'])) . '</a></p>';

		}
		else {

			$data['CATEGORY'] = '<p class="category"><a href="index.php?CATEGORY2=' . $data['CATEGORY2'] . '">' . htmlspecialchars(getNomCategoria($data['CATEGORY2'])) . '</a></p>';

		}

	}
	else { $data['CATEGORY'] = ''; }

	// elements relacionats
	if (
		$data['ADJUNT1'] != '' or
		$data['ADJUNT2'] != '' or
		$data['ADJUNT3'] != '' or
		$data['LINK1'] != '' or
		$data['LINK2'] != '' or
		$data['LINK3'] != ''
	) {

		$data['RELATED'] = '<div class="related clearfix">
						<h5><span>Enlaces relacionados</span></h5>
						<ul>';
		for ($k = 1; $k <= 3; $k++) {

			if ($data["ADJUNT$k"] != '') {

				$data['RELATED'] .= '<li class="doc"><a href="' . $CONFIG_URLUPLOADAD . '/' . $data["ADJUNT$k"] . '" rel="external">' . $data["TEXT_ADJUNT$k"] . '</a></li>';

			}

		}
		for ($k = 1; $k <= 3; $k++) {

			if ($data["LINK$k"] != '') {

				if ($data["FINESTRA$k"] == 1) {

					$data['RELATED'] .= '<li class="link"><a href="' . $data["LINK1"] . '" rel="external">' . $data["TEXTLINK$k"] . '</a></li>';

				}
				else {

					$data['RELATED'] .= '<li class="link"><a href="' . $data["LINK1"] . '">' . $data["TEXTLINK$k"] . '</a></li>';

				}

			}

		}
		$data['RELATED'] .= '</ul>
					</div>';

	}
	else { $data['RELATED'] = ''; }

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