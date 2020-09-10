<?php

	// =========================
	// CARDS Basic Configuration
	// =========================
	// list definitions
	$CARDS_LISTSORTBY = 'TIPO asc';
	$CARDS_LISTFILTER = "ID_CUEST = $ID_CUEST";
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

	$CARDS_TABLE = 'Descargables';

	$CARDS_FIELDS['ID']               = array('BASE', 'NUMBER', '');
	$CARDS_FIELDS['ECLASS']            = array('BASE', 'ITEM',   'CARDS_ECLASS');
	$CARDS_FIELDS['CREATION']         = array('BASE', 'DATE',   '');

	$CARDS_FIELDS['MODIFICAT']              = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['USUARICREAR']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['USUARIMODI']         = array('CUSTOM', 'CHAR',  'CHAR');

	// personalitzats
	$CARDS_FIELDS['ID_CUEST']               = array('CUSTOM', 'NUMBER', '');
	$CARDS_FIELDS['TIPO']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FICHERO']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['LINK']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['VISIBLE']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['PROTEGIDO_LOGIN']    = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['SUBLICENCIA']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['PRECIO_LUCRO_IND']      = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['PRECIO_LUCRO_SUBS']      = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['PRECIO_LUCRO_IND_AL']     = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['PRECIO_LUCRO_SUBS_AL']    = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['PRECIO_NO_LUCRO_IND']     = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['PRECIO_NO_LUCRO_SUBS']    = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['PRECIO_NO_LUCRO_IND_AL']  = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['PRECIO_NO_LUCRO_SUBS_AL'] = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['PRECIO_IND_IND']          = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['PRECIO_IND_SUBS']         = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['PRECIO_IND_IND_AL']       = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['PRECIO_IND_SUBS_AL']      = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['CONTADOR']               = array('CUSTOM', 'NUMBER', '');

?>