<?php

    // **********************************************
    // **********************************************
    // **********            NEWS          **********
    // **********************************************
    // **********************************************

   if($_GET){
     $DIN = $_GET['DIN'];
		$TAULA=staticFolderTableName($_GET['DIN']);
   }
   if($_POST){
     $DIN = $_POST['DIN'];
  		$TAULA=staticFolderTableName($_POST['DIN']);
   }

	if(isset($_GET['PAGE'])) {
		$pagina = $_GET['PAGE'];
	} elseif(isset($_POST['PAGE'])) {
		$pagina = $_POST['PAGE'];
	} else {
		$pagina = 1;
	}


    // =========================
    // CARDS Basic Configuration
    // =========================

    // list definitions

    $CARDS_LISTFILTER = "(STATUS='1') and ((VISIBILITY='1') or (VISIBILITY='2' and START_TIME<sysdate() and sysdate()<END_TIME))";
    $CARDS_LISTLENGTH = 10;
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



    // ============================
    // CARDS DEFAULTS Definitions
    // ============================

    $DEFAULT_LANG        = 'ESP'; // Espanyol
    $DEFAULT_ECLASS       = '1'; // Actualidad
    $DEFAULT_SKIN        = '0';
    $DEFAULT_CATEGORY1   = '0';
    $DEFAULT_CATEGORY2   = '0';
    $DEFAULT_STATUS      = '1';
    $DEFAULT_VISIBILITY  = '1';

    // ============================
    // CARDS DATABASE Configuration
    // ============================

    // Scope: BASE, CUSTOM
    // Types:  NUMBER, ITEM,  DATE, CHAR,   TEXT,  IMAGE and FILE
    // Styles: '',    <ITEM>, '',   'CHAR', 'TEXT'


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
    $CARDS_FIELDS['CALENDAR_START_TIME']            = array('BASE', 'DATE',   '');
    $CARDS_FIELDS['CALENDAR_END_TIME']              = array('BASE', 'DATE',   '');



	// CREATS
	// CREATS
	$CARDS_FIELDS['ORDRE']              = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['MODIFICAT']              = array('CUSTOM', 'CHAR', 'CHAR');
	$CARDS_FIELDS['USUARICREAR']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['USUARIMODI']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TITOL']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['URL_TITOL']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['SUBTITOL']         = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['RESUM']         = array('CUSTOM', 'TEXT',  'TEXT');
	$CARDS_FIELDS['DESCRIPCIO']         = array('CUSTOM', 'TEXT',  'TEXT');
	$CARDS_FIELDS['DESCRIPCIO2']         = array('CUSTOM', 'TEXT',  'TEXT');
	$CARDS_FIELDS['LINK1']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['LINK2']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['LINK3']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTLINK1']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTLINK2']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXTLINK3']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['FINESTRA1']        = array('CUSTOM', 'ITEM',   'CARDS_FINESTRA');
	$CARDS_FIELDS['FINESTRA2']        = array('CUSTOM', 'ITEM',   'CARDS_FINESTRA');
	$CARDS_FIELDS['FINESTRA3']        = array('CUSTOM', 'ITEM',   'CARDS_FINESTRA');

	$CARDS_FIELDS['DATA']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['AUTOR']            = array('CUSTOM', 'TEXT',  'TEXT');

	$CARDS_FIELDS['IMATGE1']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['PEU_IMATGE1']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['IMATGE2']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['PEU_IMATGE2']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['IMATGE3']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['PEU_IMATGE3']            = array('CUSTOM', 'CHAR',  'CHAR');

	$CARDS_FIELDS['ADJUNT1']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXT_ADJUNT1']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ADJUNT2']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXT_ADJUNT2']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['ADJUNT3']            = array('CUSTOM', 'CHAR',  'CHAR');
	$CARDS_FIELDS['TEXT_ADJUNT3']            = array('CUSTOM', 'CHAR',  'CHAR');

    $CARDS_FIELDS['AREA']               = array('CUSTOM', 'NUMBER', 'NUMBER');




?>
