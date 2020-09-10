<?php

	require ('../../../config_admin.inc');
	accessGroupPermCheck('pagaments');

	require('donacions.php');

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

	// text mètode pagament
	$data['METODO_PAGO'] = $paymentMethods[$data['METODO_PAGO']];

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

	if (!empty($data['FACTURACION_PAIS'])) {

		$countrySelect = ", `$COUNTRIES_TABLE`.PAIS AS PAIS";
		$countryTable = ", `$COUNTRIES_TABLE`";
		$countryWhere = "AND `$COUNTRIES_TABLE`.ID = $data[FACTURACION_PAIS]";

	}
	else {

		$countrySelect = $countryTable = $countryWhere = '';

	}

	// obtenim nom, email usuari i pais si s'ha indicat
	$iQuery = db_query("
		SELECT
			`$USERS_TABLE`.NOMBRE AS NOMBRE,
			`$USERS_TABLE`.EMAIL AS EMAIL
			$countrySelect
		FROM
			`$USERS_TABLE`
			$countryTable
		WHERE
			`$USERS_TABLE`.ID = $data[ID_USUARIO]
			$countryWhere
	");
	if (db_num_rows($iQuery) > 0) {

		$iRow = db_fetch_array($iQuery);

		if (!empty($iRow['NOMBRE']) and !empty($iRow['EMAIL'])) {
			$data['USUARIO'] = $iRow['NOMBRE'] . ' (' . $iRow['EMAIL'] . ')';
		}
		else {
			$data['USUARIO'] = 'Anònim';
		}
		$data['FACTURACION_PAIS'] = !empty($data['FACTURACION_PAIS']) ? $iRow['PAIS'] : 'No indicado';

	}
	else {

		$data['USUARIO'] = 'Anònim';
		$data['FACTURACION_PAIS'] = 'No indicado';

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