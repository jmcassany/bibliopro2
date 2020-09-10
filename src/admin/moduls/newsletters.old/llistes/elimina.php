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
	$Tpl_modul->scanFile('elimina_ca.tpl');
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

  if ($accio == 'desar') {
		$numerr = tractar_formulari();
		Header('Location: index.php');
		die();
  }

	$bl['ID'] = $row5['IdLli'];
	$bl['NOM'] = filtreQuote($row5['titol']);
	$bl['NOTES'] = nl2br($row5['notes']);
	$bl['TIPUS'] = $CFG_CAMPANYES['TIPUS_LLISTA'][$row5['tipus']];
	$rowAux = $db->sql_fetchrow( $db->sql_query("SELECT count(*) AS n1 FROM news_SUBSCRIPTORS WHERE IdLli = '$ID'") );
	$bl['NUM_SUBSCRITS'] = numero_num2fmt(intval($rowAux['n1']));
	
	include ('houdini_cap.inc');
	echo $Tpl_modul->mergeBlock('ALL', $bl);
	include ('houdini_peu.inc');
}

function tractar_formulari() {
global $db, $CFG_CAMPANYES, $ID, $LOGIN;

	fer_delete('news_SUBSCRIPTORS', "IdLli = '$ID' AND IdUsu='$LOGIN'");
	fer_delete('news_LLISTES', "IdLli = '$ID' AND IdUsu='$LOGIN'");
	register_add('Newsletters', 'Eliminada llista id: '.$ID);
	return 0;
}

?>