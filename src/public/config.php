<?php
$CONFIG_IDIOMA = 'ca'; /*falta arreglar*/
$CONFIG_PATHBASE = $_SERVER['DOCUMENT_ROOT'];

include_once $CONFIG_PATHBASE . '/config.php';
include_once $CONFIG_PATHBASE . '/lib/configdb.php';
include_once $CONFIG_PATHBASE . '/lib/aw/dbcards.php';
include_once $CONFIG_PATHBASE . '/lib/aw/awtemplate.php';

db_connect($db_url_web);

include_once $CONFIG_PATHBASE . '/admin/moduls/newsletters/config.inc';
include_once($CONFIG_PATHBASE . '/admin/moduls/newsletters/xin/cripto.inc');
include_once 'media/lang/lang_' . $CONFIG_IDIOMA . '.php';



?>