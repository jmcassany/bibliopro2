<?php

	require('../../../config_admin.inc');
	accessGroupPermCheck('pagaments');

	require('descarregues.php');
	require('questionnaires_vars.inc');

	// escapar comes dobles
	function format($cadena) {

		$cadena = str_replace('"', '""', $cadena);
		return $cadena;

	}

	// fem que el navegador descarregui el fitxer generat (escrit)
	header("Pragma: public");
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private", false);
	header("Content-Type: text/plain");
	header('Content-Disposition: attachment; filename="descarregues.csv"');
	header("Content-Transfer-Encoding: binary");

	// nom dels camps
	echo 'ID_CUEST,';
	echo 'ID_DESCARGABLE,';
	echo 'SIGLAS_CUEST,';
	echo 'NOM_ORIGINAL_CUEST,';
	echo 'NOM_CAST_CUEST,';
	echo 'USUARIO,';
	echo 'IP_USUARIO,';
	echo 'FECHA_SOLICITUD,';
	echo 'METODO_PAGO,';
	echo 'PRECIO,';
	echo 'TIPO_IVA,';
	echo 'IVA,';
	echo 'IBAN,';
	echo 'SWIFT,';
	echo 'TOTAL,';
	echo 'STATUS,';
	echo 'FECHA_VALIDEZ,';
	echo 'ID_TPV,';
	echo 'FECHA_COBRO,';
	echo 'FACTURACION_CIF,';
	echo 'FACTURACION_PROFESIONAL,';
	echo 'FACTURACION_NOMBRE,';
	echo 'FACTURACION_DIRECCION,';
	echo 'FACTURACION_CP,';
	echo 'FACTURACION_CIUDAD,';
	echo 'FACTURACION_PAIS,';
	echo 'CEUTA_O_MELILLA,';
	echo 'FACTURACION_TELEFONO,';
	echo 'FACTURACION_FAX,';
	echo 'FACTURACION_EMAIL,';
	echo 'FACTURA,';
	echo 'FECHA_FACTURA,';
	echo 'FICHERO_FACTURA,';
	echo 'SOLICITA_FACTURA,';
	echo 'NUM_ALBARAN,';
	echo "CREATION,";
	echo 'USUARICREAR,';
	echo 'MODIFICAT,';
	echo "USUARIMODI\n";

	$cerca = !empty($_GET['cerca']) ? $_GET['cerca'] : '';
	$autor = !empty($_GET['autor']) ? $_GET['autor'] : '';
	$estat = !empty($_GET['estat']) ? $_GET['estat'] : '';
	$pagament = !empty($_GET['pagament']) ? $_GET['pagament'] : '';
	$atorgament = !empty($_GET['atorgament']) ? $_GET['atorgament'] : '';
	$data_subl_desde = !empty($_GET['data_subl_desde']) ? $_GET['data_subl_desde'] : '';
	$data_subl_fins = !empty($_GET['data_subl_fins']) ? $_GET['data_subl_fins'] : '';

	// filtres
	$where = '';
	if (!empty($cerca)) {
		$cerca = addslashes($cerca);
		$where .= " AND (
			NOM_ORIGINAL_CUEST LIKE '%$nom%'
			OR NOM_CAST_CUEST LIKE '%$nom%'
			OR SIGLAS_CUEST LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_EMAIL LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_NOMBRE LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_CIF LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_DIRECCION LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_CP LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_CIUDAD LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_OTRO_PAIS LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_TELEFONO LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR FACTURACION_FAX LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR ID_TPV LIKE '%" . mysql_real_escape_string($cerca) . "%'
			OR NUM_ALBARAN LIKE '%" . mysql_real_escape_string($cerca) . "%'
		)";
	}
	// autor
	if (!empty($autor)) {
		$autor = addslashes($autor);
		$where .= " AND (IDAUTORES_ORIGINAL_CUEST LIKE '%\"$autor\"%' OR IDAUTORES_CAST_CUEST LIKE '%\"$autor\"%')";
	}
	// usuari
	if (!empty($user)) {
		$user = addslashes($user);
		$where .= " AND ID_USUARIO = '$user'";
	}
	// estat
	if ($estat != '') {
		$estat = addslashes($estat);
		$where .= " AND STATUS = '$estat'";
	}
	// forma pagament
	if (!empty($pagament)) {
		$pagament = addslashes($pagament);
		$where .= " AND METODO_PAGO = '$pagament'";
	}
	// interval data validesa
	if (!empty($data_subl_desde) and !empty($data_subl_fins)) {
		$where .= " AND (
			FECHA_COBRO != '0000-00-00 00:00:00'
			AND FECHA_COBRO <= '$data_subl_desde'
			AND FECHA_VALIDEZ >= '$data_subl_fins'
		)";
	}

	$q_query = db_query("
		SELECT
			*
		FROM
			`$CARDS_TABLE`
		WHERE
			`ECLASS` = 1
			$where
		ORDER BY
			`ID_CUEST` ASC,
			`NOM_CAST_CUEST` ASC,
			`FECHA_SOLICITUD` ASC

	");
	// si hi ha algun usuari del centre..
	if(db_num_rows($q_query) > 0) {

		// els camps
		while($row = db_fetch_array($q_query)) {

			// id cuest
			echo '"' . format($row['ID_CUEST']) . '",';

			// id cuest
			echo '"' . format($row['ID_DESCARGABLE']) . '",';

			// sigles
			echo '"' . format($row['SIGLAS_CUEST']) . '",';

			// noms qüestionari
			echo '"' . format($row['NOM_ORIGINAL_CUEST']) . '",';
			echo '"' . format($row['NOM_CAST_CUEST']) . '",';

			// usuari
			$userQuery = db_query("
				SELECT `NOMBRE`, `EMAIL`
				FROM `$USERS_TABLE`
				WHERE ID = $row[ID_USUARIO]
			");
			if (db_num_rows($userQuery) > 0) {

					$userRow = db_fetch_array($userQuery);

					echo '"' . format($userRow['NOMBRE']) . ' (' . format($userRow['EMAIL']) . ')",';

			}
			else {
				echo '"Desconocido",';
			}
			echo '"' . format($row['IP_USUARIO']) . '",';

			// data sol·licitud
			echo '"' . format($row['FECHA_SOLICITUD']) . '",';

			// mètode pagament
			echo '"' . format($paymentMethods[$row['METODO_PAGO']]) . '",';

			// info preu
			echo '"' . format($row['PRECIO']) . '",';
			echo '"' . format($row['TIPO_IVA']) . '",';
			echo '"' . format($row['IVA']) . '",';
			echo '"' . format($row['IBAN']) . '",';
			echo '"' . format($row['SWIFT']) . '",';
			echo '"' . format($row['TOTAL']) . '",';

			// estat
			echo '"' . format($status[$row['STATUS']]) . '",';

			// fecha validez
			echo '"' . format($row['FECHA_VALIDEZ']) . '",';

			// info pago
			echo '"' . format($row['ID_TPV']) . '",';
			echo '"' . format($row['FECHA_COBRO']) . '",';
			echo '"' . format($row['FACTURACION_CIF']) . '",';
			echo '"' . format($row['FACTURACION_PROFESIONAL']) . '",';
			echo '"' . format($row['FACTURACION_NOMBRE']) . '",';
			echo '"' . format($row['FACTURACION_DIRECCION']) . '",';
			echo '"' . format($row['FACTURACION_CP']) . '",';
			echo '"' . format($row['FACTURACION_CIUDAD']) . '",';
			echo '"' . format($row['FACTURACION_PAIS']) . '",';
			echo '"' . format($row['FACTURACION_OTRO_PAIS']) . '",';
			echo '"' . format($row['FACTURACION_TELEFONO']) . '",';
			echo '"' . format($row['FACTURACION_FAX']) . '",';
			echo '"' . format($row['FACTURACION_EMAIL']) . '",';
			echo '"' . format($row['FACTURA']) . '",';
			echo '"' . format($row['FECHA_FACTURA']) . '",';
			echo '"' . format($row['FICHERO_FACTURA']) . '",';
			echo '"' . format($row['SOLICITA_FACTURA']) . '",';
			echo '"' . format($row['NUM_ALBARAN']) . '",';

			// creació
			echo '"' . format($row['CREATION']) . '",';
			echo '"' . format($row['USUARICREAR']) . '",';

			// modificació
			echo '"' . format($row['MODIFICAT']) . '",';
			echo '"' . format($row['USUARIMODI']) . "\"\n";

		}

	}

?>