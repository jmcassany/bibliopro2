<?php

include_once('../selconfig.php');

$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('clics_banners_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada"));exit; }

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$ID = trim(stripslashes(obte_postget('id')));


$IdCam = isset($_GET['IdCam']) ? $_GET['IdCam'] : (isset($_POST['idCam']) ? $_POST['idCam'] : null);
$bl['ID'] = $IdCam;
$result5 = db_query("SELECT * FROM " . TAULA_NEWSLETTERS . " WHERE IdCam = ".$IdCam);
if (db_num_rows($result5) == 0) {
    htmlNewsletterError('Campanya no accessible!');
    exit;
}
$row5 = db_fetch_array($result5);

$bl['TOTAL']=0;
$result6 = db_query("SELECT * FROM " . TAULA_NLTOBANNERS . " WHERE ID_NL = ".$row5['ID'] . " GROUP BY ID_BAN");
if (db_num_rows($result6) == 0) {
    htmlNewsletterError('No hi ha informació disponible dels clics als banners!');
    exit;
}
while ($row6 = db_fetch_array($result6))
{
    $bl['LINKS'] = $row6['LINKS'];

    $bl['TOTAL'] = $bl['TOTAL'] + $bl['LINKS'];

    $result7 = db_query("SELECT * FROM " . TAULA_BANNERS . " WHERE ID = ".$row6['ID_BAN']);
    if (db_num_rows($result7) == 0) {
        htmlNewsletterError('No hi ha informació disponible dels clics als banners!');
        exit;
    }
    $row7 = db_fetch_array($result7);
    $bl['NOTICIA'] = '<a href="'.$row7['LINK'].'" target="_blank">'.$row7['TITOL'].'</a>';
    //$bl['NOTICIA'] = '<a href="../../../../public/view-banner.php?ID='.$row5['ID'].'&amp;idbanner='.$row7['ID'].'&amp;urlbanner='.$row7['LINK'].'" target="_blank">'.$row7['TITOL'].'</a>';

    $bl['RESULTAT'] .= $Tpl_modul->mergeBlock('COS', $bl);
}

setCurrent('informes');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');

?>