<?php

	require('../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('questionaris.php');

	// funció per escapar les cometes i eliminar els salts de línia
	function format($cadena) {

// 		$cadena = str_replace("\r\n", '\n', $cadena);
// 		$cadena = str_replace("\n", '', $cadena);
		$cadena = str_replace('"', '""', $cadena);
		return $cadena;

	}

	// fem que el navegador descarregui el fitxer generat (escrit)
	header("Pragma: public");
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private", false);
	header("Content-Type: text/plain");
	header('Content-Disposition: attachment; filename="questionaris.csv"');
	header("Content-Transfer-Encoding: binary");

	// nom dels camps
	echo 'ID_CUEST,';
	echo 'VERSION,';
	echo 'SIGLAS,';
	echo 'NOM_ORIGINAL,';
	echo 'REFERENCIA_ORIGINAL,';
	echo 'CORRESPONDENCIA_ORIGINAL,';
	echo 'COPYRIGHT_ORIGINAL,';
	echo 'OTROS_ORIGINAL,';
	echo 'EMAIL_CONTACTO_ORIGINAL,';
	echo 'TELEFONO_ORIGINAL,';
	echo 'IDIOMA_ORIGINAL,';
	echo 'PAIS,';
	echo 'IDAUTORES_ORIGINAL,';
	echo 'AUTORES_EXTRA_ORIGINAL,';
	echo 'NOM_CAST,';
	echo 'REFERENCIA_CAST,';
	echo 'CORRESPONDENCIA_CAST,';
	echo 'COPYRIGHT_CAST,';
	echo 'OTROS_CAST,';
	echo 'EMAIL_CONTACTO_CAST,';
	echo 'TELEFONO_CAST,';
	echo 'IDIOMA_CAST,';
	echo 'IDAUTORES_CAST,';
	echo 'AUTORES_EXTRA_ORIGINAL,';
	echo 'CONTENIDO,';
	echo 'ENFERMEDAD,';
	echo 'MEDIDA,';
	echo 'POBLACION,';
	echo 'EDAD,';
	echo 'NUMERO_ITEMS,';
	echo 'DIMENSIONES,';
	echo 'PALABRAS_CLAVE,';
	echo "MODIFICAT\n";

	$q_query = db_query("
		SELECT
			*
		FROM
			$CARDS_TABLE
		WHERE
			STATUS = 1
			AND ECLASS = 1
		ORDER BY
			ID_CUEST ASC,
			VERSION ASC
	");
	// si hi ha algun usuari del centre..
	if(db_num_rows($q_query) > 0) {

		// els camps
		while($row = db_fetch_array($q_query)) {

			// id cuest
			echo '"' . format($row['ID_CUEST']) . '",';

			// versió
			echo '"' . format($row['VERSION']) . '",';

			// sigles
			echo '"' . format($row['SIGLAS']) . '",';

			// nom orig
			echo '"' . format($row['NOM_ORIGINAL']) . '",';

			// ref orig
			echo '"' . format($row['REFERENCIA_ORIGINAL']) . '",';

			// corres orig
			echo '"' . format($row['CORRESPONDENCIA_ORIGINAL']) . '",';

			// copy orig
			echo '"' . format($row['COPYRIGHT_ORIGINAL']) . '",';

			// altres orig
			echo '"' . format($row['OTROS_ORIGINAL']) . '",';

			// email orig
			echo '"' . format($row['EMAIL_CONTACTO_ORIGINAL']) . '",';

			// tel orig
			echo '"' . format($row['TELEFONO_ORIGINAL']) . '",';

			// idioma orig
			$languageQuery = db_query("
				SELECT IDIOMA
				FROM $LANGUAGES_TABLE
				WHERE ID = $row[IDIOMA_ORIGINAL]
			");
			if (db_num_rows($languageQuery) > 0) {
				$languageRow = db_fetch_array($languageQuery);
			}
			else {
				$languageRow['IDIOMA'] = '';
			}
			echo '"' . format($languageRow['IDIOMA']) . '",';

			// pais
			$countryQuery = db_query("
				SELECT PAIS
				FROM $COUNTRIES_TABLE
				WHERE ID = $row[PAIS]
			");
			if (db_num_rows($countryQuery) > 0) {
				$countryRow = db_fetch_array($countryQuery);
			}
			else {
				$countryRow['PAIS'] = '';
			}
			echo '"' . format($countryRow['PAIS']) . '",';

			// autors orig
			$originalAuthors = unserialize($row['IDAUTORES_ORIGINAL']);
			$originalAuthorsArray = array();
			if (is_array($originalAuthors) and count($originalAuthors) > 0) {
				$where = array();
				foreach ($originalAuthors as $authorID) { $where[] = "ID = $authorID"; }
				$authorsQuery = db_query ("
					SELECT NOM
					FROM `$AUTHORS_TABLE`
					WHERE " . implode(' OR ', $where) . "
				");
				while ($authorRow = db_fetch_array($authorsQuery)) {
					$originalAuthorsArray[] = $authorRow['NOM'];
				}
			}
			echo '"' . format(implode(', ', $originalAuthorsArray)) . '",';

			// autors extra orig
			echo '"' . format($row['AUTORES_EXTRA_ORIGINAL']) . '",';

			// nom cast
			echo '"' . format($row['NOM_CAST']) . '",';

			// ref cast
			echo '"' . format($row['REFERENCIA_CAST']) . '",';

			// corres cast
			echo '"' . format($row['CORRESPONDENCIA_CAST']) . '",';

			// copy cast
			echo '"' . format($row['COPYRIGHT_CAST']) . '",';

			// altres cast
			echo '"' . format($row['OTROS_CAST']) . '",';

			// email cast
			echo '"' . format($row['EMAIL_CONTACTO_CAST']) . '",';

			// telefon cast
			echo '"' . format($row['TELEFONO_CAST']) . '",';

			// idioma cast
			$languageQuery = db_query("
				SELECT IDIOMA
				FROM $LANGUAGES_TABLE
				WHERE ID = $row[IDIOMA_CAST]
			");
			if (db_num_rows($languageQuery) > 0) {
				$languageRow = db_fetch_array($languageQuery);
			}
			else {
				$languageRow['IDIOMA'] = '';
			}
			echo '"' . format($languageRow['IDIOMA']) . '",';

			// autors cast
			$castAuthors = unserialize($row['IDAUTORES_CAST']);
			$castAuthorsArray = array();
			if (is_array($castAuthors) and count($castAuthors) > 0) {
				$where = array();
				foreach ($castAuthors as $authorID) { $where[] = "ID = $authorID"; }
				$authorsQuery = db_query ("
					SELECT NOM
					FROM `$AUTHORS_TABLE`
					WHERE " . implode(' OR ', $where) . "
				");
				while ($authorRow = db_fetch_array($authorsQuery)) {
					$castAuthorsArray[] = $authorRow['NOM'];
				}
			}
			echo '"' . format(implode(', ', $castAuthorsArray)) . '",';

			// autors extra cast
			echo '"' . format($row['AUTORES_EXTRA_ORIGINAL']) . '",';

			// contingut
			$content = unserialize($row['CONTENIDO']);
			$itemsArray = array();
			if (is_array($content) and count($content) > 0) {
				$where = array();
				foreach ($content as $itemID) { $where[] = "ID = $itemID"; }
				$itemsQuery = db_query ("
					SELECT VALOR
					FROM `$CONTENT_TABLE`
					WHERE " . implode(' OR ', $where) . "
				");
				while ($itemRow = db_fetch_array($itemsQuery)) {
					$itemsArray[] = $itemRow['VALOR'];
				}
			}
			echo '"' . format(implode(', ', $itemsArray)) . '",';

			// malalties
			$content = unserialize($row['ENFERMEDAD']);
			$itemsArray = array();
			if (is_array($content) and count($content) > 0) {
				$where = array();
				foreach ($content as $itemID) { $where[] = "ID = $itemID"; }
				$itemsQuery = db_query ("
					SELECT VALOR
					FROM `$ILLNESS_TABLE`
					WHERE " . implode(' OR ', $where) . "
				");
				while ($itemRow = db_fetch_array($itemsQuery)) {
					$itemsArray[] = $itemRow['VALOR'];
				}
			}
			echo '"' . format(implode(', ', $itemsArray)) . '",';

			// mesures
			$content = unserialize($row['MEDIDA']);
			$itemsArray = array();
			if (is_array($content) and count($content) > 0) {
				$where = array();
				foreach ($content as $itemID) { $where[] = "ID = $itemID"; }
				$itemsQuery = db_query ("
					SELECT VALOR
					FROM `$MEASURES_TABLE`
					WHERE " . implode(' OR ', $where) . "
				");
				while ($itemRow = db_fetch_array($itemsQuery)) {
					$itemsArray[] = $itemRow['VALOR'];
				}
			}
			echo '"' . format(implode(', ', $itemsArray)) . '",';

			// poblacions
			$content = unserialize($row['POBLACION']);
			$itemsArray = array();
			if (is_array($content) and count($content) > 0) {
				$where = array();
				foreach ($content as $itemID) { $where[] = "ID = $itemID"; }
				$itemsQuery = db_query ("
					SELECT VALOR
					FROM `$POPULATIONS_TABLE`
					WHERE " . implode(' OR ', $where) . "
				");
				while ($itemRow = db_fetch_array($itemsQuery)) {
					$itemsArray[] = $itemRow['VALOR'];
				}
			}
			echo '"' . format(implode(', ', $itemsArray)) . '",';

			// edats
			$content = unserialize($row['EDAD']);
			$itemsArray = array();
			if (is_array($content) and count($content) > 0) {
				$where = array();
				foreach ($content as $itemID) { $where[] = "ID = $itemID"; }
				$itemsQuery = db_query ("
					SELECT VALOR
					FROM `$AGES_TABLE`
					WHERE " . implode(' OR ', $where) . "
				");
				while ($itemRow = db_fetch_array($itemsQuery)) {
					$itemsArray[] = $itemRow['VALOR'];
				}
			}
			echo '"' . format(implode(', ', $itemsArray)) . '",';

			// num items
			echo '"' . format($row['NUMERO_ITEMS']) . '",';

			// dimensions
			echo '"' . format($row['DIMENSIONES']) . '",';

			// paraules clau
			echo '"' . format($row['PALABRAS_CLAVE']) . '",';

			// modificació
			echo '"' . format($row['MODIFICAT']) . "\"\n";

		}

	}

?>