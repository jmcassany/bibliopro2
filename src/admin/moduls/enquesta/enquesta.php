<?php

    // **********************************************
    // **********************************************
    // **********            NEWS          **********
    // **********************************************
    // **********************************************

    // =========================
    // CARDS Basic Configuration
    // =========================

    // list definitions
    $CARDS_LISTSORTBY = 'ID desc,TITOL asc, START_TIME desc';
    $CARDS_LISTFILTER = "(STATUS='1') and ((VISIBILITY='1') or (VISIBILITY='2' and START_TIME<sysdate() and sysdate()<END_TIME))";
    $CARDS_LISTLENGTH = 30;
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
    $ITEMS['CARDS_STATUS']['ESP'] = array( '0_Inactiu', '1_Actiu' );//, '2_Finalitzat');
    $ITEMS['CARDS_VISIBILITY']['ESP'] = array( '0_Mai', '1_Sempre', '2_Autom&agrave;tica');
    $ITEMS['CARDS_CATEGORY1']['ESP'] = array( '0_1', '1_2', '2_3', '3_4', '4_5', '5_6', '6_7', '7_8', '8_9', '9_10','10_11','11_12');
    $ITEMS['CARDS_CATEGORY2']['ESP'] = array( '0_No', '1_Si');

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

    $CARDS_TABLE = 'ENQUESTA';

    $CARDS_FIELDS['ID']               = array('BASE', 'NUMBER', '');
    $CARDS_FIELDS['ECLASS']            = array('BASE', 'ITEM',   'CARDS_ECLASS');
    $CARDS_FIELDS['SKIN']             = array('BASE', 'ITEM',   'CARDS_ECLASS');
    $CARDS_FIELDS['CATEGORY1']        = array('BASE', 'ITEM',   'CARDS_CATEGORY1');//aqui va el numero de preguntes
    $CARDS_FIELDS['CATEGORY2']        = array('BASE', 'ITEM',   'CARDS_CATEGORY2');
    $CARDS_FIELDS['STATUS']           = array('BASE', 'ITEM',   'CARDS_STATUS');
    $CARDS_FIELDS['VISIBILITY']       = array('BASE', 'ITEM',   'CARDS_VISIBILITY');
    $CARDS_FIELDS['CREATION']         = array('BASE', 'DATE',   '');
    $CARDS_FIELDS['START_TIME']            = array('BASE', 'DATE',   '');
    $CARDS_FIELDS['END_TIME']              = array('BASE', 'DATE',   '');

	$CARDS_FIELDS['MODIFICAT']              = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['USUARICREAR']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['USUARIMODI']         = array('CUSTOM', 'CHAR',  'CHAR');



	// CREATS PERSONAL

	//GENERALS
	$CARDS_FIELDS['TITOL']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['NOM']         = array('CUSTOM', 'CHAR',  'CHAR');
    $CARDS_FIELDS['DESCRIPCIO']         = array('CUSTOM', 'CHAR',  'CHAR');
    $CARDS_FIELDS['PLANTILLA']         = array('CUSTOM', 'CHAR',  'CHAR');






?>