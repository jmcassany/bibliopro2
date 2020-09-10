<?php

include_once '../selconfig.php';

$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('detalls_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada")); exit; }

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$ID = trim(stripslashes(obte_postget('id')));
$accio = trim(stripslashes(obte_post('accio')));
$delbounces = trim(stripslashes(obte_postget('delbounces')));

if ($delbounces == true)
{
    $result_bounce = $db->sql_query("SELECT * FROM newsletter_subscriptors WHERE IdLli = '$ID' AND bounces > 5 ");
    while ($row_bounce = $db->sql_fetchrow($result_bounce))
    {
        $email_subs = $row_bounce['email'];

        $result_bounce2 = $db->sql_query("UPDATE newsletter_subscriptors SET estat=2 WHERE IdLli = '$ID' AND email = '$email_subs' ");
        $row_bounce2 = $db->sql_fetchrow($result_bounce2);
    }
}

if ($accio != '') {
    $numerr = tractar_formulari();
    if ($numerr <= 0) {
        $bl['NUM_OK'] = intval($compta['ok']);
        $bl['NUM_NOK'] = intval($compta['nok']);
        $bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('INFO'.(-$numerr), $bl);
    } else $bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);
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


// LLISTAT DELS SUBSCRIPTORS
$estat = intval(obte_postget('estat', 1));
$cerca = trim(stripslashes(obte_postget('cerca')));
$ordenar = trim(stripslashes(obte_postget('ordenar')));
$ordre = trim(stripslashes(obte_postget('ordre', 'ASC')));
$pag = intval(obte_postget('pag', 1));

$bl['OPTS_ACCIO'] = '<option value="0">...</option>';
$sel = ($estat==0) ? ' selected="selected"' : '';
$bl['OPTS_ESTAT'] = '<option value="0"'.$sel.'>(tots)</option>';
foreach ($CFG_CAMPANYES['ESTAT_SUBSCRIPTOR'] as $k => $v) {
    $bl['OPTS_ACCIO'] .= '<option value="'.$k.'">'.$v.'</option>';
    $sel = ($estat==$k) ? ' selected="selected"' : '';
    $bl['OPTS_ESTAT'] .= '<option value="'.$k.'"'.$sel.'>'.$v.'</option>';
}
$bl['OPTS_ACCIO'] .= '<option value="99">Eliminar!</option>';

//**** Filtres, Recerques
$wh_filtre = " WHERE IdLli='$ID'";
$bl['CERCA'] = filtrequote($cerca);
$bl['FLT_ESTAT'] = filtrequote($estat);
if ($cerca != '') {
    $cerca_bd = addslashes($cerca);
    $wh_filtre .= " AND (email LIKE '%$cerca_bd%' OR nom LIKE '%$cerca_bd%')";
}
if (isset($CFG_CAMPANYES['ESTAT_SUBSCRIPTOR'][$estat])) {
    $wh_filtre .= " AND (estat = '$estat')";
}

// **** Ordenacions
$parms_aux = "id=$ID";
//if ($pag!=1) $parms_aux .= "&amp;pag=$pag";
if ($cerca!="") $parms_aux .= "&amp;cerca=$cerca";
if ($estat!=1) $parms_aux .= "&amp;estat=$estat";
$colu = array(  //num => array(id, camptaula, ordreperdefecte)
1 => array('e', 'email', 'ASC'),
2 => array('n', 'nom', 'ASC'),
3 => array('d', 'dh_alta', 'DESC'),
4 => array('t', 'estat', 'ASC'),
);
foreach ($colu as $k => $v) {
    if (($ordenar == '')&&($k==1)) {  //ordre per defecte si no n'hi ha
        $wh_ordre = ' ORDER BY '.$v[1].' '.$v[2];
        $aju_ord1 = ($v[2] == "DESC") ? "ASC" : "DESC";
        $bl['LINK_'.$k] = 'detalls.php?'.$parms_aux.'&amp;ordenar='.$v[0].'&amp;ordre='.$aju_ord1;
        $bl['ICO_'.$k] = '';
    } elseif ($ordenar == $v[0]){
        $wh_ordre = ' ORDER BY '.$v[1].' '.$ordre;
        $aju_ord1 = ($ordre == "DESC") ? "ASC" : "DESC";
        $bl['LINK_'.$k] = 'detalls.php?'.$parms_aux.'&amp;ordenar='.$v[0].'&amp;ordre='.$aju_ord1;
        $bl['ICO_'.$k] = '<img src="' . $CONFIG_NLADMINURLBASE . '/media/comu/' . $ordre.'.gif" width="10" height="10" alt="'.$ordre.'" border="0" hspace="5" align="left" />&nbsp;';
    } else {
        $aju_ord1 = $v[2];
        $bl['LINK_'.$k] = 'detalls.php?'.$parms_aux.'&amp;ordenar='.$v[0].'&amp;ordre='.$aju_ord1;
        $bl['ICO_'.$k] = '';
    }
}
//$wh_ordre .= ', dh_alta DESC'; //ordre secundari
$bl['ORDENAR'] = $ordenar;
$bl['ORDRE'] = $ordre;

//**** Paginacions
$row5 = $db->sql_fetchrow( $db->sql_query("SELECT COUNT(*) AS nombre FROM " . TAULA_SUBSCRIPTORS . " ".$wh_filtre) );
$n_regs = intval($row5['nombre']);
$parms_aux = "id=$ID";
if ($ordenar!='') $parms_aux .= "&amp;ordenar=$ordenar&amp;ordre=$ordre";
if ($cerca!="") $parms_aux .= "&amp;cerca=$cerca";
if ($estat!=1) $parms_aux .= "&amp;estat=$estat";
$pagi = calcul_paginacions($pag, $n_regs, 'detalls.php?'.$parms_aux);
$wh_limit = $pagi['WH_LIMIT'];
$bl['NUM_REGS'] = $pagi['NUM_REGS'];
$bl['NUM_PAGS'] = $pagi['NUM_PAGS'];
$bl['PAG_ACTUAL'] = $pagi['PAG_ACTUAL'];
$bl['REG_PRIMER'] = $pagi['REG_PRIMER'];
$bl['REG_ULTIM'] = $pagi['REG_ULTIM'];
$bl['LINKS_PAGS'] = $pagi['LINKS_PAGS'];
$bl['LINK_ANT'] = $pagi['LINK_ANT'];
$bl['LINK_SEG'] = $pagi['LINK_SEG'];

//**** Bucle principal
$det = array();
$det['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$bl['LLISTAT'] = $Tpl_modul->mergeBlock('LLISTAT_CAP',$bl);
$result5 = $db->sql_query("SELECT * FROM " . TAULA_SUBSCRIPTORS . " ".$wh_filtre.$wh_ordre.$wh_limit);
while ($row5 = $db->sql_fetchrow($result5)) {
    $det['ID'] = $row5['IdLli'];
    $det['IDSUB'] = $row5['IdSub'];
    $det['EMAIL'] = $row5['email'];
    $det['NOM'] = $row5['nom'];
    $det['COGNOMS'] = $row5['cognoms'];
    $det['D_ALTA'] = data_bd2fmt($row5['dh_alta']);
    $det['D_BAIXA'] = ($row5['dh_baixa']=='') ? '&nbsp;' : data_bd2fmt($row5['dh_baixa']);
    $det['ESTAT'] = $CFG_CAMPANYES['ESTAT_SUBSCRIPTOR'][$row5['estat']];
    $det['BOUNCES'] = $row5['bounces'];

    $bl['LLISTAT'] .= $Tpl_modul->mergeBlock('LLISTAT_LIN', $det);
}
$bl['LLISTAT'] .= $Tpl_modul->mergeBlock('LLISTAT_PEU', $bl);


setCurrent('subscriptors');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');


// Valida formulari. Si ok fa accio i retorna negatiu, si nok retorna nºerror
function tractar_formulari() {
    global $db, $CFG_CAMPANYES, $ID, $LOGIN, $compta;

    if (!isset($_POST['CHECK'])) return 1;
    if (count($_POST['CHECK'])==0) return 1;

    $compta = array();
    $camps = array();
    $camps['estat'] = intval($_POST['accio']);

    if ($camps['estat']==99) {  //eliminar definitivament
        foreach($_POST['CHECK'] as $k => $v) {
            if (fer_delete(TAULA_SUBSCRIPTORS, "IdLli = '$ID' AND IdSub='$k'", 0)) $compta['ok']++;
            else $compta['nok']++;
        }
        return -2;

    } else { //canviar estat
        if (!isset($CFG_CAMPANYES['ESTAT_SUBSCRIPTOR'][$camps['estat']])) return 2;
        $camps['dh_baixa'] = ($camps['estat']==1) ? NULL : date("Y-m-d H:i:s");
        foreach($_POST['CHECK'] as $k => $v) {
            if (fer_update(TAULA_SUBSCRIPTORS, $camps, "IdLli = '$ID' AND IdSub='$k'", 0)) $compta['ok']++;
            else $compta['nok']++;
        }
        return -1;

    }

    //register_add($T_LANG['adm_llistes'], 'modificació subscriptors llista '.$ID);
}

?>