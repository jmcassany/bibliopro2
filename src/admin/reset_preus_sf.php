<?php

	require_once ('config_admin.inc');

	ini_set('display_errors', 1);
	error_reporting(E_ALL);

?>
	<h1>Reset preus lucre</h1>
<?php

	// posem els preus de lucre a 0
	$query = db_query("
		SELECT `ID`, `NOM_CAST`
		FROM `Cuestionarios`
		WHERE
			SIGLAS LIKE '%SF12v2%'
			OR SIGLAS LIKE '%SF36v2%'
			OR SIGLAS LIKE '%SF36v1%'
			OR SIGLAS LIKE '%SF12v1%'
	");
	if (db_num_rows($query) > 0) {

		while ($row = db_fetch_array($query)) {

			// posem preus de lucre a 0
			$update = db_query("
				UPDATE `Sublicencias_precios`
				SET
					LUCRO = 0,
					LUCRO_SUBS = 0,
					LUCRO_AL = 0,
					LUCRO_SUBS_AL = 0
				WHERE ID_SUBLICENCIA = '$row[ID]'
			");
			if ($update) {

?>
			<p>Esborrats preus per finançament amb ànim de lucre del qüestionari <strong><?php echo htmlspecialchars($row['NOM_CAST']); ?></strong> (<?php echo htmlspecialchars($row['ID']); ?>)</p>
<?php

			}
			else {

?>
			<p>
				<strong>ERROR:</strong>
				No s'han pogut esborrar els preus per finançament amb ànim de lucre del qüestionari <strong><?php echo htmlspecialchars($row['NOM_CAST']); ?></strong> (<?php echo htmlspecialchars($row['ID']); ?>)
			</p>
<?php

			}

		}

	}

?>