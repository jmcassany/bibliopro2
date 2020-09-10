<?php

function addQuote($text) {
  return (str_replace("'", "\'", $text));
}

function folderIsValid($ruta, $name) {
  global $FOLDER_exclude;
  if ($name == '') {
    return false;
  }
  if (in_array($ruta.'/'.$name, $FOLDER_exclude)) {
    return false;
  }
  else {
    return true;
  }
}

function folderGenerate ($ruta, $dir) {
  global $CONFIG_PATHBASE;
  global $CONFIG_PERMFOLDERS;

  if (!isset($ruta) || !isset($dir) || $dir == '') {
    return false;
  }

  $path = $CONFIG_PATHBASE.'/'.$ruta.'/'.$dir;

  $perm = 0755;
  if (!empty($CONFIG_PERMFOLDERS)) {
    $perm = $CONFIG_PERMFOLDERS;
  }

  /*si existeix es mostra un missatge, pero es considera correcte*/
  if(is_dir($path)){
    @chmod($path, $perm);
    return true;
  }
  if (!@mkdir($path, $perm)) {
    return false;
  }
  if(!is_dir($path)){
    return false;
  }
  @chmod($path, $perm);
  return true;
}


function folderRename ($ruta, $dir_old, $dir_new) {
  global $CONFIG_PATHBASE;

  if (/*!isset($ruta) || $ruta == '' ||*/ !isset($dir_old) || $dir_old == '' || !isset($dir_new) || $dir_new == '') {
    return false;
  }

  $perm = 0755;
  if (!empty($CONFIG_PERMFOLDERS)) {
    $perm = $CONFIG_PERMFOLDERS;
  }


  $path = $CONFIG_PATHBASE.'/'.$ruta.'/'.$dir_old;
  $noupath = $CONFIG_PATHBASE.'/'.$ruta.'/'.$dir_new;
  if (is_dir($path)) {
    if (!rename ($path, $noupath)) {
      return false;
    }
  }
  else {
    if (!mkdir($noupath, $perm)) {
      return false;
    }
  }

  if(!is_dir($noupath)){
    return false;
  }
  @chmod($noupath, $perm);
  return true;
}

require_once('../php/graphic-title.inc');
require_once('../dinamiques/createxml.inc');







function din_parse_page ($dynamic_source, $row) {
  global $CONFIG_NOMCARPETA, $CONFIG_PATHBASE, $CONFIG_PATHADMIN;
  global $CONFIG_URLBASE, $CONFIG_SITENAME;
  global $CONFIG_URLUPLOAD, $CONFIG_URLUPLOADIM, $CONFIG_URLUPLOADAD;
  global $CONFIG_PATHUPLOADIM, $CONFIG_PATHUPLOADAD;
  global $CONFIG_TITOLGRAFIC;
  global $CONFIG_PATHPHP;
  global $CONFIG_PATHTEMPLATE, $CONFIG_PATHTEMPLATEDIN;

  global $SITUACIO_separador;

  if($dynamic_source == '') {
    return '';
  }


  /*eliminar comentaris*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/base/comentaris.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/base/comentaris.inc');
    $dynamic_source = comments_pages($dynamic_source);
  }

  /*afegir blocks de la pàgina*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/block/funcions.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/block/funcions.inc');
    $dynamic_source = block_pages($dynamic_source, $row['ID'], 'CARPETES');
  }

  /*afegir menus de la pàgina*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/menus/funcions.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/menus/funcions.inc');
    $dynamic_source = menu_pages($dynamic_source, $row['ID'], 'CARPETES');
  }

  /*afegir composicions de la pàgina*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/composicions/funcions.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/composicions/funcions.inc');
    $dynamic_source = composicio_pages($dynamic_source, $row['ID'], 'CARPETES');
  }

  /*afegir metas de la pàgina*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/metatags/funcions.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/metatags/funcions.inc');
    $dynamic_source = metas_pages($dynamic_source, $row['ID'], 'CARPETES');
  }

  /*afegir taula*/
  $dynamic_source = str_replace('|TAULA|', staticFolderTableName($row['ID']), $dynamic_source);

  /*afegir idioma*/
  $dynamic_source = str_replace('|IDIOMA_PAG|', $row['IDIOMA'], $dynamic_source);

  /*crear fil d'ariadna*/
  $navegasituacio = fil_ariadna_array ($row['TITOL'], $row['PARE'], $row['IDIOMA']);
  $dynamic_source = str_replace('|SITUACIO_array|', varToString($navegasituacio), $dynamic_source);

  $navegasituacio = fil_ariadna_build ($navegasituacio);
  $dynamic_source = str_replace('|SITUACIO|', $navegasituacio, $dynamic_source);

  $ruta_apartat = ruta_apartat($row['TITOL'], $row['PARE'], $row['IDIOMA']);
  $dynamic_source = str_replace('|APARTAT|', $ruta_apartat, $dynamic_source);

	$folders = folderPathArray($row['ID']);
	$folderKeys = array_keys($folders);

	for ($i = 0; $i < 10; $i++) {
		$folderName = array_shift($folders);
		$folderKey = array_shift($folderKeys);

		if ($folderName == null) {
			$folderName = '';
			$folderKey = '';
		}
		$dynamic_source = str_replace('|CARPETA_NOM_' . $i . '|', $folderName, $dynamic_source);
		$dynamic_source = str_replace('|CARPETA_ID_' . $i . '|', $folderKey, $dynamic_source);
	}



  /*crear titol imatge utilitzo la variable predeterminada |Titol Grafic| */
  if($row['TITOL']!="" && $CONFIG_TITOLGRAFIC=='1') {
    $text = 'din-title-'.$row['ID'];
    $dynamic_source = graphic_title_insert($row['TITOL'], $text, '|TITOLSECCIO|', $dynamic_source, false);
  }
  /*substituir titol si encara hi es*/
  $dynamic_source = str_replace('|TITOLSECCIO|', $row['TITOL'], $dynamic_source);

  /*afegir identificador editora*/
  $dynamic_source = str_replace('|ID_CARPETA|', $row['ID'], $dynamic_source);
  /*afegir altres textos*/
  $dynamic_source = str_replace('|SUBTITOLSECCIO|', $row['SUBTITOL'], $dynamic_source);
  $dynamic_source = str_replace('|TEXTSECCIO|', $row['APARTAT'], $dynamic_source);

  $introduccio = pageFilter($row['INTRODUCCIO']);
  $dynamic_source = str_replace('|INTRODUCCIO|', $introduccio, $dynamic_source);
  $dynamic_source = str_replace('|ORDENAPER|', $row['CATEGORY2'], $dynamic_source);



  /*afegir urls houdini*/
//  if (file_exists($CONFIG_PATHADMIN.'/moduls/base/url_page.inc')) {
//    require_once($CONFIG_PATHADMIN.'/moduls/base/url_page.inc');
//    $dynamic_source = url_filter($dynamic_source);
//  }

  /*afegir paths*/
  $dynamic_source = str_replace('|CONFIG_NOMCARPETA|', $CONFIG_NOMCARPETA, $dynamic_source);
  $dynamic_source = str_replace('|CONFIG_PATHBASE|', $CONFIG_PATHBASE, $dynamic_source);
  $dynamic_source = str_replace('|CONFIG_PATHPHP|', $CONFIG_PATHPHP, $dynamic_source);
  $dynamic_source = str_replace('|CONFIG_URLBASE|', $CONFIG_URLBASE, $dynamic_source);
  $dynamic_source = str_replace('|CONFIG_SITENAME|', $CONFIG_SITENAME, $dynamic_source);
  $dynamic_source = str_replace('|CONFIG_URLUPLOAD|', $CONFIG_URLUPLOAD, $dynamic_source);
  $dynamic_source = str_replace('|CONFIG_URLUPLOADIM|', $CONFIG_URLUPLOADIM, $dynamic_source);
  $dynamic_source = str_replace('|CONFIG_URLUPLOADAD|', $CONFIG_URLUPLOADAD, $dynamic_source);
  $dynamic_source = str_replace('|CONFIG_PATHUPLOADIM|', $CONFIG_PATHUPLOADIM, $dynamic_source);
  $dynamic_source = str_replace('|CONFIG_PATHUPLOADAD|', $CONFIG_PATHUPLOADAD, $dynamic_source);

  $dynamic_source = str_replace('|SITUACIO_SEPARADOR|', $SITUACIO_separador, $dynamic_source);

  $carpetes = folderPathArray($row['ID']);
  $carpetes = array_keys($carpetes);
  $dynamic_source = str_replace('|IDSDIRECTORIS|', implode(',',$carpetes), $dynamic_source);

  $page_url = folderPath($row['PARE']);
  if ($page_url == '') {
    $page_url = $row['NOMCARPETA'];
  }
  else {
    $page_url = $page_url.'/'.$row['NOMCARPETA'];
  }
  $page_url = str_replace('//', '/',$CONFIG_NOMCARPETA.'/'.$page_url);
  $dynamic_source = str_replace('|PAGE_URL|', $page_url, $dynamic_source);

  $dynamic_source = str_replace('|FOLDER_PATH|', str_replace('//', '/', $CONFIG_NOMCARPETA . '/' . folderPath($row['ID'])), $dynamic_source);

  /*afegir codi analytics*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/base/analytics.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/base/analytics.inc');
    $dynamic_source = analytics_pages($dynamic_source);
  }

  /*afegir variables php de la pàgina*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/base/php_vars.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/base/php_vars.inc');
    $dynamic_source = phpVars_pages($dynamic_source, $row['ID'], 'CARPETES');
  }


  return $dynamic_source;
}



function dinFolderGenerateFiles ($row) {
  global $CONFIG_NOMCARPETA, $CONFIG_PATHBASE, $CONFIG_PATHADMIN;
  global $CONFIG_URLBASE, $CONFIG_SITENAME;
  global $CONFIG_URLUPLOAD, $CONFIG_URLUPLOADIM, $CONFIG_URLUPLOADAD;
  global $CONFIG_PATHUPLOADIM, $CONFIG_PATHUPLOADAD;
  global $CONFIG_TITOLGRAFIC;
  global $CONFIG_PATHPHP;
  global $CONFIG_PATHTEMPLATE, $CONFIG_PATHTEMPLATEDIN;

  global $CONFIG_PERMFILES;
  global $SITUACIO_separador;
  global $tipusdinamiques;

  /*comprovar que hi ha plantilla assignada*/
  if (!isset($row['SKIN']) || !isset($tipusdinamiques[$row['SKIN']])) {
    return (t('folderserrortemplate'));
  }
  $template = $tipusdinamiques[$row['SKIN']];

	if (is_array($template['fitxers'])) {
		$files = $template['fitxers'];
	}
	else {
		$files = array($template['fitxers']);
	}
	/*compatibilitat amb versions antigues*/
	if (isset($template['config'])) {
		$files[] = $template['config'];
	}

	$path = $CONFIG_PATHBASE.'/'.folderPath($row['PARE']).'/'.$row['NOMCARPETA'];

	$error_copy = false;
	foreach ($files as $file) {

		$filename = $CONFIG_PATHTEMPLATEDIN.'/'.$file;
		if (!file_exists($filename)) {
			$error_copy = true;
			continue;
		}
		$fd = fopen($filename, 'r');
		$dynamic_source = fread($fd, filesize($filename));

		if (!$dynamic_source) {
			$error_copy = true;
			continue;
		}
		$dynamic_source = din_parse_page ($dynamic_source, $row);


		$filename = str_replace('-', '',strrchr($file, '-'));
		if ($filename == '') {
			$filename = $file;
		}

		$tempfilename = $CONFIG_PATHTEMPLATE.'/plantilla.html';
		$targetfilename = $path.'/'.$filename;
		$tempfile = fopen($tempfilename, 'w');
		if (!$tempfile) {
			$error_copy = true;
			continue;
		}
		fwrite($tempfile, $dynamic_source);
		fclose($tempfile);

		/*copiar pagina al desti final*/
		copy($tempfilename, $targetfilename);
		if (!empty($CONFIG_PERMFILES)) {
			chmod($targetfilename, $CONFIG_PERMFILES);
		}



	}

  /*generar xml*/
  createrss($row['ID']);


  return !$error_copy;

}

?>
