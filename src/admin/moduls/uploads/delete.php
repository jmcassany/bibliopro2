<?php

require ('../../config_admin.inc');
accessGroupPermCheck('users_delete');

include_once("grups.php");

//COMPROVEM SI TE ACCES A AQUEST MODUL
//include("check_moduls.php");
//FI COMPROVEM SI TE ACCES A AQUEST MODUL

if (!isset($_POST['CONFIRM']) || $_POST['CONFIRM'] !='TRUE') {
  htmlPageError(t("errorstaticpagesdelconfirm"));
}

?>
<html>
<head>
<title>Houdini v2.0</title>
	<link rel="STYLESHEET" type="text/css" href="../../css/estils.css">
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>

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

    db_query('delete from '.$CARDS_TABLE.' where ID = '.$key);

    $missatge.= "&#149;&nbsp;".t("dinamicsregistrydelete").". ID: $key.<br><br>";

    /*insertar registre d'accions*/
    register_add(t("dinamicsregistrydelete"), $key);

  }
}

echo $missatge;
?>
<b><a href="index.php" class="botonavegacio"><?php echo t("continue"); ?></a></b>
</td></tr>
</table>
</body>
</html>