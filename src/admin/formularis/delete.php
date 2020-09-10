<?php

require ('../config_admin.inc');
accessGroupPermCheck('form_delete');

include_once("formularis.php");

/*comprovar que activat checkbox de configurmacio*/
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
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;padding:20px;">
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

    $result = db_query('select * from FORMULARIS where ID = '.$key);
    $row = db_fetch_array($result);
    /*esborrar elements del formulari*/
    db_query('delete from FORMULARISITEMS where FORMULARI = '.$key);
    /*esborrar formulari*/
    db_query('delete from FORMULARIS where ID = '.$key);
    if (delete_page($row['NOMFORMULARI'], $row['PARE'])) {
      $missatge .= t("staticpagesdelok").' (<span class="vermell10b">'.$row['NOMFORMULARI'].'</span>).<br /><br />';
    }
    else {
      $missatge .= t("staticpagesdelokonlydb").' (<span class="vermell10b">'.$row['NOMFORMULARI'].'</span>).<br /><br />';
    }
    delete_page($row['NOMFORMULARI'], $row['PARE'], true);


    /*insertar registre d'accions*/
    register_add(t("form")." ".t("delete"), $row['NOMFORMULARI']);

  }
}

?>
<br />
<table width="400" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td  width="26" valign="top" style="padding-bottom:10px;"><img src="../comu/ico_paperera2.gif" width="26" height="28" ></td>
		<td class="text" style="padding-left:10px;padding-bottom:10px;" valign="top"><?php echo $missatge; ?></td>
	</tr>
</table>


<b><a href="index.php"  class="botonavegacio"><?php echo t("continue"); ?></a></b>
<br /><br />
</td></tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
