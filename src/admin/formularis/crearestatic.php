<?php

require ('../config_admin.inc');
accessGroupPermCheck('form_publish');

include_once("formularis.php");
require_once('variables.inc');

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
		<td class="text" align="center">

<?php

$ID=$_GET['ID'];
$result=db_query("select * from FORMULARIS where ID=$ID");
$row = db_fetch_array($result);
if (empty($row['ID'])){
  tmlPageBasicError(t("errordbcardscodinotfound"));
}


$valors = generate_page ($row);

  if (!is_array($valors)) {
          $missatge = '
<table cellpadding="0" cellspacing="0" border="0" style="border-bottom:solid #FF6600 2px;width:500px">
  <tr>
    <td valign="top">
      <img src="../comu/houdini_alerta.gif" alt="" border="0" align="left" style="margin-bottom:10px;margin-right:10px;">
    </td>
    <td valign="middle" style="padding-bottom:10px;" class="blau11b">
      '.$valors.'
    </td>
  </tr>
  <tr>
	<td valign="top" bgcolor="#E6ECF5"></td>
	<td valign="top"  bgcolor="#E6ECF5" style="padding-bottom:5px;padding-top:5px;" class="text10">
      <img src="../comu/ico_descripcio.gif" width="9" height="9" alt="Descripció" border="0"> '.$row['DESCRIPCIO'].'
    </td>
  </tr>
  <tr><td>&nbsp;</td></tr>
</table>
<br>
';
  }
  else {

    $resultat = create_page($row['NOMFORMULARI'], $row['PARE'], $valors['normal']);

    if(!empty($resultat)) {
          $missatge = '
<table cellpadding="0" cellspacing="0" border="0" style="border-bottom:solid #FF6600 2px;width:500px">
  <tr>
    <td valign="top">
      <img src="../comu/houdini_alerta.gif" alt="" border="0" align="left" style="margin-bottom:10px;margin-right:10px;">
    </td>
    <td valign="middle" style="padding-bottom:10px;" class="blau11b">
      '.$resultat.'
    </td>
  </tr>
  <tr>
	<td valign="top" bgcolor="#E6ECF5"></td>
	<td valign="top"  bgcolor="#E6ECF5" style="padding-bottom:5px;padding-top:5px;" class="text10">
      <img src="../comu/ico_descripcio.gif" width="9" height="9" alt="Descripció" border="0"> '.$row['DESCRIPCIO'].'
    </td>
  </tr>
  <tr><td>&nbsp;</td></tr>
</table>
<br>
';

    }
    else {
      $pagina = folderPath($row['PARE']).'/'.$row['NOMFORMULARI'];
      $missatge = '
<table cellpadding="0" cellspacing="0" border="0" style="border-bottom:solid #FF6600 2px;width:500px">
  <tr>
    <td valign="top">
      <img src="../comu/ico_paginacreada.gif" width="28" height="28" alt="" border="0" align="left" style="margin-bottom:10px;margin-right:10px;">
    </td>
    <td valign="top" style="padding-bottom:10px;" class="blau11b">
      '.t("staticpagescreateok").'<br><br>
      <img src="../comu/ico_mon.gif" width="19" height="13" alt="Adreça web" border="0" align="absmiddle">
      <a href="'.$CONFIG_URLBASE.'/'.$pagina.'" target="_blank" class="text">'.$CONFIG_URLBASE.'/'.$pagina.'</a>
    </td>
  </tr>
  <tr>
	<td valign="top" bgcolor="#E6ECF5"></td>
	<td valign="top"  bgcolor="#E6ECF5" style="padding-bottom:5px;padding-top:5px;" class="text10">
      <img src="../comu/ico_descripcio.gif" width="9" height="9" alt="Descripció" border="0"> '.$row['DESCRIPCIO'].'
    </td>
  </tr>
  <tr><td>&nbsp;</td></tr>
</table>
<br>
';

      db_query("UPDATE FORMULARIS SET STATUS='1' where ID=".$row['ID']);
      /*insertar registre d'accions*/
      register_add(t("form")." ".t("generate"), $row['NOMFORMULARI']);

    }
  }




echo $missatge;

echo ("<a href=\"index.php\" class=\"botonavegacio\">".t("backtolist")."</a>");
echo ("&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$CONFIG_URLBASE/".$pagina."\" class=\"botonavegacio\" target=\"_blank\">".t("view").' '.t("form")."</a>");
echo ("&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"nou.php\" class=\"botonavegacio\">".t("create").' '.t("form")."</a>");


db_free_result($result);

?>
</tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
