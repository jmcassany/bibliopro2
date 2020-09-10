<?php

include_once '../selconfig.php';

$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('elimina_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada")); exit; }

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$ID = trim(stripslashes(obte_postget('id')));
$accio = trim(stripslashes(obte_post('accio')));

$result5 = $db->sql_query("SELECT * FROM newsletter_llistes WHERE IdLli = '$ID'");
if ($db->sql_numrows($result5) == 0) {
    htmlNewsletterError('Llista no accessible!');
    exit;
}
$row5 = $db->sql_fetchrow($result5);

if ($accio == 'desar') {
    $numerr = tractar_formulari();
    Header('Location: index.php');
    die();
}

$bl['ID'] = $row5['IdLli'];
$bl['NOM'] = filtreQuote($row5['titol']);
$bl['NOTES'] = nl2br($row5['notes']);
$bl['TIPUS'] = $CFG_CAMPANYES['TIPUS_LLISTA'][$row5['tipus']];
$rowAux = $db->sql_fetchrow( $db->sql_query("SELECT count(*) AS n1 FROM newsletter_subscriptors WHERE IdLli = '$ID'") );
$bl['NUM_SUBSCRITS'] = numero_num2fmt(intval($rowAux['n1']));

setCurrent('subscriptors');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('ALL', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');


function tractar_formulari() {
    global $db, $CFG_CAMPANYES, $ID, $LOGIN;

    fer_delete('newsletter_subscriptors', "IdLli = '$ID'");
    fer_delete('newsletter_llistes', "IdLli = '$ID'");
    //register_add('Newsletters', 'Eliminada llista id: '.$ID);
    return 0;
}

?>
