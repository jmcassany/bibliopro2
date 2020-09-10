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
	$Tpl_modul->scanFile('pas1_ca.tpl');
	if (!$Tpl_modul->Ok) { htmlPageBasicError(t("plantillanotrobada")); }
	
	unset($bl);
  $bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
  $bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

	$ID = trim(stripslashes(obte_postget('id')));
	$accio = trim(stripslashes(obte_post('accio')));

  if ($accio == 'desar') {
		$numerr = tractar_formulari();
		if ($numerr == 0) {
			//Header('Location: index.php');
			Header('Location: pas2.php?id='.$ID);
			die();
		}
		$bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);

		$bl['TITOL'] = filtreQuote(trim(stripslashes($_POST['TITOL'])));
		$bl['SUBJECT'] = filtreQuote(trim(stripslashes($_POST['SUBJECT'])));
		$bl['NOM'] = filtreQuote(trim(stripslashes($_POST['NOM'])));
		$bl['EMAIL'] = filtreQuote(trim(stripslashes($_POST['EMAIL'])));
		$bl['EMAIL_REPLY'] = filtreQuote(trim(stripslashes($_POST['EMAIL_REPLY'])));

  } elseif ($ID!='') {  //editar
		$wh_noadmin = " AND IdUsu='$LOGIN'";
		$result5 = $db->sql_query("SELECT * FROM news_CAMPANYES WHERE IdCam = '$ID'".$wh_noadmin);
		if ($db->sql_numrows($result5) == 0) {
			htmlPageError('Campanya no accessible!');
		}
		$row5 = $db->sql_fetchrow($result5);
		$bl['ID'] = $row5['IdCam'];
		$bl['TITOL'] = filtreQuote($row5['titol']);
		$bl['SUBJECT'] = filtreQuote($row5['subject']);
		$bl['NOM'] = filtreQuote($row5['from_name']);
		$bl['EMAIL'] = filtreQuote($row5['from_email']);
		$bl['EMAIL_REPLY'] = filtreQuote($row5['reply_to']);

  } else {
		$bl['NOM'] = 'jamoros';
		$bl['EMAIL'] = 'jordi.amoros@antaviana.cat';
		$bl['EMAIL_REPLY'] = 'jordi.amoros@antaviana.cat';	
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
	$camps['dh_modif'] = date("Y-m-d H:i:s");

	$camps['titol'] = trim(stripslashes($_POST['TITOL']));
	if ($camps['titol'] == '') return 1;

	$camps['subject'] = trim(stripslashes($_POST['SUBJECT']));	
	if ($camps['subject'] == '') return 2;

	$camps['from_name'] = trim(stripslashes($_POST['NOM']));
	if ($camps['from_name'] == '') return 3;

	$camps['from_email'] = trim(stripslashes($_POST['EMAIL']));
	if ($camps['from_email'] == '') return 4;
	if (!eregi($CFG_CAMPANYES['EMAIL_VALID'],$camps['from_email'])) return 4;

	$camps['reply_to'] = trim(stripslashes($_POST['EMAIL_REPLY']));
	if (($camps['reply_to']!='')&&(!eregi($CFG_CAMPANYES['EMAIL_VALID'],$camps['reply_to']))) return 5;
	
	if ($ID=='') {
		$camps['IdUsu'] = $LOGIN;
		$camps['estat'] = 10;
		$camps['dh_alta'] = $camps['dh_modif'];
		fer_insert('news_CAMPANYES', $camps);
		$ID = $db->sql_nextid();
		register_add('Newsletters', 'Creada campanya id: '.$ID);
	} else {
		fer_update('news_CAMPANYES', $camps, "IdCam = '$ID' AND IdUsu='$LOGIN'");
		//register_add($T_LANG['adm_campanyes'], 'modificada campanya id: '.$ID);
	}

	return 0;
}

?>