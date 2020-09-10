<?php

require ('../../config_admin.inc');
accessGroupPermCheck('boxes');

require('caixetes.php');

if (!isset($_POST['CONFIRM']) || $_POST['CONFIRM'] !='TRUE') {
  htmlPageError(t("errorbannersdelconfirm"));
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

    /*obtenir les dades per tots els idiomes*/
    $result = db_query('select * from CAIXETES where ID = '.$key);

    $row = db_fetch_array($result);

    db_query('delete from CAIXETES where ID = '.$key);

    $targetfilename = $CONFIG_PATHBOX."/".$row['NOM'].'.inc';
    if (file_exists($targetfilename)) {
      unlink($targetfilename);
      $missatge .="&#149;&nbsp;".t('bannerlogdelete');
    }
    else{
      $missatge .="&#149;&nbsp;".t('bannerlogdelete2');
    }

    /*insertar registre d'accions*/
    register_add("Caixeta eliminada", $row['NOM']);

  }
}
?>
<table  border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="text"><?php echo $missatge; ?></td>
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
