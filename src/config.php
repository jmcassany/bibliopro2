<?php

$include_path = ini_get('include_path');
if (substr(PHP_OS, 0, 3) == 'WIN') {
	ini_set('include_path', $include_path.';'.'/var/www/html/lib');
} else {
	ini_set('include_path', $include_path.':'.'/var/www/html/lib');
}

require_once('configdb.php');

/*Subcarpeta del servidor en la que s'ha instalat houdini*/
/* exemple -> / o /houdini/ */
$CONFIG_PATHBASE = dirname(__FILE__);
$CONFIG_NOMCARPETA =  '';
$CONFIG_SESSIONNAME = 'bibliopro';

$CONFIG_PATHPHP = '/var/www/html//media/php/';
$CONFIG_URLBASE = 'http://bibliopro.org';
$CONFIG_SITENAME = 'BiblioPRO';
$CONFIG_URLUPLOAD = 'http://bibliopro.org/media/upload/';
$CONFIG_URLUPLOADIM = 'http://bibliopro.org/media/upload/gif/';
$CONFIG_URLUPLOADAD = 'http://bibliopro.org/media/upload/pdf/';
$CONFIG_PATHUPLOADIM = '/var/www/html//media/upload/gif/';
$CONFIG_PATHUPLOADAD = '/var/www/html//media/upload/pdf/';

$ldap_active = false;
if ($ldap_active) {
	$ldap_server = '';
	$ldap_dn = '';
	$ldap_user = '';
	$ldap_password = '';
}
$mail_sendtype = 'smtp';
$mail_port = '587';
$mail_host = 'smtp.mailgun.org';
$mail_SMTPAuth = true;
$mail_username = 'postmaster@bibliopro.org';
$mail_password = '32adce013f0993ed79a9e12caa949c7d';
$mail_hostName = 'antaviana.com';
$mail_defaultFrom = 'houdini@antaviana.net';
$mail_encode = 'utf-8';





/*situació*/
$SITUACIO_separador = ' > ';
$SITUACIO_midamax = 0;
$SITUACIO_elementmida = 10;
$SITUACIO_elementtext = '...';

?>
