<?php

require_once('session.inc');

$LOGGED_IN = false;
unset($LOGGED_IN);

/*comprova que la sessio son correctes*/
function isAccessOk()
{
	global $LOGGED_IN;
	if(isset($LOGGED_IN)) {
		return $LOGGED_IN;
	}

 if(
		isset($_SESSION['access']['level'])
		&& isset($_SESSION['access']['login'])
// 		&& isset($_SESSION['access']['ip']) && $_SESSION['access']['ip'] == checkIP()
	) {
		$LOGGED_IN = true;
		return true;
	}
	else {
		$LOGGED_IN = false;
		return false;
	}
}

/*establir sessio*/
function accessLogin($level, $login)
{
	global $LOGGED_IN;
	if(empty($login)) {
		return false;
	}
	$level = (int)$level;
	unset($_SESSION['access']);
	$_SESSION['access']['login'] = $login;
	$_SESSION['access']['level'] = $level;
// 	$_SESSION['access']['ip'] = checkIP();
	$LOGGED_IN = true;
	return true;
}

/*retorna el login de l'usuari*/
function accessGetLogin() {
	if(isset($_SESSION['access']['login'])) {
		return $_SESSION['access']['login'];
	}
	return '';
}

/*retorna el grup de l'usuari*/
function accessGetGroup() {
	return $_SESSION['access']['level'];
}

/*desavilitar la sessio*/
function accessLogout()
{
	global $LOGGED_IN;
	unset ($_SESSION['access']);
	$LOGGED_IN = false;
	return true;
}

/*tractament altres elements*/
function accessSetValue($name, $value) {
	$_SESSION['access'][$name] = $value;
}
function accessGetValue($name) {
	if(isset($_SESSION['access'][$name])) {
		return $_SESSION['access'][$name];
	}
	return '';
}

function accessGetAdminGroup() {
	return 5;
}

/*******************control de grups*************************/

/*grups d'usuari*/
$group_name = array(
	0 => 'Invitat',/*usuari no validat*/
	1 => 'Intranet',/*usuari de la intranet, no de houdini*/
	2 => 'Redactor',/*usuari que només redacta continguts*/
	3 => 'Publicador',/*usuari base de houdini*/
	4 => 'Avançat',/*usuari avançat de houdini*/
	5 => 'Administrador',/*usuari administrador*/
	6 => 'Administrador local',/*usuari administrador per zones*/
	7 => 'Administrador qüestionaris publicador',/*usuari administrador qüestionaris i publicador*/
	8 => 'Administrador qüestionaris redactor',/*usuari administrador qüestionaris i redactor*/
	9 => 'Administrador pagaments',/*usuari administrador pagaments*/
);

/*taula amb els permisos de cada grup*/
/*action: read, write, publicate, delete*/
/*permisos invitat*/
/*no te permisos*/

/***************permisos usuari intranet*************/
$group_perm[1]['intranet'] = true;
/*només permisos per entrar a la intranet*/

/***************permisos usuari redactor*************/
$group_perm[2]['intranet'] = true; /*access a la intranet*/
$group_perm[2]['houdinibasic'] = true; /*access basic a houdini*/
/*permisos per carpetes*/
$group_perm[2]['folder_read'] = true; /*acces per veure les carpetes*/
$group_perm[2]['folder_edit'] = false; /*acces per editar carpetes*/
$group_perm[2]['folder_create'] = false; /*acces per crear carpetes*/
$group_perm[2]['folder_delete'] = false; /*acces per esborrar carpetes*/
/*permisos per pagines*/
$group_perm[2]['page_read'] = true; /*acces per veure les pagines*/
$group_perm[2]['page_edit'] = true; /*acces per editar pagines*/
$group_perm[2]['page_create'] = true; /*acces per crear pagines*/
/*permisos per dinamiques*/
$group_perm[2]['dinamic_read'] = true; /*acces per veure les entrades del les dinamiques*/
$group_perm[2]['dinamic_edit'] = true; /*acces per editar les entrades del les dinamiques*/
$group_perm[2]['dinamic_create'] = true; /*acces per crear les entrades del les dinamiques*/
$group_perm[2]['dinamic_category'] = false; /*acces per canviar categories*/

/***************permisos usuari publicador*************/
$group_perm[3]['intranet'] = true; /*access a la intranet*/
$group_perm[3]['houdinibasic'] = true; /*access basic a houdini*/
/*permisos per carpetes*/
$group_perm[3]['folder_read'] = true; /*acces per veure les carpetes*/
$group_perm[3]['folder_edit'] = false; /*acces per editar carpetes*/
$group_perm[3]['folder_create'] = false; /*acces per crear carpetes*/
$group_perm[3]['folder_delete'] = false; /*acces per esborrar carpetes*/
/*permisos per pagines*/
$group_perm[3]['page_read'] = true; /*acces per veure les pagines*/
$group_perm[3]['page_edit'] = true; /*acces per editar pagines*/
$group_perm[3]['page_create'] = true; /*acces per crear pagines*/
$group_perm[3]['page_delete'] = true; /*acces per esborrar pagines*/
$group_perm[3]['page_publish'] = true; /*acces per publicar pàgines*/
/*permisos per dinamiques*/
$group_perm[3]['dinamic_read'] = true; /*acces per veure les entrades del les dinamiques*/
$group_perm[3]['dinamic_edit'] = true; /*acces per editar les entrades del les dinamiques*/
$group_perm[3]['dinamic_create'] = true; /*acces per crear les entrades del les dinamiques*/
$group_perm[3]['dinamic_delete'] = true; /*acces per esborrar les entrades del les dinamiques*/
$group_perm[3]['dinamic_publish'] = true; /*acces per publicar les entrades del les dinamiques*/
$group_perm[3]['dinamic_category'] = false; /*acces per canviar categories*/
/*permisos per plantilles*/
$group_perm[3]['template_read'] = true; /*acces per veure les plantilles*/
$group_perm[3]['template_edit'] = false; /*acces per editar plantilles*/
$group_perm[3]['template_create'] = false; /*acces per crear plantilles*/
$group_perm[3]['template_delete'] = false; /*acces per esborrar plantilles*/
$group_perm[3]['template_upload'] = false; /*acces per pujar plantilles*/
/*permisos per menus*/
$group_perm[3]['menu_read'] = true; /*acces per veure els menus*/
$group_perm[3]['menu_edit'] = false; /*acces per editar menus*/
$group_perm[3]['menu_create'] = false; /*acces per crear menus*/
$group_perm[3]['menu_delete'] = false; /*acces per esborrar menus*/
$group_perm[3]['menu_publish'] = true; /*acces per publicar menus*/
$group_perm[3]['menu_entrys'] = true; /*acces per gestionar les entrades*/
/*permisos per formularis*/
$group_perm[3]['form_read'] = true; /*acces per veure els formularis*/
$group_perm[3]['form_edit'] = true; /*acces per editar formularis*/
$group_perm[3]['form_create'] = true; /*acces per crear formularis*/
$group_perm[3]['form_delete'] = true; /*acces per esborrar formularis*/
$group_perm[3]['form_publish'] = true; /*acces per publicar formularis*/
$group_perm[3]['form_entrys'] = true; /*acces per gestionar les entrades*/
/*permisos per usuaris*/
$group_perm[3]['users_read'] = false; /*acces per veure els usuaris*/
$group_perm[3]['users_edit'] = false; /*acces per editar usuaris*/
$group_perm[3]['users_create'] = false; /*acces per crear usuaris*/
$group_perm[3]['users_delete'] = false; /*acces per esborrar usuaris*/
$group_perm[3]['users_all'] = false; /*control sobre tots els usuaris*/
/*permisos per moduls*/
$group_perm[3]['composition'] = false; /*acces per veure les composicions*/
$group_perm[3]['boxes'] = false; /*acces per veure les composicions*/
$group_perm[3]['rss'] = false; /*acces per veure els rss*/
$group_perm[3]['poll'] = false; /*acces per veure les enquestes*/
$group_perm[3]['configtext'] = false;
$group_perm[3]['newsletter'] = false; /*acces per veure el newsletter*/
/*permisos per utilitats*/
$group_perm[3]['historyall'] = false; /*acces per veure l'historic de tothom*/
$group_perm[3]['backup_make'] = false; /*acces per fer backup*/
$group_perm[3]['backup_restore'] = false; /*acces per restaurar backups*/
$group_perm[3]['upload_files'] = true; /*permet pujar fitxers*/
$group_perm[3]['avanced_options'] = true; /*gestionar metadades*/

/***************permisos usuari avançat*************/
$group_perm[4]['intranet'] = true; /*access a la intranet*/
$group_perm[4]['houdinibasic'] = true; /*access basic a houdini*/
/*permisos per carpetes*/
$group_perm[4]['folder_read'] = true; /*acces per veure les carpetes*/
$group_perm[4]['folder_edit'] = true; /*acces per editar carpetes*/
$group_perm[4]['folder_create'] = true; /*acces per crear carpetes*/
$group_perm[4]['folder_delete'] = true; /*acces per esborrar carpetes*/
/*permisos per pagines*/
$group_perm[4]['page_read'] = true; /*acces per veure les pagines*/
$group_perm[4]['page_edit'] = true; /*acces per editar pagines*/
$group_perm[4]['page_create'] = true; /*acces per crear pagines*/
$group_perm[4]['page_delete'] = true; /*acces per esborrar pagines*/
$group_perm[4]['page_publish'] = true; /*acces per publicar pàgines*/
/*permisos per dinamiques*/
$group_perm[4]['dinamic_read'] = true; /*acces per veure les entrades del les dinamiques*/
$group_perm[4]['dinamic_edit'] = true; /*acces per editar les entrades del les dinamiques*/
$group_perm[4]['dinamic_create'] = true; /*acces per crear les entrades del les dinamiques*/
$group_perm[4]['dinamic_delete'] = true; /*acces per esborrar les entrades del les dinamiques*/
$group_perm[4]['dinamic_publish'] = true; /*acces per publicar les entrades del les dinamiques*/
$group_perm[4]['dinamic_category'] = true; /*acces per canviar categories*/
/*permisos per plantilles*/
$group_perm[4]['template_read'] = true; /*acces per veure les plantilles*/
$group_perm[4]['template_edit'] = true; /*acces per editar plantilles*/
$group_perm[4]['template_create'] = true; /*acces per crear plantilles*/
$group_perm[4]['template_delete'] = true; /*acces per esborrar plantilles*/
$group_perm[4]['template_upload'] = true; /*acces per pujar plantilles*/
/*permisos per menus*/
$group_perm[4]['menu_read'] = true; /*acces per veure els menus*/
$group_perm[4]['menu_edit'] = true; /*acces per editar menus*/
$group_perm[4]['menu_create'] = true; /*acces per crear menus*/
$group_perm[4]['menu_delete'] = true; /*acces per esborrar menus*/
$group_perm[4]['menu_publish'] = true; /*acces per publicar menus*/
$group_perm[4]['menu_entrys'] = true; /*acces per gestionar les entrades*/
/*permisos per formularis*/
$group_perm[4]['form_read'] = true; /*acces per veure els formularis*/
$group_perm[4]['form_edit'] = true; /*acces per editar formularis*/
$group_perm[4]['form_create'] = true; /*acces per crear formularis*/
$group_perm[4]['form_delete'] = true; /*acces per esborrar formularis*/
$group_perm[4]['form_publish'] = true; /*acces per publicar formularis*/
$group_perm[4]['form_entrys'] = true; /*acces per gestionar les entrades*/
/*permisos per usuaris*/
$group_perm[4]['users_read'] = true; /*acces per veure els usuaris*/
$group_perm[4]['users_edit'] = false; /*acces per editar usuaris*/
$group_perm[4]['users_create'] = false; /*acces per crear usuaris*/
$group_perm[4]['users_delete'] = false; /*acces per esborrar usuaris*/
$group_perm[4]['users_all'] = false; /*control sobre tots els usuaris*/
/*permisos per moduls*/
$group_perm[4]['composition'] = true; /*acces per veure les composicions*/
$group_perm[4]['boxes'] = true; /*acces per veure les composicions*/
$group_perm[4]['rss'] = true; /*acces per veure els rss*/
$group_perm[4]['poll'] = true; /*acces per veure les enquestes*/
$group_perm[4]['configtext'] = true;
$group_perm[4]['newsletter'] = false; /*acces per veure el newsletter*/
/*permisos per utilitats*/
$group_perm[4]['historyall'] = false; /*acces per veure l'historic de tothom*/
$group_perm[4]['backup_make'] = true; /*acces per fer backup*/
$group_perm[4]['backup_restore'] = false; /*acces per restaurar backups*/
$group_perm[4]['upload_files'] = true; /*permet pujar fitxers*/
$group_perm[4]['avanced_options'] = true; /*gestionar metadades*/


/***************permisos usuari admin*************/
$group_perm[5]['intranet'] = true; /*access a la intranet*/
$group_perm[5]['houdinibasic'] = true; /*access basic a houdini*/
/*permisos per carpetes*/
$group_perm[5]['folder_read'] = true; /*acces per veure les carpetes*/
$group_perm[5]['folder_edit'] = true; /*acces per editar carpetes*/
$group_perm[5]['folder_create'] = true; /*acces per crear carpetes*/
$group_perm[5]['folder_delete'] = true; /*acces per esborrar carpetes*/
/*permisos per pagines*/
$group_perm[5]['page_read'] = true; /*acces per veure les pagines*/
$group_perm[5]['page_edit'] = true; /*acces per editar pagines*/
$group_perm[5]['page_create'] = true; /*acces per crear pagines*/
$group_perm[5]['page_delete'] = true; /*acces per esborrar pagines*/
$group_perm[5]['page_publish'] = true; /*acces per publicar pàgines*/
/*permisos per dinamiques*/
$group_perm[5]['dinamic_read'] = true; /*acces per veure les entrades del les dinamiques*/
$group_perm[5]['dinamic_edit'] = true; /*acces per editar les entrades del les dinamiques*/
$group_perm[5]['dinamic_create'] = true; /*acces per crear les entrades del les dinamiques*/
$group_perm[5]['dinamic_delete'] = true; /*acces per esborrar les entrades del les dinamiques*/
$group_perm[5]['dinamic_publish'] = true; /*acces per publicar les entrades del les dinamiques*/
$group_perm[5]['dinamic_category'] = true; /*acces per canviar categories*/
/*permisos per plantilles*/
$group_perm[5]['template_read'] = true; /*acces per veure les plantilles*/
$group_perm[5]['template_edit'] = true; /*acces per editar plantilles*/
$group_perm[5]['template_create'] = true; /*acces per crear plantilles*/
$group_perm[5]['template_delete'] = true; /*acces per esborrar plantilles*/
$group_perm[5]['template_upload'] = true; /*acces per pujar plantilles*/
/*permisos per menus*/
$group_perm[5]['menu_read'] = true; /*acces per veure els menus*/
$group_perm[5]['menu_edit'] = true; /*acces per editar menus*/
$group_perm[5]['menu_create'] = true; /*acces per crear menus*/
$group_perm[5]['menu_delete'] = true; /*acces per esborrar menus*/
$group_perm[5]['menu_publish'] = true; /*acces per publicar menus*/
$group_perm[5]['menu_entrys'] = true; /*acces per gestionar les entrades*/
/*permisos per formularis*/
$group_perm[5]['form_read'] = true; /*acces per veure els formularis*/
$group_perm[5]['form_edit'] = true; /*acces per editar formularis*/
$group_perm[5]['form_create'] = true; /*acces per crear formularis*/
$group_perm[5]['form_delete'] = true; /*acces per esborrar formularis*/
$group_perm[5]['form_publish'] = true; /*acces per publicar formularis*/
$group_perm[5]['form_entrys'] = true; /*acces per gestionar les entrades*/
/*permisos per usuaris*/
$group_perm[5]['users_read'] = true; /*acces per veure els usuaris*/
$group_perm[5]['users_edit'] = true; /*acces per editar usuaris*/
$group_perm[5]['users_create'] = true; /*acces per crear usuaris*/
$group_perm[5]['users_delete'] = true; /*acces per esborrar usuaris*/
$group_perm[5]['users_all'] = true; /*control sobre tots els usuaris*/
/*permisos per moduls*/
$group_perm[5]['composition'] = true; /*acces per veure les composicions*/
$group_perm[5]['boxes'] = true; /*acces per veure les composicions*/
$group_perm[5]['rss'] = true; /*acces per veure els rss*/
$group_perm[5]['poll'] = true; /*acces per veure les enquestes*/
$group_perm[5]['configtext'] = true;
$group_perm[5]['newsletter'] = true; /*acces per veure el newsletter*/
$group_perm[5]['questionaris'] = true; /*acces per veure els qüestionaris*/
$group_perm[5]['pagaments'] = true; /*acces per veure els pagaments*/
/*permisos per utilitats*/
$group_perm[5]['historyall'] = true; /*acces per veure l'historic de tothom*/
$group_perm[5]['backup_make'] = true; /*acces per fer backup*/
$group_perm[5]['backup_restore'] = true; /*acces per restaurar backups*/
$group_perm[5]['upload_files'] = true; /*permet pujar fitxers*/
$group_perm[5]['devel_file_browser'] = true; /*permet pujar fitxers per desenvolupament*/
$group_perm[5]['avanced_options'] = true; /*gestionar metadades*/


/***************permisos usuari admin local*************/
$group_perm[6]['intranet'] = true; /*access a la intranet*/
$group_perm[6]['houdinibasic'] = true; /*access basic a houdini*/
/*permisos per carpetes*/
$group_perm[6]['folder_read'] = true; /*acces per veure les carpetes*/
$group_perm[6]['folder_edit'] = true; /*acces per editar carpetes*/
$group_perm[6]['folder_create'] = true; /*acces per crear carpetes*/
$group_perm[6]['folder_delete'] = true; /*acces per esborrar carpetes*/
/*permisos per pagines*/
$group_perm[6]['page_read'] = true; /*acces per veure les pagines*/
$group_perm[6]['page_edit'] = true; /*acces per editar pagines*/
$group_perm[6]['page_create'] = true; /*acces per crear pagines*/
$group_perm[6]['page_delete'] = true; /*acces per esborrar pagines*/
$group_perm[6]['page_publish'] = true; /*acces per publicar pàgines*/
/*permisos per dinamiques*/
$group_perm[6]['dinamic_read'] = true; /*acces per veure les entrades del les dinamiques*/
$group_perm[6]['dinamic_edit'] = true; /*acces per editar les entrades del les dinamiques*/
$group_perm[6]['dinamic_create'] = true; /*acces per crear les entrades del les dinamiques*/
$group_perm[6]['dinamic_delete'] = true; /*acces per esborrar les entrades del les dinamiques*/
$group_perm[6]['dinamic_publish'] = true; /*acces per publicar les entrades del les dinamiques*/
$group_perm[6]['dinamic_category'] = true; /*acces per canviar categories*/
/*permisos per plantilles*/
$group_perm[6]['template_read'] = true; /*acces per veure les plantilles*/
$group_perm[6]['template_edit'] = true; /*acces per editar plantilles*/
$group_perm[6]['template_create'] = true; /*acces per crear plantilles*/
$group_perm[6]['template_delete'] = true; /*acces per esborrar plantilles*/
$group_perm[6]['template_upload'] = true; /*acces per pujar plantilles*/
/*permisos per menus*/
$group_perm[6]['menu_read'] = true; /*acces per veure els menus*/
$group_perm[6]['menu_edit'] = true; /*acces per editar menus*/
$group_perm[6]['menu_create'] = true; /*acces per crear menus*/
$group_perm[6]['menu_delete'] = true; /*acces per esborrar menus*/
$group_perm[6]['menu_publish'] = true; /*acces per publicar menus*/
$group_perm[6]['menu_entrys'] = true; /*acces per gestionar les entrades*/
/*permisos per formularis*/
$group_perm[6]['form_read'] = true; /*acces per veure els formularis*/
$group_perm[6]['form_edit'] = true; /*acces per editar formularis*/
$group_perm[6]['form_create'] = true; /*acces per crear formularis*/
$group_perm[6]['form_delete'] = true; /*acces per esborrar formularis*/
$group_perm[6]['form_publish'] = true; /*acces per publicar formularis*/
$group_perm[6]['form_entrys'] = true; /*acces per gestionar les entrades*/
/*permisos per usuaris*/
$group_perm[6]['users_read'] = true; /*acces per veure els usuaris*/
$group_perm[6]['users_edit'] = true; /*acces per editar usuaris*/
$group_perm[6]['users_create'] = true; /*acces per crear usuaris*/
$group_perm[6]['users_delete'] = false; /*acces per esborrar usuaris*/
$group_perm[6]['users_all'] = false; /*control sobre tots els usuaris*/
/*permisos per moduls*/
$group_perm[6]['composition'] = true; /*acces per veure les composicions*/
$group_perm[6]['boxes'] = true; /*acces per veure les composicions*/
$group_perm[6]['rss'] = true; /*acces per veure els rss*/
$group_perm[6]['poll'] = true; /*acces per veure les enquestes*/
$group_perm[6]['configtext'] = false;
$group_perm[6]['newsletter'] = false; /*acces per veure el newsletter*/
/*permisos per utilitats*/
$group_perm[6]['historyall'] = false; /*acces per veure l'historic de tothom*/
$group_perm[6]['backup_make'] = false; /*acces per fer backup*/
$group_perm[6]['backup_restore'] = false; /*acces per restaurar backups*/
$group_perm[6]['upload_files'] = true; /*permet pujar fitxers*/
$group_perm[6]['avanced_options'] = true; /*gestionar metadades*/

/***************permisos usuari admin qüestionaris publicador*************/
$group_perm[7]['intranet'] = true; /*access a la intranet*/
$group_perm[7]['houdinibasic'] = true; /*access basic a houdini*/
/*permisos per carpetes*/
$group_perm[7]['folder_read'] = true; /*acces per veure les carpetes*/
$group_perm[7]['folder_edit'] = false; /*acces per editar carpetes*/
$group_perm[7]['folder_create'] = false; /*acces per crear carpetes*/
$group_perm[7]['folder_delete'] = false; /*acces per esborrar carpetes*/
/*permisos per pagines*/
$group_perm[7]['page_read'] = true; /*acces per veure les pagines*/
$group_perm[7]['page_edit'] = true; /*acces per editar pagines*/
$group_perm[7]['page_create'] = true; /*acces per crear pagines*/
$group_perm[7]['page_delete'] = true; /*acces per esborrar pagines*/
$group_perm[7]['page_publish'] = true; /*acces per publicar pàgines*/
/*permisos per dinamiques*/
$group_perm[7]['dinamic_read'] = true; /*acces per veure les entrades del les dinamiques*/
$group_perm[7]['dinamic_edit'] = true; /*acces per editar les entrades del les dinamiques*/
$group_perm[7]['dinamic_create'] = true; /*acces per crear les entrades del les dinamiques*/
$group_perm[7]['dinamic_delete'] = true; /*acces per esborrar les entrades del les dinamiques*/
$group_perm[7]['dinamic_publish'] = true; /*acces per publicar les entrades del les dinamiques*/
$group_perm[7]['dinamic_category'] = false; /*acces per canviar categories*/
/*permisos per plantilles*/
$group_perm[7]['template_read'] = true; /*acces per veure les plantilles*/
$group_perm[7]['template_edit'] = false; /*acces per editar plantilles*/
$group_perm[7]['template_create'] = false; /*acces per crear plantilles*/
$group_perm[7]['template_delete'] = false; /*acces per esborrar plantilles*/
$group_perm[7]['template_upload'] = false; /*acces per pujar plantilles*/
/*permisos per menus*/
$group_perm[7]['menu_read'] = true; /*acces per veure els menus*/
$group_perm[7]['menu_edit'] = false; /*acces per editar menus*/
$group_perm[7]['menu_create'] = false; /*acces per crear menus*/
$group_perm[7]['menu_delete'] = false; /*acces per esborrar menus*/
$group_perm[7]['menu_publish'] = true; /*acces per publicar menus*/
$group_perm[7]['menu_entrys'] = true; /*acces per gestionar les entrades*/
/*permisos per formularis*/
$group_perm[7]['form_read'] = true; /*acces per veure els formularis*/
$group_perm[7]['form_edit'] = true; /*acces per editar formularis*/
$group_perm[7]['form_create'] = true; /*acces per crear formularis*/
$group_perm[7]['form_delete'] = true; /*acces per esborrar formularis*/
$group_perm[7]['form_publish'] = true; /*acces per publicar formularis*/
$group_perm[7]['form_entrys'] = true; /*acces per gestionar les entrades*/
/*permisos per usuaris*/
$group_perm[7]['users_read'] = false; /*acces per veure els usuaris*/
$group_perm[7]['users_edit'] = false; /*acces per editar usuaris*/
$group_perm[7]['users_create'] = false; /*acces per crear usuaris*/
$group_perm[7]['users_delete'] = false; /*acces per esborrar usuaris*/
$group_perm[7]['users_all'] = false; /*control sobre tots els usuaris*/
/*permisos per moduls*/
$group_perm[7]['composition'] = false; /*acces per veure les composicions*/
$group_perm[7]['boxes'] = false; /*acces per veure les composicions*/
$group_perm[7]['rss'] = false; /*acces per veure els rss*/
$group_perm[7]['poll'] = false; /*acces per veure les enquestes*/
$group_perm[7]['configtext'] = false;
$group_perm[7]['newsletter'] = false; /*acces per veure el newsletter*/
$group_perm[7]['questionaris'] = false; /*acces per veure els qüestionaris*/
/*permisos per utilitats*/
$group_perm[7]['historyall'] = false; /*acces per veure l'historic de tothom*/
$group_perm[7]['backup_make'] = false; /*acces per fer backup*/
$group_perm[7]['backup_restore'] = false; /*acces per restaurar backups*/
$group_perm[7]['upload_files'] = true; /*permet pujar fitxers*/
$group_perm[7]['avanced_options'] = true; /*gestionar metadades*/

/***************permisos usuari admin qüestionaris redactor*************/
$group_perm[8]['intranet'] = true; /*access a la intranet*/
$group_perm[8]['houdinibasic'] = true; /*access basic a houdini*/
/*permisos per carpetes*/
$group_perm[8]['folder_read'] = true; /*acces per veure les carpetes*/
$group_perm[8]['folder_edit'] = false; /*acces per editar carpetes*/
$group_perm[8]['folder_create'] = false; /*acces per crear carpetes*/
$group_perm[8]['folder_delete'] = false; /*acces per esborrar carpetes*/
/*permisos per pagines*/
$group_perm[8]['page_read'] = true; /*acces per veure les pagines*/
$group_perm[8]['page_edit'] = true; /*acces per editar pagines*/
$group_perm[8]['page_create'] = true; /*acces per crear pagines*/
/*permisos per dinamiques*/
$group_perm[8]['dinamic_read'] = true; /*acces per veure les entrades del les dinamiques*/
$group_perm[8]['dinamic_edit'] = true; /*acces per editar les entrades del les dinamiques*/
$group_perm[8]['dinamic_create'] = true; /*acces per crear les entrades del les dinamiques*/
$group_perm[8]['dinamic_category'] = false; /*acces per canviar categories*/
/*permisos per moduls*/
$group_perm[8]['questionaris'] = false; /*acces per veure els qüestionaris*/

/***************permisos usuari admin pagaments*************/
$group_perm[9]['intranet'] = true; /*access a la intranet*/
$group_perm[9]['houdinibasic'] = true; /*access basic a houdini*/
/*permisos per moduls*/
$group_perm[9]['pagaments'] = true; /*acces per veure els pagaments*/


/*retorna el nom del grup passat*/
function accessGetGroupName($group) {
	global $group_name;
	return $group_name[$group];
}

/*retorna la llista de grups*/
function accessGetGroupList() {
	global $group_name;
	return $group_name;
}

/*comprova els permisos del grup, si no els compleix retorna fals*/
function accessGroupPerm($action, $group = NULL) {
	global $group_perm;
	global $USERS_admin;
	if(isAccessOK()) {
		if(!isset($group)) {
			$group = accessGetGroup();
		}
		if(accessGetLogin() == $USERS_admin) {
			return true;
		}
		else {
			if(is_array($action)) {
				foreach ($action as $value) {
					if(isset ($group_perm[$group][$value]) && $group_perm[$group][$value]) {
						return true;
					}
				}
			}
			elseif(isset ($group_perm[$group][$action]) && $group_perm[$group][$action]) {
				return true;
			}
			else {
				return false;
			}
		}
	}
	return false;
}

/*comprova els permisos del grup, si no els compleix salta a login*/
function accessGroupPermCheck($action, $login = '') {
	global $LOGIN_page;
	if(!accessGroupPerm($action)) {
		if($login == '') {
		$login = $LOGIN_page;
		}
		header("Location: $login");
		exit;
	}
}

?>
