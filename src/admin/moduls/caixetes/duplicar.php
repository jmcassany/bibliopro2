<?php

require ('../../config_admin.inc');
accessGroupPermCheck('boxes');

require('caixetes.php');


$result1=db_query("select * from CAIXETES where ID = '$ID'");
$row = db_fetch_array($result1);

foreach($row as $key => $value) {
  $row[$key] = addslashes($value);
}


$sql = "INSERT INTO CAIXETES (
  ECLASS,
  SKIN,
  CATEGORY1,
  CATEGORY2,
  VISIBILITY,
  STATUS,
  CREATION,
  USUARICREAR,
  NOM,
  DESCRIPCIO,
  LINKC,
  IMATGE,
  FINESTRA,
  TIPO,
  TITOL,
  WIDTH,
  HEIGHT,
  TEXT
 )
  VALUES (
  '$row[ECLASS]',
  '$row[SKIN]',
  '$row[CATEGORY1]',
  '$row[CATEGORY2]',
  1,
  1,
  sysdate(),
  '".accessGetLogin()."',
  '$row[NOM]_copia',
  'copia $row[DESCRIPCIO]',
  '$row[LINKC]',
  '$row[IMATGE]',
  '$row[FINESTRA]',
  '$row[TIPO]',
  '$row[TITOL]',
  '$row[WIDTH]',
  '$row[HEIGHT]',
  '$row[TEXT]'
);";

$result = db_query($sql);


if($result) {
  $result1=db_query("select * from CAIXETES where NOM = '$row[NOM]_copia'");
  $row = db_fetch_array($result1);
  goto_url('view.php?ID='.$row['ID'].'&SKIN='.$row['TIPO']);
}
else {
  echo db_error();
  echo ("<a href='javascript:history.back()'>Tornar</a>");
}
?>
