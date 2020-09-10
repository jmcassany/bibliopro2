<?php
function changeLang($idioma, $default = 'ca') {
	global $ID_CARPETA;
	$prefix = $idioma.'_';
	if ($idioma == $default) {
		$prefix = '';
	}

	$basePath = dirname(__FILE__);
	$baseUrl = dirname($_SERVER['PHP_SELF']);
	if ($baseUrl == '/') {
		$baseUrl = '';
	}

	$file = basename(__FILE__);
	$file = preg_replace("/^[a-z]{2}_/i", '', $file);

	if (file_exists($basePath.'/'.$prefix.$file)) {
		//anar a la pàgina traduïda
		return $baseUrl.'/'.$prefix.$file;
	} elseif (file_exists($basePath.'/'.$prefix.'index.html')) {
		//anar al index de la carpeta
		return $baseUrl.'/'.$prefix.'index.html';
	}

	if (isset($ID_CARPETA)) {
		//editora
		$path = folderPath($ID_CARPETA);
		$file = basename($path);
		$file = preg_replace("/^[a-z]{2}_/i", '', $file);
		$path = dirname($path);

		$parentPath = dirname(dirname(__FILE__));
		$parentUrl = '|CONFIG_NOMCARPETA|/'.$path;

		if (file_exists($parentPath.'/'.$prefix.$file)) {
			return $parentUrl.'/'.$prefix.$file;
		}
	}

	return '|CONFIG_NOMCARPETA|/'.$prefix.'index.html';
}
?>
