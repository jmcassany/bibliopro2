<?php

include_once '../selconfig.php';

    $Tpl_modul = new awTemplate();
    $Tpl_modul->scanFile('resum_ca.tpl');
    if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada")); exit; }

    unset($bl);
    $bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
    $bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

    $ID = trim(stripslashes(obte_postget('id')));
    $accio = trim(stripslashes(obte_postget('accio')));

    $IdCam = isset($_GET['IdCam']) ? $_GET['IdCam'] : (isset($_POST['idCam']) ? $_POST['idCam'] : null);

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
    $bl['REPLY_TO'] = ($row5['reply_to']=='') ? '' : ' ('.filtreQuote($row5['reply_to']).')';
    $bl['D_ENVIAMENT'] = data_bd2fmt($row5['dh_inici']);
    $bl['PREVIEW'] = $Tpl_modul->mergeBlock('PREVIEW_'.$row5['format'], $bl);

    $totalmails = 0; $ok=0; $ko=0; $n_errorenv=0; $n_norespo=0; $n_llegit=0; $n_unsubs=0;
    $result9 = $db->sql_query("SELECT estat, count(*) as nombre FROM " . TAULA_DESTINATARIS . " WHERE IdCam = '$IdCam' GROUP BY estat");  //proves
    while ($row9 = $db->sql_fetchrow($result9)) {
        if ($row9['estat']==1) $n_norespo += $row9['nombre'];
        elseif ($row9['estat']==2) $n_errorenv += $row9['nombre'];
        elseif ($row9['estat']==10) $n_llegit += $row9['nombre'];
        elseif ($row9['estat']==21) $n_unsubs += $row9['nombre'];
        $totalmails += $row9['nombre'];
    }
    $bl['NUM_ENVIAMENTS'] = numero_num2fmt($totalmails);
    $bl['ENVIATS_KO'] = numero_num2fmt($n_errorenv);
    $bl['NUM_LLEGITS'] = numero_num2fmt($n_llegit);
    $bl['NUM_UNSUBSC'] = numero_num2fmt($n_unsubs);
    $bl['NUM_NORESPO'] = numero_num2fmt($n_norespo);
    $bl['ENVIATS_OK'] = numero_num2fmt($n_llegit+$n_unsubs+$n_norespo);

    $bl['ENVIATS_KO_NUM'] = $n_errorenv;
    $bl['NUM_LLEGITS_NUM'] = $n_llegit;
    $bl['NUM_UNSUBSC_NUM'] = $n_unsubs;
    $bl['NUM_NORESPO_NUM'] = $n_norespo;

    setCurrent('informes');
    include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
    echo $Tpl_modul->mergeBlock('HEAD', $bl);
    echo $Tpl_modul->mergeBlock('FOOT', $bl);
    include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');

?>