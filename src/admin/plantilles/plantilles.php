<?php

    // =========================
    // CARDS Basic Configuration
    // =========================

    // list definitions

    $CARDS_LISTFILTER = "(STATUS='1') and ((VISIBILITY='1') or (VISIBILITY='2' and START_TIME<sysdate() and sysdate()<END_TIME))";
    $CARDS_LISTLENGTH = 15;
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
    $ITEMS['CARDS_STATUS']['ESP'] = array( '0_Inactiu', '1_Actiu');
    $ITEMS['CARDS_VISIBILITY']['ESP'] = array( '0_Mai', '1_Sempre', '2_Autom&agrave;tica');
    $ITEMS['CARDS_CATEGORY1']['ESP'] = array( '0_Si', '1_No');
	$ITEMS['CARDS_FINESTRA']['ESP'] = array( '0_No', '1_Si');

    $ITEMS['CARDS_CATEGORY2']['ESP'] = array( '1_Enero', '2_Febrero', '3_Marzo', '4_Abril', '5_Mayo', '6_Junio',  '7_Julio', '8_Agosto', '9_Septiembre', '10_Octubre', '11_Noviembre', '12_Diciembre' );

    // ============================
    // CARDS DEFAULTS Definitions
    // ============================

    $DEFAULT_LANG        = 'ESP';
    $DEFAULT_ECLASS       = '1';
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

    $TAULA = "PLANTILLA";
	$CARDS_TABLE = $TAULA;

	//GENERALS
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



	// CREATS
	$CARDS_FIELDS['NOM']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['DESCRIPCIO']        = array('CUSTOM', 'CHAR',  'CHAR');
 $CARDS_FIELDS['PARE']    		   = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['IDIOMA']        = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTCURT']    		   = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['TEXTLLARG']         = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['IMATGES']         = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['ADJUNTS']         = array('CUSTOM', 'NUMBER',  '');
	$CARDS_FIELDS['OP']         = array('CUSTOM', 'NUMBER',  '');

?>
