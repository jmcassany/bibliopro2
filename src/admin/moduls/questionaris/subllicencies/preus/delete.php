<?php

	require ('../../../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('preus.php');

	if (!isset($_POST['CONFIRM']) || $_POST['CONFIRM'] !='TRUE') {
	  htmlPageError('Error esborrant preus de subllicència de qüestionaris');
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
			$result = db_query('select ID_SUBLICENCIA, ID from ' . $CARDS_TABLE . ' where ID = '.$key);
			$row = db_fetch_array($result);

			db_query('delete from ' . $CARDS_TABLE . ' where ID = '.$key);

			/*insertar registre d'accions*/
			register_add("Preu de subllicència de qüestionaris eliminat", $row['ID_SUBLICENCIA']);

		}
	}
?>
<table  border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="text">Els preus de subllicència seleccionats han estat esborrats</td>
	</tr>
	<tr>
		<td colspan="2" style="padding-bottom:10px;padding-top:15px;" align="center">
		<b><a href="index.php?ID_SUBLICENCIA=<?php echo urlencode($_GET['ID_SUBLICENCIA']); ?>" class="botonavegacio"><?php echo t("continue") ?></a></b>
		</td>
	</tr>
</table>

</td></tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
