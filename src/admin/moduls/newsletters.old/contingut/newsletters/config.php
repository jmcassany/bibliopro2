<?php
    require_once ('../../../../config_admin.inc');

$CONFIG_PATHCAMPANYES = '../../';
require_once($CONFIG_PATHCAMPANYES.'config.inc');

$LANG = "ESP";
$ITEMS['LANG']['ENG'] = array( 'ENG_English', 'ESP_Spanish', 'CAT_Catalan' );
$ITEMS['LANG']['ESP'] = array( 'ENG_Inglés', 'ESP_Español', 'CAT_Catalán' );
$ITEMS['LANG']['CAT'] = array( 'ENG_Anglès', 'ESP_Espanyol', 'CAT_Català' );



	$CONFIG_PRE_NOMCARPETA = $CONFIG_NOMCARPETA;
	$CONFIG_NOMCARPETA2 = $CONFIG_NOMCARPETA; //x les imatges i adjunts de la editora de houdini

	$CONFIG_DOMAIN = $_SERVER['SERVER_NAME'].$CONFIG_PRE_NOMCARPETA;
	$CONFIG_NOMCARPETA =  '/public';
	$CONFIG_URLBASE = 'http://'.$CONFIG_DOMAIN.$CONFIG_NOMCARPETA;

    	$CONFIG_PATHUPLOADAD = $CONFIG_PATHBASE.'/public/media/upload/noticies_newsletter/files/';
	$CONFIG_PATHUPLOADIM = $CONFIG_PATHBASE.'/public/upload/noticies_newsletter/imgs/';
	$CONFIG_PATHUPLOADBANNER = $CONFIG_PATHBASE.'/public/media/upload/banners_newsletter/';
	$CONFIG_PATHUPLOADANUNCI = $CONFIG_PATHBASE.'/public/media/upload/peu_noticia/';

	$CONFIG_URLUPLOADAN = $CONFIG_URLBASE.'/media/upload/peu_noticia/';
	$CONFIG_URLUPLOADAD = $CONFIG_URLBASE.'/media/upload/noticies_newsletter/files/';
	$CONFIG_URLUPLOADIM = $CONFIG_URLBASE.'/media/upload/noticies_newsletter/imgs/';


    include_once("../../../../../public/media/php/newsletters.php");

    $DEFAULT_CLASS='1';

?>
