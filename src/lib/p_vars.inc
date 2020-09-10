<?php

/*recupera una variable persistent*/
function getvar ($name) {
  if (empty($name)) {
    return (null);
  }
  $result = @db_query("SELECT VALUE FROM VARIABLE WHERE NAME = '".$name."';");
  if (db_num_rows($result) == 1) {
    $row = db_fetch_array($result);
    return (unserialize($row['VALUE']));
  }
  else {
    return (null);
  }
}

/*grava una variable persistent*/
function setvar ($name, $value) {
  if (empty($name)) {
    return false;
  }
  db_query("DELETE FROM VARIABLE WHERE NAME = '".$name."';");
  return (db_query("INSERT INTO VARIABLE (NAME, VALUE) VALUES ('".$name."', '".serialize($value)."')"));
}

/*esborra una variable persistent*/
function delvar ($name) {
  if (empty($name)) {
    return;
  }
  db_query("DELETE FROM VARIABLE WHERE NAME = '".$name."';");
}

?>
