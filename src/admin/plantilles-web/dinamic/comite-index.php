<?php

	include_once ("config.inc"); // Cards Configuration

	// gestió usuaris
	$LOGIN_page = $CONFIG_NOMCARPETA.'/login.php';
	$rutainc = $CONFIG_PATHPHP."/gestio_usuaris.php";
	include_once($rutainc);

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
	$data['PAGELIST'] = pager($dbCards->countCardPages($CATEGORY1, $CATEGORY2));

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
			$data[$name] = $value;
		}

		$idnow = $data['ID'];

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
			$data['IMATGE1'] = '<div class="image left"><img src="' . $CONFIG_URLUPLOADIM . '/thumb-' . $data['IMATGE1'] . '" alt="" /></div>';
		}

		// logo ubicació membre
		if ($data['IMATGE2'] != '') {
			$data['IMATGE2'] = '<img src="' . $CONFIG_URLUPLOADIM . '/thumb-' . $data['IMATGE2'] . '" alt="' . htmlspecialchars($data['PEU_IMATGE2']) . '" class="right" />';
		}

		// info addicional
		if ($data['ADJUNT1'] != '' or $data['LINK1'] != '') {
			$data['MAIL_SKETCH'] = '<ul class="memberInfo clearfix">';
			if ($data['LINK1'] != '') {
				$data['MAIL_SKETCH'] .= '<li class="email"><a href="mailto:' . htmlspecialchars($data['LINK1']) . '">Correo</a></li>';
			}
			if ($data['ADJUNT1'] != '') {
				$attLabel = ($data['TEXT_ADJUNT1'] != '') ? $data['TEXT_ADJUNT1'] : 'Biosketch';
				$data['MAIL_SKETCH'] .= '<li class="sketch"><a href="' . $CONFIG_URLUPLOADAD . '/' . $data['ADJUNT1'] . '">' . htmlspecialchars($attLabel) . '</a></li>';
			}
			$data['MAIL_SKETCH'] .= '</ul>';
		}
		else { $data['MAIL_SKETCH'] = ''; }

		// OUTPUT ROW =====================================================
		$content .= $Tpl->mergeBlock('ROW', $data);

	}

	// OUTPUT FOOT =====================================================
	$content .= $Tpl->mergeBlock('FOOT', $data);

	echo phpEval($content);

?>