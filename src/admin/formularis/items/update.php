<?php

require ('../../config_admin.inc');
accessGroupPermCheck('form_entrys');

foreach($_POST as $key => $value) {
  $_POST[$key] = addslashes($value);
}


   if (empty($_POST['ID']) || empty($_POST['FORMULARI'])){
	 htmlPageBasicError(t("errordbcardscodinotfound"));
	}

   $sql = "UPDATE FORMULARISITEMS SET TEXT='".$_POST['TEXT']."',NOM='".$_POST['NOM']."',VALOR='".$_POST['VALOR']."',TIPO='".$_POST['TIPO']."',OBLIGATORI='".$_POST['OBLIGATORI']."',TAMANY='".$_POST['TAMANY']."' where ID='".$_POST['ID']."'";
   $result = db_query($sql);
   if($result) {
     goto_url('preview.php?ID='.$ID.'&FORMULARI='.$_POST['FORMULARI']);
   } else {
     echo ("<a href='javascript:history.back()'>".t("back")."</a>");
	echo db_error();
   }

?>
