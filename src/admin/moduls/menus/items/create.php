<?php

require ('../../../config_admin.inc');
accessGroupPermCheck('menu_entrys');


foreach($_POST as $key => $value) {
  $_POST[$key] = addslashes($value);
}

//MIRO L´ultim ordre entrat
$result=db_query("select MAX(ORDRE) as ORDRE  from MENUITEMS where MENU='".$_POST['MENU']."'");
$totalresultats=db_num_rows($result);
$row2 = db_fetch_array($result);
if ($totalresultats>0){
  $ORDRE=$row2['ORDRE']+1;
}
else{
  $ORDRE=1;
}

$sql = "insert into MENUITEMS (TEXT,LINKPAGE,FINESTRA,`SEPARATOR`,ORDRE,MENU,CSSCLASS,DIRECTORI,EDITORA) values ('".$_POST['TEXT']."','".$_POST['LINKPAGE']."','".$_POST['FINESTRA']."','".$_POST['SEPARATOR']."','$ORDRE','".$_POST['MENU']."', '".$_POST['CSSCLASS']."', '".$_POST['DIRECTORI']."', '".$_POST['EDITORA']."')";
$result = db_query($sql);
$result = db_query("SELECT MAX(ID) as ID FROM MENUITEMS");
$row = db_fetch_array($result);
$ID=$row['ID'];

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

  goto_url('index.php?ID='.$MENU);

}
else {
  echo ("<a href='javascript:history.back()'>".t("back")."</a>");
  echo db_error();
}
?>
