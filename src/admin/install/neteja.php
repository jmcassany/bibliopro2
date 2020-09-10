<?php

$buscar = array (
/*buscat   =>   reemplaçat*/
'/demo/' => '/'
);

$buscar_menu = true;




include ('../config.php');
include ('database/database.inc');

db_connect($db_url);

$result = db_query("SELECT ID,TEXTL1,TEXTL2,TEXTL3,TEXTL4,TEXTL5,TEXTL6,TEXTL7,TEXTL8,TEXTL9,TEXTL10 FROM ESTATICA");
while($row = db_fetch_array($result)) {

  for($i=1; $i<=10; $i++){
    foreach($buscar as $key => $value) {
      $row['TEXTL'.$i] = addslashes(ereg_replace($key, $value, $row['TEXTL'.$i]));
    }
  }

  db_query("UPDATE ESTATICA SET TEXTL1='".$row['TEXTL1']."',TEXTL2='".$row['TEXTL2']."',TEXTL3='".$row['TEXTL3']."',TEXTL4='".$row['TEXTL4']."',TEXTL5='".$row['TEXTL5']."',TEXTL6='".$row['TEXTL6']."',TEXTL7='".$row['TEXTL7']."',TEXTL8='".$row['TEXTL8']."',TEXTL9='".$row['TEXTL9']."',TEXTL10='".$row['TEXTL10']."' WHERE ID=".$row['ID']);
}


if ($buscar_menu) {
  $result = db_query("SELECT ID,LINKPAGE FROM MENUITEMS");
  while($row = db_fetch_array($result)) {

    foreach($buscar as $key => $value) {
      $row['LINKPAGE'] = addslashes(ereg_replace($key, $value, $row['LINKPAGE']));
    }

    db_query("UPDATE MENUITEMS SET LINKPAGE='".$row['LINKPAGE']."' WHERE ID=".$row['ID']);
  }

  $result = db_query("SELECT ID,LINKPAGE1 FROM MENUITEMSSUB");
  while($row = db_fetch_array($result)) {

    foreach($buscar as $key => $value) {
      $row['LINKPAGE1'] = addslashes(ereg_replace($key, $value, $row['LINKPAGE1']));
    }

    db_query("UPDATE MENUITEMSSUB SET LINKPAGE1='".$row['LINKPAGE1']."' WHERE ID=".$row['ID']);
  }
}

db_close();

echo 'Acabat';


?>