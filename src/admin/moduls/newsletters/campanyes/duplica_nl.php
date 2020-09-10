<?php
include_once '../selconfig.php';
accessGroupPermCheck('newsletter');  //PDT permís concret per campanyes


$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('duplica_nl.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada")); exit; }

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$ID = trim(stripslashes(obte_postget('id')));
$IdCam = isset($_GET['IdCam']) ? $_GET['IdCam'] : (isset($_POST['idCam']) ? $_POST['idCam'] : null);

$result5 = $db->sql_query("SELECT * FROM " . TAULA_CAMPANYES . " WHERE IdCam = '$IdCam'");
if ($db->sql_numrows($result5) == 0) {
    //htmlPageError('Campanya no accessible!');
    htmlNewsletterError('Campanya no accessible!');
    exit;
}
$row5 = $db->sql_fetchrow($result5);
$bl['ID'] = $row5['IdCam'];
$bl['TITOL'] = $row5['titol'];


if($row5['tipus']==3 || $row5['tipus']==4){
    $result6 = db_query("SELECT * FROM " . TAULA_NEWSLETTERS . " WHERE IdCam = '$IdCam'");
    if (db_num_rows($result6) == 0) {
        htmlPageError('Butlletí no accessible!');
    }
    $row6 = db_fetch_array($result6);
    $bl['SKIN'] = $row6['SKIN'];
    
    $bl['FRAME']= $CONFIG_URLBASE_NL . '/butlletins/butlleti' . $row6['ID'] . '.html';
}else{
    $fmt = intval($_GET['fmt']);
    $bl['FMT'] = $fmt;
    if ((($fmt==0)&&($row5['format']==3)) || ($fmt==2)) { //només text
        $bl['CONTINGUT'] = nl2br($row5['msg_text']);
    } else {
        $bl['CONTINGUT'] = $row5['msg_html'];
    }
    $bl['FRAME']="mostra_contingut.php?IdCam=".$bl['ID']."&amp;fmt=".$bl['FMT']."";
}

$bl['BOTO_PAS_SEGUENT'] = $Tpl_modul->mergeBlock('BOTO_PAS1', $bl);

$bl['BOTO_PAS_SEGUENT2'] = $Tpl_modul->mergeBlock('BOTO_PAS2', $bl);

setCurrent('butlletins');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');


?>