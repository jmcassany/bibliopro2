<?php

include_once($CONFIG_PATHADMIN.'/php/funcions.php');

/*busca l'idioma per mostrar la interficie d'administracio*/
function get_user_lang() {
  global $CONFIG_IDIOMA;
  global $CONFIG_PATHADMIN;
  $CONFIG_PATHADMINLANG = $CONFIG_PATHADMIN.'/lang/';

  /*obtenir llista idiomes posibles*/
  $lang_files = file_list($CONFIG_PATHADMINLANG);
  $valid_lang = array();
  foreach($lang_files as $value) {
    $valid_lang[] = substr($value,5,2);
  }

  /*obtenir llista idiomes navegador*/
//  $langs = explode(";",$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
//  $lang_browser = explode(',',array_shift($langs));
  $lang_browser = explode(",",$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
  foreach ($lang_browser as $value) {
    $lang=substr($value,0,2);
    if (!empty($lang) && in_array($lang, $valid_lang)) {
      return $lang;
    }
  }

  /*retorna valor per defecte*/
  return $CONFIG_IDIOMA;
}

/*retorna la traducció*/
function t($value) {
  global $defauld_messages, $CONFIG_IDIOMA;
  global $CONFIG_PATHADMIN;
  $CONFIG_PATHADMINLANG = $CONFIG_PATHADMIN.'/lang/';
  static $messages;

  if(!isset($messages) || count($messages) == 0) {
    $user_lang = get_user_lang();
    /*incloure el fitxer amb l'idioma per defecte, ha de contenir la traducció complerta*/
    if (file_exists($CONFIG_PATHADMINLANG.'/lang_'.$CONFIG_IDIOMA.'.inc')) {
      require_once ($CONFIG_PATHADMINLANG.'/lang_'.$CONFIG_IDIOMA.'.inc');
    }
    $files = searchFiles('lang', $CONFIG_PATHADMINLANG.'/'.$CONFIG_IDIOMA);
    foreach ($files as $name => $file) {
      require_once($file);
    }
    $defauld_messages = $messages;
    unset($messages);
    /*inloure el fitxer amb l'idioma de l'usuari*/
    if (file_exists($CONFIG_PATHADMINLANG.'/lang_'.$user_lang.'.inc')) {
      include_once($CONFIG_PATHADMINLANG.'/lang_'.$user_lang.'.inc');
    }
    $files = searchFiles('lang', $CONFIG_PATHADMINLANG.'/'.$user_lang);
    foreach ($files as $name => $file) {
      include_once($file);
    }

  }

  if (isset($messages[$value])) {
    return $messages[$value];
  }
  elseif (isset($defauld_messages[$value])) {
    return $defauld_messages[$value];
  }
  return '';
}

/*retorna l'idioma de amb que es mostren els textes*/
function get_lang() {
  global $user_lang;
  return $user_lang;
}

?>
