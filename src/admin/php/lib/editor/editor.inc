<?php

/*fitxer que només inclou l'editor configurar*/
/*si no hi editor configurat utilitza el una textarea*/
$CONFIG_PATHEDITOR = dirname(__FILE__).'/'.$CONFIG_EDITOR;
if (!isset($CONFIG_EDITOR) ||
   !(is_dir($CONFIG_PATHEDITOR) && file_exists($CONFIG_PATHEDITOR.'/editor.inc'))) {
  $CONFIG_EDITOR = 'textarea';
}

include_once($CONFIG_PATHEDITOR.'/editor.inc');

?>
