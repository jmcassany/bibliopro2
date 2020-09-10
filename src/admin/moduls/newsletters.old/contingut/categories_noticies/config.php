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


    include_once("../../../../../public/media/php/categories_noticies.php");

    $DEFAULT_CLASS='1';
	//$CARDS_LISTFILTER = "1";

?>
