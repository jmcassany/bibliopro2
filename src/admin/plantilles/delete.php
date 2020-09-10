<?php

require ('../config_admin.inc');
accessGroupPermCheck('template_delete');

include_once("plantilles.php");

if (!isset($_POST['CONFIRM']) || $_POST['CONFIRM'] !='TRUE') {
  htmlPageError(t("errortemplatedelconfirm"));
}

?>
<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php
echo htmlHeader();
?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;padding:20px;">
	<tr>
		<td class="text" align="center">
<?php

$missatge = '';

if (!isset($_POST['CHECK'])) {
  $missatge = t("errordeletenocheck");
}
else {

  /*per tots els elemtens a esborrar*/
  foreach($_POST['CHECK'] as $key => $value) {

    /*obtenir les dades per tots els idiomes*/
    $result = db_query('select * from PLANTILLA where ID = '.$key);

    $row = db_fetch_array($result);

    db_query('delete from PLANTILLA_DESC where PLANTILLA = '.$key);
    db_query('delete from PLANTILLA where ID = '.$key);

    $missatge.= t("templatedelconfirmok")."(<span class=\"vermell10b\">".$row['NOM']."</span>).<br /><br />";

    /*insertar registre d'accions*/
    register_add(t("templateregistrydelete"), $row['NOM']);

  }
}


?>
<table  border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td  width="26" valign="top" style="padding-bottom:10px;"><img src="../comu/ico_paperera3.gif" alt="" width="19" height="21" border="0"></td>
		<td class="text" style="padding-left:10px;padding-bottom:10px;" valign="top"><?php echo $missatge; ?></td>
	</tr>
</table>

<b><a href="index.php" class="botonavegacio"><?php echo t("continue"); ?></a></b>
</td></tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>