<?php
include_once '../selconfig.php';

//selecció newsletter jamoros x les taules d'enllaç de notícies i banners
$IdCam = isset($_GET['IdCam']) ? $_GET['IdCam'] : (isset($_POST['idCam']) ? $_POST['idCam'] : null);

$result6 = db_query("SELECT * FROM " . TAULA_CAMPANYES . " WHERE IdCam = ".$_POST['idCam']);
if (db_num_rows($result6) > 0) {
    $row6 = db_fetch_array($result6);

    //ELIMINAR NEWSLETTER BBDD jamoros
    $result6 = db_query("DELETE FROM " . TAULA_CAMPANYES . " WHERE IdCam = ".$_POST['idCam']);
    $result7 = db_query("DELETE FROM " . TAULA_NEWSLETTERS . " WHERE IdCam = ".$_POST['idCam']);
    $result8 = db_query("DELETE FROM " . TAULA_NLTONOTICIES . " WHERE ID_NL = ".$row6['ID']);
    $result9 = db_query("DELETE FROM " . TAULA_NLTOBANNERS . " WHERE ID_NL = ".$row6['ID']);
    $result10 = db_query("DELETE FROM " . TAULA_CLICSBANNERS . " WHERE ID_NL = ".$row6['ID']);
    $result11 = db_query("DELETE FROM " . TAULA_CLICSNOTICIES . " WHERE ID_NL = ".$row6['ID']);
    header('Location: index.php');
    exit;
}

$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('elimina_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada"));exit; }

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$ID = trim(stripslashes(obte_postget('id')));
$accio = trim(stripslashes(obte_post('accio')));

$result5 = $db->sql_query("SELECT * FROM " . TAULA_CAMPANYES . " WHERE IdCam = '$IdCam'");
if ($db->sql_numrows($result5) == 0) {
    htmlNewsletterError('Campanya no accessible!');
    exit;
}
$row5 = $db->sql_fetchrow($result5);


if ($accio == 'desar') {
    $numerr = tractar_formulari();
    header('Location: index.php');
    die();
}

$bl['ID'] = $row5['IdCam'];
$bl['NOM'] = filtreQuote($row5['titol']);
$bl['PREVIEW'] = $Tpl_modul->mergeBlock('PREVIEW_'.$row5['format'], $bl);
$rowAux = $db->sql_fetchrow( $db->sql_query("SELECT count(*) AS n1 FROM " . TAULA_DESTINATARIS . " WHERE IdCam = '$IdCam'") );
$bl['NUM_SUBSCRITS'] = numero_num2fmt(intval($rowAux['n1']));


setCurrent('informes');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');


function tractar_formulari() {
    global $db, $CFG_CAMPANYES, $ID, $LOGIN;

    fer_delete('newsletter_destinataris', "IdCam = '$IdCam'");
    fer_delete('newsletter_campanyes', "IdCam = '$IdCam'");
    //register_add('Newsletters', 'Eliminada campanya id: '.$ID);
    return 0;
}

?>
