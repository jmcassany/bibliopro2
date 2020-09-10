<?php

$CONFIG_PATHPHP = '../../../../media/php';
require ('../../../config_admin.inc');
accessGroupPermCheck('newsletter');  //PDT permís concret per campanyes

$CONFIG_PATHCAMPANYES = '../';
require_once($CONFIG_PATHCAMPANYES.'config.inc');

	require_once($CFG_CAMPANYES['PATH_MAILER'].'class.phpmailer.php');
	require_once($CFG_CAMPANYES['PATH_FUNCIONS'].'cripto.inc');

   tractament();


function tractament() {
	global $db, $CFG_CAMPANYES, $ID, $LOGIN;

	$Tpl_modul = new awTemplate();
	$Tpl_modul->scanFile('pas4_ca.tpl');
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
		if ($numerr > 0) {
			$bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);

		} elseif ($numerr == -1) {
			$bl['EMAIL'] = filtreQuote(trim(stripslashes($_POST['EMAIL'])));
			$bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('INFO1', $bl);

		} elseif ($numerr == -2) {
			Header('Location: enviament.php?id='.$ID);
			die();

		}

		$bl['EMAIL'] = filtreQuote(trim(stripslashes($_POST['EMAIL'])));
		$bl['EMAIL2'] = filtreQuote(trim(stripslashes($_POST['EMAIL2'])));
		$bl['TIPUS_1'] = ($_POST['TIPUS']==1) ? 'checked="checked"' : '';
		$bl['TIPUS_2'] = ($_POST['TIPUS']==2) ? 'checked="checked"' : '';

	} else {
		$bl['EMAIL'] = '';  //PDT obtenir d'usuari houdini
  }

	include ('houdini_cap.inc');
	echo $Tpl_modul->mergeBlock('HEAD', $bl);
	echo $Tpl_modul->mergeBlock('FOOT', $bl);
	include ('houdini_peu.inc');
}

// Valida formulari. Si ok retorna negatiu, si nok retorna nºerror
function tractar_formulari($rowCam) {
global $db, $CFG_CAMPANYES, $ID, $LOGIN;
    global $mail_sendtype, $mail_port, $mail_host, $mail_SMTPAuth;
    global $mail_username, $mail_password, $mail_hostName;

	$TIPUS = intval($_POST['TIPUS']);
	if (($TIPUS!=1)&&($TIPUS!=2)) return 1;

	if (($rowCam['tipus'] == 3) or ($rowCam['tipus'] == 4)){
	  //MIRO SI ESTA LLEST EL BUTLLETÍ!!! --> x a l'hora d'enviar-lo...
	  $wh_noadmin = " AND USUARI_HOUDINI='$LOGIN'";
	  $result6 = $db->sql_query("SELECT * FROM NEWSLETTERS WHERE IdCam = '$ID'".$wh_noadmin);
	  if ($db->sql_numrows($result6) == 0) {
		htmlPageError('Campanya no accessible!');
	  }
	  $row6 = $db->sql_fetchrow($result6);
	  $llest_x_enviar = $row6['CATEGORY1'];
	}


	if ($TIPUS == 1) {  //enviar test
		$mail_test = trim(stripslashes($_POST['EMAIL']));
		if ($mail_test == '') return 2;
		if (!eregi($CFG_CAMPANYES['EMAIL_VALID'],$mail_test)) return 2;

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

	  $mail->From = $rowCam['from_email'];  //Indiquem quina és la nostra adreça de correu i el nom q volem q vegi l'usuari
	  $mail->FromName = $rowCam['from_name'];
	  $mail->Sender = $rowCam['reply_to'];  //Indiquem bustia on va a parar el bounce
	  $mail->Subject = $rowCam['subject'].' (test)';  //Assignem l'Assumpte del Missatge

	  $mail->AddAddress($mail_test);  //Indiquem l'adreça del destinatari

	  if ($rowCam['format']==3) {  //només text
		  //$mail->Body = $rowCam['msg_text'];  // Assignem el cos del missatge
		  $mail->Body = personalitzacio ($rowCam['msg_text'], $mail_test, $rowCam['IdCam']);
		  $mail->AltBody = '';
	  } else {
		  //$mail->Body = $rowCam['msg_html'];  // Assignem el cos del missatge
		  //$mail->AltBody = $rowCam['msg_text'];  //Definim AltBody per si el destinatari de correu no admet mails en format html

		   if($llest_x_enviar == 1){
			  $tempfilename = "../../../../public/plantilla".$rowCam['IdCam'].".html";
			  $gestor = fopen($tempfilename, "r");
			  $contingut_html = fread($gestor, filesize($tempfilename));
			  fclose($gestor);
			  $mail->Body = personalitzacio ($contingut_html, $email_test, $rowCam['IdCam']);
			  //$mail->Body = personalitzacio ($rowCam['msg_html'], $email_test, $rowCam['IdCam']);
			  $mail->AltBody = personalitzacio ($rowCam['msg_text'], $email_test, $rowCam['IdCam']);
		   }else{
		  	  $mail->Body = personalitzacio ($rowCam['msg_html'], $email_test, $rowCam['IdCam']);
			  $mail->AltBody = personalitzacio ($rowCam['msg_text'], $email_test, $rowCam['IdCam']);
		   }
	  }

	  if(($llest_x_enviar == 1) or ($rowCam['tipus'] == 1) or ($rowCam['tipus'] == 2)){
	  	$es_ok = $mail->Send();
	  }

	  if (!$es_ok) return 3;
		//register_add($T_LANG['adm_campanyes'], 'enviat test per campanya id: '.$ID);
		return -1;

	} elseif ($TIPUS == 2) {  //anar al següent pas
		$email_test = trim(stripslashes($_POST['EMAIL2']));
		if ($email_test == '') return 5;
		if (!eregi($CFG_CAMPANYES['EMAIL_VALID'],$email_test)) return 5;

		$camps = array();
		if ($rowCam['estat'] < 100) $camps['estat'] = 100;
		$camps['dh_modif'] = date("Y-m-d H:i:s");
		$camps['email_notify'] = $email_test;
		fer_update('news_CAMPANYES', $camps, "IdCam = '$ID' AND IdUsu='$LOGIN'");
		//register_add($T_LANG['adm_campanyes'], 'modificat contingut campanya id: '.$ID);

		//insertar a DESTINATARIS....
		$camps = array();
		$camps['IdCam'] = $ID;
		$camps['IdUsu'] = $LOGIN;
		$camps['estat'] = 0;
		$camps['tipus'] = 0;
		$camps['dh_enviament'] = NULL;
		$camps['dh_recepcio'] = NULL;

		if ($rowCam['desti_manual']!='') {
			$aux = explode(',', $rowCam['desti_manual']);
			foreach($aux as $k => $v) {
				$camps['email'] = $v;
				$camps['nom'] = '';
				$camps['cognoms'] = '';
				$camps['camp1'] = '';
				$camps['camp2'] = '';
				$camps['camp3'] = '';
				$camps['camp4'] = '';
				$camps['camp5'] = '';
				$camps['link1'] = '';
				$camps['link2'] = '';
				$camps['link3'] = '';
				$camps['adjunt1'] = '';
				$camps['adjunt2'] = '';
				$camps['adjunt3'] = '';
				$camps['pais'] = '';
				$camps['centre'] = '';
				$camps['IdLli'] = 0;
				if (fer_insert('news_DESTINATARIS', $camps, 0)) $compta['ok']++;
				else $compta['nok_error']++;
			}
		}

		if ($rowCam['desti_llista']!='') {
		  $result9 = $db->sql_query("SELECT IdLli,email,nom,camp1,camp2,camp3,camp4,camp5,link1,link2,link3,adjunt1,adjunt2,adjunt3,pais,centre,cognoms FROM news_SUBSCRIPTORS WHERE IdUsu = '$LOGIN' AND IdLli IN (".$rowCam['desti_llista'].") AND estat='1'");
		  while ($row9 = $db->sql_fetchrow($result9)) {
				$camps['email'] = $row9['email'];
				$camps['nom'] = $row9['nom'];
				$camps['cognoms'] = $row9['cognoms'];
				$camps['camp1'] = $row9['camp1'];
				$camps['camp2'] = $row9['camp2'];
				$camps['camp3'] = $row9['camp3'];
				$camps['camp4'] = $row9['camp4'];
				$camps['camp5'] = $row9['camp5'];
				$camps['link1'] = $row9['link1'];
				$camps['link2'] = $row9['link2'];
				$camps['link3'] = $row9['link3'];
				$camps['adjunt1'] = $row9['adjunt1'];
				$camps['adjunt2'] = $row9['adjunt2'];
				$camps['adjunt3'] = $row9['adjunt3'];
				$camps['pais'] = $row9['pais'];
				$camps['centre'] = $row9['centre'];
				$camps['IdLli'] = $row9['IdLli'];
				if (fer_insert('news_DESTINATARIS', $camps, 0)) $compta['ok']++;
				else $compta['nok_error']++;
		  }
		}

		if(($llest_x_enviar == 1) or ($rowCam['tipus'] == 1) or ($rowCam['tipus'] == 2)){
			return -2;
		}else{
			return 3;
		}
	}
}

function personalitzacio ($text, $email, $idcam) {
global $LOGIN, $CRIPTO_SEPAR,$CRIPTO_CHECK,$CRIPTO_KEY;

	$aju = ereg_replace("\[\[email\]\]" , $email ,$text);

	$string = $idcam.$CRIPTO_SEPAR.$LOGIN.$CRIPTO_SEPAR.$email.$CRIPTO_SEPAR.$CRIPTO_CHECK;
	$codi = urlencode(encrypt($string, $CRIPTO_KEY));
	$aju = ereg_replace("\[\[codi\]\]" , $codi ,$aju);

	return $aju;
}

?>
