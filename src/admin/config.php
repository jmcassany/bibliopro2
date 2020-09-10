<?php

$CONFIG_PATHADMIN =   dirname(__FILE__);

if(getenv('testserver')) {
	$CONFIG_URLADMIN = '/admin';
} else {
	$CONFIG_URLADMIN = substr(dirname(__FILE__),strlen($_SERVER['DOCUMENT_ROOT']));
}

$CONFIG_URLABSADMIN = $_SERVER['HTTP_HOST'].$CONFIG_URLADMIN;
if ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) {
  $CONFIG_URLABSADMIN = 'https://'.$CONFIG_URLABSADMIN;
}
else {
  $CONFIG_URLABSADMIN = 'http://'.$CONFIG_URLABSADMIN;
}

$CONFIG_PATHBASE = substr (dirname(__FILE__),0,-(strlen('admin/')));

/*busca el path els fitxers que acaben amb el sufix demanat, i retorna
una llista amb la ruta de tots els fitxers trobats*/
function searchFiles($sufix, $path = '') {
  $files = array();
  if ($sufix == '') {
    return array();
  }
  if (!file_exists($path)) {
    return array();
  }

  $realPath = $path;

  $current_dir = opendir($realPath);
  while($entryname = readdir($current_dir)){
     if(is_dir($path.'/'.$entryname) and ($entryname != '.' and $entryname != '..')){
       $files = array_merge($files,searchFiles($sufix, $path.'/'.$entryname));
     }elseif($entryname != '.' and $entryname!='..'){
       if (preg_match("#^([[:alnum:]]+).".$sufix.".php$#", $entryname, $reg)) {
         $files[$reg[1]] = $path.'/'.$entryname;
       }
     }
  }
  closedir($current_dir);
  sort($files);
  return ($files);
}



//require_once($CONFIG_PATHBASE.'/media/php/config.php');
/****** temporal per mirar si funciona *************/

/* exemple -> '' o /houdini */
//$CONFIG_NOMCARPETA =  '/devel-houdini/web';
if (getenv('testserver')) {
	$CONFIG_NOMCARPETA =  '';
}
else {
	$CONFIG_NOMCARPETA =  '';
}
$CONFIG_SITENAME = 'BiblioPRO';
$CONFIG_SESSIONNAME = sanitize_title($CONFIG_SITENAME);

$CONFIG_PATHBASE = substr (__FILE__,0,-(strlen('admin/config.php')));
$CONFIG_URLBASE = 'http://'.$_SERVER['SERVER_NAME'].$CONFIG_NOMCARPETA;

/*****************************************************/

$files = searchFiles('config', dirname(__FILE__).'/config');
foreach ($files as $name => $file) {
  require_once($file);
}

?>
