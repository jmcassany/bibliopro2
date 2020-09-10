<?php

/*configuració del sistema de correu*/
//$mail_sendtype = 'mail'; /*valors posibles -> mail (ho passa al servidor), smtp (utilitza protocol smtp)*/
/*configurar només si el correu és smtp*/
$mail_sendtype = 'smtp';
$mail_port = '587';
$mail_host = 'smtp.mailgun.org';
$mail_SMTPAuth = true;
$mail_username = 'postmaster@bibliopro.org';
$mail_password = '32adce013f0993ed79a9e12caa949c7d';
$mail_hostName = 'antaviana.com';

/*adreça per defecte que s'utilitza de remitent*/
$mail_defaultFrom = 'houdini@antaviana.net';
/*codificació del correu, si no és utf-8 es converteix el correu*/
$mail_encode = 'utf-8'; /* utf-8 iso-8859-1*/


?>
