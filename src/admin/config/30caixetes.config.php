<?php

/*activa l'utilització de logs per les caixetes*/
$CONFIG_BOXLOG = 0;

/*activar el control d'acces a l'administració de banners*/
$CONFIG_BANNERACCES = false;

/*defineix la manera com s'insertaran els banners*/
$CONFIG_BANNERTYPE = 'php'; /*php -> s'inclou utilitzant php, html -> s'afegeix directament a la pàgina*/

/*taules de les que es podrar agafar el contingut dinamic*/
$fonts_caixetes = array(
  /*array('nom'=>'menus','taula'=>'MENUS','sufix'=>'menu','path'=>$CONFIG_PATHMENU),*/
  array('nom'=>'caixetes','taula'=>'CAIXETES','sufix'=>'caix','path'=>$CONFIG_PATHBOX),
  array('nom'=>'rss','taula'=>'VIEWRSS','sufix'=>'rss','path'=>$CONFIG_PATHRSS),
  array('nom'=>'Enquestes','taula'=>'ENQUESTA','sufix'=>'enq','path'=>$CONFIG_PATHPOLL),
  array('nom'=>'Composicions','taula'=>'BANNERS','sufix'=>'banner','path'=>$CONFIG_PATHBANNER)
);


?>
