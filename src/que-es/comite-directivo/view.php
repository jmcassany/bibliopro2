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
	foreach($card as $name => $value) { $data[$name] = $value; }

	// nom
	if ($data['TITOL'] != '') { $data['NOM'] = '<h4>' . htmlspecialchars($data['TITOL']) . '</h4>'; }
	else { $data['NOM'] = ''; }

	// càrrec
	if ($data['SUBTITOL'] != '') { $data['CARREC'] = '<h5>' . htmlspecialchars($data['SUBTITOL']) . '</h5>'; }
	else { $data['CARREC'] = ''; }

	// posició
	if ($data['AUTOR'] != '') { $data['POSICIO'] = '<h6>' . htmlspecialchars($data['AUTOR']) . '</h6>'; }
	else { $data['POSICIO'] = ''; }

	// descripció
	if ($data['DESCRIPCIO'] != '') { $data['DESCRIPCIO'] = '<div class="txt clearfix">' . $data['DESCRIPCIO'] . '</div>'; }

	// imatge membre
	if ($data['IMATGE1'] != '') {
		$data['IMATGE1'] = '<div class="image left"><img src="' . $CONFIG_NOMCARPETA . '/media/upload/gif/thumb-' . $data['IMATGE1'] . '" alt="" /></div>';
	}

	// logo ubicació membre
	if ($data['IMATGE2'] != '') {
		$data['IMATGE2'] = '<img src="' . $CONFIG_NOMCARPETA . '/media/upload/gif/thumb-' . $data['IMATGE2'] . '" alt="' . htmlspecialchars($data['PEU_IMATGE2']) . '" class="right" />';
	}

	// info addicional
	if ($data['ADJUNT1'] != '' or $data['LINK1'] != '') {
		$data['MAIL_SKETCH'] = '<ul class="memberInfo clearfix">';
		if ($data['LINK1'] != '') {
			$data['MAIL_SKETCH'] .= '<li class="email"><a href="mailto:' . htmlspecialchars($data['LINK1']) . '">Correo</a></li>';
		}
		if ($data['ADJUNT1'] != '') {
			$attLabel = ($data['TEXT_ADJUNT1'] != '') ? $data['TEXT_ADJUNT1'] : 'Biosketch';
			$data['MAIL_SKETCH'] .= '<li class="sketch"><a href="' . $CONFIG_NOMCARPETA . '/media/upload/pdf/' . $data['ADJUNT1'] . '">' . htmlspecialchars($attLabel) . '</a></li>';
		}
		$data['MAIL_SKETCH'] .= '</ul>';
	}
	else { $data['MAIL_SKETCH'] = ''; }

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