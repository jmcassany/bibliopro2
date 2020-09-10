<?php

require ('../../config_admin.inc');
accessGroupPermCheck('menu_delete');

include_once("menus.php");

/*comprovar que activat checkbox de configurmacio*/
if (empty($_POST['CONFIRM']) || $_POST['CONFIRM'] !='TRUE') {
  htmlPageError(t("errortemplatedelconfirm"));
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

    $result = db_query('select * from MENUS where ID = '.$key);
    $row = db_fetch_array($result);

    /*esborrar elements del menu*/
    $result = db_query('SELECT * FROM MENUITEMS WHERE MENU = '.$key);
    while($row2 = db_fetch_array($result)) {
      db_query('DELETE FROM MENUITEMSSUB WHERE MENUITEM = '.$row2['ID']);
    }
    db_query('DELETE FROM MENUITEMS WHERE MENU = '.$key);


    /*esborrar menu*/
    db_query('delete from MENUS where ID = '.$key);

    $targetfilename = $CONFIG_PATHMENU.'/'.$row['NOM'];
    $targetfilename2 = $CONFIG_PATHMENU.'/'.$row['NOM'].'.js';

    if (file_exists("$targetfilename")) {
      unlink($targetfilename);
      unlink($targetfilename2);
      $missatge .= t("menuregistrydelete").' (<span class="vermell10b">'.$row['NOM'].'</span>).<br><br>';
    }
    else{
      $missatge .= t("menuregistrydelete").' (<span class="vermell10b">'.$row['NOM'].'</span>).<br><br>';
    }


    /*insertar registre d'accions*/
    register_add(t("menuregistrydelete"), $row['NOM']);

  }
}

?>
<table  border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td  width="26"  style="padding-top:15px;"><img src="../../comu/ico_paperera3.gif" alt="" width="19" height="21" border="0"></td>
		<td class="text" style="padding-left:10px;padding-top:28px;" ><?php echo $missatge; ?></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-bottom:10px;padding-top:15px;" align="center"><b><a href="index.php" class="botonavegacio"><?php echo t("continue"); ?></a></b></td>
	</tr>
</table>


</td></tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
