<?php

require ('../../../config_admin.inc');
accessGroupPermCheck('menu_entrys');


   foreach($_POST as $key => $value) {
     $_POST[$key] = addslashes($value);
   }

  $sql = "UPDATE MENUITEMSSUB SET TEXT='".$_POST['TEXT']."',LINKPAGE='".$_POST['LINKPAGE']."',FINESTRA='".$_POST['FINESTRA']."',`SEPARATOR`='".$_POST['SEPARATOR']."', CSSCLASS='".$_POST['CSSCLASS']."' where ID='".$_POST['ID']."'";
  $result = db_query($sql);
   if($result) {
    goto_url('index_desp.php?ID='.$_POST['MENU']);

   } else {
	echo ("<a href='javascript:history.back()'>".t("back")."</a>");
	echo db_error();
   }
?>
