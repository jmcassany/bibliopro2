<?php

function url_filter($content) {
  global $CONFIG_NOMCARPETA;

  preg_match_all("/\|url-page-([0-9]+?)\|/",$content,$values);

  $values = array_unique($values[1]);

  foreach($values as $value) {
    $url = pagePath($value);
    $url = $CONFIG_NOMCARPETA.'/'.$url;
    $content = str_replace('|url-page-'.$value.'|', $url, $content);
  }

  preg_match_all("/\|url-form-([0-9]+?)\|/",$content,$values);

  $values = array_unique($values[1]);

  foreach($values as $value) {
    $url = formPath($value);
    $url = $CONFIG_NOMCARPETA.'/'.$url;
    $content = str_replace('|url-form-'.$value.'|', $url, $content);
  }

  preg_match_all("/\|url-folder-([0-9]+?)\|/",$content,$values);

  $values = array_unique($values[1]);

  foreach($values as $value) {
    $url = folderPath($value);
    $url = $CONFIG_NOMCARPETA.'/'.$url;
    $content = str_replace('|url-folder-'.$value.'|', $url, $content);
  }



  return $content;
}


function pagePath($id) {
  $result = db_query("select NOMPAG, PARE from ESTATICA where ID=".$id);
  if (db_num_rows($result) != 1) {
    return '';
  }
  $row = db_fetch_array($result);
  $url = folderPath($row['PARE']);

  if ($url == '') {
    $url = $row['NOMPAG'];
  }
  else {
    $url = $url.'/'.$row['NOMPAG'];
  }
  return $url;
}

function formPath($id) {
  $result = db_query("select NOMFORMULARI, PARE from FORMULARIS where ID=".$id);
  if (db_num_rows($result) != 1) {
    return '';
  }
  $row = db_fetch_array($result);
  $url = folderPath($row['PARE']);

  if ($url == '') {
    $url = $row['NOMFORMULARI'];
  }
  else {
    $url = $url.'/'.$row['NOMFORMULARI'];
  }
  return $url;
}


?>
