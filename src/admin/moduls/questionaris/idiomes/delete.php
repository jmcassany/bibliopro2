<?php

	require ('../../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('idiomes.php');

	if (!isset($_POST['CONFIRM']) || $_POST['CONFIRM'] !='TRUE') {
	  htmlPageError('Error esborrant idioma de qüestionaris');
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
			$result = db_query('select IDIOMA, ID from ' . $CARDS_TABLE . ' where ID = '.$key);
			$row = db_fetch_array($result);

			// comprovem que l'autor no s'està utilitzant en algun qüestionari
// 			if (db_num_rows(
// 				db_query("
// 					SELECT ID
// 					FROM Cuestionarios
// 					WHERE
// 						IDAUTORES_ORIGINAL LIKE '%\"$row[ID]\"%' OR
// 						IDAUTORES_CAST LIKE '%\"$row[ID]\"%'
// 				")
// 			) == 0) {

				db_query('delete from ' . $CARDS_TABLE . ' where ID = '.$key);

				/*insertar registre d'accions*/
				register_add("Idioma de qüestionaris eliminat", $row['IDIOMA']);

// 			}
// 			else {
//
// 				$notDeleted[] = $row['NOM'];
//
// 			}

		}
	}
?>
<table  border="0" cellpadding="0" cellspacing="0">
<?php

	if (count($notDeleted) > 0) {

		foreach ($notDeleted as $notDeletedLanguage) {

?>
	<tr>
		<td class="text">L'idioma <em><?php echo $notDeletedLanguage; ?></em> <strong>no</strong> s'ha pogut esborrar ja que està seleccionat en algun dels qüestionaris.</td>
	</tr>
<?php

		}

	}

?>
	<tr>
		<td class="text">Els idiomes de qüestionaris seleccionats han estat esborrats</td>
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
