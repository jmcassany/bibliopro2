<?php

	// =========================
	// CARDS Basic Configuration
	// =========================
	// list definitions
	$CARDS_LISTSORTBY = 'CODIGO asc';
	$CARDS_LISTFILTER = "";
	$CARDS_LISTLENGTH = 15;
	$CARDS_LISTSKIP = 10;
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

	$authorizationStatuses = array(
		1 => 'Buscar contacto',
		2 => 'Imposible contactar',
		3 => 'Solicitada',
		4 => 'Denegada',
		5 => 'OK por email',
		6 => 'OK a firmar contrato',
		7 => 'OK a firmar contrato + comercialización',
		8 => 'Contrato firmado',
		9 => 'Original castellano',
		10 => 'Desacuerdo entre autores',
		11 => 'No aplica',
		12 => 'Otros',
        13 => 'Desacuedo con original',  
        14 => 'Desacuerdo con adaptación',
        15 => 'OK pero ellos cesión',
        16 => 'OK a enlace'
	);

	$authorizationTypes = array(
		1 => 'Reproducción',
		2 => 'Comercialización de la reproducción',
		3 => 'Reproducción y distribución',
		4 => 'Reproducción y comercialización de la distribución',
		5 => 'Todo',
		6 => 'Otros',
	);

	// ============================
	// CARDS DATABASE Configuration
	// ============================
	// Scope: BASE, CUSTOM
	// Types:  NUMBER, ITEM,  DATE, CHAR,   TEXT,  IMAGE and FILE
	// Styles: '',    <ITEM>, '',   'CHAR', 'TEXT'

	$CARDS_TABLE = 'Sublicencias';
	$QUESTIONNAIRES_TABLE = 'Cuestionarios';

	$CARDS_FIELDS['ID']               = array('BASE', 'NUMBER', '');
	$CARDS_FIELDS['ECLASS']            = array('BASE', 'ITEM',   'CARDS_ECLASS');
	$CARDS_FIELDS['STATUS']           = array('BASE', 'ITEM',   'CARDS_STATUS');

	$CARDS_FIELDS['CREATION']              = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['MODIFICAT']              = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['USUARICREAR']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['USUARIMODI']         = array('CUSTOM', 'CHAR',  'CHAR');

	// personalitzats
	$CARDS_FIELDS['CODIGO']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ESTADO_AUT_ORIGINAL']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['ESTADO_AUT_ADAPTACION']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['TIPO_AUT']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['CODIGO_CONTRATO']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FECHA_CONTRATO']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['INSTITUCIONES_CONTRATO']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['SUBLICENCIA_BIBLIOPRO']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['FICHERO_CONTRATO']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FICHERO_SUBLICENCIA']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['EXPLICACION_SOLICITACION']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTO_ACEPTACION']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['COMENTARIOS']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['VISIBLE_WEB']            = array('CUSTOM', 'NUMBER',  '');

?>