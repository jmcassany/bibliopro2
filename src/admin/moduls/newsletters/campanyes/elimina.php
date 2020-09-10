<?php

include_once '../selconfig.php';
$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('elimina_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada"));exit; }

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$ID = trim(stripslashes(obte_postget('id')));
$accio = trim(stripslashes(obte_post('accio')));

$IdCam = isset($_GET['IdCam']) ? $_GET['IdCam'] : (isset($_POST['idCam']) ? $_POST['idCam'] : null);

$result5 = db_query("SELECT * FROM " . TAULA_CAMPANYES . " WHERE IdCam = '$IdCam'");
if (db_num_rows($result5) == 0) {
    htmlNewsletterError('Campanya no accessible!');
    exit;
}
$row5 = db_fetch_array($result5);


if (($row5['tipus'] == 3) or ($row5['tipus'] == 4)){
    $result6 = db_query("SELECT * FROM " . TAULA_NEWSLETTERS . " WHERE IdCam = ".$IdCam);
    if (db_num_rows($result6) > 0) {
        $row6 = db_fetch_array($result6);

        //ELIMINAR HTML NEWSLETTER
        $butlleti = '/public/butlletins/butlleti' . $row6['ID'] .  '.html';
        if (file_exists($butlleti)) {
            unlink($butlleti);
        }

        //selecció newsletter jamoros x les taules d'enllaç de notícies i banners


        //ELIMINAR NEWSLETTER BBDD jamoros
        $result7 = db_query("DELETE FROM " . TAULA_NEWSLETTERS . " WHERE IdCam = " . $IdCam);
        $result8 = db_query("DELETE FROM " . TAULA_NLTONOTICIES . " WHERE ID_NL = " . $row6['ID']);
        $result9 = db_query("DELETE FROM " . TAULA_NLTOBANNERS . " WHERE ID_NL = " . $row6['ID']);
        $result10 = db_query("DELETE FROM " . TAULA_CLICSNOTICIES . " WHERE ID_NL = " . $row6['ID']);
        $result11 = db_query("DELETE FROM " . TAULA_CLICSBANNERS . " WHERE ID_NL = " . $row6['ID']);
    }
}

if ($accio == 'desar') {
    $numerr = tractar_formulari();
    if ($row5['estat']>=100) header('Location: index_enviades.php');
    else header('Location: index.php');
    //die();
}

$bl['ID'] = $row5['IdCam'];
$bl['NOM'] = filtreQuote($row5['titol']);
$bl['PREVIEW'] = $Tpl_modul->mergeBlock('PREVIEW_'.$row5['format'], $bl);
$rowAux = db_fetch_array(db_query("SELECT count(*) AS n1 FROM " . TAULA_DESTINATARIS . " WHERE IdCam = '$ID'") );
$bl['NUM_SUBSCRITS'] = numero_num2fmt(intval($rowAux['n1']));

setCurrent('butlletins');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');


function tractar_formulari() {
    global $db, $CFG_CAMPANYES, $IdCam, $LOGIN;

    fer_delete(TAULA_DESTINATARIS, "IdCam = '$IdCam'");
    fer_delete(TAULA_CAMPANYES, "IdCam = '$IdCam'");
    //register_add('Newsletters', 'Eliminada campanya id: '.$ID);
    return 0;
}

?>
