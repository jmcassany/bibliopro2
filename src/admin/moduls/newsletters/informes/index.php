<?php

include_once '../selconfig.php';

$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('index_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada"));exit; }

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$pag = intval(obte_postget('pag', 1));


//**** Filtres, Recerques


//**** Ordenacions
$wh_ordre = " ORDER BY dh_inici DESC";

//**** Paginacions
$row5 = $db->sql_fetchrow( $db->sql_query("SELECT COUNT(*) AS nombre FROM " . TAULA_CAMPANYES) );
$n_regs = intval($row5['nombre']);
$pagi = calcul_paginacions($pag, $n_regs, 'index.php?');
$wh_limit = $pagi['WH_LIMIT'];
$bl['NUM_REGS'] = $pagi['NUM_REGS'];
$bl['NUM_PAGS'] = $pagi['NUM_PAGS'];
$bl['PAG_ACTUAL'] = $pagi['PAG_ACTUAL'];
$bl['LINKS_PAGS'] = $pagi['LINKS_PAGS'];
$bl['LINK_ANT'] = $pagi['LINK_ANT'];
$bl['LINK_SEG'] = $pagi['LINK_SEG'];

//**** Bucle principal
$det = array();
$det['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

if ($pagi['NUM_PAGS'] > 1) $bl['PAGINACIO'] = $Tpl_modul->mergeBlock('PAGINACIO', $bl);

$bl['LLISTAT'] = $Tpl_modul->mergeBlock('LLISTAT_CAP', $bl);
$result5 = $db->sql_query("SELECT * FROM " . TAULA_CAMPANYES . " ".$wh_filtre.$wh_ordre.$wh_limit);
while ($row5 = $db->sql_fetchrow($result5)) {
    $rowAux = $db->sql_fetchrow( $db->sql_query("SELECT count(*) AS n1 FROM " . TAULA_DESTINATARIS . " WHERE IdCam = '".$row5['IdCam']."'") );
    $det['NUM_DESTINATARIS'] = numero_num2fmt(intval($rowAux['n1']));

    $det['ID'] = $row5['IdCam'];
    $det['TITOL'] = $row5['titol'];
    $det['D_ALTA'] = data_bd2fmt($row5['dh_alta']);
    $det['D_MODIF'] = ($row5['dh_modif']=='') ? '&nbsp;' : data_bd2fmt($row5['dh_modif']);

    if($row5['dh_inici'] != ''){
        $det['D_ENVIAMENT'] = data_bd2fmt($row5['dh_inici']);
    }
    else {
        $det['D_ENVIAMENT'] = '<a href="/admin/moduls/newsletters/campanyes/enviament.php?IdCam='.$det['ID'].'"><img src="/admin/moduls/newsletters/media/gif/bt_reenviar.gif" alt="Reenviar" /></a>';
    }

    $det['PREVIEW'] = $Tpl_modul->mergeBlock('PREVIEW_'.$row5['format'], $det);

    $bl['LLISTAT'] .= $Tpl_modul->mergeBlock('LLISTAT_LIN', $det);
}
$bl['LLISTAT'] .= $Tpl_modul->mergeBlock('LLISTAT_PEU', $bl);

setCurrent('informes');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');

?>