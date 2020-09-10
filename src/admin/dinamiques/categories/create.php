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

if(isset($_POST['NOM'])) {
  $name = addslashes($_POST['NOM']);
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

//MIRO L´ultim ordre entrat
$result=db_query("select MAX(ORDRE) as ORDRE from DIN_CATEGORIES WHERE DINAMICA=$DINAMICA");
$totalresultats=db_num_rows($result);
$row2 = db_fetch_array($result);
if ($totalresultats>0){
  $ORDRE=$row2['ORDRE']+1;
}
else{
  $ORDRE=1;
}

if(isset($PARE)) {
  $result = db_query("insert into DIN_CATEGORIES (NOM, URL_NOM, DESCRIPCIO,PARE,DINAMICA, ORDRE)
        values ('".$name."','".sanitize_title($name)."','".$descripcio."',".$PARE.",".$DINAMICA.",".$ORDRE.")");
}
else {
  $result = db_query("insert into DIN_CATEGORIES (NOM, URL_NOM,DESCRIPCIO,DINAMICA, ORDRE)
        values ('".$name."','".sanitize_title($name)."','".$descripcio."',".$DINAMICA.",".$ORDRE.")");
}


if($result) {
  /*pujar imatge*/
  if($_FILES['img']['name'] != '') {
    $result = db_query('select MAX(ID) as ID from DIN_CATEGORIES');
    $row = db_fetch_array($result);
    $ID = $row['ID'];
    $extensio = explode (".", $_FILES['img']['name']);
    $destName = 'cat_'.$DINAMICA.'_'.$ID.'.'.$extensio[1];
    $log = upload('img', $CONFIG_PATHUPLOADIM, 100000, array('image/png','image/jpeg','image/gif','image/pjpeg'), $destName, 160);
    if ($log == 4) {
      db_query('update DIN_CATEGORIES set IMATGE = \''.$destName.'\' where ID = '.$ID);
    }
  }

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
