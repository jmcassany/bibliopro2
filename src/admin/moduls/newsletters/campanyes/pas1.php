<?php
include_once '../selconfig.php';

$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('pas1_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada")); exit; }

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$ID = trim(stripslashes(obte_postget('id')));
$accio = trim(stripslashes(obte_post('accio')));

$IdCam = isset($_GET['IdCam']) ? $_GET['IdCam'] : (isset($_POST['idCam']) ? $_POST['idCam'] : null);

if ($accio == 'desar') {
    $numerr = tractar_formulari();
    if ($numerr == 0) {
        header('Location: pas2b.php?IdCam='.$IdCam);
        die();
    }
    $bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);

    $bl['TITOL'] = filtreQuote(trim(stripslashes($_POST['TITOL'])));
    $bl['SUBJECT'] = filtreQuote(trim(stripslashes($_POST['SUBJECT'])));
    $bl['NOM'] = filtreQuote(trim(stripslashes($_POST['NOM'])));
    $bl['EMAIL'] = filtreQuote(trim(stripslashes($_POST['EMAIL'])));
    $bl['EMAIL_REPLY'] = filtreQuote(trim(stripslashes($_POST['EMAIL_REPLY'])));
    $bl['IDNL'] = intval($_POST['IDNL']);
} elseif ($IdCam!='') {  //editar
    $result5 = $db->sql_query("SELECT * FROM " . TAULA_CAMPANYES . " WHERE IdCam = '$IdCam'");
    if ($db->sql_numrows($result5) == 0) {
        htmlNewsletterError('Campanya no accessible!');
        exit;
    }
    $row5 = $db->sql_fetchrow($result5);
    $bl['ID'] = $row5['IdCam'];
    $bl['TITOL'] = filtreQuote($row5['titol']);
    $bl['SUBJECT'] = filtreQuote($row5['subject']);
    $bl['NOM'] = filtreQuote($row5['from_name']);
    $bl['EMAIL'] = filtreQuote($row5['from_email']);
    $bl['EMAIL_REPLY'] = filtreQuote($row5['reply_to']);
    $bl['IDNL'] = intval($row5['IDNL']);

} else {

    //agafem les dades del Admin general
    $result = $db->sql_query("SELECT * FROM " . TAULA_USUARIS . " WHERE LOGIN = '$LOGIN'");
    if ($db->sql_numrows($result) == 0) {
        htmlNewsletterError('Dades de l\'usuari no accessibles!');
        exit;
    }
    $row = $db->sql_fetchrow($result);

    $bl['NOM'] = $row['REALNAME']; //FromName
    $bl['EMAIL'] = $row['EMAIL']; //Email
    //Bounce
    $result_bounce = $db->sql_query("SELECT * FROM " . TAULA_BOUNCES);
    $row_bounce = $db->sql_fetchrow($result_bounce);
    if ($row_bounce) {
        $bl['EMAIL_REPLY'] = $row_bounce['user'];
    }
    else {
        $bl['EMAIL_REPLY'] = $row['EMAIL'];
    }
}
setCurrent('butlletins');
include_once ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include_once ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');


// Valida formulari. Si ok fa insert, si nok retorna nºerror
function tractar_formulari() {
    global $db, $CFG_CAMPANYES, $IdCam, $LOGIN;

    
    $camps = array();

    $camps['dh_modif'] = date("Y-m-d H:i:s");

    $camps['titol'] = trim(stripslashes($_POST['TITOL']));
    if ($camps['titol'] == '') return 1;

    $camps['subject'] = trim(stripslashes($_POST['SUBJECT']));
    if ($camps['subject'] == '') return 2;

    $camps['from_name'] = trim(stripslashes($_POST['NOM']));
    if ($camps['from_name'] == '') return 3;

    $camps['from_email'] = trim(stripslashes($_POST['EMAIL']));
    if ($camps['from_email'] == '') return 4;
    if (!preg_match($CFG_CAMPANYES['EMAIL_VALID'],$camps['from_email'])) return 4;

    $camps['reply_to'] = trim(stripslashes($_POST['EMAIL_REPLY']));
    if (($camps['reply_to']!='')&&(!preg_match($CFG_CAMPANYES['EMAIL_VALID'],$camps['reply_to']))) return 5;

    if ($rowCam['estat'] < 20) $camps['estat'] = 20;
    $camps['format'] = intval($_POST['TIPUS']);

    $camps['IDNL'] = intval($_POST['IDNL']);
    
    if ($IdCam=='') {
        $camps['IdUsu'] = $LOGIN;
        $camps['estat'] = 10;
        $camps['dh_alta'] = $camps['dh_modif'];
        fer_insert(TAULA_CAMPANYES, $camps);
        
        $IdCam = $db->sql_nextid();
        //register_add('Newsletters', 'Creada campanya id: '.$ID);
        
    } else {
        fer_update(TAULA_CAMPANYES, $camps, "IdCam = '$IdCam'");
        //register_add($T_LANG['adm_campanyes'], 'modificada campanya id: '.$ID);
    }

    return 0;
}

?>