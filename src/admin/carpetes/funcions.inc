<?php

/*funcions per gestionar idiomes en les carpetes*/
function staticFolderLangSet($id, $lang, $title, $metakeys = '') {
  staticFolderLangDel($id, $lang);
  if ($title == '' && $metakeys == '') {
    return true;
  }
  return (db_query("INSERT INTO CARPETES_IDIOMES (ID, IDIOMA, TITOL, METAKEYS) VALUES (%d, '%s', '%s', '%s')", $id, $lang, $title, $metakeys));

}
function staticFolderLangGet($id, $lang) {
  $result = db_query("SELECT TITOL FROM CARPETES_IDIOMES WHERE ID=%d AND IDIOMA='%s';", $id, $lang);
  if (db_num_rows($result) == 1) {
    $row = db_fetch_array($result);
    return ($row['TITOL']);
  }
  else {
    return ('');
  }
}
function staticFolderMetakeysGet($id, $lang) {
  $result = db_query("SELECT METAKEYS FROM CARPETES_IDIOMES WHERE ID=%d AND IDIOMA='%s';", $id, $lang);
  if (db_num_rows($result) == 1) {
    $row = db_fetch_array($result);
    return ($row['METAKEYS']);
  }
  else {
    return ('');
  }
}
function staticFolderLangDel($id, $lang) {
  db_query("DELETE FROM CARPETES_IDIOMES WHERE ID=%d AND IDIOMA='%s';", $id, $lang);
}
function staticFolderLangDelAll($id) {
  db_query("DELETE FROM CARPETES_IDIOMES WHERE ID=%d;", $id);
}
/*fi funcions per gestionar idiomes en les carpetes*/


/*torna una llista amb la informació de les carpetes dinamiques*/
function dinamicFolderList($pare = null) {

  $carpeta = '';
  if ($pare != null) {
    $carpeta = ' PARE = '.$pare.' AND ';
  }
  $result=db_query("select ID, PARE, NOMCARPETA, DESCRIPCIO, IDIOMA from CARPETES where ".$carpeta." CATEGORY1='1' ORDER BY DESCRIPCIO ASC");
  $users = new dbUsers();
  $trozos = $users->getComments(accessGetLogin());

  $list = array();
  while($row = db_fetch_array($result)) {

    if (in_array($row['ID'], $trozos)){
      $list[] = array('id' => $row['ID'], 'pare' => $row['PARE'], 'nom' => $row['NOMCARPETA'], 'desc' => $row['DESCRIPCIO'], 'idioma' => $row['IDIOMA'], 'ruta' => folderPath($row['ID']));
    }
  }
  db_free_result($result);
  return $list;
}


/*torna una llista amb la informació de les carpetes estatiques*/
function staticFolderList($pare = null, $restrict = true) {

  $carpeta = '';
  if ($pare != null) {
    $carpeta = ' PARE = '.$pare.' AND ';
  }
  $result=db_query("select ID, PARE, NOMCARPETA, DESCRIPCIO from CARPETES Where ".$carpeta." CATEGORY1='0' ORDER BY DESCRIPCIO ASC");
  $users = new dbUsers();
  $trozos = $users->getComments(accessGetLogin());

  $list = array();
  while($row = db_fetch_array($result)) {

    if (in_array($row['ID'], $trozos) || !$restrict){
      $list[] = array('id' => $row['ID'], 'pare' => $row['PARE'], 'nom' => $row['NOMCARPETA'], 'desc' => $row['DESCRIPCIO'], 'ruta' => folderPath($row['ID']));
    }
  }
  db_free_result($result);
  return $list;
}

function staticFolder($pare = null) {

  $carpeta = ' PARE is null AND ';
  if ($pare != null) {
    $carpeta = ' PARE = '.$pare.' AND ';
  }
  $result=db_query("select ID, PARE, NOMCARPETA, DESCRIPCIO from CARPETES Where ".$carpeta." CATEGORY1='0' ORDER BY DESCRIPCIO ASC");
  $users = new dbUsers();
  $trozos = $users->getComments(accessGetLogin());

  $list = array();
  while($row = db_fetch_array($result)) {
    $element = array('id' => $row['ID'], 'pare' => $row['PARE'], 'nom' => $row['NOMCARPETA'], 'desc' => $row['DESCRIPCIO'], 'ruta' => folderPath($row['ID'] ));
    if (in_array($row['ID'], $trozos)){
      $element['access'] = true;
    }
    else {
      $element['access'] = false;
    }
    $list[] = $element;
  }
  db_free_result($result);
  return $list;
}


/*mostra les opcions per seleccionar una carpeta*/
function staticFolderSelect($actual = null, $restrict = true, $pare = null, $string = '') {

  $carpetes = staticFolder($pare, $restrict);

  $options = '';
  foreach($carpetes as $value) {

    $selected = $value['id'] == $actual ? ' selected="selected"' : '';

    if ($string == '') {
      $prefix = $value['nom'];
    }
    else {
      $prefix = $string.' > '.$value['nom'];
    }
    if ($value['access']) {
      $options .= '<option value="'.$value['id'].'" '.$selected.'>'.$prefix.': '.$value['desc'].'</option>';
    }
    $options .= staticFolderSelect($actual, $restrict, $value['id'], $prefix);
  }
  return $options;
}


/*mostra les opcions per seleccionar una editora*/
function dinamicFolderSelect($actual = null, $pare = null, $string = '') {

	$carpeta = ' where PARE is null';
	if ($pare != null) $carpeta = ' where PARE = '.$pare.' ';
	$result=db_query("select ID, PARE, NOMCARPETA, DESCRIPCIO, CATEGORY1, IDIOMA from CARPETES ".$carpeta." ORDER BY DESCRIPCIO ASC");
	$users = new dbUsers();
	$trozos = $users->getComments(accessGetLogin());

	$options = '';
	while($row = db_fetch_array($result)) {

		$element = array('id' => $row['ID'], 'pare' => $row['PARE'], 'nom' => $row['NOMCARPETA'], 'desc' => $row['DESCRIPCIO'], 'ruta' => folderPath($row['ID']), 'tipus' => $row['CATEGORY1'], 'class' => 'folder');

		if (in_array($row['ID'], $trozos)) $element['access'] = true;
		else $element['access'] = false;

		if($string == '') {
			$prefix = $row['NOMCARPETA'];
		}
		else {
			$prefix = $string.' > '.$row['NOMCARPETA'];
		}

		$selected = $row['ID'] == $actual ? ' selected="selected"' : '';

		if($row['CATEGORY1'] == 1) {
			if($element['access']) $options .= '<option value="'.$row['ID'].'"'.$selected.'>'.$prefix.': '.$row['DESCRIPCIO'].'</option>';
		}
		$options .= dinamicFolderSelect($actual, $row['ID'], $prefix);

	}
	db_free_result($result);
	return $options;

}


function folder($pare = null, $control=true) {

  $carpeta = ' where PARE is null';
  if ($pare != null) {
    $carpeta = ' where PARE = '.$pare.' ';
  }
  $result=db_query("select ID, PARE, NOMCARPETA, DESCRIPCIO, CATEGORY1, IDIOMA from CARPETES ".$carpeta." ORDER BY DESCRIPCIO ASC");
  $users = new dbUsers();
  $trozos = $users->getComments(accessGetLogin());

  $list = array();
  while($row = db_fetch_array($result)) {
    $element = array('id' => $row['ID'], 'pare' => $row['PARE'], 'nom' => $row['NOMCARPETA'], 'desc' => $row['DESCRIPCIO'], 'ruta' => folderPath($row['ID']), 'tipus' => $row['CATEGORY1'], 'class' => 'folder');
    if($control)
    {
	    if (in_array($row['ID'], $trozos)){
	      $element['access'] = true;
	    }
	    else {
	      $element['access'] = false;
	    }
    }
    else
    {
    	$element['access'] = true;
    }
    if ($row['CATEGORY1'] == 1) {
      $element['idioma'] = $row['IDIOMA'];
    }
    $list[] = $element;
  }
  db_free_result($result);
  return $list;
}


/*mostra les opcions per seleccionar una carpeta*/
function folderList($pare = null, $control=true) {

  $carpetes = folder($pare, $control);
  $fills = array();

  $options = '';
  foreach($carpetes as $value) {
    $tmp = folderList($value['id'], $control);
    if (count ($tmp) > 0) {
      $value['fills'] = $tmp;
    }
    if ($value['access'] || count ($tmp) > 0) {
      $fills[] = $value;
    }
  }
  return $fills;
}


function dinFolderDelete($id) {
  global $CONFIG_PATHBASE, $TABLE_EDITORA_MULTIPLE_PREFIX;

  if(folderPath($id)!='' && folderPath($id)!='/')
  {
	  $ruta = $CONFIG_PATHBASE.'/'.folderPath($id);

	  db_query('DROP TABLE '.staticFolderTableName($id));
	  db_query('delete from DIN_CATEGORIES where DINAMICA = '.$id);
	  $result = db_query("delete from CARPETES where ID=".$id);
	  if ($result) {
	    deldir($ruta);
	    db_query('DROP TABLE IF EXISTS '.$TABLE_EDITORA_MULTIPLE_PREFIX.staticFolderTableName($id));
	    return (true);
	  }
	  else {
	    return (false);
	  }
  }

  return (false);
}

function staticfolderDelete($id) {
  global $CONFIG_PATHBASE;

  $result=db_query("select ID, CATEGORY1 from CARPETES where PARE=".$id);
  while($row = db_fetch_array($result)) {
    if ($row['CATEGORY1'] == 1) {
      if (!dinFolderDelete($row['ID'])) {
        return false;
      }
    }
    else {
      if (!staticfolderDelete($row['ID'])) {
        return false;
      }
    }
  }

  $ruta = $CONFIG_PATHBASE.'/'.folderPath($id);
  $result=db_query("select ID, NOMPAG from ESTATICA where PARE=".$id);
  while($row = db_fetch_array($result)) {
    if(file_exists($ruta.'/'.$row['NOMPAG'])) {
      unlink($ruta.'/'.$row['NOMPAG']);
    }
    db_query("delete from ESTATICA where ID=".$row['ID']);
  }
  $result=db_query("select ID, NOMFORMULARI from FORMULARIS where PARE=".$id);
  while($row = db_fetch_array($result)) {
    if(file_exists($ruta.'/'.$row['NOMFORMULARI'])) {
      unlink($ruta.'/'.$row['NOMFORMULARI']);
    }
    db_query("delete from FORMULARIS where ID=".$row['ID']);
  }
  staticFolderLangDelAll($id);
  $result = db_query("delete from CARPETES where ID=".$id);

  if ($result) {
  	if(folderPath($id)!='' && folderPath($id)!='/')
  	{
    	rmdir($ruta);
    	return (true);
  	}
    return (false);
  }
  else {
    return (false);
  }
}

function folderListString($id){
  $value = array();
  $result = db_query('select NOMCARPETA, DESCRIPCIO from CARPETES where ID='.$id);
  $row = db_fetch_array($result);
  $value[] = $row['NOMCARPETA'].' ('.$row['DESCRIPCIO'].')';
  $result = db_query('select ID from CARPETES where PARE='.$id);
  while ($row = db_fetch_array($result)) {
    $value = array_merge($value, folderListString($row['ID']));
  }
  return $value;
}

?>
