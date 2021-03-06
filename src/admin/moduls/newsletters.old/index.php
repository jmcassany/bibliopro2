<?php

$CONFIG_PATHPHP = '../../../media/php';
require ('../../config_admin.inc');
accessGroupPermCheck('newsletter');  //PDT permís concret per campanyes

$CONFIG_PATHCAMPANYES = '';
require_once($CONFIG_PATHCAMPANYES.'config.inc');

   tractament();


function tractament() {
	global $db, $T_LANG, $CFG_CAMPANYES, $LOGIN;

	$Tpl_modul = new awTemplate();
	$Tpl_modul->scanFile('index_ca.tpl');
	if (!$Tpl_modul->Ok) { htmlPageBasicError(t("plantillanotrobada")); }
	
	unset($bl);
  $bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
  $bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];




	$det = array();
  $det['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

		//**** Bucle desades
		$wh_filtre = " WHERE IdUsu = '$LOGIN' AND estat < '100'";
		$wh_ordre = " ORDER BY dh_alta DESC";
		$wh_limit = " LIMIT 0, 2";
	$bl['LINIES_DESADES'] = '';
  $result5 = $db->sql_query("SELECT * FROM news_CAMPANYES ".$wh_filtre.$wh_ordre.$wh_limit);
  while ($row5 = $db->sql_fetchrow($result5)) {
  	$det['ID'] = $row5['IdCam'];
  	$det['TITOL'] = $row5['titol'];
  	$det['D_ALTA'] = data_bd2fmt($row5['dh_alta']);
  	$det['D_MODIF'] = ($row5['dh_modif']=='') ? '&nbsp;' : data_bd2fmt($row5['dh_modif']);

		$det['PAS1'] = $Tpl_modul->mergeBlock('PAS_OK', $bl);
		$det['PAS2'] = ($row5['format'] > 0) ? $Tpl_modul->mergeBlock('PAS_OK', $bl) : $Tpl_modul->mergeBlock('PAS_KO', $bl);
		$det['PAS3'] = (($row5['desti_llista']!='')||($row5['desti_manual']!='')) ? $Tpl_modul->mergeBlock('PAS_OK', $bl) : $Tpl_modul->mergeBlock('PAS_KO', $bl);

  	$bl['LINIES_DESADES'] .= $Tpl_modul->mergeBlock('LINIA_DESADES', $det);
	}

		//**** Bucle enviades
		$wh_filtre = " WHERE IdUsu = '$LOGIN' AND estat >= '100'";
		$wh_ordre = " ORDER BY dh_inici DESC";
		$wh_limit = " LIMIT 0, 2";
	$bl['LINIES_ENVIADES'] = '';
  $result5 = $db->sql_query("SELECT * FROM news_CAMPANYES ".$wh_filtre.$wh_ordre.$wh_limit);
  while ($row5 = $db->sql_fetchrow($result5)) {
  	$rowAux = $db->sql_fetchrow( $db->sql_query("SELECT count(*) AS n1 FROM news_DESTINATARIS WHERE IdCam = '".$row5['IdCam']."'") );
  	$det['NUM_DESTINATARIS'] = numero_num2fmt(intval($rowAux['n1']));

  	$det['ID'] = $row5['IdCam'];
  	$det['TITOL'] = $row5['titol'];
  	$det['D_ALTA'] = data_bd2fmt($row5['dh_alta']);
  	$det['D_MODIF'] = ($row5['dh_modif']=='') ? '&nbsp;' : data_bd2fmt($row5['dh_modif']);

	if($row5['dh_inici'] != ''){
	  	$det['D_ENVIAMENT'] = data_bd2fmt($row5['dh_inici']);
	}
	else {
		$det['D_ENVIAMENT'] = '<a href="campanyes/enviament.php?id='.$det['ID'].'"><img src="media/gif/bt_reenviar.gif" alt="Reenviar" /></a>';
	}

	$det['PREVIEW'] = $Tpl_modul->mergeBlock('PREVIEW_'.$row5['format'], $det);

  	$bl['LINIES_ENVIADES'] .= $Tpl_modul->mergeBlock('LINIA_ENVIADES', $det);
	}


	include ('houdini_cap.inc');
	echo $Tpl_modul->mergeBlock('HEAD', $bl);
	echo $Tpl_modul->mergeBlock('FOOT', $bl);
	include ('houdini_peu.inc');

}

?>