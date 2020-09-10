<?php

require ('../../../config_admin.inc');
accessGroupPermCheck('poll');

if (!isset($_POST['CONFIRM']) || $_POST['CONFIRM'] !='TRUE') {
  htmlPageError(t("errorpollquerydelconfirm"));
}

require('enquesta_preg.php');
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

    /*obtenir les dades per tots els idiomes*/
    $result = db_query('select * from ENQUESTA_PREG where ID = '.$key);

    $row = db_fetch_array($result);

    db_query('delete from ENQUESTA_PREG where ID = '.$key);

    $missatge .="&#149;&nbsp;".t('pollquerylogdelete').'<br>';

    /*insertar registre d'accions*/
    register_add("Resposta eliminada", $key);

  }
}

echo $missatge;

?>
<center><b><a href="index.php?ENQUESTA=<?php echo $_POST['ENQUESTA'] ?>" class="vinclenoticia"><?php echo t("continue") ?></a></b></center>
</td></tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
