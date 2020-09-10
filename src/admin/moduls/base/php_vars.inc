<?php

	function phpVars_pages($content, $id = null, $taula = '', $preview = false) {

		global $PHPVARS_automatic, $CONFIG_NOMCARPETA, $CONFIG_PATHBASE;
		$result = db_query("select * from " . $taula . " where id=" . $id);

		if (db_num_rows($result) != 1) {

			return $content;
		}
		$row = db_fetch_array($result);

		$extraVars = '';
		$folder_url = $CONFIG_NOMCARPETA . '/'. folderPath($row['PARE']);
		switch ($taula) {

			case 'FORMULARIS':

				$desc = 'TITOLFORMULARI';

				if ($folder_url == '') {
					$folder_url = $CONFIG_NOMCARPETA . '/'.$row['NOMFORMULARI'];
				} else {
					$folder_url = $folder_url . '/' . $row['NOMFORMULARI'];
				}
				$pageUrl = str_replace('//', '/', $folder_url);

				break;

				case 'CARPETES':

					$desc = 'DESCRIPCIO';
					$pageUrl = $folder_url;
					$extraVars = '$nomTaula = '.varToString(staticFolderTableName($row['ID'])).'; $pageUrl = $_SERVER["REQUEST_URI"]';

					break;

				default:

					$desc = 'DESCRIPCIO';
					if ($folder_url == '') {
						 $pageUrl = $row['NOMPAG'];
					} else {
							$pageUrl = $folder_url . '/' . $row['NOMPAG'];
					}
					$pageUrl = str_replace('//', '/', $pageUrl);

					break;

		}

		$filAriadna = fil_ariadna_array($row[$desc], $row['PARE'], $row['IDIOMA']);
		$folders = folderPathArray($row['PARE']);

		$codi = '<?php
require_once(\'' . $CONFIG_PATHBASE . '/config.php\');
$id = ' . varToString($id) . ';
$idioma = ' . varToString($row['IDIOMA']) . ';
$pare = ' . varToString($row['PARE']) . ';
$filAriadnaArray = ' . varToString($filAriadna) . ';
$folderArray = ' . varToString($folders) . ';
$folderIds = ' . varToString(array_keys($folders)) . ';
$folderUrl = ' . varToString($folder_url) . ';
$pageUrl = ' . varToString($pageUrl) . ';

' . $extraVars . '
?>';

		if ($PHPVARS_automatic) {
			$content = $codi . $content;
		} else {
			$content = str_replace('|PHP_VARS|', $codi, $content);
		}

		return $content;

	}

?>