<?php

require ('../../config_admin.inc');
accessGroupPermCheck('composition');

require('compositions.php');

 $result1=db_query("select * from BANNERS where ID = '$ID'");
 $row = db_fetch_array($result1);

  foreach($row as $key => $value) {
    $row[$key] = addslashes($value);
  }


 $sql = "INSERT INTO BANNERS (
  ECLASS,
  SKIN,
  CATEGORY1,
  CATEGORY2,
  CREATION,
  USUARICREAR,
  NOM,
  DESCRIPCIO,
  TIPO,
  TEXT,
  CAIXETES
 )
  VALUES (
  '$row[ECLASS]',
  '$row[SKIN]',
  '$row[CATEGORY1]',
  '$row[CATEGORY2]',
  sysdate(),
  '".accessGetLogin()."',
  '$row[NOM]_copia',
  'copia $row[DESCRIPCIO]',
  '$row[TIPO]',
  '$row[TEXT]',
  '$row[CAIXETES]');";

  $result = db_query($sql);


   if($result) {
     $result1=db_query("select * from BANNERS where NOM = '$row[NOM]_copia'");
     $row = db_fetch_array($result1);
     goto_url('view.php?ID='.$row['ID']);
   } else {
		echo db_error();
		echo ("<a href='javascript:history.back()'>Tornar</a>");
   }
?>
