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
	$Tpl_modul->scanFile('pas3_ca.tpl');
	if (!$Tpl_modul->Ok) { htmlPageBasicError(t("plantillanotrobada")); }
	
	unset($bl);
  $bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
  $bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

	$ID = trim(stripslashes(obte_postget('id')));
	$accio = trim(stripslashes(obte_post('accio')));

	$wh_noadmin = " AND IdUsu='$LOGIN'";
	$result5 = $db->sql_query("SELECT * FROM news_CAMPANYES WHERE IdCam = '$ID'".$wh_noadmin);
	if ($db->sql_numrows($result5) == 0) {
		htmlPageError('Campanya no accessible!');
	}
	$row5 = $db->sql_fetchrow($result5);
	$bl['ID'] = $row5['IdCam'];

  if ($accio == 'desar') {
		$numerr = tractar_formulari($row5);
		if ($numerr == 0) {
			//Header('Location: index.php');
			Header('Location: pas2c.php?id='.$ID);
			die();
		} elseif ($numerr == -1) {
			Header('Location: resum.php?id='.$ID);
			die();
		} elseif ($numerr == -2) {
			Header('Location: pas3b.php?id='.$ID);
			die();
			
		}
		$bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);

		//$bl['FITXER'] = filtreQuote(trim(stripslashes($_POST['FITXER'])));
		$bl['NOTES'] = filtreQuote(trim(stripslashes($_POST['NOTES'])));
		$bl['TIPUS_1'] = ($_POST['TIPUS']==1) ? 'checked="checked"' : '';
		$bl['TIPUS_2'] = ($_POST['TIPUS']==2) ? 'checked="checked"' : '';
		$llistes = array();
		if (count($_POST['LLISTA']) > 0) foreach($_POST['LLISTA'] as $k => $v) $llistes[] = $k;
		
	} else {
		$bl['TIPUS_1'] = ($row5['desti_llista']!='') ? 'checked="checked"' : '';
		$bl['TIPUS_2'] = ($row5['desti_manual']!='') ? 'checked="checked"' : '';
		$llistes = explode(',', $row5['desti_llista']);
  }

  $result7 = $db->sql_query("SELECT * FROM news_LLISTES WHERE IdUsu = '$LOGIN' ORDER BY titol ASC, dh_alta DESC");
  while ($row7 = $db->sql_fetchrow($result7)) {
  	$rowAux = $db->sql_fetchrow( $db->sql_query("SELECT count(*) AS n1 FROM news_SUBSCRIPTORS WHERE IdLli = '".$row7['IdLli']."' AND estat='1'") );
  	$det['NUM_SUBSCRITS'] = numero_num2fmt(intval($rowAux['n1']));
  	
  	$det['ID'] = $row7['IdLli'];
  	$det['TITOL'] = $row7['titol'];
  	$det['D_ALTA'] = data_bd2fmt($row7['dh_alta']);
  	$det['D_MODIF'] = ($row7['dh_modif']=='') ? '&nbsp;' : data_bd2fmt($row7['dh_modif']);
  	$det['MARCAT'] = (in_array($row7['IdLli'], $llistes)) ? 'checked="checked"' : '';

  	$bl['LIS_LLISTES'] .= $Tpl_modul->mergeBlock('LI_LLISTA', $det);
	}
	
	include ('houdini_cap.inc');
	echo $Tpl_modul->mergeBlock('HEAD', $bl);
	echo $Tpl_modul->mergeBlock('FOOT', $bl);
	include ('houdini_peu.inc');
}

// Valida formulari. Si ok fa insert, si nok retorna nºerror
function tractar_formulari($rowCam) {
global $db, $CFG_CAMPANYES, $ID, $LOGIN;

	$camps = array();
	$TIPUS = intval($_POST['TIPUS']);
	if (($TIPUS!=1)&&($TIPUS!=2)) return 1;

	if ($TIPUS == 1) {  //afegir de llistes
		if (count($_POST['LLISTA'])==0) return 2;
		$camps['desti_llista'] = '';
		foreach($_POST['LLISTA'] as $k => $v) {
			$camps['desti_llista'] .= $k.',';
		}
		if ($camps['desti_llista'] != '') $camps['desti_llista'] = substr($camps['desti_llista'],0,-1);

		if ($rowCam['estat'] < 30) $camps['estat'] = 30;
		$camps['dh_modif'] = date("Y-m-d H:i:s");
		fer_update('news_CAMPANYES', $camps, "IdCam = '$ID' AND IdUsu='$LOGIN'");
		//register_add($T_LANG['adm_campanyes'], 'modificats destinataris campanya id: '.$ID);		
		return -1;

	} elseif ($TIPUS == 2) {  //anar al següent pas
		return -2;
		
	} else {
		return 1;
	}

	return 0;
}

?>