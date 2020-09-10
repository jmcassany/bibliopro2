<?php

require ('../config_admin.inc');
accessGroupPermCheck('users_delete');


/*comprovar que activat checkbox de configurmacio*/
if (empty($_POST['CONFIRM']) || $_POST['CONFIRM'] !='TRUE') {
  htmlPageError(t("errorusersdelconfirm"));
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
		<td class="text" style="padding-left:100px;">
<?php
if (!isset($_POST['CHECK'])) {
  $missatge = t("errordeletenocheck");
}

else {

  $users = new dbUsers();
  $missatge = '';
  /*per tots els elemtens a esborrar*/
  foreach($_POST['CHECK'] as $key => $value) {

    if ($users->deleteUser($key)){// no es pot eliminar el usuari creat admin
      $missatge .= "&#149;&nbsp;".t("usereliminat")."<b>".$key."</b>.<br><br>";
    }
    else{
      $missatge = "&#149;&nbsp;".t("erroreliminaruser")."<b>".$key."</b>.<br><br>";
    }

    /*insertar registre d'accions*/
    register_add(t("userregistrydelete"), $key);


  }
}
echo $missatge;
?>

<center><b><a href="index.php" class="botonavegacio"><?php echo t("continue"); ?></a></b></center>
</td></tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
