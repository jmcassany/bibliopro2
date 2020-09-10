<?php

$CONFIG_PATHPHP = '../../../../media/php';
require ('../../../config_admin.inc');
accessGroupPermCheck('newsletter');  //PDT permís concret per campanyes

$CONFIG_PATHCAMPANYES = '../';
require_once($CONFIG_PATHCAMPANYES.'config.inc');


$CONFIG_PRE_NOMCARPETA = $CONFIG_NOMCARPETA;
$CONFIG_NOMCARPETA2 = $CONFIG_NOMCARPETA; //x les imatges i adjunts de la editora de houdini
$CONFIG_DOMAIN = $_SERVER['SERVER_NAME'].$CONFIG_PRE_NOMCARPETA;
$CONFIG_NOMCARPETA =  '/public';
$CONFIG_URLBASE = 'http://'.$CONFIG_DOMAIN.$CONFIG_NOMCARPETA;


require_once($CFG_CAMPANYES['PATH_MAILER'].'class.phpmailer.php');
require_once($CFG_CAMPANYES['PATH_FUNCIONS'].'cripto.inc');

$DEBUG_NOMAILS = 0;  // 1:només simula l'enviament!  0:envia mails!
$pausa_de='3';  $pausa_cada='10'; // pausa de x segons per cada x mails enviats
$intents_enviament = 4; $espera_enviament=5;  //reintents si enviament no és ok

   tractament();




function tractament() {
	global $db, $CFG_CAMPANYES, $ID, $LOGIN, $DEBUG_NOMAILS, $pausa_de,$pausa_cada,$intents_enviament,$espera_enviament;
    global $mail_sendtype, $mail_port, $mail_host, $mail_SMTPAuth;
    global $mail_username, $mail_password, $mail_hostName;

	$Tpl_modul = new awTemplate();
	$Tpl_modul->scanFile('enviament_ca.tpl');
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
	$rowCam = $db->sql_fetchrow($result5);
	$bl['ID'] = $rowCam['IdCam'];


	$wh_noadmin = " AND USUARI_HOUDINI='$LOGIN'";
	$result55 = $db->sql_query("SELECT * FROM NEWSLETTERS WHERE IdCam = '$ID'".$wh_noadmin);
	if ($db->sql_numrows($result55) == 0) {
		htmlPageError('Campanya no accessible 55!');
	}
	$rowCam55 = $db->sql_fetchrow($result55);
	$ID_NL = $rowCam55['ID'];





	//verificar estat, etc...
	if ($rowCam['estat'] >= 101) {
		htmlPageError('Campanya ja enviada!');
	}

  $result9 = $db->sql_query("SELECT * FROM news_DESTINATARIS WHERE IdCam = '$ID' AND estat='0'");
  //$result9 = $db->sql_query("SELECT * FROM news_DESTINATARIS WHERE IdCam = '$ID'");  //per proves fent reload
  $totalmails = intval($db->sql_numrows($result9));
	if ($totalmails == 0) {
		htmlPageError('No hi ha destinataris!');
	}
	$bl['NUM_ENVIAMENTS'] = numero_num2fmt($totalmails);

	include ('houdini_cap.inc');
	echo $Tpl_modul->mergeBlock('HEAD', $bl);

	// **********************
	// **** Comú del missatge
	// **********************
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

  $mail->Sender = $rowCam['reply_to'];  //Indiquem bustia on va a parar el bounce

  $enviats_ok=0;  $enviats_ko=0;  $counter=0;  $missatge = '';
	$campsCam = array();
	$campsCam['dh_inici'] = date("Y-m-d H:i:s");

	// bucle amb destinataris....
  while ($row9 = $db->sql_fetchrow($result9)) {
		$det['EMAIL'] = $row9['email'];
		$det['NOM'] = $row9['nom'];

	  $mail->AddAddress($row9['email']);  //Indiquem l'adreça del destinatari
	  if ($rowCam['format']==3) {  //només text
		  //$mail->Body = $rowCam['msg_text'];  // Assignem el cos del missatge
		  $mail->Body = personalitzacio ($rowCam['msg_text'], $row9['email'], $row9['IdLli'], $rowCam['IdCam'], $row9['nom'], $row9['camp1'], $row9['camp2'], $row9['camp3'], $row9['camp4'], $row9['camp5'], $row9['link1'], $row9['link2'], $row9['link3'], $row9['adjunt1'], $row9['adjunt2'], $row9['adjunt3'], $row9['pais'], $row9['centre'], $row9['cognoms'], $ID_NL);
		  $mail->AltBody = '';
	  } else {
		  //$mail->Body = $rowCam['msg_html'];  // Assignem el cos del missatge
		  //$mail->AltBody = $rowCam['msg_text'];  //Definim AltBody per si el destinatari de correu no admet mails en format html

		  if (($rowCam['tipus'] == 3) or ($rowCam['tipus'] == 4)){
			  $tempfilename = "../../../../public/plantilla".$rowCam['IdCam'].".html";
			  $gestor = fopen($tempfilename, "r");
			  $contingut_html = fread($gestor, filesize($tempfilename));
			  fclose($gestor);
			  $mail->Body = personalitzacio ($contingut_html, $row9['email'], $row9['IdLli'], $rowCam['IdCam'], $row9['nom'], $row9['camp1'], $row9['camp2'], $row9['camp3'], $row9['camp4'], $row9['camp5'], $row9['link1'], $row9['link2'], $row9['link3'], $row9['adjunt1'], $row9['adjunt2'], $row9['adjunt3'], $row9['pais'], $row9['centre'], $row9['cognoms'], $ID_NL);
			  //$mail->Body = personalitzacio ($rowCam['msg_html'], $row9['email'], $rowCam['IdCam']);
			  $mail->AltBody = personalitzacio ($rowCam['msg_text'], $row9['email'], $row9['IdLli'], $rowCam['IdCam'], $row9['nom'], $row9['camp1'], $row9['camp2'], $row9['camp3'], $row9['camp4'], $row9['camp5'], $row9['link1'], $row9['link2'], $row9['link3'], $row9['adjunt1'], $row9['adjunt2'], $row9['adjunt3'], $row9['pais'], $row9['centre'], $row9['cognoms'], $ID_NL);
		  }else{
		  	  $mail->Body = personalitzacio ($rowCam['msg_html'], $row9['email'], $row9['IdLli'], $rowCam['IdCam'], $row9['nom'], $row9['camp1'], $row9['camp2'], $row9['camp3'], $row9['camp4'], $row9['camp5'], $row9['link1'], $row9['link2'], $row9['link3'], $row9['adjunt1'], $row9['adjunt2'], $row9['adjunt3'], $row9['pais'], $row9['centre'], $row9['cognoms'], $ID_NL);
			  $mail->AltBody = personalitzacio ($rowCam['msg_text'], $row9['email'], $row9['IdLli'], $rowCam['IdCam'], $row9['nom'], $row9['camp1'], $row9['camp2'], $row9['camp3'], $row9['camp4'], $row9['camp5'], $row9['link1'], $row9['link2'], $row9['link3'], $row9['adjunt1'], $row9['adjunt2'], $row9['adjunt3'], $row9['pais'], $row9['centre'], $row9['cognoms'], $ID_NL);
		  }
	  }
		$counter++;
	  if($counter%(int)$pausa_cada == 0) {  //pausa de x segons per per cada x mails enviats (variables configurables a dalt)
	  	 sleep ((int)$pausa_de);
	  }

	  ////comprovem q el domini escrit sigui vàlid si no es vàlid no és necessari fer l'enviament
	  list($alias, $domaincheck) = split("@", $row9['email']);


	$mail->FromName = $rowCam['from_name'];
	$mail->Subject = $rowCam['subject'];  //Assignem l'Assumpte del Missatge


	  if ($DEBUG_NOMAILS==1) $validhost = true;  // per proves !!!!
	  else {
	  		$validhost = checkdnsrr($domaincheck, "MX");
	  }

	  if (!$validhost) $exit=false;
	  else {
	  	if ($DEBUG_NOMAILS==1) $exit = rand(0,1);  //per proves!!!!
		  else $exit = $mail->Send();  //enviem el misssatge, si no hi ha problemes la viariable $exit tindrà el valor true

		  //si el missatge no ha pogut ser enviat es realitzaran x intents més per enviar-lo. cada intent es farà x segons després de l'anterior amb la funció sleep
		  $intents=1;
		  while ((!$exit) && ($intents < $intents_enviament)) {
		    if ($DEBUG_NOMAILS==1) $exit = rand(0,1);  //per proves!!!!
		    else {
					sleep($espera_enviament);
			    $exit = $mail->Send();
		    }
		    $intents=$intents+1;
		  }
	  }

	  if (!$exit) {
	   	if (!$validhost) {
				$missatge_error = "Domini invàlid (".$domaincheck.")";
			} else {
				$missatge_error = $mail->ErrorInfo;
			}
			$det['ERROR'] = $missatge_error;
			$missatge = $Tpl_modul->mergeBlock('LINIA_KO', $det);
			//$report_adreces_fallades .= $row9['email'].",";
			$enviats_ko++;
				$campsDes['estat'] = 2;  //error enviament
				$campsDes['dh_enviament'] = date("Y-m-d H:i:s");
				fer_update('news_DESTINATARIS', $campsDes, "IdCam = '$ID' AND email='".$row9['email']."'");
	  } else {
			$missatge = $Tpl_modul->mergeBlock('LINIA_OK', $det);
			$enviats_ok++;
				$campsDes['estat'] = 1;  //enviat
				$campsDes['dh_enviament'] = date("Y-m-d H:i:s");
				fer_update('news_DESTINATARIS', $campsDes, "IdCam = '$ID' AND email='".$row9['email']."'");
	  }
		//aqui creem el report q es va actualitzant dels envios
	  $perceptual = round($counter*100/$totalmails);
	  echo '
	  <script type="text/javascript">
			document.getElementById("actual").innerHTML="'.$counter.'";
			document.getElementById("percentage").innerHTML="'.$perceptual.'%";
			document.getElementById("percbarra").style.width="'.$perceptual.'%";
			var el1=document.getElementById("lliur").insertRow(0);
			el1.className="'.((!$exit)?"ko":"ok").'";
			el1.innerHTML = "'.ereg_replace('/', '\/', $missatge).'";
		</script>
	   ';
	  $mail->ClearAddresses ();  //llimpio l'adreça per fer altres envios si n'hi ha
  }  //fi-bucle

	//report final de com ha anat i fem visible els botons de tancar o anar a portada
	//if ($missatges_enviats_error > 0) {  //mostrem els missatges q han fallat
	//	$informe_final .= "&#149; Les adreçes a les que no s'ha pogut enviar el missatge són: ".$report_adreces_fallades."<br /> <br />";
	//}
	echo '
	<script type="text/javascript">
			document.getElementById("numok").innerHTML="'.$enviats_ok.'";
			document.getElementById("numko").innerHTML="'.$enviats_ko.'";
			document.getElementById("report_final").style.display="inline";
			document.getElementById("encurs").style.display="none";
			document.getElementById("lliur").style.display="none";
	</script>';


	$campsCam['estat'] = 101;
	$campsCam['dh_final'] = date("Y-m-d H:i:s");
	$campsCam['dh_modif'] = date("Y-m-d H:i:s");
	fer_update('news_CAMPANYES', $campsCam, "IdCam = '$ID' AND IdUsu='$LOGIN'");
	//register_add($T_LANG['adm_campanyes'], 'modificat contingut campanya id: '.$ID);

	//**** enviar confirmació
	if ($DEBUG_NOMAILS!=1) {
	  $mail->Subject = 'Confirmació enviament de Newsletter';  //Assignem l'Assumpte del Missatge
	  $mail->ClearAddresses ();
	  $mail->AddAddress($rowCam['email_notify']);
		$salt = "<br />";
		$mail->Body = "S'ha enviat la campanya id: ".$rowCam['IdCam'].", <b>".$rowCam['titol']."</b>".$salt.$salt
								 ."<b>$enviats_ok</b> correus enviats correctament.".$salt
								 ."<b>$enviats_ko</b> correus amb errors.".$salt.$salt;
		$salt = "\n";
		$mail->AltBody = "S'ha enviat la campanya id: ".$rowCam['IdCam'].", ".$rowCam['titol']."".$salt.$salt
								 ."$enviats_ok correus enviats correctament.".$salt
								 ."$enviats_ko correus amb errors.".$salt.$salt;
		$exit = $mail->Send();  //enviem el misssatge, si no hi ha problemes la viariable $exit tindrà el valor true
	}


	echo $Tpl_modul->mergeBlock('FOOT', $bl);
	include ('houdini_peu.inc');
}

function personalitzacio ($text, $email, $llista, $idcam, $nom, $camp1, $camp2, $camp3, $camp4, $camp5, $link1, $link2, $link3, $adjunt1, $adjunt2, $adjunt3, $pais, $centre, $cognoms, $ID_NL) {
global $LOGIN, $CRIPTO_SEPAR,$CRIPTO_CHECK,$CRIPTO_KEY,$CONFIG_URLBASE,$CONFIG_DOMAIN;

	$aju = ereg_replace("\[\[email\]\]" , $email ,$text);

	$aju = ereg_replace("\[\[nom\]\]" , $nom ,$aju);
	$aju = ereg_replace("\[\[cognoms\]\]" , $cognoms ,$aju);
	$aju = ereg_replace("\[\[camp1\]\]" , $camp1 ,$aju);
	$aju = ereg_replace("\[\[camp2\]\]" , $camp2 ,$aju);
	$aju = ereg_replace("\[\[camp3\]\]" , $camp3 ,$aju);
	$aju = ereg_replace("\[\[camp4\]\]" , $camp4 ,$aju);
	$aju = ereg_replace("\[\[camp5\]\]" , $camp5 ,$aju);
	$aju = ereg_replace("\[\[link1\]\]" , $link1 ,$aju);
	$aju = ereg_replace("\[\[link2\]\]" , $link2 ,$aju);
	$aju = ereg_replace("\[\[link3\]\]" , $link3 ,$aju);
	$aju = ereg_replace("\[\[adjunt1\]\]" , $adjunt1 ,$aju);
	$aju = ereg_replace("\[\[adjunt2\]\]" , $adjunt2 ,$aju);
	$aju = ereg_replace("\[\[adjunt3\]\]" , $adjunt3 ,$aju);
	$aju = ereg_replace("\[\[pais\]\]" , $pais ,$aju);
	$aju = ereg_replace("\[\[centre\]\]" , $centre ,$aju);

	$aju = ereg_replace("\[\[llista\]\]", $llista, $aju);

	$string = $idcam.$CRIPTO_SEPAR.$LOGIN.$CRIPTO_SEPAR.$email.$CRIPTO_SEPAR.$CRIPTO_CHECK;
	$codi = urlencode(encrypt($string, $CRIPTO_KEY));
	$aju = ereg_replace("\[\[codi\]\]" , $codi ,$aju);

	$baixa = '<li style="font-size:.7em; font-weight:bold; margin-bottom:1px"><img src="'.$CONFIG_URLBASE.'/media/comu/icon_baixa.gif" alt="" style="vertical-align:middle"/> <a href="http://'.$CONFIG_DOMAIN.'/news_unsubscribe.php?ID='.$ID_NL.'&amp;id='.$codi.'" style="text-decoration:none;color:#28537e">Darse de baja</a></li>';
	$aju = ereg_replace("\[\[baixa\]\]" , $baixa ,$aju);

	return $aju;
}

?>
