<?php
	//****
	//**** Formulari per apuntar-se a una llista
	//****
	include_once('config.php');
	include_once('database/database.inc');

	$CONFIG_PATHCAMPANYES = 'admin/moduls/newsletters/';
	$CFG_CAMPANYES['PATH_FUNCIONS'] = $CONFIG_PATHCAMPANYES.'xin/';
	$CFG_CAMPANYES['PATH_MAILER'] = 'admin/php/lib/phpmailer/';  // ruta relativa fins la carpeta amb funcions phpmailer

	require_once($CONFIG_PATHCAMPANYES.'config_bd.inc');
	require_once($CFG_CAMPANYES['PATH_FUNCIONS'].'tipic_db.php');
	require_once($CFG_CAMPANYES['PATH_FUNCIONS'].'tipic_funcions.php');

	require_once($CFG_CAMPANYES['PATH_MAILER'].'class.phpmailer.php');
	require_once($CFG_CAMPANYES['PATH_FUNCIONS'].'cripto.inc');

	$DEBUG_NOMAILS=0;  // 1: per no enviar correu durant proves
	$idlli = intval(stripslashes(obte_postget('id')));
	$email = trim(stripslashes(obte_postget('email')));

	$nl = trim(stripslashes(obte_postget('ID')));
	
    	if ($idlli == 0) {
		mostrar_resposta("Falta especificar el ID de la lista!", array(), $nl);
		die();
	}
	$result7 = $db->sql_query("SELECT * FROM news_LLISTES WHERE IdLli='$idlli'");
	if ($db->sql_numrows($result7) == 0) {
		mostrar_resposta("No se encuentra el ID de la lista!", array(), $nl);
		die();
	}
	$rowLli = $db->sql_fetchrow($result7);

	if ($email == '') {
		mostrar_formulari($rowLli, $nl);

	} else {
			if (!eregi('^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$',$email)) {
				mostrar_resposta("El correo electrónico no es válido!", $rowLli, $nl);
				die();
			}
			$nom = trim(stripslashes(obte_postget('nom')));
			$cognoms = trim(stripslashes(obte_postget('cognoms')));
			$centre = trim(stripslashes(obte_postget('centre')));
			$pais = trim(stripslashes(obte_postget('pais')));

			$result9 = $db->sql_query("SELECT IdSub FROM news_SUBSCRIPTORS WHERE email='$email' AND IdLli='$idlli'");
			if ($db->sql_numrows($result9) > 0) {
				//$row9 = $db->sql_fetchrow($result9);
				$camps = array();
				$camps['estat'] = ($rowLli['tipus']==2) ? 4 : 1;  //1:actiu  4:pendent confirmació
				$camps['tipus'] = 3;
				$camps['dh_baixa'] = NULL;  //per si de cas s'havia donat de baixa prèviament
				$camps['nom'] = $nom;
				$camps['cognoms'] = $cognoms;
				$camps['centre'] = $centre;
				$camps['pais'] = $pais;
				$es_ok = fer_update('news_SUBSCRIPTORS', $camps, "email='$email' AND IdLli='$idlli'",0);
			} else {
				$camps = array();
				$camps['IdSub'] = '';  //autonumèric
				$camps['IdUsu'] = $rowLli['IdUsu'];
				$camps['IdLli'] = $idlli;
				$camps['estat'] = ($rowLli['tipus']==2) ? 4 : 1;  //1:actiu  4:pendent confirmació
				$camps['tipus'] = 3;
				$camps['dh_alta'] = date("Y-m-d H:i:s");
				$camps['dh_baixa'] = NULL;
				$camps['email'] = $email;
				$camps['nom'] = $nom;
				$camps['cognoms'] = $cognoms;
				$camps['centre'] = $centre;
				$camps['pais'] = $pais;
				$es_ok = fer_insert('news_SUBSCRIPTORS', $camps, 0);
			}
			if ($es_ok) {
				if ($rowLli['tipus']==2) {
					$string = $idlli.$CRIPTO_SEPAR.$email.$CRIPTO_SEPAR.$CRIPTO_CHECK;
					$criptat = urlencode(encrypt($string, $CRIPTO_KEY));

					$link_confirma = 'http://'.$_SERVER['SERVER_NAME'].$CONFIG_NOMCARPETA.'/news_confirm.php?ID='.$nl.'&amp;id='.$criptat;


					if ($DEBUG_NOMAILS==1) { // Per proves en local sense mail!!!!:
					  $MISSATGE = '(debug) Confirmación para el correo '.$email.'<br /><br />Link: <a href="'.$link_confirma.'">'.$link_confirma.'</a>';
					} else {
					  $mail = new phpmailer();  //creem un objecte de la clase phpmailer al que anomenem mail
					  $mail->SetLanguage("ca", $CFG_CAMPANYES['PATH_MAILER']."language/");  //definim l'idioma
					  $mail->PluginDir = $CFG_CAMPANYES['PATH_MAILER'];  //PluginDir li indicamem a la clase phpmailer on es troba la clase smtp
					  $mail->CharSet = "utf-8";

						if ($mail_sendtype == 'smtp') {
							$mail->Mailer = 'smtp';
				
							if ($mail_port != null) {
								$mail->Port = $mail_port;
							}
				
							if ($mail_host != null) {
								$mail->Host = $mail_host;
								if ($mail_SMTPAuth) {
									$mail->SMTPAuth = true;
									if ($mail_username != null && $mail_password != null) {
										$mail->Username = $mail_username;
										$mail->Password = $mail_password;
									}
								}
							} else {
								$mail->Mailer = 'mail';
							}
						}
						elseif ($mail_sendtype == 'sendmail') {
							$mail->Mailer = 'sendmail';
						}
						else {
							$mail->Mailer = 'mail';
						}

					  $mail->Timeout=30;  //el valor per defecte es 10, posem 30 per donar-li una mica més de marge
					  $mail->From = "noreply@bibliopro.cat";  //Indiquem quina és la nostra adreça de correu i el nom q volem q vegi l'usuari
					  $mail->FromName = "BiblioPRO";
					  $mail->Subject = "Confirmació de subscripció al butlletí";  //Assignem l'Assumpte del Missatge
					  $mail->AddAddress($email);  //Indiquem l'adreça del destinatari
					  $mail->Body = 'Per confirmar la subscripció, aneu a l\'enllaç següent:<br />'
					  						 .'<a href="'.$link_confirma.'">'.$link_confirma.'</a>';
					  $mail->AltBody = 'Per confirmar la subscripció, aneu a l\'enllaç següent:\n\n'
					  						 .$link_confirma.'\n\n';
					  $es_ok = $mail->Send();
						if ($es_ok) $MISSATGE = 'Enviado correo de confirmación a <strong>'.$email.'</strong><br /><br />Por favor revisad vuestro correo para confirmar la subscripción.';
					  else $MISSATGE = 'No se ha podido enviar el correu de confirmación a <strong>'.$email.'</strong>';
					}

				} else $MISSATGE = 'Gracias por tu interés en BiblioPRO. Te has suscrito a nuestro Boletín electrónico, que recibirás en: <strong>'.$email.'</strong>';
			} else {
				$MISSATGE = "No se ha podido hacer la subscripción para el correo <strong>$email</strong>";
			}
			mostrar_resposta($MISSATGE, $rowLli, $nl);
	}

function mostrar_formulari($rowLli, $nl) {
	include_once("html_subs.html");
}

function mostrar_resposta($MISSATGE, $rowLli, $nl) {
	include_once("html_subs_ok.html");
}

?>
