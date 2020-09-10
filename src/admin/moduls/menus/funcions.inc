<?php

function menu_pages($content, $id = null, $taula = '', $preview = false) {

  /*afegir menus*/
  if ($taula != null && $id != null) {
    $result = db_query("select MENU1, MENU2, MENU3 from ".$taula." where id=".$id);
    if(db_num_rows($result) != 1) {
      return $content;
    }
    $row = db_fetch_array($result);
    for ($i=1; $i<=3; $i++) {
      $menu[$i] = menu_code($row['MENU'.$i], $preview);
    }
    $arrayBuscados = array('|MENUESQUERRA|','|MENUDRETA|','|MENUSUPERIOR|');
    $arrayReemplazar = array($menu[1],$menu[2],$menu[3]);
    $content = str_replace($arrayBuscados, $arrayReemplazar, $content);
  }




  /*menús estatics*/
  preg_match_all("/\|(menu-static-[A-Za-z0-9_]+?)\|/",$content,$values);

  $values = array_unique($values[1]);

  foreach($values as $value) {
    $elements = explode('-', $value);
    $name = $elements[2];
    $menu = menu_code($name, $preview);
    $content = str_replace('|'.$value.'|', $menu, $content);
  }

  return $content;
}


function menu_code($menu, $preview = 0) {
  global $CONFIG_PATHMENU, $CONFIG_MENUTYPE;

  $contents = '';
  if ($menu != ''){
    $filename = $CONFIG_PATHMENU.'/'.$menu.'.inc';
    if (file_exists($filename)) {
      if ($CONFIG_MENUTYPE == 'php'/*  && !$preview*/) {
        $contents = '<?php
$directori = \'|IDSDIRECTORIS|\';
$url = \'|PAGE_URL|\';
$rutaplana = ($pos = strpos(\'|PAGE_URL|\', \'?\')) ? substr(\'|PAGE_URL|\', 0, ($pos-1)) : \'|PAGE_URL|\';
$directoris = explode(\',\', $directori);
@include("'.$filename.'")
?>';
      }
      else if ($CONFIG_MENUTYPE == 'html' && $preview) {
        ob_start();
        @include ($filename);
        $contents = ob_get_contents();
        ob_end_clean();
      }
      else {
        $fd = fopen ($filename, "r");
        $contents = fread ($fd, filesize ($filename));
        fclose ($fd);
      }
    }
  }
  return $contents;
}

/*filtrat de menus*/
function filtrat_menus() {
  global $CONFIG_MENUACCES;
  if ($CONFIG_MENUACCES) {
    $users = new dbUsers();
    $elements = $users->getComments(accessGetLogin());

    foreach ($elements as $value) {
      $trossos = explode('_', $value);
      if (isset($trossos[1]) && $trossos[1] == 'menu') {
        $permes[] = $trossos[0];
      }
    }
    $ids = array();
    foreach ($permes as $valor) {
      $ids[] = 'ID = '.$valor;
    }
    if (count($ids) > 0) {
      $filtre = implode(' OR ', $ids);
      $filtre = ' AND ('.$filtre.')';
    }
    if (count($ids) == 0) {
      /*cap menu seleccionat*/
      $filtre = ' AND 1=0';
    }
    return $filtre;
  }
  else {
    return '';
  }
}

function menu_list($nom, $type, $pare, $idioma='') {
  //$filtre = filtrat_menus();
  $filtre ='';
  $filtraidioma='';
  if($idioma!=''){
  	$filtraidioma="AND IDIOMA='$idioma'";
  }
  $text = '';
  $result = db_query("select NOM, DESCRIPCIO,ACCESSUBCARP,PARE from MENUS
                      Where TIPO = ".$type." ".$filtraidioma."
                      ".$filtre." ORDER BY DESCRIPCIO asc");

  while($row = db_fetch_array($result)) {
    if ($row['ACCESSUBCARP'] == 0 && $row['PARE'] != $pare) {
      continue;
    }
    if ($row['ACCESSUBCARP'] == 1 && !ereg('^'.folderPath($row['PARE']), folderPath($pare))) {
      continue;
    }
    if (empty ($row['DESCRIPCIO'])) {
      $descripcio = $row['NOM'];
    }
    else {
      $descripcio = $row['DESCRIPCIO'];
    }
    if ($row['NOM'] == $nom) {
      $selected = ' selected';
        }
        else {
          $selected = '';
        }
        $text .= '<option value="'.$row['NOM'].'"'.$selected.'>'.$descripcio.'</option>'."\n";
  }
  db_free_result($result);
  return $text;

}


?>
