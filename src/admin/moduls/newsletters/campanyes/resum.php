<?php

include_once '../selconfig.php';

$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('resum_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada"));exit; }

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$IdCam = isset($_GET['IdCam']) ? $_GET['IdCam'] : (isset($_POST['idCam']) ? $_POST['idCam'] : null);

$ID = trim(stripslashes(obte_postget('id')));
$accio = trim(stripslashes(obte_postget('accio')));

$result5 = $db->sql_query("SELECT * FROM " . TAULA_CAMPANYES . " WHERE IdCam = '$IdCam'");
if ($db->sql_numrows($result5) == 0) {
    htmlNewsletterError('Campanya no accessible!');
    exit;
}
$row5 = $db->sql_fetchrow($result5);
$bl['ID'] = $row5['IdCam'];

if ($accio == 'eliminadesti') {
    $numerr = tractar_formulari($row5);
    Header('Location: resum.php?IdCam='.$IdCam);
    die();
}

//PAS 1
$bl['TITOL'] = filtreQuote($row5['titol']);
$bl['SUBJECT'] = filtreQuote($row5['subject']);
$bl['NOM'] = filtreQuote($row5['from_name']);
$bl['EMAIL'] = filtreQuote($row5['from_email']);
$bl['IDNL'] = filtreQuote($row5['IDNL']);
$bl['EMAIL_REPLY'] = filtreQuote($row5['reply_to']);
$bl['REPLY_TO'] = ($row5['reply_to']=='') ? '' : ' ('.filtreQuote($row5['reply_to']).')';
$bl['PAS1'] = $Tpl_modul->mergeBlock('PAS1', $bl);
$bl['BOTO_PAS_SEGUENT'] = $Tpl_modul->mergeBlock('BOTO_PAS1', $bl);

//PAS 2
if ($row5['format'] > 0) {
    $bl['INFO_PAS2'] = $Tpl_modul->mergeBlock('PAS2_'.$row5['format'], $bl);
    $bl['PAS2'] = $Tpl_modul->mergeBlock('PAS2', $bl);
    $bl['BOTO_PAS_SEGUENT'] = $Tpl_modul->mergeBlock('BOTO_PAS2', $bl);
}

//PAS 3
if (($row5['desti_llista']!='')||($row5['desti_manual']!='')||($row5['desti_ldap']!='')) {
    $bl['INFO_PAS3'] = '';
    $destins = array();
    $det = array();
    $det['ID'] = $IdCam;
    if ($row5['desti_manual']!='') {
        $aux = explode(',', $row5['desti_manual']);
        $destins += $aux;
        $det['NOMBRE'] = count($aux);
        $bl['INFO_PAS3'] .= $Tpl_modul->mergeBlock('PAS3_MANUAL', $det);
    }
    if ($row5['desti_llista']!='') {
        //$llistes = explode(',', $row5['desti_llista']);
        $result7 = $db->sql_query("SELECT * FROM " . TAULA_LLISTES . " WHERE idLli IN (".$row5['desti_llista'].") ORDER BY titol ASC, dh_alta DESC");
        while ($row7 = $db->sql_fetchrow($result7)) {
            //$rowAux = $db->sql_fetchrow( $db->sql_query("SELECT count(*) AS n1 FROM newsletter_subscriptors WHERE IdLli = '".$row7['IdLli']."' AND estat='1'") );
            //$det['NOMBRE'] = numero_num2fmt(intval($rowAux['n1']));
            //bucle per obtenir els diferens emails i afegir-los a $destins per calcular si hi ha repetits
            $result9 = $db->sql_query("SELECT email FROM " . TAULA_SUBSCRIPTORS . " WHERE IdLli = '".$row7['IdLli']."' AND estat='1'");
            $det['NOMBRE'] = numero_num2fmt(intval($db->sql_numrows($result9)));
            while ($row9 = $db->sql_fetchrow($result9)) {
                $destins[] = $row9['email'];
            }

            $det['ID_LLISTA'] = $row7['IdLli'];
            $det['NOM_LLISTA'] = $row7['titol'];
            $det['D_ALTA'] = data_bd2fmt($row7['dh_alta']);
            $det['D_MODIF'] = ($row7['dh_modif']=='') ? '&nbsp;' : data_bd2fmt($row7['dh_modif']);

            $bl['INFO_PAS3'] .= $Tpl_modul->mergeBlock('PAS3_LLISTA', $det);
        }
    }
    if ($row5['desti_ldap']!='') {
        $det['NOMBRE'] = 'LDAP';
        $bl['INFO_PAS3'] .= $Tpl_modul->mergeBlock('PAS3_LDAP', $det);
    }
    $diferents = array_unique($destins);
    $det['UNICS'] = count($diferents);
    $det['NOMBRE'] = count($destins);
    if ($det['UNICS']==$det['NOMBRE']) $bl['INFO_PAS3'] .= $Tpl_modul->mergeBlock('PAS3_TOTAL', $det);
    else $bl['INFO_PAS3'] .= $Tpl_modul->mergeBlock('PAS3_TOTAL_NO_UNICS', $det);

    $bl['PAS3'] .= $Tpl_modul->mergeBlock('PAS3', $bl);
    $bl['BOTO_PAS_SEGUENT'] = $Tpl_modul->mergeBlock('BOTO_PAS3', $bl);
}


setCurrent('butlletins');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');


// Valida formulari. Si ok fa insert, si nok retorna nºerror
function tractar_formulari($rowCam) {
    global $db, $CFG_CAMPANYES, $IdCam, $LOGIN;

    $camps = array();
    $IDLLISTA = intval($_GET['llista']);

    if ($IDLLISTA == 0) {  //eliminar manual
        $camps['desti_manual'] = '';
        $camps['dh_modif'] = date("Y-m-d H:i:s");
        fer_update(TAULA_CAMPANYES, $camps, "IdCam = '$IdCam'");
        //register_add($T_LANG['adm_campanyes'], 'modificats destinataris campanya id: '.$ID);

    } elseif ($IDLLISTA == -1) {  //eliminar LDAP
        $camps['desti_ldap'] = '';
        $camps['dh_modif'] = date("Y-m-d H:i:s");
        fer_update(TAULA_CAMPANYES, $camps, "IdCam = '$IdCam'");
        //register_add($T_LANG['adm_campanyes'], 'modificats destinataris campanya id: '.$ID);

    } else {
        $llistes = explode(',', $rowCam['desti_llista']);
        if (in_array($IDLLISTA, $llistes)) {
            $clau = array_search ($IDLLISTA, $llistes);
            unset($llistes[$clau]);
            $camps['desti_llista'] = implode(',', $llistes);
            $camps['dh_modif'] = date("Y-m-d H:i:s");
            fer_update(TAULA_CAMPANYES, $camps, "IdCam = '$IdCam'");
            //register_add($T_LANG['adm_campanyes'], 'modificats destinataris campanya id: '.$ID);
        }
    }

    return 0;
}

?>