<?php

	require ('../../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('subllicencies.php');

	// si no s'indica el qüestionari, mostrem error
	if (empty($_GET['ID'])) {
		htmlPageBasicError('No s\'ha indicat cap qüestionari per a gestionar-ne la informació legal.');
	}
	$ID = $_GET['ID'];

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
   $Tpl->scanFile("view$SKIN.tpl");

   // Si hi ha cap problema -> Error
   if (!$Tpl->Ok) { echo "<B>Error: No se ha encontrado la plantilla 'edit.tpl'.</B><br>\n"; exit; }

	// ------------------
	// CONTENT MERGING
	// ------------------
   unset($data);

	// comprovem si ja existeix una subllicència pel qüestionari
	if ($card != false) { $data['ACCIO_FORM'] = 'update'; }
	else { $data['ACCIO_FORM'] = 'create'; }
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
	$data['ID'] = $ID;

	$data['EDITOR_HEAD'] = editor_head();
	$data['EDITOR_TEXT'] = editor_entry('TEXT', $data['TEXT'],'Antaviana');
	//fi

	// estat aut. original
	$data['SELECT_AUT_ORIGINAL'] = '<select name="ESTADO_AUT_ORIGINAL" id="ESTADO_AUT_ORIGINAL">';
	if (!empty($data['ESTADO_AUT_ORIGINAL'])) {
		$data['SELECT_AUT_ORIGINAL'] .= '<option value="' . $data['ESTADO_AUT_ORIGINAL'] . '">' . htmlspecialchars($authorizationStatuses[$data['ESTADO_AUT_ORIGINAL']]) . '</option>';
	}
	foreach ($authorizationStatuses as $i => $status) {
		if (!isset($data['ESTADO_AUT_ORIGINAL']) or $i != $data['ESTADO_AUT_ORIGINAL']) {
			$data['SELECT_AUT_ORIGINAL'] .= '<option value="' . $i . '">' . htmlspecialchars($status) . '</option>';
		}
	}
	$data['SELECT_AUT_ORIGINAL'] .= '</select>';

	// estat aut. adaptació
	$data['SELECT_AUT_ADAPTACION'] = '<select name="ESTADO_AUT_ADAPTACION" id="ESTADO_AUT_ADAPTACION">';
	if (!empty($data['ESTADO_AUT_ADAPTACION'])) {
		$data['SELECT_AUT_ADAPTACION'] .= '<option value="' . $data['ESTADO_AUT_ADAPTACION'] . '">' . htmlspecialchars($authorizationStatuses[$data['ESTADO_AUT_ADAPTACION']]) . '</option>';
	}
	foreach ($authorizationStatuses as $i => $status) {
		if (!isset($data['ESTADO_AUT_ADAPTACION']) or $i != $data['ESTADO_AUT_ADAPTACION']) {
			$data['SELECT_AUT_ADAPTACION'] .= '<option value="' . $i . '">' . htmlspecialchars($status) . '</option>';
		}
	}
	$data['SELECT_AUT_ADAPTACION'] .= '</select>';

	// tipus autorització
	$data['SELECT_TIPO_AUT'] = '<select name="TIPO_AUT" id="TIPO_AUT">';
	if (!empty($data['TIPO_AUT'])) {
		$data['SELECT_TIPO_AUT'] .= '<option value="' . $data['TIPO_AUT'] . '">' . htmlspecialchars($authorizationTypes[$data['TIPO_AUT']]) . '</option>';
	}
	foreach ($authorizationTypes as $i => $type) {
		if (!isset($data['TIPO_AUT']) or $i != $data['TIPO_AUT']) {
			$data['SELECT_TIPO_AUT'] .= '<option value="' . $i . '">' . htmlspecialchars($type) . '</option>';
		}
	}
	$data['SELECT_TIPO_AUT'] .= '</select>';

	if ($data['SUBLICENCIA_BIBLIOPRO'] == 1) { $data['SUBLICENCIA_BIBLIOPRO_CHECKED'] = ' checked="checked"'; }

	// en cas d'haver-ni, mostrem el nom del fixer i l'enllacem
	if (!empty($data['FICHERO_CONTRATO'])) {

		$data['LINK_FICHERO_CONTRATO'] = '<p><a href="' . $CONFIG_URLUPLOADAD.'/contratos/'. htmlspecialchars($data['FICHERO_CONTRATO']) . '">' . htmlentities($data['FICHERO_CONTRATO']) . '</a> (omplint el camp el substitueix) <label for="FICHERO_SUBLICENCIA_ELIMINAR"><input type="checkbox" name="FICHERO_SUBLICENCIA_ELIMINAR" id="FICHERO_SUBLICENCIA_ELIMINAR" /> Eliminar</label></p>';

	}

	// en cas d'haver-ni, mostrem el nom del fixer i l'enllacem
	if (!empty($data['FICHERO_SUBLICENCIA'])) {

		$data['LINK_FICHERO_SUBLICENCIA'] = '<p><a href="' . $CONFIG_URLUPLOADAD.'/sublicencias/'. htmlspecialchars($data['FICHERO_SUBLICENCIA']) . '">' . htmlentities($data['FICHERO_SUBLICENCIA']) . '</a> (omplint el camp el substitueix) <label for="FICHERO_SUBLICENCIA_ELIMINAR"><input type="checkbox" name="FICHERO_SUBLICENCIA_ELIMINAR" id="FICHERO_SUBLICENCIA_ELIMINAR" /> Eliminar</label></p>';

	}

	if ($data['VISIBLE_WEB'] == 1) { $data['VISIBLE_CHECKED'] = ' checked="checked"'; }
	else { $data['VISIBLE_CHECKED'] = ''; }

	$data['EDITOR_ACEPTACION'] = editor_entry('TEXTO_ACEPTACION', $data['TEXTO_ACEPTACION'],'Antaviana');
	$data['EDITOR_EXPLICACION'] = editor_entry('EXPLICACION_SOLICITACION', $data['EXPLICACION_SOLICITACION'],'Antaviana');

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