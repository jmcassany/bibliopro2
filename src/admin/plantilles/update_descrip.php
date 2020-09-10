<?php

require ('../config_admin.inc');
accessGroupPermCheck(array('template_edit', 'template_create'));
include_once("plantilles.php");




$valors = array();
for($i = 1; $i <= 45 ; $i++) {
  if(isset($_POST['TEXTC'.$i])) {
    $valors[] = "TEXTC".$i."='".$_POST['TEXTC'.$i]."'";
  }
}
for($i = 1; $i <= 10 ; $i++) {
  if(isset($_POST['TEXTL'.$i])) {
    $valors[] = "TEXTL".$i."='".$_POST['TEXTL'.$i]."'";
  }
}
for($i = 1; $i <= 25 ; $i++) {
  if(isset($_POST['IMATGE'.$i])) {
    $valors[] = "IMATGE".$i."='".$_POST['IMATGE'.$i]."'";
  }
}
for($i = 1; $i <= 10 ; $i++) {
  if(isset($_POST['ADJUNT'.$i])) {
    $valors[] = "ADJUNT".$i."='".$_POST['ADJUNT'.$i]."'";
  }
}
for($i = 1; $i <= 10 ; $i++) {
  if(isset($_POST['ALT'.$i])) {
    $valors[] = "ALT".$i."='".$_POST['ALT'.$i]."'";
  }
}
for($i = 1; $i <= 5 ; $i++) {
  if(isset($_POST['OP'.$i])) {
    $valors[] = "OP".$i."='".$_POST['OP'.$i]."'";
  }
}

$result = db_query("UPDATE PLANTILLA_DESC SET ".implode(',',$valors)." WHERE ID='$ID'");

   if($result) {
     goto_url('final.php?eleccio='.$eleccio);
   } else {
	echo ("<a href='javascript:history.back()'>Tornar</a>");
	echo db_error();
   }
?>
