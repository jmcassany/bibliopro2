<?php

	require ('../../../config_admin.inc');
	accessGroupPermCheck('pagaments');

	require('subllicencies.php');

	error_reporting (E_ALL);

	// --------------------
	// PARAMETERS FILTERING
	// --------------------
	if (empty($LANG))  { $LANG=$DEFAULT_LANG; }
	if (empty($ECLASS)) { $ECLASS=$DEFAULT_ECLASS; }
	if (!isset($SKIN))  { $SKIN=$DEFAULT_SKIN; }

	if (empty($ID)) { echo "<B>Error: No se ha recibido el codigo de card.</B><br>\n"; exit; }

	// ------------------
	// CARDS INSTANTATION
	// ------------------
	 $dbCards = new dbCards($CARDS_TABLE);
	 if (!$dbCards->Ok) { echo "<B>Error: No se ha podido crear dbCards.</B><br>\n"; exit; }

	// -----------------
	// DATA READING
	// -----------------
	 // Llegim les dades
	 $card = $dbCards->readCard($ID);

	// -----------------
	// TEMPLATE SCANNING
	// -----------------
	 // Si no ens la donen a l'url o config -> utilitzem la individual
	 if (!isset($SKIN))  { $SKIN = $card['SKIN']; }

	 // Create and define Template
	 $Tpl = new awTemplate();
	 $Tpl->scanFile("view0.tpl");

	 // Si hi ha cap problema -> Error
	 if (!$Tpl->Ok) { echo "<B>Error: No se ha encontrado la plantilla 'edit.tpl'.</B><br>\n"; exit; }

	// ------------------
	// CONTENT MERGING
	// ------------------
	 unset($data);

	 $data['ACCIO_FORM'] = 'update';
	 $data['CONFIG_URLADMIN'] = $CONFIG_URLADMIN;

	 // GENERAL DATA =====================================================
	 $data['LANG'] = $LANG;
	 $data['ECLASS'] = $ECLASS;
	 $data['ECLASS_X'] = ITEMS_GetValue( 'CARDS_ECLASS', $ECLASS, $LANG );
	 $data['SELECT_ECLASS'] = ITEMS_HTMLSelect( 'ECLASS', 'CARDS_ECLASS', $DEFAULT_SKIN, $LANG);

	 // CURRENT CARD DATA ================================================
	// Generem totes les dades de cada un dels camps
	foreach ($card as $name=>$value) {

		// Les dades en brut de tots els camps
		$data[$name] = strip_tags($value);

		// Filtrem només els camps definits
		if (!isset($CARDS_FIELDS[$name])) { continue; }
		$type = $CARDS_FIELDS[$name][1];

		// Generem les ampliades dels tipus necesaris
		if ($type=='NUMBER') { $data = $dbCards->GenerateData($data, $name, $value); }
		else if ($type=='CHAR')   { $data = $dbCards->GenerateData($data, $name, filtreQuote($value)); }
		else if ($type=='DATE')   { $data = $dbCards->GenerateData($data, $name, $value); }
		else if ($type=='FLAG')   { $data = $dbCards->GenerateData($data, $name, $value); }
		else if ($type=='ITEM')   { $data = $dbCards->GenerateData($data, $name, $value); }
		else if ($type=='TEXT')   { $data = $dbCards->GenerateData($data, $name, $value); }
		else if ($type=='FILE')   { $data = $dbCards->GenerateData($data, $name, $value); }
		else if ($type=='IMAGE')  { $data = $dbCards->GenerateData($data, $name, $value); }
	}

	$data['AVUI'] = date('Y-m-d H:i:s', time());
	$data['USUARI']=accessGetLogin();

	// estat subscripció
	$data['SELECT_STATUS'] = '<select name="STATUS" id="STATUS">';
	if (isset($data['STATUS'])) {
		$data['SELECT_STATUS'] .= '<option value="' . $data['STATUS'] . '">' . htmlentities($status[$data['STATUS']], ENT_NOQUOTES, 'UTF-8') . '</option>';
	}
	foreach ($status as $i => $st) {
		if (!isset($data['STATUS']) or $i != $data['STATUS']) {
			$data['SELECT_STATUS'] .= '<option value="' . $i . '">' . htmlentities($st, ENT_NOQUOTES, 'UTF-8') . '</option>';
		}
	}
	$data['SELECT_STATUS'] .= '</select>';

	// activació subscripció
	$data['SELECT_OTORGADA'] = '<select name="OTORGADA" id="OTORGADA">';
	if (isset($data['OTORGADA'])) {
		$data['SELECT_OTORGADA'] .= '<option value="' . $data['OTORGADA'] . '">' . htmlentities($atorgada[$data['OTORGADA']], ENT_NOQUOTES, 'UTF-8') . '</option>';
	}
	foreach ($atorgada as $i => $st) {
		if (!isset($data['OTORGADA']) or $i != $data['OTORGADA']) {
			$data['SELECT_OTORGADA'] .= '<option value="' . $i . '">' . htmlentities($st, ENT_NOQUOTES, 'UTF-8') . '</option>';
		}
	}
	$data['SELECT_OTORGADA'] .= '</select>';

	// text financiació
	if (!empty($data['FINANCIACION_ENTIDAD'])) {
		$data['FINANCIACION_ENTIDAD'] = $financementTypes[$data['FINANCIACION_ENTIDAD']];
	}
	else {
		$data['FINANCIACION_ENTIDAD'] = 'Desconocido';
	}

	// text mètode pagament
	if (!empty($data['METODO_PAGO'])) {
		$data['METODO_PAGO'] = $paymentMethods[$data['METODO_PAGO']];
	}
	else {
		$data['METODO_PAGO'] = 'Innecessari';
	}

	// sol·licita factura?
	$data['SOLICITA_FACTURA'] = $data['SOLICITA_FACTURA'] == 0 ? 'No' : 'Sí';

	// empresario o profesional?
	$data['FACTURACION_PROFESIONAL'] = $data['FACTURACION_PROFESIONAL'] == 0 ? 'No' : 'Sí';

	// canàries, ceuta o melilla?
	$data['FACTURACION_OTRO_PAIS'] = $data['FACTURACION_OTRO_PAIS'] == 0 ? 'No' : 'Sí';

	// en cas d'haver-ni, mostrem el nom del fixer i l'enllacem
	if (!empty($data['FICHERO_FACTURA'])) {

		$data['LINK_FICHERO_FACTURA'] = '<p><a href="' . $CONFIG_URLUPLOADAD.'/facturas/'. htmlspecialchars($data['FICHERO_FACTURA']) . '">' . htmlentities($data['FICHERO_FACTURA']) . '</a> (omplint el camp el substitueix)</p>';

	}

	$data['EDITOR_COMENTARIOS_INTERNOS'] = editor_entry('COMENTARIOS_INTERNOS', $data['COMENTARIOS_INTERNOS'],'Antaviana');

	// document d'atorgació
	if ($data['FECHA_OTORGADA'] and $data['FECHA_OTORGADA'] != '0000-00-00 00:00:00') {
		$data['DOCUMENT_ATORGACIO'] = '<a href="' . $CONFIG_NOMCARPETA . '/media/upload/pdf/sublicencias-atorgadas/' . $data['NUM_ALBARAN'] . '.pdf">Veure</a>';
	} else {
		$data['DOCUMENT_ATORGACIO'] = 'No otorgada';
	}

	if (!empty($data['FACTURACION_PAIS'])) {

		$countrySelect = ", `$COUNTRIES_TABLE`.PAIS AS PAIS";
		$countryTable = ", `$COUNTRIES_TABLE`";
		$countryWhere = "AND `$COUNTRIES_TABLE`.ID = $data[FACTURACION_PAIS]";

	}
	else {

		$countrySelect = $countryTable = $countryWhere = '';

	}

	if (!empty($data['ENFERMEDAD'])) {

		$illnessSelect = ", `$ILLNESS_TABLE`.VALOR AS ENFERMEDAD";
		$illnessTable = ", `$ILLNESS_TABLE`";
		$illnessWhere = "AND `$ILLNESS_TABLE`.ID = $data[ENFERMEDAD]";

	}
	else {

		$illnessSelect = $illnessTable = $illnessWhere = '';

	}

	// obtenim email usuari, nom qüestionari, nom enfermetat o símptoma i pais fact.
	$iQuery = db_query("
		SELECT
			`$USERS_TABLE`.NOMBRE AS NOMBRE,
			`$USERS_TABLE`.EMAIL AS EMAIL,
			`$QUESTIONNAIRES_TABLE`.NOM_CAST AS NOM_CAST
			$illnessSelect
			$countrySelect
		FROM
			`$USERS_TABLE`,
			`$QUESTIONNAIRES_TABLE`
			$illnessTable
			$countryTable
		WHERE
			`$USERS_TABLE`.ID = $data[ID_USUARIO]
			AND `$QUESTIONNAIRES_TABLE`.ID = $data[ID_CUEST]
			$illnessWhere
			$countryWhere
	");
	$iRow = db_fetch_array($iQuery);
	$data['USUARIO'] = $iRow['NOMBRE'] . ' (' . $iRow['EMAIL'] . ')';
	$data['CUESTIONARIO'] = $iRow['NOM_CAST'];
	$data['FACTURACION_PAIS'] = !empty($data['FACTURACION_PAIS']) ? $iRow['PAIS'] : 'No indicado';
	$data['ENFERMEDAD'] = !empty($data['ENFERMEDAD']) ? $iRow['ENFERMEDAD'] : 'No indicado';

	// obtenim preguntes i respostes que l'usuari hagi indicat
	if (!empty($data['PREGUNTAS'])) {

		$questions = unserialize($data['PREGUNTAS']);
		if (is_array($questions) and count($questions) > 0) {

			$data['RESPUESTAS'] = '<TR>';

			foreach ($questions as $questionID => $answers) {

				if (is_array($answers) and count($answers) > 0) {

					// get question text
					$questionQuery = db_query("
						SELECT PREGUNTA FROM `$QUESTIONS_TABLE`
						WHERE ID = '$questionID'
					");
					$questionRow = db_fetch_array($questionQuery);

					$data['RESPUESTAS'] .= '<TD colspan="2">';
					$data['RESPUESTAS'] .= '<P>' . htmlspecialchars($questionRow['PREGUNTA']) . '</P>';
					$data['RESPUESTAS'] .= '<UL>';
					foreach ($answers as $answerID) {
						// get question text
						$answerQuery = db_query("
							SELECT RESPUESTA FROM `$ANSWERS_TABLE`
							WHERE ID = '$answerID'
						");
						$answerRow = db_fetch_array($answerQuery);
						$data['RESPUESTAS'] .= '<LI>' . htmlspecialchars($answerRow['RESPUESTA']) . '</LI>';
					}
					$data['RESPUESTAS'] .= '</UL>';
					$data['RESPUESTAS'] .= '</TD>';

				}

			}

			$data['RESPUESTAS'] .= '</TR>';

		}

	}

	//CODI HTML CAPCELERA
	$data['CAPCELERA'] = htmlHeader();
	//CODI HTML PEU
	$data['PEU'] = htmlFoot();

	$data['METAS'] = htmlMetas();

	// OUTPUT ALL
	echo $Tpl->mergeBlock('ALL',$data);

	// OUTPUT BLOCS
	//echo $Tpl->mergeBlock('HEAD',$data);
	//if (isset($data['RECIPETITLE'])) { echo $Tpl->mergeBlock('RECIPE',$data); }
	// echo $Tpl->mergeBlock('FOOT',$data);

?>