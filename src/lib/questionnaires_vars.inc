<?php

	require_once dirname(__FILE__) . '/Tpv.php';

	// taules base de dades
	$taula_questionaris = 'Cuestionarios';
	$taula_autors = 'Autores';
	$taula_idiomes = 'Idiomas';
	$taula_contingut = 'Contenido';
	$taula_malalties = 'Enfermedades';
	$taula_mesures = 'Medidas';
	$taula_poblacio = 'Poblaciones';
	$taula_edats = 'Edades';
	$taula_descarregables = 'Descargables';
	$taula_usuaris = 'Usuarios';
	$taula_usuaris_houdini = 'USERS';
	$taula_subscripcions = 'Suscripciones';
	$taula_subscripcions_tipus = 'Tipos_suscripcion';
	$taula_paisos = 'Paises';
	$taula_descarregues = 'PagoDescargas';
	$taula_subllicencies = 'Sublicencias';
	$taula_subllicencies_preus = 'Sublicencias_precios';
	$taula_subllicencies_pagaments = 'PagoSublicencias';
	$taula_donacions = 'Donaciones';
	$taula_variables = 'Variables';
	$taula_preguntes = 'Cuestionarios_Preguntas';
	$taula_respostes = 'Cuestionarios_Respuestas';

	// informació TPV
	if (getenv('testserver')) {
		$url_tpvv = 'https://sis-t.sermepa.es:25443/sis/realizarPago';
		$clave = 'qwertyasdf0123456789';
	}
	else {
		$url_tpvv = 'https://sis.sermepa.es/sis/realizarPago';
		$clave = '90O1D3T70FJ9169N';
	}
	$name = 'BiblioPRO';
	$code = '322013483';
	$terminal = '1';
	$currency = '978';
	$transactionType = '0';


/*
 * Inicialització del comerç
*/
$merchant = new Houdini_Services_Tpv_Merchant(
    'BiblioPRO',
    '322013483',
    '001',
    '978',
    'sq7HjrUOBfKmC576ILgskD5srU870gJ7',
    'YumCeEYbB3hawv5d6BhuoRJIrSbvuR0p'
);

/*
 * Inicialització del tpv, segons entorn desenvolupament o real
*/
$environment = Houdini_Services_Tpv::ENV_TEST;
if (!getenv('testserver')) {
    $environment = Houdini_Services_Tpv::ENV_PRODUCTION;
}

$tpv = new Houdini_Services_Tpv($merchant, $environment);



	// variables pagaments (iva, iban, swift)
	$varsQuery = db_query("
		SELECT VARIABLE, VALOR
		FROM `$taula_variables`
	");
	while ($varsRow = db_fetch_array($varsQuery)) {
		if ($varsRow['VARIABLE'] == 'IVA') {
			$iva = (int) $varsRow['VALOR']; // %
		}
		if ($varsRow['VARIABLE'] == 'IBAN') {
			$IBAN = $varsRow['VALOR']; // %
		}
		if ($varsRow['VARIABLE'] == 'SWIFT') {
			$SWIFT = $varsRow['VALOR']; // %
		}
		if ($varsRow['VARIABLE'] == 'NUM_CUENTA') {
			$bankAccountNumber = $varsRow['VALOR']; // %
		}
		if ($varsRow['VARIABLE'] == 'ENTIDAD_BANCARIA') {
			$bankName = $varsRow['VALOR']; // %
		}
	}
	if (!isset($iva)) { $iva = 18; }
	if (!isset($IBAN)) { $IBAN = ''; }
	if (!isset($SWIFT)) { $SWIFT = ''; }
	if (!isset($bankAccountNumber)) { $bankAccountNumber = '2100 0801 18 0200626899'; }
	if (!isset($bankName)) { $bankName = 'La Caixa'; }

	// id espanya taula països
	$spainID = '73';

	// tipus descarregables
	$dTypes = array(
		1 => 'Descripción',
		2 => 'Cuestionario',
		3 => 'Manual',
		4 => 'Puntuación',
		5 => 'Bibliografía',
		6 => 'Enlace',
		7 => 'Evaluación EMPRO',
		8 => 'Otros',
	);
	$dClasses = array(
		1 => 'description',
		2 => 'poll',
		3 => 'manual',
		4 => 'score',
		5 => 'bibliography',
		6 => 'links',
		7 => 'empro',
		8 => 'others nomargin',
	);

	// estat donacions
	$donationsStatus = array(
		0 => 'Por confirmar',
		1 => 'Confirmada'
	);

	// tipus finançament
	/*
	$financementTypes = array(
		1 => 'Financiación privada con ánimo de lucro',
		2 => 'Financiación pública o sin ánimo de lucro',
		3 => 'Sin financiación'
	);*/

	$financementTypes = array(
        1 => 'Proyecto con financiación privada',
        2 => 'Organismos públicos (proyectos sin financiación privada)',
        3 => 'Estudiantes/Universidades sin financiación privada ni pública'
    );

	function getUserInfo($usersTable) {

		// obtenim informació actual de l'usuari
		$userInfoQuery = db_query("
			SELECT * FROM `$usersTable`
			WHERE EMAIL = '" . accessGetLogin() . "'
		");
		if (db_num_rows($userInfoQuery) > 0) {
			return db_fetch_array($userInfoQuery);
		}
		else {
			return false;
		}

	}

	function getCountryName($id, $countriesTable) {

		// obtenim informació del pais
		$countryInfoQuery = db_query("
			SELECT PAIS FROM `$countriesTable`
			WHERE ID = '" . mysql_real_escape_string($id) . "'
		");
		if (db_num_rows($countryInfoQuery) > 0) {
			$countryRow = db_fetch_array($countryInfoQuery);
			return $countryRow['PAIS'];
		}
		else {
			return false;
		}

	}

?>