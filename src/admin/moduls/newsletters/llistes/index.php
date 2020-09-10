<?php

include_once '../selconfig.php';

$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('index_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(t("plantillanotrobada"));exit; }

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$pag = intval(obte_postget('pag', 1));


//**** Filtres, Recerques
//$wh_filtre = '';
//$wh_filtre = " WHERE estat = '1'";

//**** Ordenacions
$wh_ordre = " ORDER BY titol ASC, dh_alta DESC";

//**** Paginacions
$row5 = $db->sql_fetchrow( $db->sql_query("SELECT COUNT(*) AS nombre FROM newsletter_llistes ") );
$n_regs = intval($row5['nombre']);
$pagi = calcul_paginacions($pag, $n_regs, 'index.php?', 10, 10);
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
$result5 = $db->sql_query("SELECT * FROM newsletter_llistes ".$wh_filtre.$wh_ordre.$wh_limit);
while ($row5 = $db->sql_fetchrow($result5)) {
    $rowAux = $db->sql_fetchrow( $db->sql_query("SELECT count(*) AS n1 FROM newsletter_subscriptors WHERE IdLli = '".$row5['IdLli']."'") );
    $det['NUM_SUBSCRITS'] = numero_num2fmt(intval($rowAux['n1']));

    $det['ID'] = $row5['IdLli'];
    $det['TITOL'] = $row5['titol'];
    $det['D_ALTA'] = data_bd2fmt($row5['dh_alta']);
    $det['D_MODIF'] = ($row5['dh_modif']=='') ? '&nbsp;' : data_bd2fmt($row5['dh_modif']);

    $bl['LLISTAT'] .= $Tpl_modul->mergeBlock('LLISTAT_LIN', $det);
}
$bl['LLISTAT'] .= $Tpl_modul->mergeBlock('LLISTAT_PEU', $bl);

setCurrent('subscriptors');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');

?>
