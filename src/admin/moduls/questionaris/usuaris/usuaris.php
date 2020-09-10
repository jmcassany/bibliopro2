<?php

	// =========================
	// CARDS Basic Configuration
	// =========================
	// list definitions
	$CARDS_LISTSORTBY = 'EMAIL asc, NOMBRE asc';
	$CARDS_LISTFILTER = "ECLASS = 1";
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

	$entityTypes = array(
		1 => 'Sin ánimo de lucro',
		2 => 'Con ánimo de lucro',
		3 => 'Académica',
	);

	$workCenterTypes = array(
		1 => 'Centro de Investigación',
		2 => 'Universidad u otros centros académicos',
		3 => 'CRO (Contract Research Organisation)',
		4 => 'Empresa Farmacéutica o de Tecnología Médica',
		5 => 'Hospital',
		6 => 'Centro de Salud',
		7 => 'Organismo/Administración Pública',
		8 => 'Fundación',
		9 => 'Sociedad Científica',
		10 => 'Asociación de Pacientes',
		11 => 'Aseguradora/Mútua',
		12 => 'Otros',
	);

 function generateOptions ($a) {

		$r = '';
		if (is_array($a) and count($a) > 0) {

			foreach ($a as $i => $v) {

				$r .= '<option value="' . htmlspecialchars($i) . '">' . htmlspecialchars($v) . '</option>';

			}

		}
		return $r;

	}

	$CARDS_TABLE = 'Usuarios';
	$HOUDINI_USERS_TABLE = 'USERS';
	$COUNTRIES_TABLE = 'Paises';
	$SUBSCRIPTIONS_TABLE = 'Suscripciones';

	$CARDS_FIELDS['ID']               = array('BASE', 'NUMBER', '');
	$CARDS_FIELDS['ECLASS']            = array('BASE', 'ITEM',   'CARDS_ECLASS');
	$CARDS_FIELDS['CREATION']         = array('BASE', 'DATE',   '');

	$CARDS_FIELDS['MODIFICAT']              = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['USUARICREAR']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['USUARIMODI']         = array('CUSTOM', 'CHAR',  'CHAR');

	// personalitzats
	$CARDS_FIELDS['EMAIL']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['PWD']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['NOMBRE']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TIPO_ENTIDAD']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['PAIS']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['OTRO_PAIS']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ENTIDAD_NOMBRE']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TIPO_CENTRO_TRABAJO']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ENTIDAD_DIRECCION']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ENTIDAD_CIUDAD']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ENTIDAD_CP']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ENTIDAD_TELEFONO']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_NOMBRE']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_CIF']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_DIRECCION']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_PAIS']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_OTRO_PAIS']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_CP']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_TELEFONO']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FACTURACION_EMAIL']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['NEWSLETTER']            = array('CUSTOM', 'CHAR',  'CHAR');

?>