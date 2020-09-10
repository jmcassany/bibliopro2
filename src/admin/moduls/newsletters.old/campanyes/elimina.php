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
	$result5 = $db->sql_query("SELECT * FROM news_CAMPANYES WHERE IdCam = '$ID'".$wh_noadmin);
	if ($db->sql_numrows($result5) == 0) {
		htmlPageError('Campanya no accessible!');
	}
	$row5 = $db->sql_fetchrow($result5);
	
	
	
	if (($row5['tipus'] == 3) or ($row5['tipus'] == 4)){ 
		//ELIMINAR HTML NEWSLETTER
		$butlleti = '../../../../public/plantilla'.$_POST['id'].'.html';
		if (file_exists($butlleti)) {
		  unlink($butlleti);
		}
		
		//selecció newsletter jamoros x les taules d'enllaç de notícies i banners
		$wh_noadmin = " AND USUARI_HOUDINI='$LOGIN'";
		$result6 = $db->sql_query("SELECT * FROM NEWSLETTERS WHERE IdCam = ".$_POST['id'].$wh_noadmin);
		if ($db->sql_numrows($result6) > 0) {
		  	$row6 = $db->sql_fetchrow($result6);
		  	 
			//ELIMINAR NEWSLETTER BBDD jamoros
			$wh_noadmin = " AND USUARI_HOUDINI='$LOGIN'";
			$result7 = $db->sql_query("DELETE FROM NEWSLETTERS WHERE IdCam = ".$_POST['id'].$wh_noadmin);
			
			$result8 = $db->sql_query("DELETE FROM TE_NNL_NL WHERE ID_NL = ".$row6['ID']);
			$result9 = $db->sql_query("DELETE FROM TE_BAN_NL WHERE ID_NL = ".$row6['ID']);

			$result10 = $db->sql_query("DELETE FROM CONTROL_CLICS WHERE ID_NL = ".$row6['ID']);
		}
	}
	
	
	
  if ($accio == 'desar') {
		$numerr = tractar_formulari();
		if ($row5['estat']>=100) Header('Location: index_enviades.php');
		else Header('Location: index.php');
		die();
  }

	$bl['ID'] = $row5['IdCam'];
	$bl['NOM'] = filtreQuote($row5['titol']);
	$bl['PREVIEW'] = $Tpl_modul->mergeBlock('PREVIEW_'.$row5['format'], $bl);
	$rowAux = $db->sql_fetchrow( $db->sql_query("SELECT count(*) AS n1 FROM news_DESTINATARIS WHERE IdCam = '$ID'") );
	$bl['NUM_SUBSCRITS'] = numero_num2fmt(intval($rowAux['n1']));
	
	include ('houdini_cap.inc');
	echo $Tpl_modul->mergeBlock('HEAD', $bl);
	echo $Tpl_modul->mergeBlock('FOOT', $bl);
	include ('houdini_peu.inc');
}

function tractar_formulari() {
global $db, $CFG_CAMPANYES, $ID, $LOGIN;

	fer_delete('news_DESTINATARIS', "IdCam = '$ID' AND IdUsu='$LOGIN'");
	fer_delete('news_CAMPANYES', "IdCam = '$ID' AND IdUsu='$LOGIN'");
	register_add('Newsletters', 'Eliminada campanya id: '.$ID);
	return 0;
}

?>