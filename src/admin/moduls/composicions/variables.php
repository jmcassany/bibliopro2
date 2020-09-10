<?php

$tipus_banners = array(
  '0'=>array('nom'=>'Vertical','crear'=>'generar_lateral', 'defecte'=>1, 'max_width'=>140),
  '1'=>array('nom'=>'Horitzontal','crear'=>'generar_horitzontal')
);

function generar_horitzontal($row,$caixetes,$preview=0) {
  global $CONFIG_PATHBANNER;
  global $fonts_caixetes;

  $content = '';

  foreach ($caixetes as $value) {

    list($id, $sufix) = split('_', $value);
    foreach($fonts_caixetes as $value2) {
      if ($value2['sufix'] == $sufix) {
        $taula = $value2['taula'];
        $path = $value2['path'];
      }
    }

    $resultat = db_query('SELECT NOM FROM '.$taula.' WHERE ID='.$id);
    if (db_num_rows($resultat) != 1) { continue; }
    $row = db_fetch_array($resultat);
    $targetfilename = $path.'/'.$row['NOM'].'.inc';


    if (file_exists($targetfilename)) {
      if ($preview) {
        ob_start();
        @include ($targetfilename);
        $content .= ob_get_contents();
        ob_end_clean();
      }
      else {
        $content .= '<?php @include("'.$targetfilename.'") ?>';
      }
    }

  }
  if ($content != '') {
    $content = '<div class="comp-horitzontal">'.$content.'</div>';
  }


  return $content;
}


function generar_lateral($oldrow,$caixetes,$preview=0) {
  global $CONFIG_PATHBANNER;
  global $fonts_caixetes;

  $content = '';
  foreach ($caixetes as $value) {

    list($id, $sufix) = split('_', $value);
    foreach($fonts_caixetes as $value2) {
      if ($value2['sufix'] == $sufix) {
        $taula = $value2['taula'];
        $path = $value2['path'];
      }
    }

    $resultat = db_query('SELECT NOM FROM '.$taula.' WHERE ID=\''.$id.'\'');

    if (db_num_rows($resultat) != 1) { continue; }
    $row = db_fetch_array($resultat);
    $targetfilename = $path.'/'.$row['NOM'].'.inc';
    if (file_exists($targetfilename)) {
      if ($preview) {
        ob_start();
        @include ($targetfilename);
        $content .= ob_get_contents();
        ob_end_clean();
      }
      else {
        $content .= '<?php @include("'.$targetfilename.'") ?>';
      }
    }

  }
  if ($content != '') {
  	/*
    if(!empty($oldrow['DESCRIPCIO'])) {
      $content = '<div class="comp-vertical"><h2>'.$oldrow["DESCRIPCIO"].'</h2> '.$content.'</div>';
    }
    else {
    */
      $content = '<div class="comp-vertical">'.$content.'</div>';
    //}
  }

  return $content;

}

?>