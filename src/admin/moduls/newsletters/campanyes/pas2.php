<?php

$CONFIG_PATHPHP = '../../../../media/php';
require ('../../../config_admin.inc');
accessGroupPermCheck('newsletter');  //PDT permís concret per campanyes

$CONFIG_PATHCAMPANYES = '../';
require_once($CONFIG_PATHCAMPANYES.'config.inc');

tractament();


function tractament() {
    global $db, $CFG_CAMPANYES, $ID, $LOGIN, $curbutlletins, $curinfomes, $curconfig, $cursubscriptors;

    $Tpl_modul = new awTemplate();
    $Tpl_modul->scanFile('pas2_ca.tpl');
    if (!$Tpl_modul->Ok) { htmlNewsletterError(t("plantillanotrobada"));exit; }

    unset($bl);
    $bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
    $bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

    $ID = trim(stripslashes(obte_postget('id')));
    $accio = trim(stripslashes(obte_post('accio')));

    $result5 = $db->sql_query("SELECT * FROM newsletter_campanyes WHERE IdCam = '$ID'");
    if ($db->sql_numrows($result5) == 0) {
        htmlNewsletterError('Campanya no accessible!');
        exit;
    }
    $row5 = $db->sql_fetchrow($result5);
    $bl['ID'] = $row5['IdCam'];

    if ($accio == 'desar') {
        $numerr = tractar_formulari($row5);
        if ($numerr == 0) {
            //Header('Location: index.php');
            Header('Location: pas2b.php?id='.$ID);
            die();
        }
        $bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);
        foreach ($CFG_CAMPANYES['FORMAT_CAMPANYA'] as $k => $v) {
            $bl['TIPUS_'.$k] = ($_POST['TIPUS']==$k) ? 'checked="checked"' : '';
        }

    } else {
        foreach ($CFG_CAMPANYES['FORMAT_CAMPANYA'] as $k => $v) {
            $bl['TIPUS_'.$k] = ($row5['format']==$k) ? 'checked="checked"' : '';
        }
        $bl['TIPUS_2'] = 'checked="checked"';

    }
    if($row5['format']!=2 && $row5['format']!=0)$bl['MOSTRARALTRESOPCIONS']="<script type=\"text/javascript\">toggleLayer('capaOpcions');</script>";

    setCurrent('butlletins');
    include ('../houdini_cap.inc');
    echo $Tpl_modul->mergeBlock('HEAD', $bl);
    echo $Tpl_modul->mergeBlock('FOOT', $bl);
    include ('../houdini_peu.inc');
}

// Valida formulari. Si ok fa insert, si nok retorna nºerror
function tractar_formulari($rowCam) {
    global $db, $CFG_CAMPANYES, $ID, $LOGIN;

    $camps = array();
    if ($rowCam['estat'] < 20) $camps['estat'] = 20;
    $camps['dh_modif'] = date("Y-m-d H:i:s");

    $camps['format'] = intval($_POST['TIPUS']);
    if (!isset($CFG_CAMPANYES['FORMAT_CAMPANYA'][$camps['format']])) return 1;

    fer_update('newsletter_campanyes', $camps, "IdCam = '$ID'");
    //register_add($T_LANG['adm_campanyes'], 'modificat format campanya id: '.$ID);

    return 0;
}

?>
