<?php

include_once '../selconfig.php';

$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('importa_manual_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada"));exit; }

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];


$ID = trim(stripslashes(obte_postget('id')));
$accio = trim(stripslashes(obte_post('accio')));

if ($accio == 'desar') {
    $numerr = tractar_formulari();
    if ($numerr == 0) {
        $bl['NUM_EMAILS'] = array_sum($compta);
        $bl['NUM_OK'] = intval($compta['ok']);
        $bl['NUM_NOK_DUPLI'] = intval($compta['nok_duplicat']);
        $bl['NUM_NOK_ERROR'] = intval($compta['nok_error']);
        $bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('INFO1', $bl);
        $bl['EMAILS'] = '';
    } else {
        $bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);
        $bl['EMAILS'] = filtreQuote(trim(stripslashes($_POST['EMAILS'])));
    }
}

$result5 = $db->sql_query("SELECT * FROM newsletter_llistes WHERE IdLli = '$ID'");
if ($db->sql_numrows($result5) == 0) {
    htmlNewsletterError('Llista no accessible!');
    exit;
}
$row5 = $db->sql_fetchrow($result5);
$bl['ID'] = $row5['IdLli'];
$bl['NOM'] = filtreQuote($row5['titol']);
$bl['NOTES'] = nl2br($row5['notes']);
$bl['TIPUS'] = $CFG_CAMPANYES['TIPUS_LLISTA'][$row5['tipus']];
$rowAux = $db->sql_fetchrow( $db->sql_query("SELECT count(*) AS n1 FROM newsletter_subscriptors WHERE IdLli = '$ID'") );
$bl['NUM_SUBSCRITS'] = numero_num2fmt(intval($rowAux['n1']));

$bl['IMPORTAR'] = '<input type="submit" value="Importar" class="boto continuar" />';
/*
if (isset($_GET['id']) or $numerr != 0) {
    $bl['IMPORTAR'] = '<input type="submit" value="Importar" class="boto continuar" />';
}
else {
    $bl['IMPORTAR'] = '';
}*/

setCurrent('subscriptors');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');


// Valida formulari. Si ok fa insert, si nok retorna nºerror
function tractar_formulari() {
    global $db, $CFG_CAMPANYES, $ID, $LOGIN, $compta;

    $compta = array();

    $EMAILS = trim(stripslashes($_POST['EMAILS']));
    if ($EMAILS == '') return 1;

    $camps = array();
    $camps['IdSub'] = '';  //autonumèric
    $camps['IdUsu'] = $LOGIN;
    $camps['IdLli'] = $ID;
    $camps['estat'] = 1;
    $camps['tipus'] = 1;
    $camps['dh_alta'] = date("Y-m-d H:i:s");
    $camps['dh_baixa'] = NULL;

    // bucle per analitzar els emails.....
    preg_match_all($CFG_CAMPANYES['EMAIL_EXTRACTOR'], $EMAILS, $out);
    if (count($out[0])==0) return 1;

    foreach ($out[0] as $k => $v) {
        //echo $v."<br>";
        $result1 = $db->sql_query("SELECT * FROM newsletter_subscriptors WHERE IdLli='$ID' AND email='$v' LIMIT 0,1");
        if ($db->sql_numrows($result1) > 0) {
            //$row1 = $db->sql_fetchrow($result1);
            $compta['nok_duplicat']++;

        } else {
            $camps['email'] = $v;
            if (fer_insert('newsletter_subscriptors', $camps, 0)) $compta['ok']++;
            else $compta['nok_error']++;
        }
    }

    return 0;
}

?>
