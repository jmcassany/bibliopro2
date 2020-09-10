<?php

$CONFIG_PATHPHP = '../../../../media/php';
require ('../../../config_admin.inc');
accessGroupPermCheck('newsletter');  //PDT permís concret per campanyes

$CONFIG_PATHCAMPANYES = '../';
require_once($CONFIG_PATHCAMPANYES.'config.inc');

   tractament();


function tractament() {
	global $db, $CFG_CAMPANYES, $ID, $LOGIN;

	$Tpl_modul = new awTemplate();
	$Tpl_modul->scanFile('edita_ca.tpl');
	if (!$Tpl_modul->Ok) { htmlPageBasicError(t("plantillanotrobada")); }
	
	unset($bl);
  $bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
  $bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

	$ID = trim(stripslashes(obte_postget('id')));
	$accio = trim(stripslashes(obte_post('accio')));

	$wh_noadmin = " AND IdUsu='$LOGIN'";
	$result5 = $db->sql_query("SELECT * FROM news_LLISTES WHERE IdLli = '$ID'".$wh_noadmin);
	if ($db->sql_numrows($result5) == 0) {
		htmlPageError('Llista no accessible!');
	}
	$row5 = $db->sql_fetchrow($result5);
	$bl['ID'] = $row5['IdLli'];

  if ($accio == 'desar') {
		$numerr = tractar_formulari();
		if ($numerr == 0) {
			Header('Location: detalls.php?id='.$ID);
			die();
		}
		$bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);

		$bl['NOM'] = filtreQuote(trim(stripslashes($_POST['NOM'])));
		$bl['NOTES'] = filtreQuote(trim(stripslashes($_POST['NOTES'])));
		foreach ($CFG_CAMPANYES['TIPUS_LLISTA'] as $k => $v) {
			$bl['TIPUS_'.$k] = ($_POST['TIPUS']==$k) ? 'checked="checked"' : '';
		}

  } else {
		$bl['NOM'] = filtreQuote($row5['titol']);
		$bl['NOTES'] = filtreQuote($row5['notes']);
		foreach ($CFG_CAMPANYES['TIPUS_LLISTA'] as $k => $v) {
			$bl['TIPUS_'.$k] = ($row5['tipus']==$k) ? 'checked="checked"' : '';
		}
  }
	
	include ('houdini_cap.inc');
	echo $Tpl_modul->mergeBlock('HEAD', $bl);
	echo $Tpl_modul->mergeBlock('FOOT', $bl);
	include ('houdini_peu.inc');
}


// Valida formulari. Si ok fa update, si nok retorna nºerror
function tractar_formulari() {
global $db, $CFG_CAMPANYES, $ID, $LOGIN;

	$camps = array();
	//$camps['IdUsu'] = $LOGIN;
	$camps['dh_modif'] = date("Y-m-d H:i:s");

	$camps['tipus'] = intval($_POST['TIPUS']);
	if (!isset($CFG_CAMPANYES['TIPUS_LLISTA'][$camps['tipus']])) return 2;

	$camps['titol'] = trim(stripslashes($_POST['NOM']));
	if ($camps['titol'] == '') return 1;

	$camps['notes'] = trim(stripslashes($_POST['NOTES']));

	fer_update('news_LLISTES', $camps, "IdLli = '$ID' AND IdUsu='$LOGIN'");
	//register_add($T_LANG['adm_llistes'], 'modificada llista id: '.$ID);

	return 0;
}

?>