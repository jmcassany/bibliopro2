<?php
	//****
	//**** Formulari per desapuntar-se
	//****
	require_once($CONFIG_PATHBASE . '/public/config.php');
	require_once($CFG_CAMPANYES['PATH_FUNCIONS'].'tipic_db.php');
	require_once($CFG_CAMPANYES['PATH_FUNCIONS'].'tipic_funcions.php');


	// desencriptar paràmetres i validar k són ok.
	//$xurro = urldecode(stripslashes(obte_get('id')));
	$xurro = trim(stripslashes(obte_get('id')));
	$valors = explode($CRIPTO_SEPAR, decrypt($xurro, $CRIPTO_KEY));

	$nl = trim(stripslashes(obte_postget('ID')));

	if ((count($valors)==5)&&($valors[3]==$CRIPTO_CHECK)) {
		$idcam = $valors[0];
		$idusu = $valors[1];
		$email = $valors[2];
		$idioma = $valors[3];
		//echo "Campanya: $idcam  ,Usuari: $idusu  ,Email: $email";  //proves
		//die();

		// Llegir registre a actualitzar
		$result5 = $db->sql_query("SELECT estat,IdLli FROM " . TAULA_DESTINATARIS . " WHERE IdCam = '$idcam' AND email='$email' AND IdUsu='$idusu'");
		if ($db->sql_numrows($result5) > 0) {
			$row5 = $db->sql_fetchrow($result5);
			if ($row5['estat'] == 0) {  //si encara no s'ha enviat és un test i no cal actualitzar
				$MISSATGE = 'No es pot donar de baixa un correu de test!';
			} else {
				$camps = array();
				$camps['estat'] = 21;
				$camps['dh_recepcio'] = date("Y-m-d H:i:s");
				if (fer_update('newsletter_destinataris', $camps, "IdCam = '$idcam' AND email='$email' AND IdUsu='$idusu'", 0)) {
					if ($row5['IdLli'] == 0) { //afegit manualment!
						// Si consta a alguna llista, marcar-lo com unsubscrit perquè quedi constància !
						$result9 = $db->sql_query("SELECT estat FROM " . TAULA_SUBSCRIPTORS . " WHERE email='$email' AND IdUsu='$idusu'");
						if ($db->sql_numrows($result9) > 0) {
							$row9 = $db->sql_fetchrow($result9);
							if ($row9['estat'] != 3)  {
								$campsSub = array();
								$campsSub['estat'] = 3;
								$campsSub['dh_baixa'] = date("Y-m-d H:i:s");
								fer_update('newsletter_subscriptors', $campsSub, "email='$email' AND IdUsu='$idusu'");
							}
						}

					} else {  //d'una llista
						$campsSub = array();
						$campsSub['estat'] = 3;
						$campsSub['dh_baixa'] = date("Y-m-d H:i:s");
						// unsubscriure d'una sola llista:
						fer_update(TAULA_SUBSCRIPTORS, $campsSub, "IdLli = '".$row5['IdLli']."' AND email='$email' AND IdUsu='$idusu'");
						// a IdLli hi consta una llista, però podria ser que el mateix mail fós a varies llistes.
						// Fer update per les diferents llistes de l'usuari, per si de cas, i marcar-lo com unsubscrit
						//fer_update('newsletter_subscriptors', $campsSub, "email='$email' AND IdUsu='$idusu'");
					}

					$MISSATGE = 'Baixa feta correctament pel correu: <strong>'.$email.'</strong>';
				} else $MISSATGE = 'Paràmetres erronis!';
			}
		} else $MISSATGE = 'Destinatari no trobat a la llista!';
	} else $MISSATGE = 'Paràmetres erronis!';



// retorna html amb el missatge de l'acció

include_once("public/config.php");

include_once("admin/config/nl-html-public.inc");

$sql = "select * from newsletter_newsletter where ID=".$nl;
$query = mysql_query($sql);
$row = mysql_fetch_array($query);

$CAP = $row['CAP'];
$SKIN = $row['SKIN'];
$tornar = 'public/view.php?ID='.$nl;

$data['HTML_CAP'] = capHTML('', '', '', '', '', 'Baixa', $SKIN, $CAP);
$data['HTML_PEU'] = peuHTML($SKIN, '', '', '', $CAP);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ca" lang="ca">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Antaviana</title>
	<style type="text/css">
	a, a:visited, a:active {
	    color: #8e003d;
	    text-decoration:none;
	}
	p {
		font-size: .8125em;
		line-height: 1.5em;
		margin: 0;
		padding: 0;
	}
	</style>
</head>
<body style="background-color:#fb7804; font-family:Arial, Verdana, sans-serif; font-size:100%; color:#000" link="#8e003d" id="top">

	<!-- Capçalera -->
	<table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;width:750px; margin:0 auto;background-color:#fff;font-family:Arial, Verdana, sans-serif">
	<?php echo $data['HTML_CAP']; ?>
	</table>
	<!-- /Capçalera -->

	<!-- Contingut -->
	<table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;width:750px; margin:0 auto;background-color:#fff;font-family:Arial, Verdana, sans-serif">
			<tr><td colspan="3">&nbsp;</td></tr>
			<tr>
				<td colspan="3" style="padding:0 17px 0 17px">
					<table border="0" cellspacing="0" cellpadding="0" style="width:571px; border-collapse:collapse;">
						<tr>
							<!-- Contingut principal -->
							<td width="556" valign="top" style="font-size:.75em;">
								<?php echo $MISSATGE; ?>
							</td>
							<!-- /Contingut principal -->
						</tr>
					</table>
				</td>
			</tr>
			<tr><td colspan="3">&nbsp;</td></tr>
	</table>
	<!-- /Contingut -->

	<!-- Peu -->
	<table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;width:750px; margin:0 auto;background-color:#fff;font-family:Arial, Verdana, sans-serif">
	<?php echo $data['HTML_PEU']; ?>
	</table>
	<!-- /Peu -->

</body>
</html>
