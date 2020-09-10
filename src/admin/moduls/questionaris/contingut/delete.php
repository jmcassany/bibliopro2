<?php

	require ('../../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('contingut.php');

	if (!isset($_POST['CONFIRM']) || $_POST['CONFIRM'] !='TRUE') {
	  htmlPageError('Error esborrant concepte de qüestionaris');
	}

?>
<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;padding:20px;">
	<tr>
		<td class="text" style="padding:10px;">
<?php

	$missatge = '';

	if (!isset($_POST['CHECK'])) {
	  $missatge = t("errordeletenocheck");
	}
	else {

		$notDeleted = array();

		/*per tots els elemtens a esborrar*/
		foreach($_POST['CHECK'] as $key => $value) {

			/*obtenir les dades*/
			$result = db_query('select VALOR from ' . $CARDS_TABLE . ' where ID = '.$key);
			$row = db_fetch_array($result);

			// comprovem que el valor no s'està utilitzant en algun qüestionari
			if (db_num_rows(
				db_query("
					SELECT ID
					FROM Cuestionarios
					WHERE
						CONTENIDO LIKE '%\"$row[ID]\"%'
				")
			) == 0) {

				db_query('delete from ' . $CARDS_TABLE . ' where ID = '.$key);

				/*insertar registre d'accions*/
				register_add("Concepte de qüestionaris eliminat", $row['VALOR']);

			}
			else {

				$notDeleted[] = $row['VALOR'];

			}

		}
	}
?>
<table  border="0" cellpadding="0" cellspacing="0">
<?php

	if (count($notDeleted) > 0) {

		foreach ($notDeleted as $notDeletedCountry) {

?>
	<tr>
		<td class="text">El valor <em><?php echo $notDeletedCountry; ?></em> <strong>no</strong> s'ha pogut esborrar ja que està seleccionat en algun dels qüestionaris.</td>
	</tr>
<?php

		}

	}

?>
	<tr>
		<td class="text">Les entrades de concepte seleccionades han estat esborrades</td>
	</tr>
	<tr>
		<td colspan="2" style="padding-bottom:10px;padding-top:15px;" align="center">
		<b><a href="index.php" class="botonavegacio"><?php echo t("continue") ?></a></b>
		</td>
	</tr>
</table>

</td></tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
