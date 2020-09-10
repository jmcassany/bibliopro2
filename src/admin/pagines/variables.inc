<?php

require_once($CONFIG_PATHADMIN.'/php/graphic-title.inc');
require_once($CONFIG_PATHADMIN.'/php/funcions.php');



function generate_page ($row, $preview = false) {
  global $CONFIG_NOMCARPETA, $CONFIG_PATHBASE, $CONFIG_PATHADMIN;
  global $CONFIG_URLBASE, $CONFIG_SITENAME;
  global $CONFIG_URLUPLOAD, $CONFIG_URLUPLOADIM, $CONFIG_URLUPLOADAD;
  global $CONFIG_PATHUPLOADIM, $CONFIG_PATHUPLOADAD;
  global $CONFIG_TITOLGRAFIC;
  global $CONFIG_PATHPHP;
  global $CONFIG_PATHTEMPLATE, $CONFIG_PATHTEMPLATEEST;
  global $Pujar_alt;

  $pageElements = array();

  if($preview) {
    $error = t('staticpageerrorpreview');
  }
  else {
    $error = t('staticpageerrorcreate');
  }

  /*comprovar que hi ha plantilla assignada*/
  if (!isset($row['PLANTILLAID']) || $row['PLANTILLAID'] == '') {
    return ($error);
  }


  /*obtenir identificador de plantilla*/
  $result=db_query('select * from PLANTILLA, PLANTILLA_DESC where PLANTILLA.ID = PLANTILLA_DESC.PLANTILLA AND PLANTILLA.ID = \''.$row['PLANTILLAID'].'\'');
  if (db_num_rows($result) == 0) {
    return ($error);
  };
  $plantilla = db_fetch_array($result);
  db_free_result($result);


  /*llegir plantilla*/
  $filename = $CONFIG_PATHTEMPLATEEST.'/'.$plantilla['NOM'];
  if (!file_exists($filename)) {
    return ($error);
  }
  //$dynamic_source = file_get_contents($filename);
  $fd = fopen($filename, 'r');
  $dynamic_source = fread($fd, filesize($filename));

  if (!$dynamic_source) {
    return ($error);
  }

  /*eliminar comentaris*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/base/comentaris.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/base/comentaris.inc');
    $dynamic_source = comments_pages($dynamic_source);
  }

  /*afegir blocks de la pàgina*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/block/funcions.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/block/funcions.inc');
    $dynamic_source = block_pages($dynamic_source, $row['ID'], 'ESTATICA', $preview);
  }

  /*afegir menus de la pàgina*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/menus/funcions.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/menus/funcions.inc');
    $dynamic_source = menu_pages($dynamic_source, $row['ID'], 'ESTATICA', $preview);
  }

  /*afegir composicions de la pàgina*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/composicions/funcions.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/composicions/funcions.inc');
    $dynamic_source = composicio_pages($dynamic_source, $row['ID'], 'ESTATICA', $preview);
  }

  /*afegir metas de la pàgina*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/metatags/funcions.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/metatags/funcions.inc');
    $dynamic_source = metas_pages($dynamic_source, $row['ID'], 'ESTATICA', $preview);
  }

  /*afegir idioma*/
  $dynamic_source = str_replace('|IDIOMA_PAG|', $row['IDIOMA'], $dynamic_source);
  $pageElements['IDIOMA_PAG'] = $row['IDIOMA'];


  /*crear fil d'ariadna*/
  $navegasituacio = fil_ariadna ($row['DESCRIPCIO'], $row['PARE'], $row['IDIOMA']);
  $dynamic_source = str_replace('|SITUACIO|', $navegasituacio, $dynamic_source);
  $pageElements['SITUACIO'] = $navegasituacio;


  /*crear ruta de aparatat*/
  $navegarutaapartat = ruta_apartat ($row['NOMPAG'], $row['PARE'], $row['IDIOMA']);
  $dynamic_source = str_replace('|APARTAT|', $navegarutaapartat, $dynamic_source);
  $pageElements['APARTAT'] = $navegarutaapartat;


  $folders = folderPathArray($row['PARE']);
  $folderKeys = array_keys($folders);
  for($i = 0; $i < 10; $i++) {
    $folderName = array_shift($folders);
    $folderKey = array_shift($folderKeys);
    if ($folderName == null) {
      $folderName = '';
      $folderKey = '';
    }
    $dynamic_source = str_replace('|CARPETA_NOM_'.$i.'|', $folderName, $dynamic_source);
    $dynamic_source = str_replace('|CARPETA_ID_'.$i.'|', $folderKey, $dynamic_source);
  }

  /*crear titol imatge utilitzo la variable predeterminada |Titol Grafic| */
  if($plantilla['TEXTC1']=="|Titol Grafic|" && $CONFIG_TITOLGRAFIC=='1') {
    $text = 'page-title-'.$row['ID'];
    $dynamic_source = graphic_title_insert($row['TEXTC1'], $text, '|Titol Grafic|', $dynamic_source, $preview);
  }


  /*afegir text curt*/
  for($i=1;$i<=45;$i++){
    $camp='TEXTC'.$i;
    if(!isset($plantilla[$camp]) || $plantilla[$camp] == '') {
      $plantilla[$camp]='|'.$camp.'|';
    }
    $dynamic_source = str_replace($plantilla[$camp], stripslashes($row[$camp]), $dynamic_source);
    $pageElements[str_replace('|', '', $plantilla[$camp])] = $row[$camp];
  }


  /*afegir text llarg*/
  for($i=1;$i<=10;$i++){
    $camp='TEXTL'.$i;
    if(!isset($plantilla[$camp]) || $plantilla[$camp] == '') {
      $plantilla[$camp]='|'.$camp.'|';
    }
    $lText = textareaFilter($row[$camp]);
    $dynamic_source = str_replace($plantilla[$camp], $lText, $dynamic_source);
    $pageElements[str_replace('|', '', $plantilla[$camp])] = $lText;
  }


  /*afegir text alternatiu*/
  for($i=1;$i<=10;$i++){
    $camp='ALT'.$i;
    if(!isset($plantilla[$camp]) || $plantilla[$camp] == '') {
      $plantilla[$camp]='|'.$camp.'|';
    }
    $dynamic_source = str_replace($plantilla[$camp], $row[$camp], $dynamic_source);
    $pageElements[str_replace('|', '', $plantilla[$camp])] = $row[$camp];
  }


  /*afegir imatges*/
  for($i=1;$i<=20;$i++){
    $camp='IMATGE'.$i;
    if(!isset($plantilla[$camp]) || $plantilla[$camp] == '') {
      $plantilla[$camp]='|'.$camp.'|';
    }
    $img = '';
    if(isset($row[$camp]) && $row[$camp] != '') {
      $img=$CONFIG_URLUPLOADIM.'/'.$row[$camp];
    }
    $dynamic_source = str_replace($plantilla[$camp], $img, $dynamic_source);
    $pageElements[str_replace('|', '', $plantilla[$camp])] = $img;
  }


  /*afegir fitxers adjunts*/
  for($i=1;$i<=10;$i++){
    $camp='ADJUNT'.$i;
    if(!isset($plantilla[$camp]) || $plantilla[$camp] == '') {
      $plantilla[$camp]='|'.$camp.'|';
    }
    $file = '';
    if(isset($row[$camp]) && $row[$camp] != '') {
      $file=$CONFIG_URLUPLOADAD.'/'.$row[$camp];
    }
    $dynamic_source = str_replace($plantilla[$camp], $file, $dynamic_source);
    $pageElements[str_replace('|', '', $plantilla[$camp])] = $file;
  }

  /*afegir text curt*/
  for($i=1;$i<=5;$i++){
    $camp='OP'.$i;
    if ($row[$camp] == '1') {
      $pageElements[str_replace('|', '', $plantilla[$camp])] = $row[$camp];
    }
  }


  /*afegir urls houdini*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/base/url_page.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/base/url_page.inc');
    $dynamic_source = url_filter($dynamic_source);
  }

  /*posar alt a imatge pujar*/
  $dynamic_source = str_replace('|variable_pujar|', $Pujar_alt[$row['IDIOMA']], $dynamic_source);

  /*afegir paths*/
  $dynamic_source = str_replace('|CONFIG_NOMCARPETA|', $CONFIG_NOMCARPETA, $dynamic_source);
  $dynamic_source = str_replace('|CONFIG_PATHBASE|', $CONFIG_PATHBASE, $dynamic_source);
  $dynamic_source = str_replace('|CONFIG_PATHPHP|', $CONFIG_PATHPHP, $dynamic_source);
  $dynamic_source = str_replace('|CONFIG_URLBASE|', $CONFIG_URLBASE, $dynamic_source);
  $dynamic_source = str_replace('|CONFIG_SITENAME|', $CONFIG_SITENAME, $dynamic_source);


  $carpetes = folderPathArray($row['PARE']);
  $carpetes = array_keys($carpetes);
  $dynamic_source = str_replace('|IDSDIRECTORIS|', implode(',',$carpetes), $dynamic_source);


  $page_url = folderPath($row['PARE']);
  if ($page_url == '') {
    $page_url = $row['NOMPAG'];
  }
  else {
    $page_url = $page_url.'/'.$row['NOMPAG'];
  }
  $page_url = str_replace('//', '/',$CONFIG_NOMCARPETA.'/'.$page_url);
  $dynamic_source = str_replace('|PAGE_URL|', $page_url, $dynamic_source);




  $dynamic_source = issetBlockFilter ($dynamic_source, $pageElements);


  $dynamic_source = pageFilter ($dynamic_source);


  /*afegir codi analytics*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/base/analytics.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/base/analytics.inc');
    $dynamic_source = analytics_pages($dynamic_source);
  }


  /*afegir variables php de la pàgina*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/base/php_vars.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/base/php_vars.inc');
    $dynamic_source = phpVars_pages($dynamic_source, $row['ID'], 'ESTATICA', $preview);
  }



  if ($preview) {
    /*desavilitar els links*/
    $dynamic_source = str_replace('<a href="', '<a href="#', $dynamic_source);
  }

  return (array('normal' => $dynamic_source));

}



/*funcio que guarda les pàgines*/
function create_page($nom, $pare, $content) {
  global $CONFIG_PATHTEMPLATE, $CONFIG_PATHBASE;
  global $CONFIG_PERMFILES;

  $path = folderPath($pare);

  $tempfilename = $CONFIG_PATHTEMPLATE.'/plantilla.html';
  $targetfilename = $CONFIG_PATHBASE.'/'.$path.'/'.$nom;

  /*crear fitxer amb la pagina*/
  $tempfile = fopen($tempfilename, 'w');
  if (!$tempfile) {
    return(t("staticpageerrornoopen")); //impossible obrir la plantilla
  }
  fwrite($tempfile, $content);
  fclose($tempfile);

  /*copiar pagina al desti final*/
  copy($tempfilename, $targetfilename);
  if (!empty($CONFIG_PERMFILES)) {
    chmod($targetfilename, $CONFIG_PERMFILES);
  }
//  unlink ($tempfilename);
  return ('');
}




function issetBlockFilter ($content, $elements = array()) {
  $blocks = array();
  preg_match_all("@\|begin_isset\s+([^|]*?)\|(.*?)(\|else_isset\|(.*?))?\|end_isset\|@si", $content, $blocks, PREG_SET_ORDER);

  foreach ($blocks as $value) {
    if (isset($elements[$value[1]]) && $elements[$value[1]] != null && trim($elements[$value[1]]) != '') {
      //afegir block
      $content = str_replace($value[0], $value[2], $content);
    }
    else if (isset($value[4])){
      $content = str_replace($value[0], $value[4], $content);
    }
    else {
      //eliminar block
      $content = str_replace($value[0], '', $content);
    }



  }

  return $content;
}


?>
