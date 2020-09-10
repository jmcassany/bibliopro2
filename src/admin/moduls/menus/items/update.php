<?php

require ('../../../config_admin.inc');
accessGroupPermCheck('menu_entrys');


foreach($_POST as $key => $value) {
  $_POST[$key] = addslashes($value);
}

$ID=$_POST['ID'];
$sql = "UPDATE MENUITEMS SET TEXT='".$_POST['TEXT']."',LINKPAGE='".$_POST['LINKPAGE']."',FINESTRA='".$_POST['FINESTRA']."',`SEPARATOR`='".$_POST['SEPARATOR']."', CSSCLASS='".$_POST['CSSCLASS']."', DIRECTORI='".$_POST['DIRECTORI']."', EDITORA='".$_POST['EDITORA']."' where ID='".$_POST['ID']."'";
$result = db_query($sql);
if($result) {

  /*pujar imatge*/
  $log = 0;
  if($_FILES['img']['name'] != '') {
    $extensio = explode (".", $_FILES['img']['name']);
    $destName = 'menu_'.$ID.'.'.$extensio['1'];
    $log = upload('img', $CONFIG_PATHMENU.'/img', $UPLOAD_imgsize, $UPLOAD_imgtype, $destName);
    if ($log == 4) {
      db_query('update MENUITEMS set IMATGE = \''.$destName.'\' where ID = '.$ID);
    }
  }

  goto_url('index.php?ID='.$_POST['MENU']);
}
else {
  echo ("<a href='javascript:history.back()'>".t("back")."</a>");
  echo db_error();
}
?>
