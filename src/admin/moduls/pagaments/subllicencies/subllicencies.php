<?php

	// =========================
	// CARDS Basic Configuration
	// =========================
	// list definitions
	$CARDS_LISTSORTBY = 'OTORGADA ASC, FECHA_SOLICITUD ASC, STATUS ASC';
	$CARDS_LISTFILTER = "ECLASS = 1";
	$CARDS_LISTLENGTH = 15;
	$CARDS_LISTSKIP = 15;
	$CARDS_LISTPAGENEXT = 'Següent';
	$CARDS_LISTPAGEPREV = 'Anterior';

	// upload definitions
	$CARDS_IMAGETYPES = 'gif|jpg|jpeg|png|bmp';
	$CARDS_IMAGEMAXSIZE = 50;
	$CARDS_IMAGEMAXWIDTH = 250;
	$CARDS_IMAGEMAXHEIGHT = 150;
	$CARDS_FILEMAXSIZE = 1000;

	// ========================
	// CARDS ITEMS Definition
	// ========================
	// Field Values
	$ITEMS['CARDS_ECLASS']['ESP'] = array( '1_Actualidad', '2_Agenda', '3_Protagonistas', '4_Eventos');
	$ITEMS['CARDS_SKIN']['ESP'] = array( '0_?');
	$ITEMS['CARDS_STATUS']['ESP'] = array( '0_Inactivo', '1_Activo', '2_En espera');
	$ITEMS['CARDS_VISIBILITY']['ESP'] = array( '0_Nunca', '1_Siempre', '2_Autom&aacute;tica');
	$ITEMS['CARDS_CATEGORY1']['ESP'] = array( '0_' );
	$ITEMS['CARDS_CATEGORY2']['ESP'] = array( '1_Enero', '2_Febrero', '3_Marzo', '4_Abril', '5_Mayo', '6_Junio',  '7_Julio', '8_Agosto', '9_Septiembre', '10_Octubre', '11_Noviembre', '12_Diciembre' );
	$ITEMS['CARDS_FINESTRA']['ESP'] = array( '0_No', '1_Si');
	// ============================
	// CARDS DEFAULTS Definitions
	// ============================
	$DEFAULT_LANG        = 'ESP'; // Espanyol
	$DEFAULT_ECLASS       = '1'; // Actualidad
	$DEFAULT_SKIN        = '0';
	$DEFAULT_CATEGORY1   = '0';
	$DEFAULT_CATEGORY2   = '1';
	$DEFAULT_STATUS      = '1';
	$DEFAULT_VISIBILITY  = '1';

	$paymentMethods = array(
		1 => 'TPV',
		2 => 'Transferencia',
	);

	$financementTypes = array(
		1 => 'Financiación privada con ánimo de lucro',
		2 => 'Financiación pública o sin ánimo de lucro',
		3 => 'Sin financiación'
	);

	$status = array(
		0 => 'Inactiva',
		1 => 'Activa',
	);

	$atorgada = array(
		0 => 'Pendiente',
		1 => 'Pendiente terceros',
		2 => 'Otorgada',
		3 => 'Denegada',
	);

	// ============================
	// CARDS DATABASE Configuration
	// ============================
	// Scope: BASE, CUSTOM
	// Types:  NUMBER, ITEM,  DATE, CHAR,   TEXT,  IMAGE and FILE
	// Styles: '',    <ITEM>, '',   'CHAR', 'TEXT'

	$CARDS_TABLE = 'PagoSublicencias';
	$SUBLICENCES_TABLE = 'Sublicencias';
	$AUTHORS_TABLE = 'Autores';
	$USERS_TABLE = 'Usuarios';
	$QUESTIONNAIRES_TABLE = 'Cuestionarios';
	$ILLNESS_TABLE = 'Enfermedades';
	$COUNTRIES_TABLE = 'Paises';
	$QUESTIONS_TABLE = 'Cuestionarios_Preguntas';
	$ANSWERS_TABLE = 'Cuestionarios_Respuestas';

	$CARDS_FIELDS['ID']               = array('BASE', 'NUMBER', '');
	$CARDS_FIELDS['ECLASS']            = array('BASE', 'ITEM',   'CARDS_ECLASS');
	$CARDS_FIELDS['STATUS']           = array('BASE', 'ITEM',   'CARDS_STATUS');
	$CARDS_FIELDS['OTORGADA']            = array('CUSTOM', 'NUMBER',  '');

	$CARDS_FIELDS['CREATION']              = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['MODIFICAT']              = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['USUARICREAR']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['USUARIMODI']         = array('CUSTOM', 'CHAR',  'CHAR');

	$CARDS_FIELDS['FICHERO_SUBLICENCIA']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FECHA_OTORGADA']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FECHA_COBRO']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FECHA_VALIDEZ']         = array('CUSTOM', 'CHAR',  'CHAR');

	// personalitzats
	$CARDS_FIELDS['ID_USUARIO']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['ID_CUEST']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['SIGLAS_CUEST']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['NOM_ORIGINAL_CUEST']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['NOM_CAST_CUEST']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['IDAUTORES_ORIGINAL_CUEST']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['IDAUTORES_CAST_CUEST']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FECHA_SOLICITUD']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['USO']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['USO_OTROS']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FINANCIACION_ENTIDAD']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['PROMOTOR']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TITULO']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['OBJETIVOS']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FECHA_INICIO']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FECHA_FINAL']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['DISENO_ESTUDIO']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['DISENO_ESTUDIO_OTROS']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['POBLACION']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ENFERMEDAD']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['NUM_ADMINISTRACIONES']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['MODO_ADMIN']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['PREGUNTAS']            = array('CUSTOM', 'TEXT',  'TEXT');
	$CARDS_FIELDS['SOPORTE_TECNICO']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['COMENTARIOS']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_CIF']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_NOMBRE']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_DIRECCION']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_CP']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_CIUDAD']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_PAIS']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_OTRO_PAIS']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_TELEFONO']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_FAX']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_EMAIL']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURA']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FECHA_FACTURA']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FICHERO_FACTURA']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['SOLICITA_FACTURA']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['NUM_ALBARAN']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['COMENTARIOS_INTERNOS']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TIPO_IVA']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['IVA']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TOTAL']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['METODO_PAGO']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['STATUS']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['ID_TPV']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FECHA_ACTIVACION']            = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['IBAN']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['SWIFT']            = array('CUSTOM', 'CHAR',  'CHAR');

	// funció comprovació correus electrònics
	function isValidEmail ($email)
	{
		$isValid = true;
		$atIndex = strrpos($email, "@");
		if (is_bool($atIndex) && !$atIndex) {
			$isValid = false;
		}
		else {
			$domain = substr($email, $atIndex+1);
			$local = substr($email, 0, $atIndex);
			$localLen = strlen($local);
			$domainLen = strlen($domain);
			if ($localLen < 1 || $localLen > 64) {
				$isValid = false;
			}
			else if ($domainLen < 1 || $domainLen > 255) {
				$isValid = false;
			}
			else if ($local[0] == '.' || $local[$localLen-1] == '.') {
				// local part starts or ends with '.'
				$isValid = false;
			}
			else if (preg_match('/\\.\\./', $local)) {
				// local part has two consecutive dots
				$isValid = false;
			}
			else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
				// character not valid in domain part
				$isValid = false;
			}
			else if (preg_match('/\\.\\./', $domain)) {
				// domain part has two consecutive dots
				$isValid = false;
			}
			else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) {
				// character not valid in local part unless
				// local part is quoted
				if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) {
					$isValid = false;
				}
			}
			if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) {
				// domain not found in DNS
				$isValid = false;
			}
		}
		return $isValid;
	}

?>