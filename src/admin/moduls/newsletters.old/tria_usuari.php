<?php

$CONFIG_PATHPHP = '../../../media/php';
require ('../../config_admin.inc');
accessGroupPermCheck('newsletter');  //PDT permís concret per campanyes

require_once('config_bd.inc');

if (accessGetGroup() < 5) {
	header("Location: index.php");
}

   tractament();


function tractament() {
	global $db;

	$Tpl_modul = new awTemplate();
	$Tpl_modul->scanFile('tria_usuari_ca.tpl');
	if (!$Tpl_modul->Ok) { htmlPageBasicError(t("plantillanotrobada")); }
	
	unset($bl);

	//$accio = trim(stripslashes($_POST['accio']));
	//$USUARI = trim(stripslashes($_POST['USUARI']));
	$accio = ''; $USUARI = '';
	if (isset($_POST['accio'])) $accio = trim(stripslashes($_POST['accio']));
	if (isset($_POST['USUARI'])) $USUARI = trim(stripslashes($_POST['USUARI']));

  if ($accio == 'desar') {  	
	  $users = new dbUsers();
	  //$user = $users->readUser($USUARI);
		if ($users->existsLogin($USUARI)) {
			accessSetValue('usu_gestionat', $USUARI);
			Header('Location: index.php');
			die();
		}
		$bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR1', $bl);
  }

  if ($USUARI=='') {
  	//$USUARI = accessGetValue('usu_gestionat');  //per defecte mostrar usuari gestionat
  	//if ($USUARI=='') $USUARI = accessGetLogin();  //sinó mostrar usuari propi

	$result = mysql_query("SELECT * FROM USERS WHERE STATUS=0");
	while ($rowUser = mysql_fetch_array($result)){
		$USUARI .= '<option value="'.$rowUser['LOGIN'].'">'.$rowUser['LOGIN'].'</option>';
	}

  }
	//$bl['USUARI'] = filtreQuote($USUARI);
	$bl['USUARI'] = $USUARI;



	include ('houdini_cap.inc');
	echo $Tpl_modul->mergeBlock('HEAD', $bl);
	echo $Tpl_modul->mergeBlock('FOOT', $bl);
	include ('houdini_peu.inc');
}

?>