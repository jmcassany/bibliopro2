<?php

	require ('../../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('usuaris.php');

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

	// tipus entitat
	$data['SELECT_TIPO_ENTIDAD'] = '<select name="TIPO_ENTIDAD" id="TIPO_ENTIDAD">';
	switch ($data['TIPO_ENTIDAD']) {
		case 1:
			$data['SELECT_TIPO_ENTIDAD'] .= '<option value="1">Con ánimo de lucro</option>';
			$data['TIPO_ENTIDAD'] .= 'Con ánimo de lucro';
			break;
		case 2:
			$data['SELECT_TIPO_ENTIDAD'] .= '<option value="2">Sin ánimo de lucro</option>';
			$data['TIPO_ENTIDAD'] .= 'Sin ánimo de lucro';
			break;
		case 3:
			$data['SELECT_TIPO_ENTIDAD'] .= '<option value="3">Académico</option>';
			$data['TIPO_ENTIDAD'] .= 'Académico';
			break;
		default:
			$data['SELECT_TIPO_ENTIDAD'] .= '<option value="">Indica el tipo de entidad</option>';
			$data['TIPO_ENTIDAD'] .= 'Desconocido';
			break;
	}
// 	if ($data['TIPO_ENTIDAD'] != 1) {
// 		$data['SELECT_TIPO_ENTIDAD'] .= '<option value="1">Con ánimo de lucro</option>';
// 	}
// 	if ($data['TIPO_ENTIDAD'] != 2) {
// 		$data['SELECT_TIPO_ENTIDAD'] .= '<option value="2">Sin ánimo de lucro</option>';
// 	}
// 	if ($data['TIPO_ENTIDAD'] != 3) {
// 		$data['SELECT_TIPO_ENTIDAD'] .= '<option value="3">Académico</option>';
// 	}
	$data['SELECT_TIPO_ENTIDAD'] .= '</select>';

	// pais
	$countries = array();
	$countriesQuery = db_query("SELECT ID, PAIS FROM `$COUNTRIES_TABLE` ORDER BY PAIS ASC");
	if (db_num_rows($countriesQuery) > 0) {

		while ($countriesRow = db_fetch_array($countriesQuery)) { $countries[$countriesRow['ID']] = $countriesRow['PAIS']; }

	}
	$data['SELECT_PAIS'] = '<select name="PAIS" id="PAIS">';
	$data['SELECT_PAIS'] .= '<option value="' . $data['PAIS'] . '">' . $countries[$data['PAIS']] . '</option>';
	foreach ($countries as $countryID => $country) {
		if ($countryID != $data['PAIS']) {
			$data['SELECT_PAIS'] .= '<option value="' . $countryID . '">' . $country . '</option>';
		}
	}
	if ($data['PAIS'] != 0) { $data['SELECT_PAIS'] .= '<option value="0">Otro</option>'; }
	$data['SELECT_PAIS'] .= '</select>';
	// literal
	$data['PAIS'] = $countries[$data['PAIS']];

	if ($data['OTRO_PAIS'] == '1') {
		$data['OTRO_PAIS'] = 'Sí';
	}
	else {
		$data['OTRO_PAIS'] = 'No';
	}

	// tipus centre treball
	$data['SELECT_TIPO_CENTRO_TRABAJO'] = '<select name="TIPO_CENTRO_TRABAJO" id="TIPO_CENTRO_TRABAJO">';
	$data['SELECT_TIPO_CENTRO_TRABAJO'] .= '<option value="' . $data['TIPO_CENTRO_TRABAJO'] . '">' . $workCenterTypes[$data['TIPO_CENTRO_TRABAJO']] . '</option>';
	foreach ($workCenterTypes as $workCenterTypeID => $workCenterType) {
		if ($workCenterTypeID != $data['TIPO_CENTRO_TRABAJO']) {
			$data['SELECT_TIPO_CENTRO_TRABAJO'] .= '<option value="' . $workCenterTypeID . '">' . htmlspecialchars($workCenterType) . '</option>';
		}
	}
	$data['SELECT_TIPO_CENTRO_TRABAJO'] .= '</select>';
	// literal
	$data['TIPO_CENTRO_TRABAJO'] = $workCenterTypes[$data['TIPO_CENTRO_TRABAJO']];

	// pais facturació
	$data['SELECT_PAIS_FACTURACIO'] = '<select name="FACTURACION_PAIS" id="FACTURACION_PAIS">';
	$data['SELECT_PAIS_FACTURACIO'] .= '<option value="' . $data['FACTURACION_PAIS'] . '">' . $countries[$data['FACTURACION_PAIS']] . '</option>';
	foreach ($countries as $countryID => $country) {
		if ($countryID != $data['FACTURACION_PAIS']) {
			$data['SELECT_PAIS_FACTURACIO'] .= '<option value="' . $countryID . '">' . $country . '</option>';
		}
	}
	if ($data['FACTURACION_PAIS'] != 0) { $data['SELECT_PAIS_FACTURACIO'] .= '<option value="0">Otro</option>'; }
	$data['SELECT_PAIS_FACTURACIO'] .= '</select>';
	// literal
	$data['FACTURACION_PAIS'] = $countries[$data['FACTURACION_PAIS']];

	if ($data['FACTURACION_OTRO_PAIS'] == '1') {
		$data['FACTURACION_OTRO_PAIS'] = 'Sí';
	}
	else {
		$data['FACTURACION_OTRO_PAIS'] = 'No';
	}

	if ($data['FACTURACION_PROFESIONAL'] == '1') {
		$data['FACTURACION_PROFESIONAL'] = 'Sí';
	}
	else {
		$data['FACTURACION_PROFESIONAL'] = 'No';
	}

	// newsletter (sí/no)
	if ($data['NEWSLETTER'] == 1) { $data['NEWSLETTER_CHECKED'] = ' checked="checked"'; }

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