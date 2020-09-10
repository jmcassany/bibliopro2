<?php

	require ('../../config_admin.inc');
	accessGroupPermCheck('questionaris');

	require('questionaris.php');

	if (!isset($_POST['CONFIRM']) || $_POST['CONFIRM'] !='TRUE') {
	  htmlPageError('Error esborrant qüestionari');
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

		/*per tots els elemtens a esborrar*/
		foreach($_POST['CHECK'] as $key => $value) {

			/*obtenir les dades*/
			$result = db_query("select * from $CARDS_TABLE where ID = $key");
			$row = db_fetch_array($result);

			//db_query("delete from $CARDS_TABLE where ID = $key");
            //Evitem que s'esborrin questionaris per no perdre'n les dades
			db_query("UPDATE $CARDS_TABLE set STATUS=2 where ID = $key");
			// esborrem els descarregables
// 			$targetfilename = $CONFIG_PATHBOX."/".$row['NOM'].'.inc';
// 			if (file_exists($targetfilename)) {
// 				unlink($targetfilename);
// 			}

			/*insertar registre d'accions*/
			register_add("Qüestionari eliminat", $row['NOM_ORIGINAL']);

		}
	}
?>
<table  border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="text">Els qüestionaris seleccionats han estat esborrats</td>
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
