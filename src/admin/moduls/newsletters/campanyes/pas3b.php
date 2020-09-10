<?php
include_once '../selconfig.php';

$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('pas3b_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada"));exit; }

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$ID = trim(stripslashes(obte_postget('id')));
$accio = trim(stripslashes(obte_post('accio')));
$IdCam = isset($_GET['IdCam']) ? $_GET['IdCam'] : (isset($_POST['idCam']) ? $_POST['idCam'] : null);

$result5 = db_query("SELECT * FROM " . TAULA_CAMPANYES . " WHERE IdCam = '$IdCam'");
if (db_num_rows($result5) == 0) {
    htmlPageError('Campanya no accessible!');
}
$row5 = db_fetch_array($result5);
$bl['ID'] = $row5['IdCam'];

if ($accio == 'desar') {
    $numerr = tractar_formulari($row5);
    if ($numerr == 0) {
        $bl['NUM_EMAILS'] = array_sum($compta);
        $bl['NUM_OK'] = intval($compta['ok']);
        $bl['NUM_NOK_DUPLI'] = intval($compta['nok_duplicat']);
        $bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('INFO1', $bl);
        $bl['EMAILS'] = '';
    } else {
        $bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);
        $bl['EMAILS'] = filtreQuote(trim(stripslashes($_POST['EMAILS'])));
    }

} else {
    $bl['EMAILS'] = filtreQuote(preg_replace("@,@", ",\n", $row5['desti_manual']));
}

$bl['IMPORTAR'] = '<input type="submit" value="Importar" class="boto continuar" />';


setCurrent('butlletins');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');


// Valida formulari. Si ok fa insert, si nok retorna nºerror
function tractar_formulari($rowCam) {
    global $db, $CFG_CAMPANYES, $IdCam, $LOGIN, $compta;

    $compta = array();

    $EMAILS = trim(stripslashes($_POST['EMAILS']));
    if ($EMAILS == '') return 1;

    // bucle per analitzar els emails.....
    preg_match_all($CFG_CAMPANYES['EMAIL_EXTRACTOR'], $EMAILS, $out);
    if (count($out[0])==0) return 1;

    preg_match_all($CFG_CAMPANYES['EMAIL_EXTRACTOR'], $rowCam['desti_manual'], $actuals);

    //print_r($actuals);
    foreach ($out[0] as $k => $v) {
        if (in_array($v, $actuals[0])) $compta['nok_duplicat']++;
        else {
            $actuals[0][] = $v;
            $compta['ok']++;
        }
    }
    //print_r($out);
    //print_r($actuals);

    $camps = array();
    $camps['desti_manual'] = '';
    foreach($actuals[0] as $k => $v) {
        $camps['desti_manual'] .= $v.',';
    }
    if ($camps['desti_manual'] != '') $camps['desti_manual'] = substr($camps['desti_manual'],0,-1);

    if ($rowCam['estat'] < 30) $camps['estat'] = 30;
    $camps['dh_modif'] = date("Y-m-d H:i:s");
    fer_update(TAULA_CAMPANYES, $camps, "IdCam = '$IdCam'");
    //register_add($T_LANG['adm_campanyes'], 'modificats destinataris manuals campanya id: '.$ID);
    return 0;
}

?>
