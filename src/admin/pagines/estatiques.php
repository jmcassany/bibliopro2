<?php

if(!isset($path))$path="home";



    // **********************************************
    // **********************************************
    // **********            NEWS          **********
    // **********************************************
    // **********************************************

    // =========================
    // CARDS Basic Configuration
    // =========================

    // list definitions
    $CARDS_LISTSORTBY = 'NOMPAG asc, START_TIME desc';
    $CARDS_LISTFILTER = "(STATUS='1') and ((VISIBILITY='1') or (VISIBILITY='2' and START_TIME<sysdate() and sysdate()<END_TIME))";
    $CARDS_LISTLENGTH = 25;
    $CARDS_LISTSKIP = 10;
    $CARDS_LISTPAGENEXT = t("next");
    $CARDS_LISTPAGEPREV = t("previous");

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
    $ITEMS['CARDS_CATEGORY1']['ESP'] = array( '1_Enero', '2_Febrero', '3_Marzo', '4_Abril', '5_Mayo', '6_Junio',  '7_Julio', '8_Agosto', '9_Septiembre', '10_Octubre', '11_Noviembre', '12_Diciembre');
    $ITEMS['CARDS_CATEGORY2']['ESP'] = array( '1_Enero', '2_Febrero', '3_Marzo', '4_Abril', '5_Mayo', '6_Junio',  '7_Julio', '8_Agosto', '9_Septiembre', '10_Octubre', '11_Noviembre', '12_Diciembre' );

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

    $CARDS_TABLE = 'ESTATICA';

    $CARDS_FIELDS['ID']               = array('BASE', 'NUMBER', '');
    $CARDS_FIELDS['ECLASS']            = array('BASE', 'ITEM',   'CARDS_ECLASS');
    $CARDS_FIELDS['SKIN']             = array('BASE', 'ITEM',   'CARDS_ECLASS');
    $CARDS_FIELDS['CATEGORY1']        = array('BASE', 'ITEM',   'CARDS_CATEGORY1');
    $CARDS_FIELDS['CATEGORY2']        = array('BASE', 'ITEM',   'CARDS_CATEGORY2');
    $CARDS_FIELDS['STATUS']           = array('BASE', 'ITEM',   'CARDS_STATUS');
    $CARDS_FIELDS['VISIBILITY']       = array('BASE', 'ITEM',   'CARDS_VISIBILITY');
    $CARDS_FIELDS['CREATION']         = array('BASE', 'DATE',   '');
    $CARDS_FIELDS['START_TIME']            = array('BASE', 'DATE',   '');
    $CARDS_FIELDS['END_TIME']              = array('BASE', 'DATE',   '');



	$CARDS_FIELDS['MODIFICAT']              = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['USUARICREAR']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['USUARIMODI']         = array('CUSTOM', 'CHAR',  'CHAR');

	// CREATS
	$CARDS_FIELDS['NOMPAG']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['DESCRIPCIO']        = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['IDIOMA']        = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['REFERENCIA']        = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['METATITOL']        = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['METADESCRIPCIO']        = array('CUSTOM', 'TEXT',  'TEXT');
	$CARDS_FIELDS['METAKEYS']         = array('CUSTOM', 'TEXT',  'TEXT');
  $CARDS_FIELDS['PARE']    		   = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['PLANTILLAID']         = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['MENU1']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['MENU2']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['MENU3']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['BANNER1']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['BANNER2']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['BANNER3']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['CERCADOR']         = array('CUSTOM', 'CHAR',  'CHAR');

	$CARDS_FIELDS['TEXTC1']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC2']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC3']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC4']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC5']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC6']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC7']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC8']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC9']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC10']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC11']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC12']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC13']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC14']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC15']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC16']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC17']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC18']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC19']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC20']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC21']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC22']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC23']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC24']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC25']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC25']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC26']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC27']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC28']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC29']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC30']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC31']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC32']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC33']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC34']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC35']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC36']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC37']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC38']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC39']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC40']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC41']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC42']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC43']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC44']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTC45']            = array('CUSTOM', 'CHAR',  'CHAR');

/*
	$CARDS_FIELDS['TEXTL1']         = array('CUSTOM', 'TEXT',  'TEXT');
	$CARDS_FIELDS['TEXTL2']         = array('CUSTOM', 'TEXT',  'TEXT');
	$CARDS_FIELDS['TEXTL3']         = array('CUSTOM', 'TEXT',  'TEXT');
	$CARDS_FIELDS['TEXTL4']         = array('CUSTOM', 'TEXT',  'TEXT');
	$CARDS_FIELDS['TEXTL5']         = array('CUSTOM', 'TEXT',  'TEXT');
	$CARDS_FIELDS['TEXTL6']         = array('CUSTOM', 'TEXT',  'TEXT');
	$CARDS_FIELDS['TEXTL7']         = array('CUSTOM', 'TEXT',  'TEXT');
	$CARDS_FIELDS['TEXTL8']         = array('CUSTOM', 'TEXT',  'TEXT');
	$CARDS_FIELDS['TEXTL9']         = array('CUSTOM', 'TEXT',  'TEXT');
	$CARDS_FIELDS['TEXTL10']         = array('CUSTOM', 'TEXT',  'TEXT');
*/

	$CARDS_FIELDS['IMATGE1']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE2']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE3']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE4']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE5']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE6']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE7']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE8']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE9']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE10']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE11']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE12']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE13']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE14']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE15']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE16']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE17']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE18']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE19']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE20']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE21']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE22']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE23']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE24']            = array('CUSTOM', 'IMAGE', '');
	$CARDS_FIELDS['IMATGE25']            = array('CUSTOM', 'IMAGE', '');

	$CARDS_FIELDS['ADJUNT1']            = array('CUSTOM', 'FILE', '');
	$CARDS_FIELDS['ADJUNT2']            = array('CUSTOM', 'FILE', '');
	$CARDS_FIELDS['ADJUNT3']            = array('CUSTOM', 'FILE', '');
	$CARDS_FIELDS['ADJUNT4']            = array('CUSTOM', 'FILE', '');
	$CARDS_FIELDS['ADJUNT5']            = array('CUSTOM', 'FILE', '');
	$CARDS_FIELDS['ADJUNT6']            = array('CUSTOM', 'FILE', '');
	$CARDS_FIELDS['ADJUNT7']            = array('CUSTOM', 'FILE', '');
	$CARDS_FIELDS['ADJUNT8']            = array('CUSTOM', 'FILE', '');
	$CARDS_FIELDS['ADJUNT9']            = array('CUSTOM', 'FILE', '');
	$CARDS_FIELDS['ADJUNT10']            = array('CUSTOM', 'FILE', '');

	$CARDS_FIELDS['ALT1']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ALT2']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ALT3']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ALT4']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ALT5']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ALT6']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ALT7']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ALT8']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ALT9']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ALT10']            = array('CUSTOM', 'CHAR',  'CHAR');

	$CARDS_FIELDS['OP1']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['OP2']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['OP3']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['OP4']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['OP5']            = array('CUSTOM', 'CHAR',  'CHAR');

?>
