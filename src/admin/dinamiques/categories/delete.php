<?php

require ('../../config_admin.inc');
accessGroupPermCheck('dinamic_category');

$DINAMICA = $_POST['DINAMICA'];

if(isset($_POST['PARE'])) {
  $PARE = $_POST['PARE'];
}

//COMPROVEM SI TE ACCES A AQUEST MODUL
include("check_moduls.php");
//FI COMPROVEM SI TE ACCES A AQUEST MODUL
include_once('funcions.inc');

if (!isset($_POST['CONFIRM']) || $_POST['CONFIRM'] !='TRUE') {
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

    if (catEsborrar($key)) {
      $missatge .=t("dinsubcategoryentrydelete")." ID: $key.<br><br>";
    }
    else{
      $missatge .="<img src=\"../../comu/houdini_alerta.gif\" width=\"19\" height=\"31\" alt=\"Alert\" border=\"0\" align=\"absmiddle\"> <font class=\"grana\" hspace=\"5\"><B>".t("dinsubcategoryerrordelete")."</b></font><br><br>";
    }


  }
}

?>
<br />
<table  border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td  width="26" valign="top" style="padding-bottom:10px;"><img src="../../comu/ico_paperera3.gif" alt="" width="19" height="21" border="0"></td>
		<td class="text" style="padding-left:10px;padding-bottom:10px;padding-top:6px;" valign="top"><b><?php echo $missatge; ?></b></td>
	</tr>
</table>

<b>
<?php
if(isset($PARE)) {
  echo '<a href="index.php?ID='.$PARE.'&amp;DINAMICA='.$DINAMICA.'" class="botonavegacio">'.t("continue").'</a>';
}
else {
  echo '<a href="index.php?DINAMICA='.$DINAMICA.'" class="botonavegacio">'.t("continue").'</a>';
}
?>
</b>

<br /><br />
</td></tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
