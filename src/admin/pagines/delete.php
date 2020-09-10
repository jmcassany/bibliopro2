<?php


require ('../config_admin.inc');
accessGroupPermCheck('page_delete');

include_once("estatiques.php");

include("check_moduls.php");

include_once("variables.inc");

/*comprovar que activat checkbox de configurmacio*/
if (!isset($_POST['CONFIRM']) || $_POST['CONFIRM'] !='TRUE')
{
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
		<td class="text" style="padding:20px;" align="center">
<?php

$missatge = '';

if (!isset($_POST['CHECK'])) {
  $missatge = t("errordeletenocheck");
}
else {

  /*per tots els elemtens a esborrar*/
  foreach($_POST['CHECK'] as $key => $value) {

    /*obtenir les dades per tots els idiomes*/
    $result = db_query("select NOMPAG, ID, PARE,
         IMATGE1, IMATGE2, IMATGE3, IMATGE4, IMATGE5, IMATGE6, IMATGE7, IMATGE8, IMATGE9, IMATGE10, IMATGE11, IMATGE12,
         IMATGE13, IMATGE14, IMATGE15, IMATGE16, IMATGE17, IMATGE18, IMATGE19, IMATGE20, IMATGE21, IMATGE22, IMATGE23,
         IMATGE24, IMATGE25, ADJUNT1, ADJUNT2, ADJUNT3, ADJUNT4, ADJUNT5, ADJUNT6, ADJUNT7, ADJUNT8, ADJUNT9, ADJUNT10
         from ESTATICA where (ID = ".$key.") OR (REFERENCIA = ".$key.")");

    while($row = db_fetch_array($result)) {
      /* eliminar imatges associades */
      for($i=1;$i<=25;$i++){
        if (!empty($row['IMATGE'.$i])){
          $targetimagename = $CONFIG_PATHUPLOADIM.'/'.$row['IMATGE'.$i];
          if (file_exists($targetimagename)) {
            unlink($targetimagename);
          }
        }
      }
      /* eliminar adjunts associades */
      for($i=1;$i<=10;$i++){
        if (!empty($row['ADJUNT'.$i])){
          $targetadjuntname = $CONFIG_PATHUPLOADAD.'/'.$row['ADJUNT'.$i];
          if (file_exists($targetadjuntname)) {
            unlink($targetadjuntname);
          }
        }
      }

      db_query('delete from ESTATICA where ID = '.$key.' OR REFERENCIA = '.$key);

      if (delete_page($row['NOMPAG'], $row['PARE'])) {
        $missatge .= t("staticpagesdelok").' (<span class="vermell10b">'.$row['NOMPAG'].'</span>).<br /><br />';
      }
      else {
        $missatge .= t("staticpagesdelokonlydb").' (<span class="vermell10b">'.$row['NOMPAG'].'</span>).<br /><br />';
      }
      delete_page($row['NOMPAG'], $row['PARE'], true);


      /*insertar registre d'accions*/
      register_add(t("staticpagesregistrydelete"), $row['NOMPAG']);

    }


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


<b><a href="index.php?carpeta=<?php echo $carpeta; ?>"  class="botonavegacio"><?php echo t("continue"); ?></a></b>
<br /><br />
</td></tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>