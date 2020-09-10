<?php

require ('../../config_admin.inc');
accessGroupPermCheck('form_entrys');

if (empty($_POST['CONFIRM']) || $_POST['CONFIRM'] !='TRUE') {
  htmlPageError(t("errorstaticpagesdelconfirm"));
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
		<td class="text" style="padding:10px;" align="center">
<?php

$missatge = '';

if (!isset($_POST['CHECK'])) {
  $missatge = t("errordeletenocheck");
}
else {

  /*per tots els elemtens a esborrar*/
  foreach($_POST['CHECK'] as $key => $value) {

    /*esborrar elements del formulari*/
    db_query('delete from FORMULARISITEMS where ID = '.$key);

    $missatge .= t("dinamicsregistrydelete").": $key.<br><br>";

    /*insertar registre d'accions*/
    register_add(t("formregistryfielddeleted"), $key);

  }
}

?>
<br />
<table  border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td  width="26" valign="top" style="padding-bottom:10px;"><img src="../../comu/ico_paperera3.gif" width="19" height="21" ></td>
		<td class="texteliminat" style="padding-left:10px;padding-bottom:10px;padding-top:5px;" valign="top"><?php echo $missatge; ?></td>
	</tr>
</table>


<b><a href="index.php?ID=<?php echo $FORMULARI; ?>"  class="botonavegacio"><?php echo t("continue"); ?></a></b>
<br /><br />
</td></tr>
</table>

</td></tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
