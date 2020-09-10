<?php
	//****
	//**** Retorna la imatge demanada i actualitza com a llegit per la Campanya+Correu donats.
	//****
	include_once('config.php');
	include_once('database/database.inc');

	$CONFIG_PATHCAMPANYES = 'admin/moduls/newsletters/';
	$CFG_CAMPANYES['PATH_FUNCIONS'] = $CONFIG_PATHCAMPANYES.'xin/';
	require_once($CONFIG_PATHCAMPANYES.'config_bd.inc');
	require_once($CFG_CAMPANYES['PATH_FUNCIONS'].'tipic_db.php');
	require_once($CFG_CAMPANYES['PATH_FUNCIONS'].'tipic_funcions.php');

	require_once($CFG_CAMPANYES['PATH_FUNCIONS'].'cripto.inc');


	$imatge = trim(stripslashes(obte_get('img')));
	//if ($imatge=='') $imatge = 'admin/comu/hlogo.gif';
	if ($imatge=='') $imatge = 'pix.gif';

	// desencriptar paràmetres i validar k són ok.
	//$xurro = urldecode(stripslashes(obte_get('id')));
	$xurro = trim(stripslashes(obte_get('id')));
	$valors = explode($CRIPTO_SEPAR, decrypt($xurro, $CRIPTO_KEY));

	if ((count($valors)==4)&&($valors[3]==$CRIPTO_CHECK)) {
		$idcam = $valors[0];
		$idusu = $valors[1];
		$email = $valors[2];
		//echo "Campanya: $idcam  ,Usuari: $idusu  ,Email: $email";  //proves
		//die();

		// Llegir registre a actualitzar
		$result5 = $db->sql_query("SELECT estat FROM news_DESTINATARIS WHERE IdCam = '$idcam' AND email='$email' AND IdUsu='$idusu'");
		if ($db->sql_numrows($result5) > 0) {
			$row5 = $db->sql_fetchrow($result5);
			if ($row5['estat'] == 1) {  //si consta com enviat, marcar com llegit, però no fer-ho si consta com a unsubscrit o encara no s'ha enviat!
				$camps = array();
				$camps['estat'] = 10;
				$camps['dh_recepcio'] = date("Y-m-d H:i:s");
				fer_update('news_DESTINATARIS', $camps, "IdCam = '$idcam' AND email='$email' AND IdUsu='$idusu'");
			}
		}
	}

	// retorna $imatge
	Header("Location: $imatge");
	die();
?>
