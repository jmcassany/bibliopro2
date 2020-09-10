<?php
    require ('../../../../config_admin.inc');

$CONFIG_PATHCAMPANYES = '../../';
require_once($CONFIG_PATHCAMPANYES.'config.inc');

$LANG = "ESP";
$ITEMS['LANG']['ENG'] = array( 'ENG_English', 'ESP_Spanish', 'CAT_Catalan' );
$ITEMS['LANG']['ESP'] = array( 'ENG_Inglés', 'ESP_Español', 'CAT_Catalán' );
$ITEMS['LANG']['CAT'] = array( 'ENG_Anglès', 'ESP_Espanyol', 'CAT_Català' );



	$CONFIG_PRE_NOMCARPETA = $CONFIG_NOMCARPETA;

	$CONFIG_DOMAIN = $_SERVER['SERVER_NAME'].$CONFIG_PRE_NOMCARPETA;
	$CONFIG_NOMCARPETA =  '/public';
	$CONFIG_URLBASE = 'http://'.$CONFIG_DOMAIN.$CONFIG_NOMCARPETA;

    $CONFIG_PATHUPLOADAD = $CONFIG_PATHBASE.'/public/media/upload/noticies_newsletter/files/';
	$CONFIG_PATHUPLOADIM = $CONFIG_PATHBASE.'/public/media/upload/noticies_newsletter/imgs/';


    include_once("../../../../../public/media/php/noticies_newsletter.php");

    include_once("../../../../../public/media/lang/lang_ca.php");

    $DEFAULT_CLASS='1';
	//$CARDS_LISTFILTER = "1";
    

?>
