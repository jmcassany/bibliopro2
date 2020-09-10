<?php

/*funcions bàsiques*/
function goto_url($url) {
  header('Location: '.$url);
  exit;
}

function redirectTo($url) {
  header('Location: '.$url);
  exit;
}


function folderPathArray($id) {
  static $cache = array();

  if (isset($cache[$id])) {
    return ($cache[$id]);
  }

  $result = db_query("select PARE, NOMCARPETA from CARPETES where ID=".$id);
  if (db_num_rows($result) == 0) {
    return array();
  }
  $row = db_fetch_array($result);
  if ($row['PARE'] != null) {
    $ret = folderPathArray($row['PARE']);
  }
  else {
    $ret = array();
  }
  if ($row['PARE'] != null && $row['NOMCARPETA'] != '') {
    $ret[$id] = $row['NOMCARPETA'];
  }
  $cache[$id] = $ret;
  return $ret;
}

function folderPath($id) {
  $values = folderPathArray($id);
  $path = implode('/', $values);
  //return '/'.$path;
  return $path;
}

function staticFolderTableName($id) {
  return ('editora_'.$id);
}

function phpEval($html) {
  ob_start();
  eval(' ?>'.$html.'<?php ');
  $code = ob_get_contents();
  ob_end_clean();

  return $code;
}

/*crea el fil d'ariadna*/
function fil_ariadna_build ($elem_situacio) {
  global $SITUACIO_separador;
  global $SITUACIO_midamax, $SITUACIO_elementmida, $SITUACIO_elementtext;

  /*limitar mida del fil d'ariadna*/
  $mida = 0;
  foreach($elem_situacio as $value) {
    $mida += strlen($value['nom']);
  }
  if ($SITUACIO_midamax > 0 && $mida > $SITUACIO_midamax) {
    /*retallar fil d'ariadna*/
    foreach($elem_situacio as $key => $value) {
      if ($key != 0 && strlen($value['nom']) > $SITUACIO_elementmida + strlen($SITUACIO_elementtext)) {
        $elem_situacio[$key]['nom'] = substr($value['nom'], 0, $SITUACIO_elementmida).$SITUACIO_elementtext;
      }
    }
  }

  $elements = array();
  foreach ($elem_situacio as $value) {
    if ($value['link'] != '') {
      $link = str_replace("//", "/", $value['link']);
      $elements[] = '<a href="'.$link.'" title="'.$value['title'].'">'.$value['nom'].'</a>';
    } /*else {
      $elements[] = $value['nom'];
    }*/
  }
  $situacio = implode($SITUACIO_separador, $elements);
  return ($situacio);
}


?>
