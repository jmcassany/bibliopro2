<?php
require ('config_admin.inc');
accessGroupPermCheck('users_read');

if (isset($_POST['genconfig'])) {

	/*genera config.php*/
	$genOk = false;
	$file = @fopen('skel/config.php', 'r');
	if ($file) {
		$content = fread($file, filesize('skel/config.php'));
		fclose($file);


		$vars = array(
			'PATHLIB' => $PATHLIB,
			'CONFIG_NOMCARPETA' => $CONFIG_NOMCARPETA,
			'CONFIG_SESSIONNAME' => $CONFIG_SESSIONNAME,

			'CONFIG_PATHPHP' => $CONFIG_PATHPHP,
			'CONFIG_URLBASE' => $CONFIG_URLBASE,
			'CONFIG_SITENAME' => $CONFIG_SITENAME,
			'CONFIG_URLUPLOAD' => $CONFIG_URLUPLOAD,
			'CONFIG_URLUPLOADIM' => $CONFIG_URLUPLOADIM,
			'CONFIG_URLUPLOADAD' => $CONFIG_URLUPLOADAD,
			'CONFIG_PATHUPLOADIM' => $CONFIG_PATHUPLOADIM,
			'CONFIG_PATHUPLOADAD' => $CONFIG_PATHUPLOADAD,

			'ldap_active' => $ldap_active,
			'ldap_server' => $ldap_server,
			'ldap_dn' => $ldap_dn,
			'ldap_user' => $ldap_user,
			'ldap_password' => $ldap_password,

			'SITUACIO_separador' => $SITUACIO_separador,
			'SITUACIO_midamax' => $SITUACIO_midamax,
			'SITUACIO_elementmida' => $SITUACIO_elementmida,
			'SITUACIO_elementtext' => $SITUACIO_elementtext,
			'mail_sendtype' => $mail_sendtype,
			'mail_port' => $mail_port,
			'mail_host' => $mail_host,
			'mail_SMTPAuth' => $mail_SMTPAuth,
			'mail_username' => $mail_username,
			'mail_password' => $mail_password,
			'mail_hostName' => $mail_hostName,
			'mail_defaultFrom' => $mail_defaultFrom,
			'mail_encode' => $mail_encode,


		);

		foreach ($vars as $key => $value) {
			$content = str_replace('|'.$key.'|', varToString($value), $content);
		}



		$file = @fopen($CONFIG_PATHBASE.'/config.php', 'w');
		if ($file) {
			@fwrite($file, $content);
			fclose($file);
			if (!empty($CONFIG_PERMFILES)) {
				@chmod($CONFIG_PATHBASE.'/config.php', $CONFIG_PERMFILES);
			}
			$genOk = true;
		}
	}


	/*genera robots.txt*/
	$genRobotsOk = false;
	$file = @fopen('skel/robots.txt', 'r');
	if ($file) {
		$content = fread($file, filesize('skel/robots.txt'));
		fclose($file);

		$vars = array(
			'CONFIG_URLBASE' => $CONFIG_URLBASE
		);

		foreach ($vars as $key => $value) {
			$content = str_replace('|'.$key.'|', $value, $content);
		}

		$file = @fopen($CONFIG_PATHBASE.'/robots.txt', 'w');
		if ($file) {
			@fwrite($file, $content);
			fclose($file);
			if (!empty($CONFIG_PERMFILES)) {
				@chmod($CONFIG_PATHBASE.'/robots.txt', $CONFIG_PERMFILES);
			}
			$genRobotsOk = true;
		}
	}





}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

<title>Configuració</title>
<link rel="stylesheet" href="install.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">

body {
  background-color: #ffffff;
  font-size: 11px;
  font-family: trebuchet,verdana,geneva,arial,sans-serif;
  margin-left: 18px;
  margin-right: 18px;
  font-weight: normal;
  color: #000000;
  padding: 10px;
  line-height:120%;
}

a:link    {
  color: #990000;
  font-size: 12px;
  font-weight: bold;
  text-decoration: none;
  border-bottom : 1px dotted #333399;
}
a:visited {
  color: #990000;
  font-size: 12px;
  font-weight: bold;
  text-decoration: none;
  border-bottom : 1px dotted #333399;
}
a:active  {
  color: #990000;
  font-size: 12px;
  font-weight: bold;
  text-decoration: none;
  border-bottom : 1px dotted #333399;
}
a:hover   {
  color: #aaaaaa;
  font-size: 12px;
  font-weight: bold;
  text-decoration: none;
}

.border {
  border:   #999999 1px dotted;
  margin: 10px;
}
h2 {
  font-size: 15px;
  color: #000000;
  margin-bottom: 6px;
  margin-top: 6px;
  margin-left: 12px;
  margin-right: 12px;
  font-weight: bold;
}
h3 {
  font-size: 11px;
  margin-left: 12px;
  margin-top: 6px;
  margin-bottom: 6px;
  color: #999999;
  font-weight: normal;
}
h4 {
  font-size: 11px;
  margin-top: 6px;
  color: #333333;
  font-weight: bold;
}
button {
  margin: 20px 0px 0px 0px;
}
.missatge {
  color: green;
  font-weight:bold;
}
.error, strong {
color: #ff0000;
font-weight: bold;
}
fieldset {
  border:   #999999 1px dotted;
  margin: 10px;
}
</style>
</head>
<body>

<div class="border">
<h2 >Configuració del houdini</h2>
<h3>Copyright &#169; 2004 - Can Antaviana</h3>
</div>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">










<fieldset>
<legend>
Fitxer de configuració de la web
</legend>
<?php
if (isset($genOk) && isset($genRobotsOk)) {
  if ($genOk && $genRobotsOk) {
    echo '<div class="missatge">El fitxer s\'ha creat correctament</div>';
  }
  else {
    echo '<div class="error">No s\'ha pogut generar el fitxer comprova els permissos</div>';
  }
}
?>
<button type="submit" name="genconfig">Regenerar</button>
</fieldset>

</form>

</body>
</html>
