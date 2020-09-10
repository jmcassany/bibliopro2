<?php

/*funcio per arreglar els problemes amb magic quotes*/
function _fix_gpc_magic(&$item) {
  if (is_array($item)) {
    array_walk($item, '_fix_gpc_magic');
  }
  else {
    $item = stripslashes($item);
  }
}

function fix_gpc_magic() {
  static $fixed = false;
  if (!$fixed && ini_get('magic_quotes_gpc')) {
    array_walk($_GET, '_fix_gpc_magic');
    array_walk($_POST, '_fix_gpc_magic');
    array_walk($_COOKIE, '_fix_gpc_magic');
    array_walk($_REQUEST, '_fix_gpc_magic');
    $fixed = true;
  }
}

/*fi funcions bàsiques*/







//funcio q borra el directori i els seus arxius
function deldir($dir){
  $current_dir = opendir($dir);
  while($entryname = readdir($current_dir)){
     if(is_dir($dir.'/'.$entryname) and ($entryname != '.' and $entryname!='..')){
        deldir($dir.'/'.$entryname);
     }elseif($entryname != '.' and $entryname!='..'){
        unlink($dir.'/'.$entryname);
     }
  }
  closedir($current_dir);
  rmdir($dir);
}

/*esborra una pàgina*/
function delete_page($nom, $pare, $imprimir = false) {
  global $CONFIG_PATHBASE;

  $path = folderPath($pare);

  if (!$imprimir) {
    $targetfilename = $CONFIG_PATHBASE.'/'.$path.'/'.$nom;
  }
  else {
    $targetfilename = $CONFIG_PATHBASE.'/'.$path.'/v_'.$nom;
  }

  /*esborrar fitxer amb la pagina*/
  if (file_exists($targetfilename)) {
    return @unlink ($targetfilename);
  }
  else {
    return false;
  }

  return true;
}

function option_dinamic($id) {
  global $fonts_caixetes, $CONFIG_BANNERACCES;

  $users = new dbUsers();
  $perm = $users->getComments(accessGetLogin());

  foreach ($fonts_caixetes as $value) {
    $resultat = db_query('SELECT * FROM '.$value['taula']);
    if (db_num_rows($resultat) > 0) {
      echo '<optgroup label="-- '.$value['nom'].' --">';
      while ($row = db_fetch_array($resultat)) {
        if($CONFIG_BANNERACCES && $value['taula'] == 'BANNERS') {
          if (!in_array($row['ID'].'_'.$value['sufix'], $perm)) {
            continue;
          }
        }
        if (empty ($row['DESCRIPCIO'])) {
          $descripcio = $row['NOM'];
        }
        else {
          $descripcio = $row['DESCRIPCIO'];
        }
        if ($row['ID'].'_'.$value['sufix'] == $id) {
          $selected = 'selected';
        }
        else {
          $selected = '';
        }
        echo '<option value="'.$row['ID'].'_'.$value['sufix'].'" '.$selected.'>'.$descripcio.'</option>'."\n";
      }
      echo '</optgroup>';
    }
  }
}

function path_dinamic($idc) {
  global $fonts_caixetes;

  if($idc == '') {
    return '';
  }

  $trosos = explode('_', $idc);
  $id = $trosos[0];
  $sufix = $trosos[1];
  foreach($fonts_caixetes as $value) {
    if ($value['sufix'] == $sufix) {
      $taula = $value['taula'];
      $path = $value['path'];
    }
  }
  if (isset($taula)) {
    $resultat = db_query('SELECT NOM FROM '.$taula.' WHERE ID='.$id);
    if (db_num_rows($resultat) != 1) {
      return '';
    }
    $row = db_fetch_array($resultat);
    return $path.'/'.$row['NOM'].'.inc';
  }
  else {
    return '';
  }
}

function file_list($directory) {
  $file_list = array();
  if( is_readable($directory))
  {
    $handle=opendir($directory);
    while ($file = readdir($handle)) {
      if (!is_dir($directory.'/'.$file)) {
        array_push($file_list, $file);
      }
    }
    closedir($handle);
  }
  return ($file_list);
}


function indexIdioma($idioma) {
  global $CONFIG_idiomes, $CONFIG_IDIOMA;
  $trozosidioma = explode ("_", $CONFIG_idiomes[$CONFIG_IDIOMA]['0']);
  $codiidioma=$trozosidioma['2'];
  if ($idioma != $codiidioma) {
    return $idioma.'_index.html';
  }else{
    return 'index.html';
  }
}





function fil_ariadna_array ($nom, $pare, $idioma) {
  global $SITUACIO_home, $CONFIG_NOMCARPETA;

  $elem_situacio = array();
  $result = db_query('select * from CARPETES where ID='.$pare);
  $row = db_fetch_array($result);
  while (!(isset($row['CARPETAINICI']) && $row['CARPETAINICI']) && !$row['PARE'] == null) {
    /* buscar el nom a la taula a la carpeta dels fils d'ariadna */
    $nomcarpeta = staticFolderLangGet($row['ID'], $idioma);
    if ($nomcarpeta == '') {
      $nomcarpeta = $row['NOMCARPETA'];
    }

    /*afegir link*/
    $elem_situacio[] = array('link' => $CONFIG_NOMCARPETA.'/'.folderPath($row['ID']).'/'.indexIdioma($idioma), 'title' => $nomcarpeta, 'nom' => $nomcarpeta);

    $result = db_query('select * from CARPETES where ID='.$row['PARE']);
    $row = db_fetch_array($result);
  }
  if ((isset($row['CARPETAINICI']) && $row['CARPETAINICI']) || $row['PARE'] == null) {
    /*carpeta que es vol que sigui inici de fil d'ariadna*/
    if (isset($SITUACIO_home[$idioma])){
      $nomcarpeta = $SITUACIO_home[$idioma];
    }
    else {
      $nomcarpeta = 'Portada';
    }
    $elem_situacio[] = array('link' => $CONFIG_NOMCARPETA.'/'.folderPath($row['ID']).'/'.indexIdioma($idioma), 'title' => $nomcarpeta, 'nom' => $nomcarpeta);
  }
  $elem_situacio = array_reverse($elem_situacio);
  if ($nom != '') {
    $elem_situacio[] = array('link' => '', 'title' => $nom, 'nom' => $nom);
  }
  return $elem_situacio;
}

/*crea el fil d'ariadna*/
function fil_ariadna ($nom, $pare, $idioma) {
  global $SITUACIO_separador, $SITUACIO_home;
  global $SITUACIO_midamax, $SITUACIO_elementmida, $SITUACIO_elementtext;

  global $CONFIG_NOMCARPETA;

  $elem_situacio = fil_ariadna_array($nom, $pare, $idioma);

  return fil_ariadna_build($elem_situacio);
}



/*crea ruta apartat*/
function ruta_apartat ($nom, $pare, $idioma) {
 global $SITUACIO_separador, $SITUACIO_home;
 global $SITUACIO_midamax, $SITUACIO_elementmida, $SITUACIO_elementtext;

 global $CONFIG_NOMCARPETA;

 $elem_situacio = array();
 $result = db_query('select * from CARPETES where ID='.$pare);
 $row = db_fetch_array($result);
 while (!(isset($row['CARPETAINICI']) && $row['CARPETAINICI']) && !$row['PARE'] == null) {
   /* buscar el nom a la taula a la carpeta dels fils d'ariadna */
   $nomcarpeta = staticFolderLangGet($row['ID'], $idioma);
     if ($nomcarpeta == '') {
     $nomcarpeta = $row['NOMCARPETA'];
   }

   //afegir link
   $elem_situacio[] = array('link' => $CONFIG_NOMCARPETA.folderPath($row['ID']).'/'.indexIdioma($idioma), 'title' => $nomcarpeta, 'nom' => $nomcarpeta);
     $result = db_query('select * from CARPETES where ID='.$row['PARE']);
   $row = db_fetch_array($result);
 }

 $elements = array();
 //$elem_situacio = array_reverse($elem_situacio);
 foreach ($elem_situacio as $value) {
   $elements[] = $value['nom'];
 }
 $situacio = implode($SITUACIO_separador, $elements);

 if (!empty($situacio)) {
   $situacio .= $SITUACIO_separador;
 }
 $situacio .= $nom;

 $apartat = explode(" > ", $situacio);
 return ($apartat[0]);
}

require_once ($CONFIG_PATHADMIN.'/php/lib/class.Thumbnail.inc');
/*funció per gravar un fitxer al servidor*/
function upload($name, $path, $sizeLim = 0, $mimeTypeLim = array(), $destName = '', $imageWidth = 0) {
  global $CONFIG_PERMFILES;
  /*mirar si hi ha fitxer a pujar*/
  if(!isset($_FILES[$name]) || !is_uploaded_file($_FILES[$name]['tmp_name'])) {
    return 1;
  }

  /*si no hi ha nom assignat utilitzar l'original*/
  if($destName == '') {
    $destName = $_FILES[$name]['name'];
  }

  /*comprovar mida*/
  if (($sizeLim > 0) && ($_FILES[$name]['size'] > $sizeLim)) {
    return 2;
  }
  /*comprovar mimetype*/
  if (count($mimeTypeLim) > 0 && !in_array($_FILES[$name]['type'], $mimeTypeLim)) {
    return 5;
  }

  /*s'ha de redimensionar imatge*/
  $error = false;
  if ($imageWidth > 0) {
    /*comprovar mides*/
    $mides=getimagesize($_FILES[$name]['tmp_name']);
    if ($mides['0'] > $imageWidth && in_array($_FILES[$name]['type'], array('image/png', 'image/x-png','image/jpeg','image/gif','image/pjpeg'))) {
      $tn_image = new Thumbnail($_FILES[$name]['tmp_name'], $imageWidth, 0, 0, $_FILES[$name]['type']);
      $tn_image->save($path.'/'.$destName);
      if ($tn_image->error) {
        return 3;
      }
    }
    else {
      if (!copy($_FILES[$name]['tmp_name'], $path.'/'.$destName)) {
        return 3;
      }
    }
  }
  else {
    if (!copy($_FILES[$name]['tmp_name'], $path.'/'.$destName)) {
      return 3;
    }
  }
  /*comprovar si s'ha creat*/
  if (file_exists($path.'/'.$destName)) {
    if (!empty($CONFIG_PERMFILES)) {
      @chmod($path.'/'.$destName, $CONFIG_PERMFILES);
    }
    return 4;
  }
  else {
    return 3;
  }
}


/*afegeix un permissos per accedir a un element, els afegeix al usuari admin
i a l'usuari que l'ha creat*/
function addPerm($value) {
  global $USERS_admin;

  $users = new dbUsers();
  $admins = $users->listUsers(0, '', accessGetAdminGroup());
  foreach ($admins as $admin) {
    //afegir permissos a tots els administradors
    $comments = $users->getComments($admin['LOGIN']);
    if (is_array($value)) {
      $comments = array_merge($comments, $value);
    }
    else {
      $comments[] = $value;
    }
    $users->setComments($admin['LOGIN'], $comments);
  }
/*  if (accessGetLogin() != $USERS_admin) {
    $comments = $users->getComments($USERS_admin);
    if (is_array($value)) {
      $comments = array_merge($comments, $value);
    }
    else {
      $comments[] = $value;
    }
    $users->setComments($USERS_admin, $comments);
  }*/
  /*afegir access al usuari creador*/
  $comments = $users->getComments(accessGetLogin());
  if (is_array($value)) {
    $comments = array_merge($comments, $value);
  }
  else {
    $comments[] = $value;
  }
  array_unique($comments);
  $users->setComments(accessGetLogin(), $comments);
}


/*neteja el nom d'un fitxer de caracters estranys*/
function normalizeFile ($name) {

  /*eliminar accents ñ i ç*/
  $orig = array('Á','É','Í','Ó','Ú','À','È','Ì','Ò','Ù','Ä','Ë','Ï','Ö','Ü',
				'Â','Ê','Î','Ô','Û','Ç','Ñ','á','é','í','ó','ú','à','è','ì',
				'ò','ù','ä','ë','ï','ö','ü','â','ê','î','ô','û','ç','ñ',' ');
  $dest = array('a','e','i','o','u','a','e','i','o','u','a','e','i','o','u',
				'a','e','i','o','u','c','n','a','e','i','o','u','a','e','i',
				'o','u','a','e','i','o','u','a','e','i','o','u','c','n','_');

  $name = str_replace($orig, $dest, $name);

  $name = strtolower($name);
  /*eliminar qualsevol caracter no alfanumeric punt o subrallat*/
  $name = preg_replace('#[^[:alnum:]._-]#', '', $name);
  return $name;
}
/*neteja el nom d'un fitxer amb extensio de caracters estranys*/
function normalizeFileAndExtension ($name) {

  $file_parts = explode(".",$name);
  $file_name = '';
  for($i=0; $i<count($file_parts)-1;$i++)
  {
  	$file_name .= $file_parts[$i];
  }
  /*normalitzem la part del nom*/
  $file_name = normalizeFile($file_name);
  /*afegim l'extensio*/
  $file_name .= '.'.$file_parts[count($file_parts)-1];
  return $file_name;
}

/*copiar un directori a un altre*/
function dirCopy($dirOrig, $dirDesti) {
  global $CONFIG_PERMFILES, $CONFIG_PERMFOLDERS;
  $file_list = array();
  $copyCorrect = true;
  if(is_readable($dirOrig) && is_writable($dirDesti))
  {
    $handle=@opendir($dirOrig);
    while ($file = @readdir($handle)) {
      if (!is_dir($dirOrig.'/'.$file)) {
        if (@copy($dirOrig.'/'.$file, $dirDesti.'/'.$file)) {
          if (!empty($CONFIG_PERMFILES)) {
            @chmod($dirDesti.'/'.$file, $CONFIG_PERMFILES);
          }
        }
        else {
          $copyCorrect = false;
        }
      }
      else {
        if (@mkdir($dirDesti.'/'.$file)) {
          if (!empty($CONFIG_PERMFOLDERS)) {
            @chmod($dirDesti.'/'.$file, $CONFIG_PERMFOLDERS);
          }
          $copyCorrect = dirCopy($dirOrig.'/'.$file, $dirDesti.'/'.$file);
        }
        else {
          $copyCorrect = false;
        }
      }
    }
    closedir($handle);
  }
}

function urlDir ($url) {
  $data = parse_url($url);
  if (!isset($data['path']) || $data['path'] == '') {
    return '';
  }
  $path = preg_replace('#/+#', '/',$data['path']);
  if ($path != '/') {
    return $path;
  }
  else {
    return '';
  }
}

function urlHost ($url) {
  $data = parse_url($url);
  if (!isset($data['host']) || $data['host'] == '') {
    return '';
  }
  return 'http://'.$data['host'];
}


require_once(dirname(__FILE__).'/lib/kses/kses.php');
function htmlFilter ($content) {
  global $htmlFilter_allowed, $htmlFilter_closed_tags;
  global $htmlFilter_pre_replace, $htmlFilter_post_replace;
  global $htmlFilter;

  if (!isset($htmlFilter) || !$htmlFilter) {
    return $content;
  }

  /*reemplaça coses inadecuades*/
  foreach ($htmlFilter_pre_replace as $key => $value) {
    $content = preg_replace($key, $value, $content);
  }

  /*filtre de limitació de tags*/
  $content = kses($content, $htmlFilter_allowed,
                  array('http', 'https', 'ftp', 'news', 'nntp', 'telnet',
                  'gopher', 'mailto'), $htmlFilter_closed_tags);

  /*reemplaça coses inadecuades*/
  foreach ($htmlFilter_post_replace as $key => $value) {
//	$coincidencias = array();
//    preg_match_all($key, $content, $coincidencias);
//	var_dump($coincidencias);
    $content = preg_replace($key, $value, $content);
  }

  return $content;
}


function textareaFilter ($content) {
  global $textareaFilter, $textareaFilter_replace;

  if (!isset($textareaFilter) || !$textareaFilter) {
    return $content;
  }

  /*reemplaça*/
  foreach ($textareaFilter_replace as $key => $value) {
    //$content = eregi_replace($key, $value, $content);
    $content = preg_replace($key, $value, $content);
  }

  return $content;
}

function pageFilter ($content) {
  global $pageFilter, $pageFilter_replace;

  if (!isset($pageFilter) || !$pageFilter) {
    return $content;
  }

  /*reemplaça*/
  foreach ($pageFilter_replace as $key => $value) {
//    $content = eregi_replace($key, $value, $content);
    $content = preg_replace($key, $value, $content);
  }
  return $content;
}













function pages($pare = null) {
  if ($pare == null) {
    return array();
  }

  $carpeta = ' where PARE = '.$pare.' ';

  $result=db_query("select ID, PARE, NOMPAG, DESCRIPCIO, IDIOMA from ESTATICA where PARE=".$pare." ORDER BY DESCRIPCIO ASC");

  $list = array();
  while($row = db_fetch_array($result)) {
    $element = array('id' => $row['ID'], 'pare' => $row['PARE'], 'nom' => $row['NOMPAG'], 'desc' => $row['DESCRIPCIO'], 'ruta' => folderPath($row['PARE']).'/'.$row['NOMPAG'], 'class' => 'page');
    $element['idioma'] = $row['IDIOMA'];
    $list[] = $element;
  }
  db_free_result($result);
  return $list;
}

function forms($pare = null) {
  if ($pare == null) {
    return array();
  }

  $carpeta = ' where PARE = '.$pare.' ';

  $result=db_query("select ID, PARE, NOMFORMULARI, TITOLFORMULARI, IDIOMA from FORMULARIS where PARE=".$pare." ORDER BY DESCRIPCIO ASC");

  $list = array();
  while($row = db_fetch_array($result)) {
    $element = array('id' => $row['ID'], 'pare' => $row['PARE'], 'nom' => $row['NOMFORMULARI'], 'desc' => $row['TITOLFORMULARI'], 'ruta' => folderPath($row['PARE']).'/'.$row['NOMFORMULARI'], 'class' => 'form');
    $element['idioma'] = $row['IDIOMA'];
    $list[] = $element;
  }
  db_free_result($result);
  return $list;
}


function treeList($pare = null) {

  $carpetes = folder($pare);
  $fills = array();

  $options = '';
  foreach($carpetes as $value) {
    $tmp = treeList($value['id']);
    $value['fills'] = array();
    if (count ($tmp) > 0) {
      $value['fills'] = $tmp;
    }
    if (/*$value['access'] || */count ($value['fills']) > 0) {
      $fills[] = $value;
    }
  }

  /*afegir pagines*/
  $pages = pages($pare);
  $fills = array_merge($fills, $pages);

  /*afegir formularis*/
  $forms = forms($pare);
  $fills = array_merge($fills, $forms);


  return $fills;
}


function varToString($var) {
	if (is_string($var)) {
		return "'".str_replace("'","\'", $var)."'";
	}
	elseif (is_integer($var)) {
		return sprintf("%d", $var);
	}
	elseif (is_float($var)) {
		return sprintf("%f", $var);
	}
	elseif (is_bool($var)) {
		if ($var) {
			return 'true';
		} else {
			return 'false';
		}
	}
	elseif (is_array($var)) {
		$vars = array();
		foreach ($var as $key => $value) {
			$vars[] = varToString($key).' => '.varToString($value);
		}
		$vars = implode(' , ', $vars);
		return 'array('.$vars.')';
	}

}

?>
