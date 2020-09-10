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
	$Tpl_modul->scanFile('crea_ca.tpl');
	if (!$Tpl_modul->Ok) { htmlPageBasicError(t("plantillanotrobada")); }
	
	unset($bl);
  $bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
  $bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];


	$accio = trim(stripslashes(obte_post('accio')));
  if ($accio == 'desar') {
		$numerr = tractar_formulari();
		if ($numerr == 0) {
			//Header('Location: index.php');
			Header('Location: detalls.php?id='.$ID);
			die();
		}
		$bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);

		$bl['NOM'] = filtreQuote(trim(stripslashes($_POST['NOM'])));
		$bl['NOTES'] = filtreQuote(trim(stripslashes($_POST['NOTES'])));
  }

	foreach ($CFG_CAMPANYES['TIPUS_LLISTA'] as $k => $v) {
		$bl['TIPUS_'.$k] = ($_POST['TIPUS']==$k) ? 'checked="checked"' : '';
	}
	
	include ('houdini_cap.inc');
	echo $Tpl_modul->mergeBlock('HEAD', $bl);
	echo $Tpl_modul->mergeBlock('FOOT', $bl);
	include ('houdini_peu.inc');
}

// Valida formulari. Si ok fa insert, si nok retorna nºerror
function tractar_formulari() {
global $db, $CFG_CAMPANYES, $ID, $LOGIN;

	$camps = array();
	$camps['IdUsu'] = $LOGIN;
	$camps['estat'] = 1;
	$camps['dh_alta'] = date("Y-m-d H:i:s");
	$camps['dh_modif'] = $camps['dh_alta'];

	$camps['tipus'] = intval($_POST['TIPUS']);
	if (!isset($CFG_CAMPANYES['TIPUS_LLISTA'][$camps['tipus']])) return 2;

	$camps['titol'] = trim(stripslashes($_POST['NOM']));
	if ($camps['titol'] == '') return 1;

	$camps['notes'] = trim(stripslashes($_POST['NOTES']));

	fer_insert('news_LLISTES', $camps);
	$ID = $db->sql_nextid();
	register_add('Newsletters', 'Creada llista id: '.$ID);

	return 0;
}

?>