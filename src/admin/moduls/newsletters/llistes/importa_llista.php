<?php

include_once '../selconfig.php';

$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('importa_llista_ca.tpl');
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
    } else {
        $bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);
    }
}

$bl['OPTS_LLISTA'] = '<option value="0" selected="selected">...</option>';
$result5 = $db->sql_query("SELECT IdLli,titol FROM newsletter_llistes WHERE IdLli != '$ID' ORDER BY titol ASC");
while ($row5 = $db->sql_fetchrow($result5)) {
    $rowAux = $db->sql_fetchrow( $db->sql_query("SELECT count(*) AS n1 FROM newsletter_subscriptors WHERE IdLli = '".$row5['IdLli']."'") );
    $nomaux = filtreQuote($row5['titol']).' ('.numero_num2fmt(intval($rowAux['n1'])).' subscriptors)';
    $bl['OPTS_LLISTA'] .= '<option value="'.$row5['IdLli'].'">'.$nomaux.'</option>';
}


$wh_noadmin = " AND IdUsu='$LOGIN'";
$result5 = $db->sql_query("SELECT * FROM newsletter_llistes WHERE IdLli = '$ID'".$wh_noadmin);
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

if (isset($_GET['id']) or $numerr != 0) {
    $bl['IMPORTAR'] = '<input type="submit" value="Importar" class="boto continuar" />';
}
else {
    $bl['IMPORTAR'] = '';
}

setCurrent('subscriptors');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');


// Valida formulari. Si ok fa insert, si nok retorna nºerror
function tractar_formulari() {
    global $db, $CFG_CAMPANYES, $ID, $LOGIN, $compta;

    $compta = array();

    $LLISTA = intval($_POST['LLISTA']);
    if ($LLISTA == 0) return 1;
    $result5 = $db->sql_query("SELECT IdLli FROM newsletter_llistes WHERE IdLli = '$LLISTA'");
    if ($db->sql_numrows($result5) == 0) return 1;

    $camps = array();
    $camps['IdSub'] = '';  //autonumèric
    $camps['IdUsu'] = $LOGIN;
    $camps['IdLli'] = $ID;
    //$camps['estat'] = 1;
    //$camps['tipus'] = 2;
    $camps['dh_alta'] = date("Y-m-d H:i:s");
    $camps['dh_baixa'] = NULL;

    $result5 = $db->sql_query("SELECT * FROM newsletter_subscriptors WHERE IdLli = '$LLISTA' AND estat='1'");
    while ($row5 = $db->sql_fetchrow($result5)) {
        $result1 = $db->sql_query("SELECT IdSub FROM newsletter_subscriptors WHERE IdLli='$ID' AND email='".$row5['email']."' LIMIT 0,1");
        if ($db->sql_numrows($result1) > 0) {
            //$row1 = $db->sql_fetchrow($result1);
            $compta['nok_duplicat']++;

        } else {
            $camps['estat'] = $row5['estat'];
            $camps['tipus'] = $row5['tipus'];
            $camps['email'] = $row5['email'];
            $camps['nom'] = $row5['nom'];
            $camps['pais'] = $row5['pais'];
            $camps['centre'] = $row5['centre'];
            $camps['camp1'] = $row5['camp1'];
            $camps['camp2'] = $row5['camp2'];
            $camps['camp3'] = $row5['camp3'];
            $camps['camp4'] = $row5['camp4'];
            $camps['camp5'] = $row5['camp5'];
            $camps['link1'] = $row5['link1'];
            $camps['link2'] = $row5['link2'];
            $camps['link3'] = $row5['link3'];
            $camps['adjunt1'] = $row5['adjunt1'];
            $camps['adjunt2'] = $row5['adjunt2'];
            $camps['adjunt3'] = $row5['adjunt3'];
            $camps['cognoms'] = $row5['cognoms'];
            $camps['bounces'] = $row5['bounces'];

            if (fer_insert('newsletter_subscriptors', $camps, 0)) $compta['ok']++;
            else $compta['nok_error']++;
        }
    }

    return 0;
}

?>
