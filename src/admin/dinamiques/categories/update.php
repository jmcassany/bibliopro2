<?php

require ('../../config_admin.inc');
accessGroupPermCheck('dinamic_category');

include_once($CONFIG_PATHADMIN."/php/lib/class.Thumbnail.inc");

$DINAMICA = $_POST['DINAMICA'];

//COMPROVEM SI TE ACCES A AQUEST MODUL
include("check_moduls.php");
//FI COMPROVEM SI TE ACCES A AQUEST MODUL


if(isset($_POST['PARE'])) {
  $PARE = $_POST['PARE'];
}

if(isset($_POST['NOM']) && isset($_POST['ID'])) {
  $name = addslashes($_POST['NOM']);
  $ID = addslashes($_POST['ID']);
}
else {
  if(isset($PARE)) {
    goto_url('index.php?ID='.$PARE.'&amp;DINAMICA='.$DINAMICA);
  }
  else {
    goto_url('index.php?DINAMICA='.$DINAMICA);
  }
}

$descripcio = '';
if (isset($_POST['DESCRIPCIO'])) {
  $descripcio = addslashes($_POST['DESCRIPCIO']);
}

$result = db_query("update DIN_CATEGORIES set NOM = '".$name."' ,URL_NOM = '".sanitize_title($name)."' ,DESCRIPCIO = '".$descripcio."' where ID = ".$ID);

  /*pujar imatge*/
if($_FILES['img']['name'] != '') {
  $extensio = explode (".", $_FILES['img']['name']);
  $destName = 'cat_'.$DINAMICA.'_'.$ID.'.'.$extensio[1];
  $log = upload('img', $CONFIG_PATHUPLOADIM, $UPLOAD_imgsize, $UPLOAD_imgtype, $destName, 160);
  if ($log == 4) {
    db_query('update DIN_CATEGORIES set IMATGE = \''.$destName.'\' where ID = '.$ID);
  }
}
elseif(isset($_POST['delete_image'])) {
  $result = db_query('select IMATGE from DIN_CATEGORIES where ID='.$ID);
  $row = db_fetch_array($result);
  @unlink($CONFIG_PATHUPLOADIM.'/'.$row['IMATGE']);
  db_query('update DIN_CATEGORIES set IMATGE = \'\' where ID = '.$ID);
}


if($result) {
  if(isset($PARE)) {
    goto_url('index.php?ID='.$PARE.'&DINAMICA='.$DINAMICA);
  }
  else {
    goto_url('index.php?DINAMICA='.$DINAMICA);
  }
} else {
  echo ("<a href='javascript:history.back()'>".t("back")."</a>");
  echo db_error();
}
?>
