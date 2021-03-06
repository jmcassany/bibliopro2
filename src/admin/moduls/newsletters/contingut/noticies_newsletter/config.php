<?php
/* **********************************************
// **********************************************
// **********            NEWS          **********
// **********************************************
// **********************************************/

// =========================
// CARDS Basic Configuration
// =========================

// list definitions
$CARDS_LISTSORTBY = 'CREATION desc';//governa l'ordenar de list.php
$CARDS_LISTFILTER = ""; //filtra newsletters x user houdini
$CARDS_LISTLENGTH = 10;
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
$CARDS_ERRORDEFAULT = '';
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
$ITEMS['CARDS_CLASS']['ESP'] = array( '1_?');
$ITEMS['CARDS_SKIN']['ESP'] = array( '0_?');
$ITEMS['CARDS_STATUS']['ESP'] = array( '0_Inactiu', '1_Actiu');
$ITEMS['CARDS_VISIBILITY']['ESP'] = array( '0_');
$ITEMS['CARDS_CATEGORY1']['ESP'] = array( '0_');
$ITEMS['CARDS_CATEGORY2']['ESP'] = array( '0_');

// ============================
// CARDS DEFAULTS Definitions
// ============================

$DEFAULT_LANG        = 'ESP'; 	// Espanyol
$DEFAULT_CLASS       = '1';
$DEFAULT_SKIN        = '0';
$DEFAULT_CATEGORY1   = '0';
$DEFAULT_CATEGORY2   = '0';
$DEFAULT_STATUS      = '1';
$DEFAULT_VISIBILITY  = '1';

// ============================
// CARDS DATABASE Configuration
// ============================

// Scope: BASE, CUSTOM
// Types:  NUMBER, ITEM,  DATE, CHAR,   TEXT,   LIST,  IMAGE and FILE
// Styles: '',    <ITEM>, '',   'CHAR', 'TEXT', <LIST>

$CARDS_TABLE = TAULA_NOTICIESNEWSLETTER;

$CARDS_FIELDS['ID']               	= array('BASE', 'NUMBER', '');
$CARDS_FIELDS['CLASS']            	= array('BASE', 'ITEM',   'CARDS_CLASS');
$CARDS_FIELDS['SKIN']             	= array('BASE', 'ITEM',   'CARDS_CLASS');
$CARDS_FIELDS['CATEGORY1']        	= array('BASE', 'ITEM',   'CARDS_CATEGORY1');
$CARDS_FIELDS['CATEGORY2']        	= array('BASE', 'ITEM',   'CARDS_CATEGORY2');
$CARDS_FIELDS['STATUS']          	= array('BASE', 'ITEM',   'CARDS_STATUS');
$CARDS_FIELDS['VISIBILITY']      	= array('BASE', 'ITEM',   'CARDS_VISIBILITY');
$CARDS_FIELDS['CREATION']         	= array('BASE', 'DATE',   '');
$CARDS_FIELDS['START']            	= array('BASE', 'DATE',   '');
$CARDS_FIELDS['END']              	= array('BASE', 'DATE',   '');

$CARDS_FIELDS['TITOL']         	  	= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['RESUM']         	  	= array('CUSTOM', 'TEXT',  '');
$CARDS_FIELDS['DESCRIPCIO']       	= array('CUSTOM', 'TEXT',  '');
$CARDS_FIELDS['NOMAD1']         	= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['NOMAD2']         	= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['NOMAD3']         	= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['NOMAD4']         	= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['NOMAD5']         	= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['ADJUNT1']          	= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['ADJUNT2']           	= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['ADJUNT3']           	= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['ADJUNT4']           	= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['ADJUNT5']           	= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['IMATGE1']           	= array('CUSTOM', 'IMAGE', '');
$CARDS_FIELDS['IMATGE2']           	= array('CUSTOM', 'IMAGE', '');
$CARDS_FIELDS['IMATGE3']           	= array('CUSTOM', 'IMAGE', '');
$CARDS_FIELDS['MESINFO']        	= array('CUSTOM', 'NUMBER',  '');
$CARDS_FIELDS['LINK1']        		= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['LINK2']        		= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['NOM']        		= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['CARREC']        		= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['METATAGS']      	  	= array('CUSTOM', 'TEXT',  '');
$CARDS_FIELDS['LLOC']        		= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['DATA_LLOC']        	= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['SUBTITOL']        	= array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['MODEL']        		= array('CUSTOM', 'NUMBER',  '');
$CARDS_FIELDS['USUARI_HOUDINI']    = array('CUSTOM', 'CHAR',  '');
$CARDS_FIELDS['NOM_LINK']    = array('CUSTOM', 'CHAR',  '');
?>
