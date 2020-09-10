<?php

	// =========================
	// CARDS Basic Configuration
	// =========================
	// list definitions
	$CARDS_LISTSORTBY = 'NOM asc, START_TIME desc';
	$CARDS_LISTFILTER = "STATUS =  1 ";
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

	// ============================
	// CARDS DATABASE Configuration
	// ============================
	// Scope: BASE, CUSTOM
	// Types:  NUMBER, ITEM,  DATE, CHAR,   TEXT,  IMAGE and FILE
	// Styles: '',    <ITEM>, '',   'CHAR', 'TEXT'

	$CARDS_TABLE = 'Cuestionarios';
	$COUNTRIES_TABLE = 'Paises';
	$LANGUAGES_TABLE = 'Idiomas';
	$POPULATIONS_TABLE = 'Poblaciones';
	$AGES_TABLE = 'Edades';
	$CONTENT_TABLE = 'Contenido';
	$MEASURES_TABLE = 'Medidas';
	$ILLNESS_TABLE = 'Enfermedades';
	$AUTHORS_TABLE = 'Autores';

	$CARDS_FIELDS['ID']               = array('BASE', 'NUMBER', '');
	$CARDS_FIELDS['ECLASS']            = array('BASE', 'ITEM',   'CARDS_ECLASS');
	$CARDS_FIELDS['STATUS']           = array('BASE', 'ITEM',   'CARDS_STATUS');
	$CARDS_FIELDS['START_TIME']            = array('BASE', 'DATE',   '');
	$CARDS_FIELDS['END_TIME']              = array('BASE', 'DATE',   '');

	$CARDS_FIELDS['CREATION']              = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['MODIFICAT']              = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['USUARICREAR']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['USUARIMODI']         = array('CUSTOM', 'CHAR',  'CHAR');

	// personalitzats
	$CARDS_FIELDS['ID_CUEST']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['IDENTIFICADO']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['DISPONIBLE']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['EVALUADO']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['VERSION']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['NOM_ORIGINAL']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['NOM_CAST']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['SIGLAS']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['REFERENCIA_ORIGINAL']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['REFERENCIA_ORIGINAL_LINK']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['REFERENCIA_CAST']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['REFERENCIA_CAST_LINK']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['CORRESPONDENCIA_ORIGINAL']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['CORRESPONDENCIA_ORIGINAL_LINK']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['CORRESPONDENCIA_CAST']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['CORRESPONDENCIA_CAST_LINK']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['COPYRIGHT_ORIGINAL']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['COPYRIGHT_CAST']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['OTROS_ORIGINAL']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['OTROS_CAST']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['EMAILS']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['CONTENIDO']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ENFERMEDAD']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['POBLACION']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['EDAD']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['MEDIDA']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['NUMERO_ITEMS']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['DIMENSIONES']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['PALABRAS_CLAVE']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['CUESTIONARIO_AL']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['EMAIL_CONTACTO_ORIGINAL']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['EMAIL_CONTACTO_CAST']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TELEFONO_ORIGINAL']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TELEFONO_CAST']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['IDIOMA_ORIGINAL']           = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['PAIS']            = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['IDIOMA_CAST']               = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['IDAUTORES_ORIGINAL']               = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['IDAUTORES_CAST']               = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['AUTORES_EXTRA_ORIGINAL']               = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['AUTORES_EXTRA_CAST']               = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['AUTORES_ORIGINAL_NOMBRES']               = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['AUTORES_CAST_NOMBRES']               = array('CUSTOM', 'CHAR', 'CHAR');

?>