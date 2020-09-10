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
	$Tpl_modul->scanFile('mostra_ca.tpl');
	if (!$Tpl_modul->Ok) { htmlPageBasicError(t("plantillanotrobada")); }
	
	unset($bl);
  $bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
  $bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

	$ID = trim(stripslashes(obte_postget('id')));
	$accio = trim(stripslashes(obte_postget('accio')));
	
	

	$wh_noadmin = " AND IdUsu='$LOGIN'";
	$result5 = $db->sql_query("SELECT * FROM news_CAMPANYES WHERE IdCam = '$ID'".$wh_noadmin);
	if ($db->sql_numrows($result5) == 0) {
		htmlPageError('Campanya no accessible!');
	}
	$row5 = $db->sql_fetchrow($result5);
	$bl['ID'] = $row5['IdCam'];
	$bl['TITOL'] = $row5['titol'];
	
	
	if($row5['tipus']==3 || $row5['tipus']==4){
		$wh_noadmin2 = " AND USUARI_HOUDINI='$LOGIN'";
		$result6 = $db->sql_query("SELECT * FROM NEWSLETTERS WHERE IdCam = '$ID'".$wh_noadmin2);
		if ($db->sql_numrows($result6) == 0) {
			htmlPageError('Butlletí no accessible!');
		}
		$row6 = $db->sql_fetchrow($result6);
		$bl['SKIN'] = $row6['SKIN'];
		$bl['FRAME']="../../../../public/view.php?id=".$bl['ID']."&amp;SKIN=".$bl['SKIN']."";
	}else{	
		$fmt = intval($_GET['fmt']);
		$bl['FMT'] = $fmt;
		if ((($fmt==0)&&($row5['format']==3)) || ($fmt==2)) { //només text
			$bl['CONTINGUT'] = nl2br($row5['msg_text']);
		} else {
			$bl['CONTINGUT'] = $row5['msg_html'];
		}
		$bl['FRAME']="mostra_contingut.php?id=".$bl['ID']."&amp;fmt=".$bl['FMT']."";
	}
	//echo $Tpl_modul->mergeBlock('HEAD', $bl);
	//echo $Tpl_modul->mergeBlock('FOOT', $bl);
	
	echo $Tpl_modul->mergeBlock('ALL', $bl);
}

?>