<?php
include_once '../selconfig.php';

$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('index_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada")); exit; }

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$pag = intval(obte_postget('pag', 1));


//**** Filtres, Recerques
$wh_filtre = "WHERE estat < '100'";

//**** Ordenacions
//$wh_ordre = " ORDER BY titol ASC, dh_alta DESC";
$wh_ordre = " ORDER BY dh_alta DESC";

//**** Paginacions
$row5 = $db->sql_fetchrow( $db->sql_query("SELECT COUNT(*) AS nombre FROM " . TAULA_CAMPANYES . " " . $wh_filtre) );
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
$result5 = $db->sql_query("SELECT * FROM " . TAULA_CAMPANYES . " " . $wh_filtre . $wh_ordre . $wh_limit);
while ($row5 = $db->sql_fetchrow($result5)) {
    $det['ID'] = $row5['IdCam'];
    $det['TITOL'] = $row5['titol'];
    $det['D_ALTA'] = data_bd2fmt($row5['dh_alta']);
    $det['D_MODIF'] = ($row5['dh_modif']=='') ? '&nbsp;' : data_bd2fmt($row5['dh_modif']);

    $det['PAS1'] = $Tpl_modul->mergeBlock('PAS_OK', $bl);
    $det['PAS2'] = ($row5['format'] > 0) ? $Tpl_modul->mergeBlock('PAS_OK', $bl) : $Tpl_modul->mergeBlock('PAS_KO', $bl);
    $det['PAS3'] = (($row5['desti_llista']!='')||($row5['desti_manual']!='')) ? $Tpl_modul->mergeBlock('PAS_OK', $bl) : $Tpl_modul->mergeBlock('PAS_KO', $bl);

    $bl['LLISTAT'] .= $Tpl_modul->mergeBlock('LLISTAT_LIN', $det);
}
$bl['LLISTAT'] .= $Tpl_modul->mergeBlock('LLISTAT_PEU', $bl);

setCurrent('butlletins');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');

?>