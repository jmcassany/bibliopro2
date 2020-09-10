<?php

function metas_pages($content, $id = null, $taula = '', $preview = false) {

  /*afegir menus*/
  if ($taula != null && $id != null) {
    $extraTitle = '';
    switch ($taula) {
      case 'FORMULARIS':
        $desc = 'TITOLFORMULARI';
        break;
      case 'CARPETES':
        $desc = 'DESCRIPCIO';
        $extraTitle = '!METAS_TITLE!';
        break;
      default:
        $desc = 'DESCRIPCIO';
        break;
    } 

    $result = db_query("select METATITOL, METADESCRIPCIO, METAKEYS, ".$desc." from ".$taula." where id=".$id);
    if(db_num_rows($result) != 1) {
      return $content;
    }
    $row = db_fetch_array($result);

    if (!isset($row['METATITOL']) || $row['METATITOL'] == '') {
      $row['METATITOL'] = $row[$desc];
    }
    if ($row['METATITOL'] != '') {
      $row['METATITOL'] .= ' - ';
    }
    
    // metakeys heredats de les carpetes
    $extraMetakeys = metatagsExtraMetakeysGet($taula, $id);    
    $row['METAKEYS'] = ($row['METAKEYS'] != '') ? $row['METAKEYS'].$extraMetakeys : substr($extraMetakeys, strlen(', '));

    $arrayBuscados = array('|METAS_TITLE|','|METAS_DESCRIPTION|','|METAS_KEYWORDS|');
    $arrayReemplazar = array($extraTitle.$row['METATITOL'], $row['METADESCRIPCIO'], $row['METAKEYS']);
    $content = str_replace($arrayBuscados, $arrayReemplazar, $content);


    /*compativilitat cap enrera*/
    $content = str_replace('|METATITOL|', $extraTitle.$row['METATITOL'], $content);

  }

  return $content;
}

function metatagsExtraMetakeysGet($taula, $id) {
	
	// agafem l'id de la carpeta pare	
   	$result = db_query("SELECT PARE, IDIOMA FROM $taula WHERE ID=$id");
  	if(db_num_rows($result) != 1) {
  		return '';
  	}
  	$row = db_fetch_array($result);
    $pare = $row['PARE'];
    $idioma = $row['IDIOMA'];
    
    // recorrem totes les carpetes de nivell superior
    $array_folders_id = array_reverse(array_keys(folderPathArray($pare)));
    $content_extra_metakeys = '';
    foreach ($array_folders_id as $folder_id) {
    	$result = db_query("SELECT METAKEYS FROM CARPETES_IDIOMES WHERE ID = $folder_id AND IDIOMA='$idioma'");
    	if($result) {
    		$row = db_fetch_array($result);
    		$content_extra_metakeys .= ', '.$row['METAKEYS'];
    	}
    }
    
	return $content_extra_metakeys;
}

?>
