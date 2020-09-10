<?php
include("../php/config.php");
include('checkip.inc');

$this->Ip = checkIP();								// Retorne l'IP
$this->Host = gethostbyaddr($this->Ip);								// Retorne el Host
$this->Referer = $_SERVER["HTTP_REFERER"];
$data = date('Y-m-d H:i:s', time());
$dia = date('Y-m-d', time());

$ruta = dirname(__FILE__).'/logs/'.$b.'_'.$dia.'.log';
if (!file_exists($ruta)) {
   touch(dirname(__FILE__).'/logs/'.$b.'_'.$dia.'.log');
}

if (isset($url)) {
   $text = "Entrada nova banner";
}
else {
   $text = "Visualitzacio banner";
}


if (file_exists($ruta)) {
	$fd = fopen ($ruta, "a+");
	fputs ($fd, $text . "|" . $this->Ip . "|" . $this->Host . "|" . $this->Referer . "|" . $_SERVER["REQUEST_URI"] . "|" . $data . "\n");
	fclose ($fd);
}

if (isset($url)) {
    echo header("Location: $url");
}

?>
