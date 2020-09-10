<?php

	require ('../../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('usuaris.php');

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

	// CURRENT CARD DATA ================================================
	// Creem el SELECT pels CUSTOM de tipus ITEM
	foreach ($CARDS_FIELDS as $name=>$field) {
		list ($scope, $type, $style) = $field;
		if ($scope=='CUSTOM' && $type=='ITEM') {
			$data['SELECT_'.$name] = ITEMS_HTMLSelect( $name, $style, '', $LANG);
		}
	}

	$data['MODIFICAT']="";

	$data['AVUI'] = date('Y-m-d H:i:s', time());
	$data['USUARI']=accessGetLogin();

	// tipus entitat
	$data['SELECT_TIPO_ENTIDAD'] = '<select name="TIPO_ENTIDAD" id="TIPO_ENTIDAD">';
	$data['SELECT_TIPO_ENTIDAD'] .= '<option value="1">Con ánimo de lucro</option>';
	$data['SELECT_TIPO_ENTIDAD'] .= '<option value="2">Sin ánimo de lucro</option>';
	$data['SELECT_TIPO_ENTIDAD'] .= '<option value="3">Académico</option>';
	$data['SELECT_TIPO_ENTIDAD'] .= '</select>';

	// pais
	$countries = array();
	$countriesQuery = db_query("SELECT ID, PAIS FROM `$COUNTRIES_TABLE` ORDER BY PAIS ASC");
	if (db_num_rows($countriesQuery) > 0) {

		while ($countriesRow = db_fetch_array($countriesQuery)) { $countries[$countriesRow['ID']] = $countriesRow['PAIS']; }

	}
	$data['SELECT_PAIS'] = '<select name="PAIS" id="PAIS">';
	foreach ($countries as $countryID => $country) {
		$data['SELECT_PAIS'] .= '<option value="' . $countryID . '">' . $country . '</option>';
	}
	$data['SELECT_PAIS'] .= '<option value="0">Otro</option>';
	$data['SELECT_PAIS'] .= '</select>';

	// pais facturació
	$data['SELECT_PAIS_FACTURACIO'] = '<select name="FACTURACION_PAIS" id="FACTURACION_PAIS">';
	foreach ($countries as $countryID => $country) {
		$data['SELECT_PAIS_FACTURACIO'] .= '<option value="' . $countryID . '">' . $country . '</option>';
	}
	$data['SELECT_PAIS_FACTURACIO'] .= '<option value="0">Otro</option>';
	$data['SELECT_PAIS_FACTURACIO'] .= '</select>';

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