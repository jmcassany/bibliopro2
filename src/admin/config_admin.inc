<?php
error_reporting(E_ALL);

$PATHLIB = dirname(dirname(__FILE__)).'/lib';

$include_path = ini_get('include_path');

if(getenv('testserver')){
	if (substr(PHP_OS, 0, 3) == 'WIN') {
		ini_set('include_path', $include_path.';'.$PATHLIB);
	} else {
		ini_set('include_path', $include_path.':'.$PATHLIB);
	}
} else {
	if (substr(PHP_OS, 0, 3) == 'WIN') {
		ini_set('include_path', $include_path.';'.'/var/www/html/lib');
	} else {
		ini_set('include_path', $include_path.':'.'/var/www/html/lib');
	}
}

require_once("formatting.php");
require_once('configdb.php');
/*incloure configuració global*/
require_once (dirname(__FILE__).'/config.php');
/*incloure llibreria de base de dades*/
require_once ("database/database.inc");
/*incloure funcions basiques, publiques*/
require_once('funcions_base.inc');
/*incloure funcions categories*/
require_once('funcions_cat.inc');
/*incloure funcions basiques*/
require_once($CONFIG_PATHADMIN.'/php/funcions.php');
/*plantilla per errors*/
require_once($CONFIG_PATHADMIN."/php/htmlcode.inc");

if (!db_connect($db_url)) {
  htmlPageBasicError(t("db_connect_error"));
}

/*incloure gestio de permissos*/
require_once ('aw/awaccess.php');

/*arreglar problemes amb les magic quotes en el cas que no funcioni
la configuració del php o .htaccess*/
fix_gpc_magic();

/*incloure gestio idiomes*/
require_once($CONFIG_PATHADMIN.'/php/lib/lang.inc');
/*incloure gestio de registres*/
require_once ($CONFIG_PATHADMIN.'/php/register.inc');
/*incloure gestio d'usuaris*/
require_once("aw/dbusers.php");
/*incloure gestio de cards*/
require_once("aw/dbcards.php");


/*incloure functions pels carpetes*/
require_once($CONFIG_PATHADMIN.'/carpetes/funcions.inc');

/*incloure les funcions de l'editor html*/
require_once($CONFIG_PATHADMIN.'/php/lib/editor/editor.inc');

/*altres*/
require_once("aw/awtools.php");
require_once("aw/awitems.php");
/*incloure llibreries templates*/
require_once("aw/awtemplate.php");


?>
