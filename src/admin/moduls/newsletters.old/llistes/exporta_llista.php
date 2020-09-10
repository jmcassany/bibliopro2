<?php

$CONFIG_PATHPHP = '../../../../media/php';
require ('../../../config_admin.inc');
accessGroupPermCheck('newsletter');  //PDT permís concret per campanyes

$CONFIG_PATHCAMPANYES = '../';
require_once($CONFIG_PATHCAMPANYES.'config.inc');

   tractament();


function tractament() {
	global $db, $CFG_CAMPANYES, $ID, $LOGIN, $compta;

	$Tpl_modul = new awTemplate();
	$Tpl_modul->scanFile('exporta_llista_ca.tpl');
	if (!$Tpl_modul->Ok) { htmlPageBasicError(t("plantillanotrobada")); }
	
	unset($bl);
  $bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
  $bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];


	$ID = trim(stripslashes(obte_postget('id')));
	$accio = trim(stripslashes(obte_post('accio')));

  if ($accio == 'desar') {
		$numerr = tractar_formulari();
		if ($numerr == 0) {
		  $bl['NUM_EMAILS'] = array_sum($compta);
		  $bl['NUM_OK'] = intval($compta['ok']);
		  $bl['NUM_NOK_DUPLI'] = intval($compta['nok_duplicat']);
		  $bl['NUM_NOK_ERROR'] = intval($compta['nok_error']);
			$bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('INFO1', $bl);
		} else {
			$bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);
		}
  }

	$wh_noadmin = " AND IdUsu='$LOGIN'";
	$result5 = $db->sql_query("SELECT * FROM news_LLISTES WHERE IdLli = '$ID'".$wh_noadmin);
	if ($db->sql_numrows($result5) == 0) {
		htmlPageError('Llista no accessible!');
	}
	$row5 = $db->sql_fetchrow($result5);
	$bl['ID'] = $row5['IdLli'];
	$bl['NOM'] = filtreQuote($row5['titol']);
	$bl['NOTES'] = nl2br($row5['notes']);
	$bl['TIPUS'] = $CFG_CAMPANYES['TIPUS_LLISTA'][$row5['tipus']];
	
	//$rowAux = $db->sql_fetchrow( $db->sql_query("SELECT count(*) AS n1 FROM news_SUBSCRIPTORS WHERE IdLli = '$ID'") );
	//$bl['NUM_SUBSCRITS'] = numero_num2fmt(intval($rowAux['n1']));

	$total_estat = array();
  $result7 = $db->sql_query("SELECT estat, count(*) AS n1 FROM news_SUBSCRIPTORS WHERE IdLli = '$ID' GROUP BY estat");
  while ($row7 = $db->sql_fetchrow($result7)) {
  	$total_estat[$row7['estat']] = $row7['n1'];
  }
  $bl['NUM_SUBSCRITS'] = numero_num2fmt(array_sum($total_estat));

    	$sel = ($estat==0) ? ' selected="selected"' : '';
			$bl['OPTS_ESTAT'] = '<option value="0"'.$sel.'> Tots ('.$bl['NUM_SUBSCRITS'].' subscriptors)</option>';
		foreach ($CFG_CAMPANYES['ESTAT_SUBSCRIPTOR'] as $k => $v) {
    	$sel = ($estat==$k) ? ' selected="selected"' : '';
    	$bl['OPTS_ESTAT'] .= '<option value="'.$k.'"'.$sel.'>'.$v.' ('.intval($total_estat[$k]).' subscriptors)</option>';
		}


	include ('houdini_cap.inc');
	echo $Tpl_modul->mergeBlock('HEAD', $bl);
	echo $Tpl_modul->mergeBlock('FOOT', $bl);
	include ('houdini_peu.inc');
}

// Valida formulari. Si ok fa insert, si nok retorna nºerror
function tractar_formulari() {
global $db, $CFG_CAMPANYES, $ID, $LOGIN, $compta, $dades_export;

	$CAMPS_EXPORT = array(  // definició del format del csv de sortida.
		'email', 'nom', 'web', 'telefon1', 'telefon2', 'poblacio', 'codipostal', 'estat', 'tipus',
	);
	$compta = array();

	$ESTAT = intval($_POST['ESTAT']);
	if ($ESTAT != 0) $wh_estat = " AND estat='$ESTAT'";

	// Capçalera dels camps:
	$data='';
	foreach ($CAMPS_EXPORT as $k => $v) $data .= afegeix_camp($v);
	$dades_export = $data."\n";

	$wh_noadmin = " AND IdUsu='$LOGIN'";
	$result5 = $db->sql_query("SELECT * FROM news_SUBSCRIPTORS WHERE IdLli = '$ID'".$wh_estat.$wh_noadmin);
	if ($db->sql_numrows($result5)==0) return 1;
  while ($row5 = $db->sql_fetchrow($result5)) {
  	$data='';
		foreach ($CAMPS_EXPORT as $k => $v) {
			if ($v=='estat') $data .= afegeix_camp($CFG_CAMPANYES['ESTAT_SUBSCRIPTOR'][$row5[$v]]);
			elseif ($v=='tipus') $data .= afegeix_camp($CFG_CAMPANYES['TIPUS_SUBSCRIPTOR'][$row5[$v]]);
  		else $data .= afegeix_camp($row5[$v]);
  	}
  	$dades_export .= $data."\n";
  	$compta['ok']++;
	}
	exportar_csv();
	die();

	return 0;
}

function afegeix_camp($valor) {
	//return '"'.addslashes($valor).'";';
	$valor = ereg_replace('"', '""', $valor);
	return '"'.$valor.'";';
}
function exportar_csv() {
global $dades_export;
        ob_start(); 
        header("Content-type: application/octet-stream"); 
        header("Content-Disposition: attachment; filename=export.csv"); 
        header("Pragma: no-cache"); 
        header("Expires: 0"); 
        print($dades_export);
        ob_end_flush();
}

?>