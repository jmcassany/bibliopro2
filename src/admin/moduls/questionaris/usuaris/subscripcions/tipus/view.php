<?php

	require ('../../../../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('tipus.php');

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

	// selector tipus entitat
	$data['SELECT_TIPO_ENTIDAD'] = '<select name="TIPO_ENTIDAD" id="TIPO_ENTIDAD">';
	switch ($data['TIPO_ENTIDAD']) {
		case 1: $data['SELECT_TIPO_ENTIDAD'] .= '<option value="1">Con ánimo de lucro</option>'; break;
		case 2: $data['SELECT_TIPO_ENTIDAD'] .= '<option value="2">Sin ánimo de lucro</option>'; break;
		case 3: $data['SELECT_TIPO_ENTIDAD'] .= '<option value="3">Académico</option>'; break;
		default: $data['SELECT_TIPO_ENTIDAD'] .= '<option value="">Indica el tipo de entidad</option>'; break;
	}
	if ($data['TIPO_ENTIDAD'] != 1) {
		$data['SELECT_TIPO_ENTIDAD'] .= '<option value="1">Con ánimo de lucro</option>';
	}
	if ($data['TIPO_ENTIDAD'] != 2) {
		$data['SELECT_TIPO_ENTIDAD'] .= '<option value="2">Sin ánimo de lucro</option>';
	}
	if ($data['TIPO_ENTIDAD'] != 3) {
		$data['SELECT_TIPO_ENTIDAD'] .= '<option value="3">Académico</option>';
	}
	$data['SELECT_TIPO_ENTIDAD'] .= '</select>';

	// passem tipus d'entitat a cadena
	switch ($data['TIPO_ENTIDAD']) {
		case 1: $data['TIPO_ENTIDAD'] = 'Con ánimo de lucro'; break;
		case 2: $data['TIPO_ENTIDAD'] = 'Sin ánimo de lucro'; break;
		case 3: $data['TIPO_ENTIDAD'] = 'Académica'; break;
		default: $data['TIPO_ENTIDAD'] = 'Desconocida'; break;
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