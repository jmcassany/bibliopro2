<?php

	require ('../../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('descargables.php');

	// si no s'indica el qüestionari per als descarregables, mostrem error
	if (empty($_GET['ID_CUEST'])) {
		htmlPageBasicError('No s\'ha indicat cap qüestionari per a gestionar-ne els descarregables.');
	}

	// si no queda cap tipus de descarregable lliure, mostrem error
	$checkQuery = db_query ("
		select TIPO
		from $CARDS_TABLE
		where ID_CUEST = '$_GET[ID_CUEST]'
	");
	if (db_num_rows($checkQuery) == 8) {
		htmlPageBasicError('Ja s\'han introduït tots els tipus de descarregable possibles per al qüestionari indicat.');
	}

	// --------------------
	// PARAMETERS FILTERING
	// --------------------
	if (empty($LANG))  { $LANG=$DEFAULT_LANG; }
	if (empty($ECLASS)) { $ECLASS=$DEFAULT_ECLASS; }
	$SKIN = $DEFAULT_SKIN;

	// -----------------
	// TEMPLATE SCANNING
	// -----------------
	// Create and define Template
	$Tpl = new awTemplate();
	$Tpl->scanFile("view$SKIN.tpl");
	// Si hi ha cap problema -> Error
	if (!$Tpl->Ok) { echo "<B>Error: No se ha encontrado la plantilla 'edit.tpl'.</B><br>\n"; exit; }

	// ------------------
	// CONTENT MERGING
	// ------------------
	unset($data);

	$data['ACCIO_FORM'] = 'create';
	$data['CONFIG_URLADMIN'] = $CONFIG_URLADMIN;

	// GENERAL DATA =====================================================
	$data['LANG'] = $LANG;
	$data['ECLASS'] = $ECLASS;
	$data['ECLASS_X'] = ITEMS_GetValue( 'CARDS_ECLASS', $ECLASS, $LANG );
	$data['SELECT_ECLASS'] = ITEMS_HTMLSelect( 'ECLASS', 'CARDS_ECLASS', $DEFAULT_SKIN, $LANG);

	$data['METAS'] = htmlMetas();

	$data['ID_CUEST'] = $_GET['ID_CUEST'];

	// CURRENT CARD DATA ================================================
	// Creem el SELECT pels CUSTOM de tipus ITEM
	foreach ($CARDS_FIELDS as $name=>$field) {
		list ($scope, $type, $style) = $field;
		if ($scope=='CUSTOM' && $type=='ITEM') {
			$data['SELECT_'.$name] = ITEMS_HTMLSelect( $name, $style, '', $LANG);
		}
	}

	$data['MODIFICAT']="";

	// només mostrem els tipus que no estiguin introduïts
	while ($checkRow = db_fetch_array($checkQuery)) { $alreadyFilled[] = $checkRow['TIPO']; }
	$data['SELECT_TIPO'] = '<select name="TIPO" id="TIPO">';
	foreach ($TIPOS as $i => $tipo) {
		if (array_search($i, $alreadyFilled) === false) {
			$data['SELECT_TIPO'] .= '<option value="' . $i . '">' . htmlspecialchars($tipo) . '</option>';
		}
	}
	$data['SELECT_TIPO'] .= '</select>';

	$data['AVUI'] = date('Y-m-d H:i:s', time());
	$data['USUARI']=accessGetLogin();

	//CODI HTML CAPCELERA
	$data['CAPCELERA'] = htmlHeader();
	//CODI HTML PEU
	$data['PEU'] = htmlFoot();

	// OUTPUT ALL
	echo $Tpl->mergeBlock('ALL',$data);

	// OUTPUT BLOCS
	//echo $Tpl->mergeBlock('HEAD',$data);
	//if (isset($data['RECIPETITLE'])) { echo $Tpl->mergeBlock('RECIPE',$data); }
	// echo $Tpl->mergeBlock('FOOT',$data);

?>