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
	$Tpl_modul->scanFile('clics_ca.tpl');
	if (!$Tpl_modul->Ok) { htmlPageBasicError(t("plantillanotrobada")); }
	
	unset($bl);
  	$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
  	$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

	$ID = trim(stripslashes(obte_postget('id')));
	$bl['ID'] = $ID;
	
	$wh_noadmin = " AND USUARI_HOUDINI='$LOGIN'";
	$result5 = $db->sql_query("SELECT * FROM NEWSLETTERS WHERE IdCam = ".$ID.$wh_noadmin);
	if ($db->sql_numrows($result5) == 0) {
		htmlPageError('Campanya no accessible!');
	}
	$row5 = $db->sql_fetchrow($result5);
	
	$bl['TOTAL']=0;
	$result6 = $db->sql_query("SELECT * FROM TE_NNL_NL WHERE ID_NL = ".$row5['ID']);
	if ($db->sql_numrows($result6) == 0) {
		htmlPageError('Campanya no accessible 2!');
	}
	while ($row6 = $db->sql_fetchrow($result6))
	{
		$bl['LINKS'] = $row6['LINKS'];	
		
		$bl['TOTAL'] = $bl['TOTAL'] + $bl['LINKS'];
			
		$result7 = $db->sql_query("SELECT * FROM NOTICIES_NEWSLETTER WHERE ID = ".$row6['ID_NNL']);
		/*if ($db->sql_numrows($result7) == 0) {
			htmlPageError('Campanya no accessible 3!');
		}*/
		$row7 = $db->sql_fetchrow($result7);
		$bl['NOTICIA'] = '<a href="../../../../public/view-not.php?ID='.$row5['ID'].'&amp;idnot='.$row6['ID_NNL'].'&amp;SKIN='.$row5['SKIN'].'" target="_blank">'.$row7['TITOL'].'</a>';
		
		$bl['RESULTAT'] .= $Tpl_modul->mergeBlock('COS', $bl);
	}	

	include ('houdini_cap.inc');
	echo $Tpl_modul->mergeBlock('HEAD', $bl);
	echo $Tpl_modul->mergeBlock('FOOT', $bl);
	include ('houdini_peu.inc');
}

?>