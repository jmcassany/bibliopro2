<?php

	// =========================
	// CARDS Basic Configuration
	// =========================
	// list definitions
	$CARDS_LISTSORTBY = 'STATUS ASC, FECHA_SOLICITUD DESC';
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

	$status = array(
		0 => 'Inactiva',
		1 => 'Activa',
	);

	$TIPOS = array(
		1 => 'Descripción',
		2 => 'Cuestionario',
		3 => 'Manual',
		4 => 'Puntuación',
		5 => 'Bibliografía',
		6 => 'Enlace',
		7 => 'Evaluación EMPRO',
		8 => 'Otros',
	);

	// ============================
	// CARDS DATABASE Configuration
	// ============================
	// Scope: BASE, CUSTOM
	// Types:  NUMBER, ITEM,  DATE, CHAR,   TEXT,  IMAGE and FILE
	// Styles: '',    <ITEM>, '',   'CHAR', 'TEXT'

	$CARDS_TABLE = 'PagoDescargas';
	$USERS_TABLE = 'Usuarios';
	$AUTHORS_TABLE = 'Autores';
	$QUESTIONNAIRES_TABLE = 'Cuestionarios';
	$DOWNLOADS_TABLE = 'Descargables';
	$COUNTRIES_TABLE = 'Paises';

	$CARDS_FIELDS['ID']               = array('BASE', 'NUMBER', '');
	$CARDS_FIELDS['ECLASS']            = array('BASE', 'ITEM',   'CARDS_ECLASS');
	$CARDS_FIELDS['STATUS']           = array('BASE', 'ITEM',   'CARDS_STATUS');

	$CARDS_FIELDS['CREATION']              = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['MODIFICAT']              = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['USUARICREAR']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['USUARIMODI']         = array('CUSTOM', 'CHAR',  'CHAR');

	$CARDS_FIELDS['FECHA_COBRO']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FECHA_VALIDEZ']         = array('CUSTOM', 'CHAR',  'CHAR');

	// personalitzats
	$CARDS_FIELDS['ID_USUARIO']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['ID_DESCARGABLE']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['ID_CUEST']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['SIGLAS_CUEST']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['NOM_ORIGINAL_CUEST']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['NOM_CAST_CUEST']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['IDAUTORES_ORIGINAL_CUEST']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['IDAUTORES_CAST_CUEST']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FECHA_SOLICITUD']            = array('CUSTOM', 'CHAR',  'CHAR');
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

?>