<?php
include_once '../selconfig.php';
require_once($CONFIG_PATHMEDIA . '/php/class.phpmailer.php');
require_once($CONFIG_PATHMEDIA . '/php/cripto.inc');
require_once 'html2text.php';

$DEBUG_NOMAILS = 0;  // 1:només simula l'enviament!  0:envia mails!
$pausa_de='1';  $pausa_cada='50'; // pausa de x segons per cada x mails enviats
$intents_enviament = 2; $espera_enviament=1;  //reintents si enviament no és ok

$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('enviament_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada"));exit;}

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$ID = trim(stripslashes(obte_postget('id')));
$accio = trim(stripslashes(obte_post('accio')));
$IdCam = isset($_GET['IdCam']) ? $_GET['IdCam'] : (isset($_POST['idCam']) ? $_POST['idCam'] : null);

if($IdCam != ''){
    $queryButlleti = db_query('SELECT * FROM ' . TAULA_NEWSLETTERS . ' WHERE IdCam = ' . $IdCam);
    $dadesButlleti = db_fetch_array($queryButlleti);
}

if($IdCam != ''){
    $queryCampanya = db_query('SELECT * FROM ' . TAULA_CAMPANYES . ' WHERE IdCam = ' . $IdCam);
    $dadesCampanya = db_fetch_array($queryCampanya);
}

if ($dadesCampanya['estat'] >= 101) {
    htmlNewsletterError('Campanya ja enviada!');
    exit;
}

$bl['ID'] = $dadesButlleti['IdCam'];
$ID_NL = $dadesCampanya['IDNL'];
$SKIN_NL = $dadesButlleti['SKIN'];

//verificar estat, etc...

$result9 = db_query("SELECT * FROM " . TAULA_DESTINATARIS . " WHERE IdCam = '" . $IdCam . "' AND estat='0'");
//$result9 = $db->sql_query("SELECT * FROM newsletter_destinataris WHERE IdCam = '$ID'");  //per proves fent reload
$totalmails = intval(db_num_rows($result9));
if ($totalmails == 0) {
    htmlNewsletterError('No hi ha destinataris!');
    exit;
}
$bl['NUM_ENVIAMENTS'] = numero_num2fmt($totalmails);

include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
setCurrent('butlletins');
echo $Tpl_modul->mergeBlock('HEAD', $bl);


// **********************
// **** Comú del missatge
// **********************
$mail = new phpmailer();  //creem un objecte de la clase phpmailer al que anomenem mail

$mail->SetLanguage("ca", $CFG_CAMPANYES['PATH_MAILER']."language/");  //definim l'idioma
$mail->PluginDir = $CFG_CAMPANYES['PATH_MAILER'];  //PluginDir li indicamem a la clase phpmailer on es troba la clase smtp
$mail->CharSet = "utf-8";

//mirar format HTML/PLA
if ($dadesCampanya['format'] == 3) {
    $mail->ContentType = "text/plain";
}
else {
    $mail->ContentType = "text/html";
}


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
$mail->From = $dadesCampanya['from_email'];  //Indiquem quina és la nostra adreça de correu i el nom q volem q vegi l'usuari
$mail->Sender = $dadesCampanya['reply_to'];  //Indiquem bustia on va a parar el bounce

$enviats_ok=0;  $enviats_ko=0;  $counter=0;  $missatge = '';
$campsCam = array();
$campsCam['dh_inici'] = date("Y-m-d H:i:s");
$html2text = new Html2Text();
        

// bucle amb destinataris....
while ($row9 = $db->sql_fetchrow($result9)) {
    $det['EMAIL'] = $row9['email'];
    $det['NOM'] = $row9['nom'];
    $det['ERROR'] = '';

    $idllista = $row9['IdLli'];
    $emailuser = $row9['email'];
    $mail->addCustomHeader("X-MessageID: $idllista");
    $mail->addCustomHeader("X-ListMember: $emailuser");

    //$mail->addCustomHeader("List-ID: ");
    //$mail->addCustomHeader("List-Owner: ");
    $string = $dadesCampanya['IdCam'].$CRIPTO_SEPAR.$LOGIN.$CRIPTO_SEPAR.$row9['email'].$CRIPTO_SEPAR.$CRIPTO_CHECK;
    $codi = urlencode(encrypt($string, $CRIPTO_KEY));
    $urlbaixa = $CONFIG_URLBASE_NL . '/altres.php?opcio=baixa&amp;code=' . $codi . '&amp;idCam=' . $IdCam;

    $mail->addCustomHeader("List-Unsubscribe:" . $urlbaixa);

    $mail->AddAddress($row9['email']);  //Indiquem l'adreça del destinatari
    if ($dadesCampanya['format']==3) {  //només text
        $text = Html2Text::convert($dadesCampanya['msg_text']);
        //$mail->Body = $dadesCampanya['msg_text'];  // Assignem el cos del missatge
        $mail->Body = personalitzacio ($text, $row9['email'], $row9['IdLli'], $dadesCampanya['IdCam'], $row9['nom'], $row9['camp1'], $row9['camp2'], $row9['camp3'], $row9['camp4'], $row9['camp5'], $row9['link1'], $row9['link2'], $row9['link3'], $row9['adjunt1'], $row9['adjunt2'], $row9['adjunt3'], $row9['pais'], $row9['centre'], $row9['cognoms'], $ID_NL, $SKIN_NL);
        $mail->AltBody = $mail->Body;
    } else {
        //$mail->Body = $dadesCampanya['msg_html'];  // Assignem el cos del missatge
        //$mail->AltBody = $dadesCampanya['msg_text'];  //Definim AltBody per si el destinatari de correu no admet mails en format html

        if (($dadesCampanya['tipus'] == 3) or ($dadesCampanya['tipus'] == 4)){
            $tempfilename = $CONFIG_PATHBUTLLETINS  . '/butlleti' . $dadesButlleti['ID'] . '.html';
            $contingut_html = file_get_contents($tempfilename);
            $contingut_text = Html2Text::convert($contingut_html);
            $mail->Body = personalitzacio ($contingut_html, $row9['email'], $row9['IdLli'], $dadesCampanya['IdCam'], $row9['nom'], $row9['camp1'], $row9['camp2'], $row9['camp3'], $row9['camp4'], $row9['camp5'], $row9['link1'], $row9['link2'], $row9['link3'], $row9['adjunt1'], $row9['adjunt2'], $row9['adjunt3'], $row9['pais'], $row9['centre'], $row9['cognoms'], $ID_NL, $SKIN_NL);
            //$mail->Body = personalitzacio ($dadesCampanya['msg_html'], $row9['email'], $dadesCampanya['IdCam']);
            $mail->AltBody = personalitzacio ($contingut_text, $row9['email'], $row9['IdLli'], $dadesCampanya['IdCam'], $row9['nom'], $row9['camp1'], $row9['camp2'], $row9['camp3'], $row9['camp4'], $row9['camp5'], $row9['link1'], $row9['link2'], $row9['link3'], $row9['adjunt1'], $row9['adjunt2'], $row9['adjunt3'], $row9['pais'], $row9['centre'], $row9['cognoms'], $ID_NL, $SKIN_NL);
        }else{
            $tempfilename = $CONFIG_PATHBUTLLETINS  . '/butlleti' . $dadesButlleti['ID'] . '.html';
            $contingut_html = file_get_contents($tempfilename);
            $contingut_text = Html2Text::convert($contingut_html);
            $mail->Body = personalitzacio ($contingut_html, $row9['email'], $row9['IdLli'], $dadesCampanya['IdCam'], $row9['nom'], $row9['camp1'], $row9['camp2'], $row9['camp3'], $row9['camp4'], $row9['camp5'], $row9['link1'], $row9['link2'], $row9['link3'], $row9['adjunt1'], $row9['adjunt2'], $row9['adjunt3'], $row9['pais'], $row9['centre'], $row9['cognoms'], $ID_NL, $SKIN_NL);
            $mail->AltBody = personalitzacio ($contingut_text, $row9['email'], $row9['IdLli'], $dadesCampanya['IdCam'], $row9['nom'], $row9['camp1'], $row9['camp2'], $row9['camp3'], $row9['camp4'], $row9['camp5'], $row9['link1'], $row9['link2'], $row9['link3'], $row9['adjunt1'], $row9['adjunt2'], $row9['adjunt3'], $row9['pais'], $row9['centre'], $row9['cognoms'], $ID_NL, $SKIN_NL);
        }
    }
    $counter++;
    if($counter%(int)$pausa_cada == 0) {  //pausa de x segons per per cada x mails enviats (variables configurables a dalt)
        sleep ((int)$pausa_de);
    }

    ////comprovem q el domini escrit sigui vàlid si no es vàlid no és necessari fer l'enviament
    list($alias, $domaincheck) = split("@", $row9['email']);
    $mail->FromName = $dadesCampanya['from_name'];
    
    $mail->Subject = $dadesCampanya['subject'];  //Assignem l'Assumpte del Missatge


    if ($DEBUG_NOMAILS==1) $validhost = true;  // per proves !!!!
    else {
        //$validhost = checkdnsrr($domaincheck, "MX");
        $validhost = true;
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
        fer_update(TAULA_DESTINATARIS, $campsDes, "IdCam = '$IdCam' AND email='".$row9['email']."'");
    } else {
        $missatge = $Tpl_modul->mergeBlock('LINIA_OK', $det);
        $enviats_ok++;
        $campsDes['estat'] = 1;  //enviat
        $campsDes['dh_enviament'] = date("Y-m-d H:i:s");
        fer_update(TAULA_DESTINATARIS, $campsDes, "IdCam = '$IdCam' AND email='".$row9['email']."'");
    }
    //aqui creem el report q es va actualitzant dels envios
    $perceptual = round($counter*100/$totalmails);
    echo '
	  <script type="text/javascript">
	       $("#actual").html("'.$counter.'");
	       $("#percentage").html("'.$perceptual.'%");
	       $("#percbarra").css("width","'.$perceptual.'%");
	       $("#lliur").html("'.str_replace('/', '\/', $missatge).'");
	       $("#lliur").attr("class","'.((!$exit)?"ko":"ok").'");
		</script>
	   ';
    $mail->ClearAddresses ();  //llimpio l'adreça per fer altres envios si n'hi ha
    $mail->ClearCustomHeaders(); //netejo les capçaleres

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
fer_update(TAULA_CAMPANYES, $campsCam, "IdCam = '$IdCam'");
//register_add($T_LANG['adm_campanyes'], 'modificat contingut campanya id: '.$ID);



//**** enviar confirmació
$bl['ERRORCONFI'] = '';

if ($DEBUG_NOMAILS!=1) {
    $mail->Subject = 'Confirmació enviament de Newsletter';  //Assignem l'Assumpte del Missatge
    $mail->ClearAddresses ();
    if($dadesCampanya['email_notify']){
        $mail->AddAddress($dadesCampanya['email_notify']);
        $salt = "<br />";
        $mail->Body = "S'ha enviat la campanya id: ".$dadesCampanya['IdCam'].", <b>".$dadesCampanya['titol']."</b>".$salt.$salt
        ."<b>$enviats_ok</b> correus enviats correctament.".$salt
        ."<b>$enviats_ko</b> correus amb errors.".$salt.$salt;
        $salt = "\n";
        $mail->AltBody = "S'ha enviat la campanya id: ".$dadesCampanya['IdCam'].", ".$dadesCampanya['titol']."".$salt.$salt
        ."$enviats_ok correus enviats correctament.".$salt
        ."$enviats_ko correus amb errors.".$salt.$salt;
        $exit = $mail->Send();  //enviem el misssatge, si no hi ha problemes la viariable $exit tindrà el valor true
        if(!$exit){
            $bl['ERRORCONFI'] = '<div class="missat_err">El missatge de confirmació no s\'ha pogut enviar</div>';
        }
    } else {
        $bl['ERRORCONFI'] = '<div  class="missat_err">El missatge de confirmació no s\'ha pogut enviar</div>';
    }
}
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');


function personalitzacio ($text, $email, $llista, $idcam, $nom, $camp1, $camp2, $camp3, $camp4, $camp5, $link1, $link2, $link3, $adjunt1, $adjunt2, $adjunt3, $pais, $centre, $cognoms, $ID_NL, $SKIN_NL) {
    global $LOGIN,$IdCam,$CRIPTO_SEPAR,$CRIPTO_CHECK,$CRIPTO_KEY,$CONFIG_URLBASE,$CONFIG_DOMAIN, $CONFIG_URLBASE_NL;

    $aju = preg_replace("#\[\[email\]\]#" , $email ,$text);
    $aju = preg_replace("#\[\[nom\]\]#" , $nom ,$aju);
    $aju = preg_replace("#\[\[cognoms\]\]#" , $cognoms ,$aju);
    $aju = preg_replace("#\[\[camp1\]\]#" , $camp1 ,$aju);
    $aju = preg_replace("#\[\[camp2\]\]#" , $camp2 ,$aju);
    $aju = preg_replace("#\[\[camp3\]\]#" , $camp3 ,$aju);
    $aju = preg_replace("#\[\[camp4\]\]#" , $camp4 ,$aju);
    $aju = preg_replace("#\[\[camp5\]\]#" , $camp5 ,$aju);
    $aju = preg_replace("#\[\[link1\]\]#" , $link1 ,$aju);
    $aju = preg_replace("#\[\[link2\]\]#" , $link2 ,$aju);
    $aju = preg_replace("#\[\[link3\]\]#" , $link3 ,$aju);
    $aju = preg_replace("#\[\[adjunt1\]\]#" , $adjunt1 ,$aju);
    $aju = preg_replace("#\[\[adjunt2\]\]#" , $adjunt2 ,$aju);
    $aju = preg_replace("#\[\[adjunt3\]\]#" , $adjunt3 ,$aju);
    $aju = preg_replace("#\[\[pais\]\]#" , $pais ,$aju);
    $aju = preg_replace("#\[\[centre\]\]#" , $centre ,$aju);
    $aju = preg_replace("#\[\[llista\]\]#", $llista, $aju);

    if($llista != ''){
        $string = $idcam.$CRIPTO_SEPAR.$LOGIN.$CRIPTO_SEPAR.$email.$CRIPTO_SEPAR.$CRIPTO_CHECK;
        $codi = urlencode(encrypt($string, $CRIPTO_KEY));
        $urlbaixa = $CONFIG_URLBASE_NL . '/altres.php?opcio=baixa&amp;code=' . $codi . '&amp;idCam=' . $IdCam;
        $aju = str_replace('#!URL_BAIXA!', $urlbaixa, $aju);
        $aju = str_replace('[[codi]]', $codi, $aju);
    }

    return $aju;
}

?>