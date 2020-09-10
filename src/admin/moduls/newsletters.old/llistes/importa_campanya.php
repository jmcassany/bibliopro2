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
	$Tpl_modul->scanFile('importa_campanya_ca.tpl');
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

	$bl['OPTS_LLISTA'] = '<option value="0" selected="selected">...</option>';
	$wh_filtre = " WHERE IdUsu = '$LOGIN' AND estat >= '100'";
	$wh_ordre = " ORDER BY dh_inici DESC";
  $result5 = $db->sql_query("SELECT IdCam,titol,dh_inici FROM news_CAMPANYES ".$wh_filtre.$wh_ordre.$wh_limit);
  while ($row5 = $db->sql_fetchrow($result5)) {
  	$rowAux = $db->sql_fetchrow( $db->sql_query("SELECT count(*) AS n1 FROM news_DESTINATARIS WHERE IdCam = '".$row5['IdCam']."' AND (estat='1' OR estat='10')") );
  	if ($rowAux['n1'] > 0) {
			$nomaux = filtreQuote($row5['titol']).' ('.numero_num2fmt(intval($rowAux['n1'])).' subscriptors, '.data_bd2fmt($row5['dh_inici']).')';
	  	$bl['OPTS_LLISTA'] .= '<option value="'.$row5['IdCam'].'">'.$nomaux.'</option>';
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

	$compta = array();

	$LLISTA = intval($_POST['LLISTA']);
	if ($LLISTA == 0) return 1;
	$wh_noadmin = " AND IdUsu='$LOGIN'";
	$result5 = $db->sql_query("SELECT IdCam FROM news_CAMPANYES WHERE IdCam = '$LLISTA'".$wh_noadmin);
	if ($db->sql_numrows($result5) == 0) return 1;

	$camps = array();
	$camps['IdSub'] = '';  //autonumèric
	$camps['IdUsu'] = $LOGIN;
	$camps['IdLli'] = $ID;
	$camps['estat'] = 1;
	$camps['tipus'] = 2;
	$camps['dh_alta'] = date("Y-m-d H:i:s");
	$camps['dh_baixa'] = NULL;

	$wh_noadmin = " AND IdUsu='$LOGIN'";
	$result5 = $db->sql_query("SELECT * FROM news_DESTINATARIS WHERE IdCam = '$LLISTA' AND (estat='1' OR estat='10')".$wh_noadmin);
  while ($row5 = $db->sql_fetchrow($result5)) {
		$result1 = $db->sql_query("SELECT IdSub FROM news_SUBSCRIPTORS WHERE IdLli='$ID' AND email='".$row5['email']."' LIMIT 0,1");
		if ($db->sql_numrows($result1) > 0) {
		  //$row1 = $db->sql_fetchrow($result1);
		  $compta['nok_duplicat']++;

		} else {
			$camps['email'] = $row5['email'];
			$camps['nom'] = $row5['nom'];
			//$camps['web'] = $row5['web'];
			//$camps['telefon1'] = $row5['telefon1'];
			//$camps['telefon2'] = $row5['telefon2'];
			//$camps['codipostal'] = $row5['codipostal'];
			//$camps['poblacio'] = $row5['poblacio'];
			//$camps['adreca'] = $row5['adreca'];
			//$camps['pais'] = $row5['pais'];
			//$camps['notes'] = $row5['notes'];
			if (fer_insert('news_SUBSCRIPTORS', $camps, 0)) $compta['ok']++;
			else $compta['nok_error']++;
	  }
	}

	return 0;
}

?>