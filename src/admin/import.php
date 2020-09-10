<?php

	$preTable = 'Cuest2';
	$cTable = 'Cuestionarios';

	$authorsTable = 'Autores';
	$languagesTable = 'Idiomas';
	$contentTable = 'Contenido';
	$illnessTable = 'Enfermedades';
	$agesTable = 'Edades';
	$populationTable = 'Poblaciones';
	$conceptTable = 'Medidas';

	$now = date('Y-m-d H:i:s');
	$user = 'admin';

	require_once ('config_admin.inc');

	error_reporting (E_ALL);

	$preQuery = db_query ("
		SELECT *
		FROM `$preTable`
		ORDER BY ID_CUEST ASC
	");
	for ($count = 1; $preRow = db_fetch_array($preQuery); $count++) {

		// agrupem enfermetats
		$illness = array();
		if (!empty($preRow['ENFERMEDAD'])) {
			$c = db_query ("SELECT ID FROM `$illnessTable` WHERE VALOR = '" . mysql_real_escape_string(trim($preRow['ENFERMEDAD'])) . "'");
			if (db_num_rows($c) > 0) {
				$r = db_fetch_array($c);
				$illness[] = $r['ID'];
			}
			else {
				$i = db_query ("INSERT INTO `$illnessTable` (VALOR) VALUES ('" . mysql_real_escape_string(trim($preRow['ENFERMEDAD'])) . "')");
				$illness[] = mysql_insert_id();
			}
		}
		if (!empty($preRow['ENFERMEDAD_2'])) {
			$c = db_query ("SELECT ID FROM `$illnessTable` WHERE VALOR = '" . mysql_real_escape_string(trim($preRow['ENFERMEDAD_2'])) . "'");
			if (db_num_rows($c) > 0) {
				$r = db_fetch_array($c);
				$illness[] = $r['ID'];
			}
			else {
				$i = db_query ("INSERT INTO `$illnessTable` (VALOR) VALUES ('" . mysql_real_escape_string(trim($preRow['ENFERMEDAD_2'])) . "')");
				$illness[] = mysql_insert_id();
			}
		}

		// agrupem tipus contingut
		$content = array();
		if (!empty($preRow['MEDIDA'])) {
			$c = db_query ("SELECT ID FROM `$contentTable` WHERE VALOR = '" . mysql_real_escape_string(trim($preRow['MEDIDA'])) . "'");
			if (db_num_rows($c) > 0) {
				$r = db_fetch_array($c);
				$content[] = $r['ID'];
			}
			else {
				$i = db_query ("INSERT INTO `$contentTable` (VALOR) VALUES ('" . mysql_real_escape_string(trim($preRow['MEDIDA'])) . "')");
				$content[] = mysql_insert_id();
			}
		}
		if (!empty($preRow['MEDIDA_2'])) {
			$c = db_query ("SELECT ID FROM `$contentTable` WHERE VALOR = '" . mysql_real_escape_string(trim($preRow['MEDIDA_2'])) . "'");
			if (db_num_rows($c) > 0) {
				$r = db_fetch_array($c);
				$content[] = $r['ID'];
			}
			else {
				$i = db_query ("INSERT INTO `$contentTable` (VALOR) VALUES ('" . mysql_real_escape_string(trim($preRow['MEDIDA_2'])) . "')");
				$content[] = mysql_insert_id();
			}
		}

		// agrupem edats
		$ages = array();
		if (!empty($preRow['EDAD'])) {
			$c = db_query ("SELECT ID FROM `$agesTable` WHERE VALOR = '" . mysql_real_escape_string(trim($preRow['EDAD'])) . "'");
			if (db_num_rows($c) > 0) {
				$r = db_fetch_array($c);
				$ages[] = $r['ID'];
			}
			else {
				$i = db_query ("INSERT INTO `$agesTable` (VALOR) VALUES ('" . mysql_real_escape_string(trim($preRow['EDAD'])) . "')");
				$ages[] = mysql_insert_id();
			}
		}
		if (!empty($preRow['EDAD_2'])) {
			$c = db_query ("SELECT ID FROM `$agesTable` WHERE VALOR = '" . mysql_real_escape_string(trim($preRow['EDAD_2'])) . "'");
			if (db_num_rows($c) > 0) {
				$r = db_fetch_array($c);
				$ages[] = $r['ID'];
			}
			else {
				$i = db_query ("INSERT INTO `$agesTable` (VALOR) VALUES ('" . mysql_real_escape_string(trim($preRow['EDAD_2'])) . "')");
				$ages[] = mysql_insert_id();
			}
		}

		// població
		$population = array();
		if (!empty($preRow['POBLACION'])) {
			$c = db_query ("SELECT ID FROM `$populationTable` WHERE VALOR = '" . mysql_real_escape_string(trim($preRow['POBLACION'])) . "'");
			if (db_num_rows($c) > 0) {
				$r = db_fetch_array($c);
				$population[] = $r['ID'];
			}
			else {
				$i = db_query ("INSERT INTO `$populationTable` (VALOR) VALUES ('" . mysql_real_escape_string(trim($preRow['POBLACION'])) . "')");
				$population[] = mysql_insert_id();
			}
		}

		// autor original
		$originalAuthors = array();
		if (!empty($preRow['AUTOR_ORIGINAL'])) {
			$c = db_query ("SELECT ID FROM `$authorsTable` WHERE NOM = '" . mysql_real_escape_string(trim($preRow['AUTOR_ORIGINAL'])) . "'");
			if (db_num_rows($c) > 0) {
				$r = db_fetch_array($c);
				$originalAuthors[] = $r['ID'];
			}
			else {
				$i = db_query ("
					INSERT
					INTO `$authorsTable` (NOM, EMAIL, TELEFON)
					VALUES (
						'" . mysql_real_escape_string(trim($preRow['AUTOR_ORIGINAL'])) . "',
						'" . mysql_real_escape_string(trim($preRow['EMAIL_CONTACTO_ORIGINAL'])) . "',
						'" . mysql_real_escape_string(trim($preRow['TELEFONO_ORIGINAL'])) . "'
					)
				");
				$originalAuthors[] = mysql_insert_id();
			}
		}

		// autor cast
		$castAuthors = array();
		if (!empty($preRow['AUTOR_CAST'])) {
			$c = db_query ("SELECT ID FROM `$authorsTable` WHERE NOM = '" . mysql_real_escape_string(trim($preRow['AUTOR_CAST'])) . "'");
			if (db_num_rows($c) > 0) {
				$r = db_fetch_array($c);
				$castAuthors[] = $r['ID'];
			}
			else {
				$i = db_query ("
					INSERT
					INTO `$authorsTable` (NOM, EMAIL, TELEFON)
					VALUES (
						'" . mysql_real_escape_string(trim($preRow['AUTOR_CAST'])) . "',
						'" . mysql_real_escape_string(trim($preRow['EMAIL_CONTACTO_CAST'])) . "',
						'" . mysql_real_escape_string(trim($preRow['TELEFONO_CAST'])) . "'
					)
				");
				$castAuthors[] = mysql_insert_id();
			}
		}

		// idioma original
		$originalLanguage = '';
		if (!empty($preRow['IDIOMA_ORIGINAL'])) {
			$c = db_query ("SELECT ID FROM `$languagesTable` WHERE IDIOMA = '" . mysql_real_escape_string(trim($preRow['IDIOMA_ORIGINAL'])) . "'");
			if (db_num_rows($c) > 0) {
				$r = db_fetch_array($c);
				$originalLanguage = $r['ID'];
			}
			else {
				$i = db_query ("INSERT INTO `$languagesTable` (IDIOMA) VALUES ('" . mysql_real_escape_string(trim($preRow['IDIOMA_ORIGINAL'])) . "')");
				$originalLanguage = mysql_insert_id();
			}
		}

		// idioma cast
		$castLanguage = '';
		if (!empty($preRow['IDIOMA_CAST'])) {
			$c = db_query ("SELECT ID FROM `$languagesTable` WHERE IDIOMA = '" . mysql_real_escape_string(trim($preRow['IDIOMA_CAST'])) . "'");
			if (db_num_rows($c) > 0) {
				$r = db_fetch_array($c);
				$castLanguage = $r['ID'];
			}
			else {
				$i = db_query ("INSERT INTO `$languagesTable` (IDIOMA) VALUES ('" . mysql_real_escape_string(trim($preRow['IDIOMA_CAST'])) . "')");
				$castLanguage = mysql_insert_id();
			}
		}

		db_query("
			INSERT INTO `$cTable`
			VALUES (
				'',
				'" . mysql_real_escape_string($preRow['ID_CUEST']) . "',
				1,
				'" . mysql_real_escape_string($preRow['NOMBRE_ORIGINAL']) . "',
				'" . mysql_real_escape_string($preRow['NOMBRE_CAST']) . "',
				'" . mysql_real_escape_string($preRow['SIGLAS']) . "',
				'" . mysql_real_escape_string($preRow['REFERENCIA_ORIGINAL']) . "',
				'" . mysql_real_escape_string($preRow['REFERENCIA_CAST']) . "',
				'" . mysql_real_escape_string($preRow['CORRESPONDENCIA_ORIGINAL']) . "',
				'" . mysql_real_escape_string($preRow['CORRESPONDENCIA_CAST']) . "',
				'" . mysql_real_escape_string($preRow['COPYRIGHT_ORIGINAL']) . "',
				'" . mysql_real_escape_string($preRow['COPYRIGHT_CAST']) . "',
				'" . mysql_real_escape_string($preRow['OTROS_ORIGINAL']) . "',
				'" . mysql_real_escape_string($preRow['OTROS_CAST']) . "',
				'" . (count($content) > 0 ? serialize($content) : '') . "',
				'" . (count($illness) > 0 ? serialize($illness) : '') . "',
				'" . (count($population) > 0 ? serialize($population) : '') . "',
				'" . (count($ages) > 0 ? serialize($ages) : '') . "',
				'',
				'" . mysql_real_escape_string($preRow['NUMERO_ITEMS']) . "',
				'" . mysql_real_escape_string($preRow['DIMENSIONES']) . "',
				'" . mysql_real_escape_string($preRow['PALABRAS_CLAVE']) . "',
				'" . mysql_real_escape_string($preRow['EMAIL_CONTACTO_ORIGINAL']) . "',
				'" . mysql_real_escape_string($preRow['EMAIL_CONTACTO_CAST']) . "',
				'" . mysql_real_escape_string($preRow['TELEFONO_ORIGINAL']) . "',
				'" . mysql_real_escape_string($preRow['TELEFONO_CAST']) . "',
				'$originalLanguage',
				'$castLanguage',
				'',
				'" . (count($originalAuthors) > 0 ? serialize($originalAuthors) : '') . "',
				'" . (count($castAuthors) > 0 ? serialize($castAuthors) : '') . "',
				'" . mysql_real_escape_string($preRow['AUTORES_EXTRA_ORIGINAL']) . "',
				'" . mysql_real_escape_string($preRow['AUTORES_EXTRA_CAST']) . "',
				'$now',
				'$user',
				'$user',
				'$now',
				1,
				1
			)
		");

		echo '<p>Creat qüestionari ' . $preRow['ID_CUEST'] . ' (' . $count . ')</p>';

	}

	echo "<p><strong>Importats $count qüestionaris</strong></p>";

?>