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
	$Tpl_modul->scanFile('pas2c_ca.tpl');
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
		if ($numerr > 0) $bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);
		else $bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('INFO'.(-$numerr), $bl);

		$bl['TIPUS_1'] = ($_POST['TIPUS']==1) ? 'checked="checked"' : '';
		$bl['TIPUS_2'] = ($_POST['TIPUS']==2) ? 'checked="checked"' : '';
		$bl['TIPUS_3'] = ($_POST['TIPUS']==3) ? 'checked="checked"' : '';
  } else {
		$bl['TIPUS_3'] = 'checked="checked"';

  }

  
  
  
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
  
 
  
  $bl['BOTO_PAS_SEGUENT2'] = $Tpl_modul->mergeBlock('BOTO_PAS2', $bl);
  
  
  
  
	include ('houdini_cap.inc');
	echo $Tpl_modul->mergeBlock('HEAD', $bl);
	echo $Tpl_modul->mergeBlock('FOOT', $bl);
	include ('houdini_peu.inc');
}

// Valida formulari. Si ok fa insert, si nok retorna nºerror
function tractar_formulari($rowCam) {
	global $db, $CFG_CAMPANYES, $ID, $LOGIN;
    global $mail_sendtype, $mail_port, $mail_host, $mail_SMTPAuth;
    global $mail_username, $mail_password, $mail_hostName;


	$TIPUS = intval($_POST['TIPUS']);
	if ($TIPUS == 1) {  //enviar email de test
		$email_test = trim(stripslashes($_POST['EMAIL']));
		if ($email_test == '') return 2;
		if (!eregi($CFG_CAMPANYES['EMAIL_VALID'],$email_test)) return 2;

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

	  $mail->AddAddress($email_test);  //Indiquem l'adreça del destinatari

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


	  if ($rowCam['format']==3) {  //només text
		  //$mail->Body = $rowCam['msg_text'];  // Assignem el cos del missatge

		  $mail->Body = personalitzacio ($rowCam['msg_text'], $email_test, $rowCam['IdCam']);
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
		$_POST['TIPUS']=3;
		return -1;

	} elseif ($TIPUS == 2) {
		//Header('Location: pas2.php?id='.$ID);
		if (($rowCam['tipus'] == 1) or ($rowCam['tipus'] == 2)){
			Header('Location: pas2b.php?id='.$ID);
		}else{
			Header('Location: ../contingut/newsletters/edita.php?id='.$ID);
		}
		die();

	} elseif ($TIPUS == 3) {
		Header('Location: pas3.php?id='.$ID);
		die();

	} else {
		return 1;
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
