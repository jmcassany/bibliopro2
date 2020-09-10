<?php

require ('../../../config_admin.inc');
accessGroupPermCheck('menu_entrys');

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

    $result = db_query('select * from MENUITEMS where ID = '.$key);
    $row = db_fetch_array($result);

    /*esborrar elements*/
    db_query('delete from MENUITEMS where ID = '.$key);

    if ($result) {
      db_query('delete from MENUITEMSSUB where MENUITEM = '.$key);
      $missatge .=t("menuregistryentrydelete")." : ".$row['TEXT'].".<br><br>";
    }
    else {
      $missatge .="<img src=\"../../../comu/houdini_alerta.gif\" width=\"19\" height=\"31\" alt=\"Alert\" border=\"0\" align=\"absmiddle\"> <font class=\"grana\" hspace=\"5\"><B>".t("menuerrordelete")."</b></font><br><br>";
    }


    /*insertar registre d'accions*/
    register_add(t("menuregistryentrydelete"), $key);

  }
}

?>
<br />
<table  border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td  width="26" valign="top" style="padding-bottom:10px;"><img src="../../../comu/ico_paperera3.gif" alt="" width="19" height="21" border="0"></td>
		<td class="text" style="padding-left:10px;padding-bottom:10px;padding-top:6px;" valign="top"><b><?php echo $missatge; ?></b></td>
	</tr>
</table>

<b><a href="index.php?ID=<?php echo $_POST['MENU']; ?>" class="botonavegacio"><?php echo t("continue"); ?></a></b>
<br /><br />
</td></tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
