<?php

	require ('../../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('descargables.php');

	// si no s'indica el qüestionari per als descarregables, mostrem error
	if (empty($_GET['ID_CUEST'])) {
		htmlPageBasicError('No s\'ha indicat cap qüestionari per a gestionar-ne els descarregables.');
	}

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

	$data['ID_CUEST'] = $_GET['ID_CUEST'];

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

	// només mostrem els tipus que no estiguin introduïts
	$checkQuery = db_query ("
		select TIPO
		from $CARDS_TABLE
		where ID_CUEST = '$_GET[ID_CUEST]'
	");
	$alreadyFilled = array();
	while ($checkRow = db_fetch_array($checkQuery)) { $alreadyFilled[] = $checkRow['TIPO']; }
	$data['SELECT_TIPO'] = '<select name="TIPO" id="TIPO">';
	$data['SELECT_TIPO'] .= '<option value="' . $data['TIPO'] . '">' . htmlspecialchars($TIPOS[$data['TIPO']]) . '</option>';
	foreach ($TIPOS as $i => $tipo) {
		if (array_search($i, $alreadyFilled) === false) {
			$data['SELECT_TIPO'] .= '<option value="' . $i . '">' . htmlspecialchars($tipo) . '</option>';
		}
	}
	$data['SELECT_TIPO'] .= '</select>';

	if ($data['VISIBLE'] == 1) { $data['VISIBLE_CHECKED'] = ' checked="checked"'; }
	if ($data['PROTEGIDO_LOGIN'] == 1) { $data['PROTEGIDO_CHECKED'] = ' checked="checked"'; }
	if ($data['SUBLICENCIA'] == 1) { $data['SUBLICENCIA_CHECKED'] = ' checked="checked"'; }

	// en cas d'haver-ni, mostrem el nom del fixer i l'enllacem
	if (!empty($data['FICHERO'])) {

		$data['LINK_FICHERO'] = '<p><a href="' . $CONFIG_URLUPLOADAD.'/descargables/'. htmlspecialchars($data['FICHERO']) . '">' . htmlentities($data['FICHERO']) . '</a> (omplint el camp el substitueix)</p>';

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