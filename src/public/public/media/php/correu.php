<?php
$CONFIG_PATHBASE = $_SERVER['DOCUMENT_ROOT'];
require_once($CONFIG_PATHBASE . '/public/config.php');
require_once("class.phpmailer.php");

$correu_amic = $_POST['correu_amic'];
$idCam = $_POST['idCam'];

$queryButlleti = db_query('SELECT * FROM ' . TAULA_NEWSLETTERS . ' WHERE IdCam = ' . $idCam);
$dadesButlleti = db_fetch_array($queryButlleti);

$queryCampanya = db_query('SELECT * FROM ' . TAULA_CAMPANYES . ' WHERE IdCam = ' . $idCam);
$dadesCampanya = db_fetch_array($queryCampanya);

$filename = $CONFIG_PATHBUTLLETINS . '/butlleti' . $dadesButlleti['ID'] . '.html';
$email = $dadesCampanya['from_email'];
$nom = $dadesCampanya['titol'];
$content = file_get_contents($filename);

$mail = new PHPMailer();

$mail->AddAddress($correu_amic);

$mail->CharSet = "utf-8";
$mail->ContentType = "text/html";
$mail->From = $email;
$mail->FromName = $nom;
$mail->Subject = $nom . " - Enviat per un amic";
$mail->Body = $content;
$mail->AltBody = strip_tags($content);
$mail->Timeout=120;

//$mail->AddAttachment($archivo,$archivo_name);

$exito = $mail->Send();

$intentos=1;
while ((!$exito) && ($intentos < 5)) {
    sleep(5);
    //echo $mail->ErrorInfo;
    $exito = $mail->Send();
    $intentos=$intentos+1;
}

if(!$exito){
    //echo "Problemas enviando correo electr�nico a ".$valor;
    header("Location:" . $CONFIG_URLBASE . "/altres.php?opcio=amicerror&idCam=" . $idCam);
}else{
    //echo "Mensaje enviado correctamente";
    header("Location:" . $CONFIG_URLBASE . "/altres.php?opcio=amicok&idCam=" . $idCam);
}
?>