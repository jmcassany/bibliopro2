<?php

$include_path = ini_get('include_path');
if (substr(PHP_OS, 0, 3) == 'WIN') {
	ini_set('include_path', $include_path.';'.|PATHLIB|);
} else {
	ini_set('include_path', $include_path.':'.|PATHLIB|);
}

require_once('configdb.php');

/*Subcarpeta del servidor en la que s'ha instalat houdini*/
/* exemple -> / o /houdini/ */
$CONFIG_PATHBASE = dirname(__FILE__);
$CONFIG_NOMCARPETA =  |CONFIG_NOMCARPETA|;
$CONFIG_SESSIONNAME = |CONFIG_SESSIONNAME|;

$CONFIG_PATHPHP = |CONFIG_PATHPHP|;
$CONFIG_URLBASE = |CONFIG_URLBASE|;
$CONFIG_SITENAME = |CONFIG_SITENAME|;
$CONFIG_URLUPLOAD = |CONFIG_URLUPLOAD|;
$CONFIG_URLUPLOADIM = |CONFIG_URLUPLOADIM|;
$CONFIG_URLUPLOADAD = |CONFIG_URLUPLOADAD|;
$CONFIG_PATHUPLOADIM = |CONFIG_PATHUPLOADIM|;
$CONFIG_PATHUPLOADAD = |CONFIG_PATHUPLOADAD|;

$ldap_active = |ldap_active|;
if ($ldap_active) {
	$ldap_server = |ldap_server|;
	$ldap_dn = |ldap_dn|;
	$ldap_user = |ldap_user|;
	$ldap_password = |ldap_password|;
}
$mail_sendtype = |mail_sendtype|;
$mail_port = |mail_port|;
$mail_host = |mail_host|;
$mail_SMTPAuth = |mail_SMTPAuth|;
$mail_username = |mail_username|;
$mail_password = |mail_password|;
$mail_hostName = |mail_hostName|;
$mail_defaultFrom = |mail_defaultFrom|;
$mail_encode = |mail_encode|;





/*situació*/
$SITUACIO_separador = |SITUACIO_separador|;
$SITUACIO_midamax = |SITUACIO_midamax|;
$SITUACIO_elementmida = |SITUACIO_elementmida|;
$SITUACIO_elementtext = |SITUACIO_elementtext|;

?>
