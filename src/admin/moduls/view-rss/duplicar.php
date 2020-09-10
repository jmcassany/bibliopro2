<?php

require ('../../config_admin.inc');
accessGroupPermCheck('rss');

require('rss.php');



 $result1=db_query("select * from VIEWRSS where ID = '$ID'");
 $row = db_fetch_array($result1);

foreach($row as $key => $value) {
  $row[$key] = addslashes($value);
}

 $sql = "INSERT INTO VIEWRSS (
  ECLASS,
  SKIN,
  CATEGORY1,
  CATEGORY2,
  CREATION,
  USUARICREAR,
  NOM,
  DESCRIPCIO,
  LINKRSS,
  MAXRSS,
  PLANTILLA
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
  '$row[LINKRSS]',
  '$row[MAXRSS]',
  '$row[PLANTILLA]'
  );";

  $result = db_query($sql);


   if($result) {
     $result1=db_query("select * from VIEWRSS where NOM = '$row[NOM]_copia'");
     $row = db_fetch_array($result1);
     goto_url('view.php?ID='.$row['ID']);
   } else {
		echo db_error();
		echo ("<a href='javascript:history.back()'>Tornar</a>");
   }
?>
