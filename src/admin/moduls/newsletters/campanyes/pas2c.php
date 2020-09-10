<?php
include_once '../selconfig.php';
require_once($CONFIG_PATHMEDIA . '/php/class.phpmailer.php');
require_once($CONFIG_PATHMEDIA . '/php/cripto.inc');
require_once 'html2text.php';


$Tpl_modul = new awTemplate();
$Tpl_modul->scanFile('pas2c_ca.tpl');
if (!$Tpl_modul->Ok) { htmlNewsletterError(_t("plantillanotrobada"));exit; }

unset($bl);
$bl['PATH_CSS'] = $CFG_CAMPANYES['PATH_CSS'];
$bl['PATH_IMG'] = $CFG_CAMPANYES['PATH_IMG'];

$ID = trim(stripslashes(obte_postget('id')));
$bl['IDC'] = $IdCam;
$accio = trim(stripslashes(obte_post('accio')));
$IdCam = isset($_GET['IdCam']) ? $_GET['IdCam'] : (isset($_POST['idCam']) ? $_POST['idCam'] : null);

$result5 = $db->sql_query("SELECT * FROM " .    TAULA_CAMPANYES . " WHERE IdCam = '$IdCam'");
if ($db->sql_numrows($result5) == 0) {
    htmlNewsletterError('Campanya no accessible!');
    exit;
}
$row5 = $db->sql_fetchrow($result5);
$bl['ID'] = $row5['IdCam'];
$bl['IDC'] = $row5['IdCam'];

/* Nou sistema de generació a partir de plantilla */
include_once 'generar_butlleti.php';
$generat = generarButlleti($IdCam);
if(!generat){
    htmlNewsletterError('El butlletí no s\'ha pogut generar correctament. Si us plau, comproveu els permisos de la carpeta de butlletins');
    exit;
}
if($IdCam != ''){
    $queryButlleti = db_query('SELECT * FROM ' . TAULA_NEWSLETTERS . ' WHERE IdCam = ' . $IdCam);
    $dadesButlleti = db_fetch_array($queryButlleti);
}

if($IdCam != ''){
    $queryCampanya = db_query('SELECT * FROM ' . TAULA_CAMPANYES . ' WHERE IdCam = ' . $IdCam);
    $dadesCampanya = db_fetch_array($queryCampanya);
}

if (($dadesCampanya['tipus'] == 1) or ($dadesCampanya['tipus'] == 2)){
    $bl['enrere'] = 'pas2b.php?IdCam=' . $IdCam;
}else{
    $bl['enrere'] = '../contingut/newsletters/edita.php?IdCam='.$IdCam;
}

if ($accio == 'desar') {
    $numerr = tractar_formulari();
    if ($numerr > 0) $bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('ERROR'.$numerr, $bl);
    else $bl['T_MISSATGE'] = $Tpl_modul->mergeBlock('INFO'.(-$numerr), $bl);

    $bl['TIPUS_1'] = ($_POST['TIPUS']==1) ? 'checked="checked"' : '';
    $bl['TIPUS_2'] = ($_POST['TIPUS']==2) ? 'checked="checked"' : '';
    $bl['TIPUS_3'] = ($_POST['TIPUS']==3) ? 'checked="checked"' : '';
} else {
    $bl['TIPUS_3'] = 'checked="checked"';

}

if($row5['tipus']==3 || $row5['tipus']==4){
    $bl['SKIN'] = $dadesButlleti['SKIN'];
    $bl['FRAME']= $CONFIG_URLBUTLLETINS . 'butlleti' . $dadesButlleti['ID'] . '.html';

}else{
    $bl['FRAME']= $CONFIG_URLBUTLLETINS . 'butlleti' . $dadesButlleti['ID'] . '.html';
}



$bl['BOTO_PAS_SEGUENT2'] = $Tpl_modul->mergeBlock('BOTO_PAS2', $bl);

setCurrent('butlletins');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
echo $Tpl_modul->mergeBlock('HEAD', $bl);
echo $Tpl_modul->mergeBlock('FOOT', $bl);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');


// Valida formulari. Si ok fa insert, si nok retorna nºerror
function tractar_formulari() {
    global $db, $CFG_CAMPANYES, $ID, $LOGIN, $IdCam, $CONFIG_URLBUTLLETINS, $CONFIG_PATHBUTLLETINS, $CONFIG_URLBASE_NL;
    global $mail_sendtype, $mail_port, $mail_host, $mail_SMTPAuth;
    global $mail_username, $mail_password, $mail_hostName;

    if($IdCam != ''){
        $queryButlleti = db_query('SELECT * FROM ' . TAULA_NEWSLETTERS . ' WHERE IdCam = ' . $IdCam);
        $dadesButlleti = db_fetch_array($queryButlleti);
    }

    if($IdCam != ''){
        $queryCampanya = db_query('SELECT * FROM ' . TAULA_CAMPANYES . ' WHERE IdCam = ' . $IdCam);
        $dadesCampanya = db_fetch_array($queryCampanya);
    }

        
    $TIPUS = intval($_POST['TIPUS']);
    if ($TIPUS == 1) {  //enviar email de test
        $email_test = trim(stripslashes($_POST['EMAIL']));
        if ($email_test == '') return 2;
        if (!preg_match($CFG_CAMPANYES['EMAIL_VALID'],$email_test)) return 2;

        
        $mail = new phpmailer();  //creem un objecte de la clase phpmailer al que anomenem mail

        $mail->SetLanguage("ca", $CFG_CAMPANYES['PATH_MAILER']."language/");  //definim l'idioma
        $mail->PluginDir = $CFG_CAMPANYES['PATH_MAILER'];  //PluginDir li indicamem a la clase phpmailer on es troba la clase smtp
        $mail->CharSet = "utf-8";


        //mirar format HTML/PLA
        if ($rowCam['format'] == 3) {
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
        $mail->FromName = $dadesCampanya['from_name'];
        $mail->Sender = $dadesCampanya['reply_to'];  //Indiquem bustia on va a parar el bounce
        $mail->Subject = $dadesCampanya['subject'].' (test)';  //Assignem l'Assumpte del Missatge

        $mail->AddAddress($email_test);  //Indiquem l'adreça del destinatari

        //$mail->addCustomHeader("List-ID: ");
        //$mail->addCustomHeader("List-Owner: ");
        $mail->addCustomHeader("List-Unsubscribe:" . $CONFIG_URLBASE_NL . '/altres.php?opcio=baixa');

        $tempfilename = $CONFIG_URLBUTLLETINS . 'butlleti' . $dadesButlleti['ID'] . '.html';
        $tempfilenamepath = $CONFIG_PATHBUTLLETINS . '/butlleti' . $dadesButlleti['ID'] . '.html';
        $contingut_html = file_get_contents($tempfilenamepath);

        if (($dadesCampanya['tipus'] == 1) or ($dadesCampanya['tipus'] == 2)){
            $llest_x_enviar = 1;
        }
        if (($dadesCampanya['tipus'] == 3) or ($dadesCampanya['tipus'] == 4)){
            //MIRO SI ESTA LLEST EL BUTLLETÍ!!! --> x a l'hora d'enviar-lo...
            $llest_x_enviar = $dadesButlleti['CATEGORY1'];
        }

        if ($dadesCampanya['format']==3) {  //només text
            //$mail->Body = $rowCam['msg_text'];  // Assignem el cos del missatge
            $contingut_text = Html2Text::convert($contingut_html);
            $mail->Body = personalitzacio ($contingut_text, $email_test, $rowCam['IdCam']);
            $mail->AltBody = personalitzacio ($contingut_text, $email_test, $dadesCampanya['IdCam']);
            
        } else {
            //$mail->Body = $rowCam['msg_html'];  // Assignem el cos del missatge
            //$mail->AltBody = $rowCam['msg_text'];  //Definim AltBody per si el destinatari de correu no admet mails en format html

            $contingut_text = Html2Text::convert($contingut_html);

            if($llest_x_enviar == 1){
                $mail->Body = personalitzacio ($contingut_html, $email_test, $dadesCampanya['IdCam']);
                $mail->AltBody = personalitzacio ($contingut_text, $email_test, $dadesCampanya['IdCam']);
            }else{
                $mail->Body = personalitzacio ($contingut_html, $email_test, $rowCam['IdCam']);
                $mail->AltBody = personalitzacio ($contingut_text, $email_test, $dadesCampanya['IdCam']);
            }
        }

        $es_ok = false;
        if($llest_x_enviar == 1 || $dadesCampanya['tipus'] == 1 || $dadesCampanya['tipus'] == 2 || $dadesCampanya['tipus'] == 3){
            $es_ok = $mail->Send();
        }

        if (!$es_ok) return 3;
        //register_add($T_LANG['adm_campanyes'], 'enviat test per campanya id: '.$ID);
        $_POST['TIPUS']=3;
        return -1;

    } elseif ($TIPUS == 2) {
        //Header('Location: pas2.php?id='.$ID);
        if (($dadesCampanya['tipus'] == 1) or ($dadesCampanya['tipus'] == 2)){
            header('Location: pas2b.php?IdCam='.$IdCam);
        }else{
            header('Location: ../contingut/newsletters/edita.php?IdCam='.$IdCam);
        }
        die();

    } elseif ($TIPUS == 3) {
        header('Location: pas3.php?IdCam='.$IdCam);
        die();

    } else {
        return 1;
    }
}

function personalitzacio ($text, $email, $idcam) {
    global $LOGIN, $CRIPTO_SEPAR,$CRIPTO_CHECK,$CRIPTO_KEY;

    $aju = preg_replace("#\[\[email\]\]#" , $email ,$text);
    $aju = str_replace('!URL_BAIXA!', '#', $aju);

    return $aju;
}

?>
