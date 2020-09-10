<?php

	require('../../config_admin.inc');

	require('questionaris.php');

	$query = db_query("
		SELECT *
		FROM `$CARDS_TABLE`
	");
	if (db_num_rows($query) > 0) {

		while ($row = db_fetch_array($query)) {

			// autors original
			$authors = array();
			$authorIDS = unserialize($row['IDAUTORES_ORIGINAL']);
			foreach ($authorIDS as $authorID) {
				$authorQuery = db_query("
					SELECT `NOM`
					FROM `$AUTHORS_TABLE`
					WHERE `ID` = '$authorID'
				");
				if (db_num_rows($authorQuery) > 0) {
					$authorRow = db_fetch_array($authorQuery);
					$authors[] = $authorRow['NOM'];
				}
			}
			$update = db_query("
				UPDATE `$CARDS_TABLE`
				SET AUTORES_ORIGINAL_NOMBRES = '" . mysql_real_escape_string(implode(', ', $authors)) . "'
				WHERE ID = $row[ID]
			");

			// autors adaptació
			$authors = array();
			$authorIDS = unserialize($row['IDAUTORES_CAST']);
			foreach ($authorIDS as $authorID) {
				$authorQuery = db_query("
					SELECT `NOM`
					FROM `$AUTHORS_TABLE`
					WHERE `ID` = '$authorID'
				");
				if (db_num_rows($authorQuery) > 0) {
					$authorRow = db_fetch_array($authorQuery);
					$authors[] = $authorRow['NOM'];
				}
			}
			$update = db_query("
				UPDATE `$CARDS_TABLE`
				SET AUTORES_CAST_NOMBRES = '" . mysql_real_escape_string(implode(', ', $authors)) . "'
				WHERE ID = $row[ID]
			");

			echo '<p>· Converted ' . $row['NOM_CAST'] . '</p>';

		}

	}

?>