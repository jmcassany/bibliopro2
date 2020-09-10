<?php

	/*estils dels menús, per tal que l'usuari els seleccioni'*/
	$MENU_estiltext = array(
		'Estil defecte' => 'nav clearfix',
		'Informació' => 'information clearfix',
		'Informació (portada)' => 'frontpageInfo clearfix',
	);
	/*tipus de menú*/
	$MENU_tipus = array('Menú' => 'menu_normal', 'Desplegable' => 'menu_desplegable_hover', 'Desplegable per selecció' => 'menu_desplegable_click');

	/*activa el control d'acces a l'administració de menús'*/
	$CONFIG_MENUACCES = true;
	/*defineix la manera com s'inclouen els menús en les pàgines*/
	$CONFIG_MENUTYPE = 'php'; /*php -> s'inclou utilitzant un include php, html -> s'afegeix directament a la pàgina*/

?>
