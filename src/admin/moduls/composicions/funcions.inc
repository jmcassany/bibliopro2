<?php




function composicio_pages($content, $id = null, $taula = null, $preview = false) {
  global $CONFIG_PATHADMIN;

  if ($taula != null && $id != null) {
    /*afegir composicions*/
    $result = db_query("select BANNER1, BANNER2, BANNER3 from ".$taula." where id=".$id);
    if(db_num_rows($result) != 1) {
      return $content;
    }
    $row = db_fetch_array($result);
    if (file_exists($CONFIG_PATHADMIN.'/moduls/composicions')) {
      for ($i=1; $i<=3; $i++) {
        $banner[$i] = composicio_code($row['BANNER'.$i], $preview);
      }
    }

    $arrayBuscados = array('|BANNERESQUERRA|','|BANNERDRETA|','|BANNERSUPERIOR|');
    $arrayReemplazar = array($banner[1],$banner[2],$banner[3]);
    $content = str_replace($arrayBuscados, $arrayReemplazar, $content);
  }



  /*menús estatics*/
  preg_match_all("/\|(composicio-static-[A-Za-z0-9_]+?)\|/",$content,$values);

  $values = array_unique($values[1]);

  foreach($values as $value) {
    $elements = explode('-', $value);
    $name = $elements[2];
    $composicio = composicio_code(name, $preview);
    $content = str_replace('|'.$value.'|', $composicio, $content);
  }

  return $content;
}

function composicio_code($banner, $preview = 0) {
  global $CONFIG_BANNERTYPE;

  $contents = '';
  if ($banner != ''){
    $filename = path_dinamic($banner);
    if (file_exists($filename)) {
      if (!$preview && $CONFIG_BANNERTYPE != 'html') {
        $contents = '<?php @include("'.$filename.'") ?>';
      }
      else {
        ob_start();
        @include ($filename);
        $contents = ob_get_contents();
        ob_end_clean();
      }
    }
  }
  return $contents;
}



?>
