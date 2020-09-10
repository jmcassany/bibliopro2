<?php

function cat_anteriors($DINAMICA, $pare = null,$last_link = 1) {
  global $CONFIG_URLADMIN;
  $anteriors = array();

  $result = db_query('select NOMCARPETA, PARE,DESCRIPCIO  from CARPETES where ID ='.$DINAMICA);
  $row = db_fetch_array($result);
  $titol = $row['DESCRIPCIO'];
  $nom_dinamica = $row['NOMCARPETA'];

  while ($pare != null) {
    $parent = db_query('select * from DIN_CATEGORIES where ID = '.$pare.' AND DINAMICA = '.$DINAMICA);
    $row = db_fetch_array($parent);
    //$anteriors[] = array('id' => $row['ID'] , 'nom' => $row['NOM']);
    array_unshift($anteriors, array('id' => $row['ID'] , 'nom' => $row['NOM']));
    $pare = null;
    if (isset($row['PARE'])) {
      $pare = $row['PARE'];
    }
  }
  if (count($anteriors) > 0) {
    $etsa = '<img src="'.$CONFIG_URLADMIN.'/comu/ico_categoria_mapa.png" align="middle"><a href="index.php?DINAMICA='.$DINAMICA.'" class="blau10">'.$titol.'</a><br>';
  }
  else
  {
    $etsa = '<img src="'.$CONFIG_URLADMIN.'/comu/ico_categoria_mapa.png" align="middle"><span  class="blau10b">'.$titol.'</span><br>';
  }
  $ultim = end($anteriors);
  $i = 0;
  foreach($anteriors as $key => $value) {
    /*espais*/
    $espais = '';
    for($j = 0; $j < $i; $j ++) {
      $espais .= '<img src="'.$CONFIG_URLADMIN.'/comu/ico_categoria_blanc.png" align="middle">';
    }
    if ($value['nom'] == $ultim['nom']) {
      $etsa .= $espais.'<img src="'.$CONFIG_URLADMIN.'/comu/ico_categoria_fil.png" align="middle"><img src="'.$CONFIG_URLADMIN.'/comu/ico_categoria_mapa.png" align="middle"><span class="blau10b">'.$value['nom'].'</span>';
    }
    else {
      $etsa .= $espais.'<img src="'.$CONFIG_URLADMIN.'/comu/ico_categoria_fil.png" align="middle"><img src="'.$CONFIG_URLADMIN.'/comu/ico_categoria_mapa.png" align="middle"><a href="index.php?ID='.$value['id'].'&amp;DINAMICA='.$DINAMICA.'" class="blau10">'.$value['nom'].'</a><br>';
    }
    $i ++;
  }

  $editora = '<a href="../index.php?DIN='.$DINAMICA.'" >'.$titol.'</a>';

  return array('etsa' => $etsa, 'editora' => $editora, 'nivell' => (count($anteriors)+1), 'ultim' => $ultim['nom']);

}

if (!is_callable('cat2items')) {
	function cat2items($carpetaid, $id = null, $prefix = '') {

		$entrades = array();
		if ($id != null) {
			$result = db_query('select ID, NOM from DIN_CATEGORIES where PARE = '.$id.' AND DINAMICA = '.$carpetaid);
		}
		else {
			$result = db_query('select ID, NOM from DIN_CATEGORIES where PARE is null AND DINAMICA = '.$carpetaid);
		}
		while($row = db_fetch_array($result)) {
			$entrades[] = $row['ID'].'_'.$prefix.$row['NOM'];
			$fills = cat2items($carpetaid, $row['ID'], $prefix.$row['NOM'].' > ');
			$entrades = array_merge($entrades, $fills);
		}
		return ($entrades);
	}
}

function catEsborrar($id) {
  $result = db_query('select ID from DIN_CATEGORIES where PARE = '.$id);
  while($row = db_fetch_array($result)) {
    catEsborrar($row['ID']);
  }
  $result = db_query('delete from DIN_CATEGORIES where ID = '.$id);
  return ($result);


}


?>