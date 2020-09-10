<?php

require ('../config_admin.inc');
accessGroupPermCheck('dinamic_publish');


include_once("dinamiques.php");
include_once('categories/funcions.inc');

$ID=$_GET['ID'];

//COMPROVEM SI TE ACCES A AQUEST MODUL
 include("check_moduls.php");

//FI COMPROVEM SI TE ACCES A AQUEST MODUL

   $STATUS = 1;
   $urlnavegacio = $_SERVER['HTTP_REFERER'];
   $sql = "UPDATE $TAULA SET STATUS='$STATUS'  where ID='$ID'";
	$result = db_query($sql);
   if($result) {


	 	//// Inserta al registre d'accions
        register_add(t("dinamicsregistrypublish")." $nomcarpeta", "ID: $ID");
		// fi inserta

include("createxml.inc");
createrss($DIN);

  goto_url('index.php?DIN='.$DIN.'&PAGE='.$pagina);
}
else {
  echo ("<a href='javascript:history.back()'>".t('BACK')."</a>");
  echo db_error();
}
?>
