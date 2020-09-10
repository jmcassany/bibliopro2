<?php

	require ('../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('questionaris.php');

	error_reporting (E_ALL);

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

	$data['MODIFICAT'] = "No modificat";

	$data['AVUI'] = date('Y-m-d H:i:s', time());
	$data['USUARI']=accessGetLogin();

	// llistem els autors disponibles
	$authorsQuery = db_query ("SELECT NOM, ID FROM $AUTHORS_TABLE ORDER BY NOM ASC");
	if (db_num_rows($authorsQuery) < 1) {
			$data['SELECT_AUTORES_ORIGINAL'] =
			$data['SELECT_AUTORES_CAST'] =
			"No s'ha pogut obtenir el llistat d'autors de la base deades.";
	}
	else {

		$data['SELECT_AUTORES_ORIGINAL_TODOS'] = '<select name="IDAUTORES_ORIGINAL_TODOS[]" id="IDAUTORES_ORIGINAL_TODOS" multiple="multiple">';
		$data['SELECT_AUTORES_CAST_TODOS'] = '<select name="IDAUTORES_CAST_TODOS[]" id="IDAUTORES_CAST_TODOS" multiple="multiple">';
		$data['SELECT_AUTORES_ORIGINAL'] = '<select name="IDAUTORES_ORIGINAL[]" id="IDAUTORES_ORIGINAL" multiple="multiple"></select>';
		$data['SELECT_AUTORES_CAST'] = '<select name="IDAUTORES_CAST[]" id="IDAUTORES_CAST" multiple="multiple"></select>';
		while ($authorsRow = db_fetch_array($authorsQuery)) {

			$data['SELECT_AUTORES_ORIGINAL_TODOS'] .= '<option value="' . $authorsRow['ID'] . '">' . htmlspecialchars($authorsRow['NOM']) . '</option>';
			$data['SELECT_AUTORES_CAST_TODOS'] .= '<option value="' . $authorsRow['ID'] . '">' . htmlspecialchars($authorsRow['NOM']) . '</option>';

		}
		$data['SELECT_AUTORES_ORIGINAL_TODOS'] .= '</select>';
		$data['SELECT_AUTORES_CAST_TODOS'] .= '</select>';

	}

	// llistem els tipus de contingut disponibles
	$cQuery = db_query ("SELECT VALOR, ID FROM $CONTENT_TABLE ORDER BY VALOR ASC");
	if (db_num_rows($cQuery) < 1) {
		$data['SELECT_CONTENIDO'] = "Cal omplir el llistat de tipus de contingut";
	}
	else {

		$data['SELECT_CONTENIDO'] = '<select name="CONTENIDO[]" id="CONTENIDO" multiple="multiple">';
		while ($cRow = db_fetch_array($cQuery)) {

			$data['SELECT_CONTENIDO'] .= '<option value="' . $cRow['ID'] . '">' . htmlspecialchars($cRow['VALOR']) . '</option>';

		}
		$data['SELECT_CONTENIDO'] .= '</select>';

	}

	// llistem les malalties disponibles
	$cQuery = db_query ("SELECT VALOR, ID FROM $ILLNESS_TABLE ORDER BY VALOR ASC");
	if (db_num_rows($cQuery) < 1) {
		$data['SELECT_ENFERMEDAD'] = "Cal omplir el llistat de malalties";
	}
	else {

		$data['SELECT_ENFERMEDAD'] = '<select name="ENFERMEDAD[]" id="ENFERMEDAD" multiple="multiple">';
		while ($cRow = db_fetch_array($cQuery)) {

			$data['SELECT_ENFERMEDAD'] .= '<option value="' . $cRow['ID'] . '">' . htmlspecialchars($cRow['VALOR']) . '</option>';

		}
		$data['SELECT_ENFERMEDAD'] .= '</select>';

	}

	// llistem les poblacions disponibles
	$cQuery = db_query ("SELECT VALOR, ID FROM $POPULATIONS_TABLE ORDER BY VALOR ASC");
	if (db_num_rows($cQuery) < 1) {
		$data['SELECT_POBLACION'] = "Cal omplir el llistat de poblacions";
	}
	else {

		$data['SELECT_POBLACION'] = '<select name="POBLACION[]" id="POBLACION" multiple="multiple">';
		while ($cRow = db_fetch_array($cQuery)) {

			$data['SELECT_POBLACION'] .= '<option value="' . $cRow['ID'] . '">' . htmlspecialchars($cRow['VALOR']) . '</option>';

		}
		$data['SELECT_POBLACION'] .= '</select>';

	}

	// llistem les edats disponibles
	$cQuery = db_query ("SELECT VALOR, ID FROM $AGES_TABLE ORDER BY VALOR ASC");
	if (db_num_rows($cQuery) < 1) {
		$data['SELECT_EDAD'] = "Cal omplir el llistat de d'edats";
	}
	else {

		$data['SELECT_EDAD'] = '<select name="EDAD[]" id="EDAD" multiple="multiple">';
		while ($cRow = db_fetch_array($cQuery)) {

			$data['SELECT_EDAD'] .= '<option value="' . $cRow['ID'] . '">' . htmlspecialchars($cRow['VALOR']) . '</option>';

		}
		$data['SELECT_EDAD'] .= '</select>';

	}

	// llistem les mesures disponibles
	$cQuery = db_query ("SELECT VALOR, ID FROM $MEASURES_TABLE ORDER BY VALOR ASC");
	if (db_num_rows($cQuery) < 1) {
		$data['SELECT_MEDIDA'] = "Cal omplir el llistat de tipus mesures";
	}
	else {

		$data['SELECT_MEDIDA'] = '<select name="MEDIDA[]" id="MEDIDA" multiple="multiple">';
		while ($cRow = db_fetch_array($cQuery)) {

			$data['SELECT_MEDIDA'] .= '<option value="' . $cRow['ID'] . '">' . htmlspecialchars($cRow['VALOR']) . '</option>';

		}
		$data['SELECT_MEDIDA'] .= '</select>';

	}

	// llistem els idiomes disponibles
	$languagesQuery = db_query ("SELECT IDIOMA, ID FROM $LANGUAGES_TABLE ORDER BY IDIOMA ASC");
	if (db_num_rows($authorsQuery) < 1) {
			$data['SELECT_IDIOMA'] = "No s'ha pogut obtenir el llistat d'idiomes de la base deades.";
	}
	else {

		$data['SELECT_IDIOMA'] = '<select name="IDIOMA_ORIGINAL" id="IDIOMA_ORIGINAL">';
		$data['SELECT_IDIOMA_CAST'] = '<select name="IDIOMA_CAST" id="IDIOMA_CAST">';
		$languageOptions = '';
		while ($languageRow = db_fetch_array($languagesQuery)) {

			$languageOptions .= '<option value="' . $languageRow['ID'] . '">' . htmlspecialchars($languageRow['IDIOMA']) . '</option>';

		}
		$data['SELECT_IDIOMA'] .= $languageOptions . '</select>';
		$data['SELECT_IDIOMA_CAST'] .= $languageOptions . '</select>';

	}

	// llistem els països disponibles
	$countriesQuery = db_query ("SELECT PAIS, ID FROM $COUNTRIES_TABLE ORDER BY PAIS ASC");
	if (db_num_rows($authorsQuery) < 1) {
			$data['SELECT_PAIS'] = "No s'ha pogut obtenir el llistat de països de la base deades.";
	}
	else {

		$data['SELECT_PAIS'] = '<select name="PAIS" id="PAIS">';
		$data['SELECT_PAIS'] .= '<option value="">Escolliu un pais</option>';
		while ($countryRow = db_fetch_array($countriesQuery)) {

			$data['SELECT_PAIS'] .= '<option value="' . $countryRow['ID'] . '">' . htmlspecialchars($countryRow['PAIS']) . '</option>';

		}
		$data['SELECT_PAIS'] .= '</select>';

	}

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