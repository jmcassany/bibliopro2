<?php
include_once (dirname(__FILE__) . "/../../config.php");
include_once ("mail.php");

// simple captcha
if (!isset ($_SESSION)) { session_start(); }
$captcha = array();
$captcha['seconds'] = 6;
if (!isset($_SESSION['SUM1']) or !isset($_SESSION['SUM2'])) {
	$captcha['sum1'] = $_SESSION['SUM1'] = rand(0, 98);
	$captcha['sum2'] = $_SESSION['SUM2'] = rand(0, (99 - $captcha['sum1']));
}
else {
	$captcha['sum1'] = $_SESSION['SUM1'];
	$captcha['sum2'] = $_SESSION['SUM2'];
}
$captcha['timestamp'] = time();

function gestionaFormulari($subject, $dest, $redirect, $redirectError = "/error.html")
{

	global $CONFIG_NOMCARPETA, $captcha;

	// captcha
	if (
		isset($_POST['captcha']) and
		$captcha['timestamp'] > ($_POST['timestamp'] + $captcha['seconds']) and
		$_POST['captcha'] == ($captcha['sum1'] + $captcha['sum2'])
	) {

		$hostvalids = $_SERVER['SERVER_NAME'];
		$error = $redirectError;
		$referer = '';

		if (isset($_SERVER['HTTP_REFERER'])) {
			$referer = strtok(str_replace('https://', '', $_SERVER['HTTP_REFERER']) , '/');
		}

		if ($referer == $hostvalids) {

			if (!isset($_POST['enviar'])) {
				return;
			}
			$msg = '';

			while (list($key, $value) = each($_POST)) {

				if (!(
					$key == "Enviar"
					|| $key == "enviar"
					|| $key == "enviar_x"
					|| $key == "enviar_y"
					|| $key == "x"
					|| $key == "y"
					|| $key == "RECIPIENT"
					|| $key == "REDIRECT"
					|| $key == "SUBJECT"
					|| $key == "captcha_id"
				)) {
					$msg.= "<li><strong>" . htmlspecialchars($key) . ":</strong>" . htmlspecialchars($value) . "<li>";
				}

			}

			$destinatari = $dest;

			$from = (isset($_POST['email']) and !empty($_POST['email'])) ? $from = $_POST['email'] : 'bibliopro@imim.es';

			$assumpte = "[BiblioPRO]: " . $subject;

			$cos = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<h1>' . $subject . '</h1>
		<hr size="1">
		<ul>
			' . $msg . '
		</ul>
		<hr size="1">
		Mensaje enviado des del sitio web de BiblioPRO.
	</body>
</html>';

			if (!spamDetect($cos)) {

				//codificació x Outlook
				//$cos = utf8_decode($cos);
				//$assumpte = utf8_decode($assumpte);
				// preparem adjunts per enviar si n'hi ha
				$adjunts = array();

				foreach($_FILES as $fitxer_adjunt) {
					if (!empty($fitxer_adjunt['name'])) {
						array_unshift($adjunts, array(
							'path' => $fitxer_adjunt['tmp_name'],
							'name' => $fitxer_adjunt['name']
						));
					}
				}
				if (count($adjunts) == 0) {
					$adjunts = null;
				}

				if (sendMail($destinatari, $assumpte, $cos, $from, $adjunts, true)) {
					header("Location: $redirect");
				} else {
					header("Location: $error");
				}

			}

		}

	}

}

function spamDetect($content_to_filter)
{
	$filtre = array(
		'[/url]'
	);

	foreach($filtre as $filter_item) {

		if (strpos($content_to_filter, $filter_item) != false) {
			return true;
		}
	}
	return false;
}

?>