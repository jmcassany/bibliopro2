<?php

	require ('../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('questionaris.php');

	setlocale(LC_ALL, 'es_CA@UTF-8');

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

	//creem modificacio
	$modificat=$data['MODIFICAT'];
	if ($data['MODIFICAT'] != '0000-00-00 00:00:00'){
		$dataexpl=split(" ",$data['MODIFICAT']);
		$dataexpl=split("-",$dataexpl[0]);
		$usuarimodi=$data['USUARIMODI'];
		$data['MODIFICAT'] = "$dataexpl[2]-$dataexpl[1]-$dataexpl[0] ".t("for")." $usuarimodi";
	}else{
		$data['MODIFICAT'] = "No modificat";
	}

	$data['AVUI'] = date('Y-m-d H:i:s', time());
	$data['USUARI']=accessGetLogin();
	//fi

	// llistem els autors disponibles marcant-ne els seleccionats
	$authorsQuery = db_query ("SELECT NOM, ID FROM $AUTHORS_TABLE ORDER BY NOM ASC");
	if (db_num_rows($authorsQuery) < 1) {
		$data['SELECT_AUTORES_ORIGINAL'] =
		$data['SELECT_AUTORES_CAST'] =
		"Cal omplir el llistat d'autors de la base dades.";
	}
	else {

		$data['SELECT_AUTORES_ORIGINAL_TODOS'] = '<select name="IDAUTORES_ORIGINAL_TODOS[]" id="IDAUTORES_ORIGINAL_TODOS" multiple="multiple">';
		$data['SELECT_AUTORES_CAST_TODOS'] = '<select name="IDAUTORES_CAST_TODOS[]" id="IDAUTORES_CAST_TODOS" multiple="multiple">';
		$data['SELECT_AUTORES_ORIGINAL'] = '<select name="IDAUTORES_ORIGINAL[]" id="IDAUTORES_ORIGINAL" multiple="multiple">';
		$data['SELECT_AUTORES_CAST'] = '<select name="IDAUTORES_CAST[]" id="IDAUTORES_CAST" multiple="multiple">';
		while ($authorsRow = db_fetch_array($authorsQuery)) {

			if (strpos($data['IDAUTORES_ORIGINAL'], '&quot;' . $authorsRow['ID'] . '&quot;') !== false) {
				$data['SELECT_AUTORES_ORIGINAL'] .= '<option value="' . $authorsRow['ID'] . '" selected="selected">' . htmlspecialchars($authorsRow['NOM']) . '</option>';
			}

			if (strpos($data['IDAUTORES_CAST'], '&quot;' . $authorsRow['ID'] . '&quot;') !== false) {
				$data['SELECT_AUTORES_CAST'] .= '<option value="' . $authorsRow['ID'] . '" selected="selected">' . htmlspecialchars($authorsRow['NOM']) . '</option>';
			}

			$data['SELECT_AUTORES_ORIGINAL_TODOS'] .= '<option value="' . $authorsRow['ID'] . '">' . htmlspecialchars($authorsRow['NOM']) . '</option>';
			$data['SELECT_AUTORES_CAST_TODOS'] .= '<option value="' . $authorsRow['ID'] . '">' . htmlspecialchars($authorsRow['NOM']) . '</option>';

		}
		$data['SELECT_AUTORES_ORIGINAL_TODOS'] .= '</select>';
		$data['SELECT_AUTORES_CAST_TODOS'] .= '</select>';
		$data['SELECT_AUTORES_ORIGINAL'] .= '</select>';
		$data['SELECT_AUTORES_CAST'] .= '</select>';

	}

	// llistem els tipus de contingut disponibles marcant-ne els seleccionats
	$cQuery = db_query ("SELECT VALOR, ID FROM $CONTENT_TABLE ORDER BY VALOR ASC");
	if (db_num_rows($cQuery) < 1) {
		$data['SELECT_CONTENIDO'] = "Cal omplir el llistat de tipus de contingut";
	}
	else {

		$data['SELECT_CONTENIDO'] = '<select name="CONTENIDO[]" id="CONTENIDO" multiple="multiple">';
		while ($cRow = db_fetch_array($cQuery)) {

			if (strpos($data['CONTENIDO'], '&quot;' . $cRow['ID'] . '&quot;') !== false) {
				$data['SELECT_CONTENIDO'] .= '<option value="' . $cRow['ID'] . '" selected="selected">' . htmlspecialchars($cRow['VALOR']) . '</option>';
			}
			else {
				$data['SELECT_CONTENIDO'] .= '<option value="' . $cRow['ID'] . '">' . htmlspecialchars($cRow['VALOR']) . '</option>';
			}

		}
		$data['SELECT_CONTENIDO'] .= '</select>';

	}

	// llistem les malalties disponibles marcant-ne les seleccionades
	$cQuery = db_query ("SELECT VALOR, ID FROM $ILLNESS_TABLE ORDER BY VALOR ASC");
	if (db_num_rows($cQuery) < 1) {
		$data['SELECT_ENFERMEDAD'] = "Cal omplir el llistat de malalties";
	}
	else {

		$data['SELECT_ENFERMEDAD'] = '<select name="ENFERMEDAD[]" id="ENFERMEDAD" multiple="multiple">';
		while ($cRow = db_fetch_array($cQuery)) {

			if (strpos($data['ENFERMEDAD'], '&quot;' . $cRow['ID'] . '&quot;') !== false) {
				$data['SELECT_ENFERMEDAD'] .= '<option value="' . $cRow['ID'] . '" selected="selected">' . htmlspecialchars($cRow['VALOR']) . '</option>';
			}
			else {
				$data['SELECT_ENFERMEDAD'] .= '<option value="' . $cRow['ID'] . '">' . htmlspecialchars($cRow['VALOR']) . '</option>';
			}

		}
		$data['SELECT_ENFERMEDAD'] .= '</select>';

	}

	// llistem les poblacions disponibles marcant-ne les seleccionades
	$cQuery = db_query ("SELECT VALOR, ID FROM $POPULATIONS_TABLE ORDER BY VALOR ASC");
	if (db_num_rows($cQuery) < 1) {
		$data['SELECT_POBLACION'] = "Cal omplir el llistat de poblacions";
	}
	else {

		$data['SELECT_POBLACION'] = '<select name="POBLACION[]" id="POBLACION" multiple="multiple">';
		while ($cRow = db_fetch_array($cQuery)) {

			if (strpos($data['POBLACION'], '&quot;' . $cRow['ID'] . '&quot;') !== false) {
				$data['SELECT_POBLACION'] .= '<option value="' . $cRow['ID'] . '" selected="selected">' . htmlspecialchars($cRow['VALOR']) . '</option>';
			}
			else {
				$data['SELECT_POBLACION'] .= '<option value="' . $cRow['ID'] . '">' . htmlspecialchars($cRow['VALOR']) . '</option>';
			}

		}
		$data['SELECT_POBLACION'] .= '</select>';

	}

	// llistem les edats disponibles marcant-ne les seleccionades
	$cQuery = db_query ("SELECT VALOR, ID FROM $AGES_TABLE ORDER BY VALOR ASC");
	if (db_num_rows($cQuery) < 1) {
		$data['SELECT_EDAD'] = "Cal omplir el llistat de d'edats";
	}
	else {

		$data['SELECT_EDAD'] = '<select name="EDAD[]" id="EDAD" multiple="multiple">';
		while ($cRow = db_fetch_array($cQuery)) {

			if (strpos($data['EDAD'], '&quot;' . $cRow['ID'] . '&quot;') !== false) {
				$data['SELECT_EDAD'] .= '<option value="' . $cRow['ID'] . '" selected="selected">' . htmlspecialchars($cRow['VALOR']) . '</option>';
			}
			else {
				$data['SELECT_EDAD'] .= '<option value="' . $cRow['ID'] . '">' . htmlspecialchars($cRow['VALOR']) . '</option>';
			}

		}
		$data['SELECT_EDAD'] .= '</select>';

	}

	// llistem les mesures disponibles marcant-ne les seleccionades
	$cQuery = db_query ("SELECT VALOR, ID FROM $MEASURES_TABLE ORDER BY VALOR ASC");
	if (db_num_rows($cQuery) < 1) {
		$data['SELECT_MEDIDA'] = "Cal omplir el llistat de tipus mesures";
	}
	else {

		$data['SELECT_MEDIDA'] = '<select name="MEDIDA[]" id="MEDIDA" multiple="multiple">';
		while ($cRow = db_fetch_array($cQuery)) {

			if (strpos($data['MEDIDA'], '&quot;' . $cRow['ID'] . '&quot;') !== false) {
				$data['SELECT_MEDIDA'] .= '<option value="' . $cRow['ID'] . '" selected="selected">' . htmlspecialchars($cRow['VALOR']) . '</option>';
			}
			else {
				$data['SELECT_MEDIDA'] .= '<option value="' . $cRow['ID'] . '">' . htmlspecialchars($cRow['VALOR']) . '</option>';
			}

		}
		$data['SELECT_MEDIDA'] .= '</select>';

	}

	// llistem els idiomes disponibles marcant-ne el seleccionat
	$languagesQuery = db_query ("SELECT IDIOMA, ID FROM $LANGUAGES_TABLE ORDER BY IDIOMA ASC");
	if (db_num_rows($authorsQuery) < 1) {
			$data['SELECT_IDIOMA'] = $data['SELECT_IDIOMA_CAST'] = "Cal omplir el llistat d'idiomes de la base deades.";
	}
	else {

		$data['SELECT_IDIOMA'] = '<select name="IDIOMA_ORIGINAL" id="IDIOMA_ORIGINAL">';
		$data['SELECT_IDIOMA_CAST'] = '<select name="IDIOMA_CAST" id="IDIOMA_CAST">';
		$languageOptions = $castLanguageOptions = '';
		while ($languageRow = db_fetch_array($languagesQuery)) {

			if ($data['IDIOMA_ORIGINAL'] == $languageRow['ID']) {
				$languageOptions .= '<option value="' . $languageRow['ID'] . '" selected="selected">' . htmlspecialchars($languageRow['IDIOMA']) . '</option>';
			}
			else {
				$languageOptions .= '<option value="' . $languageRow['ID'] . '">' . htmlspecialchars($languageRow['IDIOMA']) . '</option>';
			}

			if ($data['IDIOMA_CAST'] == $languageRow['ID']) {
				$castLanguageOptions .= '<option value="' . $languageRow['ID'] . '" selected="selected">' . htmlspecialchars($languageRow['IDIOMA']) . '</option>';
			}
			else {
				$castLanguageOptions .= '<option value="' . $languageRow['ID'] . '">' . htmlspecialchars($languageRow['IDIOMA']) . '</option>';
			}

		}
		$data['SELECT_IDIOMA'] .= $languageOptions . '</select>';
		$data['SELECT_IDIOMA_CAST'] .= $castLanguageOptions . '</select>';

	}

	// llistem els països disponibles marcant-ne el seleccionat
	$countriesQuery = db_query ("SELECT PAIS, ID FROM $COUNTRIES_TABLE ORDER BY PAIS ASC");
	if (db_num_rows($authorsQuery) < 1) {
			$data['SELECT_PAIS'] = "Cal omplir el llistat de països de la base deades.";
	}
	else {

		$data['SELECT_PAIS'] = '<select name="PAIS" id="PAIS">';
		while ($countryRow = db_fetch_array($countriesQuery)) {

			if ($data['PAIS'] == $countryRow['ID']) {
				$data['SELECT_PAIS'] .= '<option value="' . $countryRow['ID'] . '" selected="selected">' . htmlspecialchars($countryRow['PAIS']) . '</option>';
				$selected = true;
			}
			else {
				$data['SELECT_PAIS'] .= '<option value="' . $countryRow['ID'] . '">' . htmlspecialchars($countryRow['PAIS']) . '</option>';
			}

		}
		if (!isset($selected)) {
			$data['SELECT_PAIS'] .= '<option value="" selected="selected">Escolliu un pais</option>';
		}
		$data['SELECT_PAIS'] .=  '</select>';

	}

	if ($data['IDENTIFICADO'] == 1) { $data['IDENTIFICADO_CHECKED'] = ' checked="checked"'; }
	else { $data['IDENTIFICADO_CHECKED'] = ''; }

	if ($data['DISPONIBLE'] == 1) { $data['DISPONIBLE_CHECKED'] = ' checked="checked"'; }
	else { $data['DISPONIBLE_CHECKED'] = ''; }

	if ($data['EVALUADO'] == 1) { $data['EVALUADO_CHECKED'] = ' checked="checked"'; }
	else { $data['EVALUADO_CHECKED'] = ''; }

	$data['LINKS_INFO_LEGAL_DESCARGABLES_OTRAS_VERSIONES'] = '
			<HR>
			<TABLE width="100%" cellpadding="15" cellspacing="3" border="0">
				<TR>
					<TD class="text" valign="middle" width="33%" style="vertical-align: middle; background: #dfdfdf;">
						<a href="subllicencies/view.php?ID=' . $data['ID'] . '"><img src="' . $CONFIG_URLADMIN . '/comu/questionaris/icon-info-legal.gif" alt="" border="0" style="vertical-align: middle;" /></a>
						<a href="subllicencies/view.php?ID=' . $data['ID'] . '"><strong>Informació legal</strong></a>
					</TD>
					<TD class="text" valign="middle" width="33%" style="vertical-align: middle; background: #dfdfdf;">
						<a href="descargables/index.php?ID_CUEST=' . $data['ID'] . '"><img src="' . $CONFIG_URLADMIN . '/comu/questionaris/icon-descargables.gif" alt="" border="0" style="vertical-align: middle;" /></a>
						<a href="descargables/index.php?ID_CUEST=' . $data['ID'] . '"><strong>Descarregables</strong></a>
					</TD>
					<TD class="text" valign="middle" width="33%" style="vertical-align: middle; background: #dfdfdf;">
						<a href="versions.php?ID_CUEST=' . $data['ID_CUEST'] . '"><img src="' . $CONFIG_URLADMIN . '/comu/questionaris/icon-otras-versiones.gif" alt="" border="0" style="vertical-align: middle;" /></a>
						<a href="versions.php?ID_CUEST=' . $data['ID_CUEST'] . '"><strong>Altres versions</strong></a>
					</TD>
				</TR>
				<TR>
			</TABLE>
	';

	$data['EDITOR_OTROS_ORIGINAL'] = editor_entry('OTROS_ORIGINAL', $data['OTROS_ORIGINAL'],'Antaviana');
	$data['EDITOR_OTROS_CAST'] = editor_entry('OTROS_CAST', $data['OTROS_CAST'],'Antaviana');

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