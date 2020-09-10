<?php
// **********************************************
// **********************************************
// **********            NEWS          **********
// **********************************************
// **********************************************

// =========================
// CARDS Basic Configuration
// =========================

ini_set('register_globals',1);

// list definitions
$CARDS_LISTSORTBY = 'ID desc,TITOL asc';
$CARDS_LISTFILTER = "";
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

// miscelaneus
$CARDS_ERRORDEFAULT = 'http://www.catalanet.org';
$CARDS_CHARSPERMINUTE = '1430';

// ==================================
// CARDS Style Definitions: LIST+HTML
// ==================================

// List Base
$LIST['BASIC']['OPEN'] = '<table>';
$LIST['BASIC']['ITEM'] = '<tr><td>|NUMBER|</td><td>|TEXT|</td></tr>';
$LIST['BASIC']['CLOSE'] = '</table>';

// List Table
$LIST['TABLE']['OPEN'] = '<table border="0" cellspacing="0" cellpadding="0" width="100%">';
$LIST['TABLE']['ITEM'] = '
              <tr>
                <td valign="top" align="right"><img src="../gif/pix_red.gif" width="4" height="4" hspace="0" vspace="5" alt="|NUMBER|"></td>
                <td valign="top" align="left">&nbsp;</td>
                <td valign="top" align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">|TEXT|</font></td>
              </tr>
              <tr>
                <td valign="top" align="right"></td>
                <td valign="top" align="left"><img src="../gif/pix.gif" width="5" height="5"></td>
                <td valign="top" align="left"></td>
              </tr>
    ';
$LIST['TABLE']['CLOSE'] = '</table>';

// Bold
$HTML['CHAR']['BOLD'] = array( '[', ']', '<b>', '</b>');
$HTML['LIST']['BOLD'] = array( '[', ']', '<b>', '</b>');
$HTML['TEXT']['BOLD'] = array( '[', ']', '<b>', '</b>');

// Italic
$HTML['CHAR']['ITALIC'] = array( '{', '}', '<i>', '</i>');
$HTML['LIST']['ITALIC'] = array( '{', '}', '<i>', '</i>');
$HTML['TEXT']['ITALIC'] = array( '{', '}', '<i>', '</i>');

// Links
$HTML['CHAR']['LINK'] = array( 'class="link"', 'class="mailto"');
$HTML['LIST']['LINK'] = array( 'class="link"', 'class="mailto"');
$HTML['TEXT']['LINK'] = array( 'class="link"', 'class="mailto"');


// ========================
// CARDS ITEMS Definition
// ========================

// Field Values
$ITEMS['CARDS_CLASS']['ESP'] = array( '1_Actualidad', '2_Agenda', '3_Protagonistas', '4_Eventos');
$ITEMS['CARDS_SKIN']['ESP'] = array( '0_?');
$ITEMS['CARDS_STATUS']['ESP'] = array( '0_Inactiu', '1_Actiu' );//, '2_Finalitzat');
$ITEMS['CARDS_VISIBILITY']['ESP'] = array( '0_Mai', '1_Sempre', '2_Autom&agrave;tica');
$ITEMS['CARDS_CATEGORY1']['ESP'] = array( '0_1', '1_2', '2_3', '3_4', '4_5', '5_6', '6_7', '7_8', '8_9', '9_10','10_11','11_12');
$ITEMS['CARDS_CATEGORY2']['ESP'] = array( '0_No', '1_Si');

// ============================
// CARDS DEFAULTS Definitions
// ============================

$DEFAULT_LANG        = 'ESP'; // Espanyol
$DEFAULT_CLASS       = '1'; // Actualidad
$DEFAULT_SKIN        = '0';
$DEFAULT_CATEGORY1   = '0';
$DEFAULT_CATEGORY2   = '1';
$DEFAULT_STATUS      = '1';
$DEFAULT_VISIBILITY  = '1';

// ============================
// CARDS DATABASE Configuration
// ============================

// Scope: BASE, CUSTOM
// Types:  NUMBER, ITEM,  DATE, CHAR,   TEXT,   LIST,  IMAGE and FILE
// Styles: '',    <ITEM>, '',   'CHAR', 'TEXT', <LIST>

$CARDS_TABLE = TAULA_RSS;

$CARDS_FIELDS['ID']               = array('BASE', 'NUMBER', '');
$CARDS_FIELDS['ECLASS']            = array('BASE', 'ITEM',   'CARDS_CLASS');
$CARDS_FIELDS['SKIN']             = array('BASE', 'ITEM',   'CARDS_CLASS');
$CARDS_FIELDS['CATEGORY1']        = array('BASE', 'ITEM',   'CARDS_CATEGORY1');//aqui va el numero de preguntes
$CARDS_FIELDS['CATEGORY2']        = array('BASE', 'ITEM',   'CARDS_CATEGORY2');
$CARDS_FIELDS['STATUS']           = array('BASE', 'ITEM',   'CARDS_STATUS');
$CARDS_FIELDS['VISIBILITY']       = array('BASE', 'ITEM',   'CARDS_VISIBILITY');
$CARDS_FIELDS['CREATION']         = array('BASE', 'DATE',   '');
$CARDS_FIELDS['START_TIME']            = array('BASE', 'DATE',   '');
$CARDS_FIELDS['END_TIME']              = array('BASE', 'DATE',   '');




// CREATS PERSONAL

//GENERALS
$CARDS_FIELDS['TITOL']         = array('CUSTOM', 'CHAR',  'CHAR');
$CARDS_FIELDS['LINK1']         = array('CUSTOM', 'CHAR',  'CHAR');
$CARDS_FIELDS['MAX_ITEMS']         = array('CUSTOM', 'NUMBER', '');
$CARDS_FIELDS['IDIOMA']         = array('CUSTOM', 'CHAR',  'CHAR');
?>