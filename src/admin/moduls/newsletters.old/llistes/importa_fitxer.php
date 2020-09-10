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
	$Tpl_modul->scanFile('importa_fitxer_ca.tpl');
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
			$bl['EMAILS'] = '';
		} else {
			$bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);
			$bl['EMAILS'] = filtreQuote(trim(stripslashes($_POST['EMAILS'])));
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
	$rowAux = $db->sql_fetchrow( $db->sql_query("SELECT count(*) AS n1 FROM news_SUBSCRIPTORS WHERE IdLli = '$ID'") );
	$bl['NUM_SUBSCRITS'] = numero_num2fmt(intval($rowAux['n1']));

	include ('houdini_cap.inc');
	echo $Tpl_modul->mergeBlock('HEAD', $bl);
	echo $Tpl_modul->mergeBlock('FOOT', $bl);
	include ('houdini_peu.inc');
}

// Valida formulari. Si ok fa insert, si nok retorna nºerror
function tractar_formulari() {
global $db, $CFG_CAMPANYES, $ID, $LOGIN, $compta;
//global $HTTP_POST_FILES;

	$compta = array();

	if (!isset($_POST['CONFIRMA'])) return 2;

	//$tmp_name = $HTTP_POST_FILES['EMAILS']['tmp_name'];
	$tmp_name = $_FILES['EMAILS']['tmp_name'];
	if ( (!$tmp_name)||($tmp_name=='') ) {
	  return 1;
	} else {
		//if ($HTTP_POST_FILES['EMAILS']['size']==0) return 1;
		if ($_FILES['EMAILS']['size']==0) return 1;
		if (!$fp = fopen($tmp_name, 'r')) return 1;
		$EMAILS = fread($fp, filesize($tmp_name));
		fclose($fp);
	}
	if ($EMAILS == '') return 1;

	$camps = array();
	$camps['IdSub'] = '';  //autonumèric
	$camps['IdUsu'] = $LOGIN;
	$camps['IdLli'] = $ID;
	$camps['estat'] = 1;
	$camps['tipus'] = 2;
	$camps['dh_alta'] = date("Y-m-d H:i:s");
	$camps['dh_baixa'] = NULL;

	// bucle per analitzar els emails.....
	preg_match_all($CFG_CAMPANYES['EMAIL_EXTRACTOR'], $EMAILS, $out);
	if (count($out[0])==0) return 1;

  foreach ($out[0] as $k => $v) {
		//echo $v."<br>";
		$result1 = $db->sql_query("SELECT * FROM news_SUBSCRIPTORS WHERE IdLli='$ID' AND email='$v' LIMIT 0,1");
		if ($db->sql_numrows($result1) > 0) {
		  //$row1 = $db->sql_fetchrow($result1);
		  $compta['nok_duplicat']++;

		} else {
			$camps['email'] = $v;
			if (fer_insert('news_SUBSCRIPTORS', $camps, 0)) $compta['ok']++;
			else $compta['nok_error']++;
	  }
	}

	return 0;
}

?>