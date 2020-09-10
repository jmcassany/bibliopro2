<?php

/*editor a usar valor: textarea, fckeditor, tinymce*/
$CONFIG_EDITOR = 'fckeditor';

/*configuració editor*/
/*classes dels ul que mostrarà l'editor  (nom => classe)*/
$EDITOR_ulclass = array(
'Llista de dues columnes' => 'duesCol clearfix',
'Llista caixa opcions' => 'llista_caixa',
'Llista amb fons de color' => 'llista_fons',
'Llista amb separadors' => 'llista_separadors',
//'Llista amb imatge a l\'esquerra' => 'txtImgEsq',
'Llista de continuació d\'imatge esquerra' => 'txtImgEsqCont',
//'Llista amb imatge a la dreta' => 'txtImgDr',
'Llista de continuació d\'imatge dreta' => 'txtImgDrCont'
);
/*classes dels ol que mostrarà l'editor  (nom => classe)*/
$EDITOR_olclass = array(
'Llista de dues columnes' => 'duesCol clearfix',
'Llista caixa opcions' => 'llista_caixa',
'Llista amb fons de color' => 'llista_fons',
'Llista amb separadors' => 'llista_separadors',
//'Llista amb imatge a l\'esquerra' => 'txtImgEsq',
'Llista de continuació d\'imatge esquerra' => 'txtImgEsqCont',
//'Llista amb imatge a la dreta' => 'txtImgDr',
'Llista de continuació d\'imatge dreta' => 'txtImgDrCont'
);

/*classes dels p que mostrarà l'editor  (nom => classe)*/
$EDITOR_pclass = array(
'Paràgraf amb pic decoratiu' => 'primer',
'Paràgraf de text destacat' => 'destacat',
'Paràgraf destacat a la dreta' => 'destacat destacatDre',
'Paràgraf destacat a l\'esquerra' => 'destacat destacatEsq',
'Paràgraf amb separador inferior' => 'linia',
'Paràgraf amb imatge a l\'esquerra' => 'txtImgEsq',
'Paràgraf amb imatge a la dreta' => 'txtImgDr',
);

/*classes dels h3 que mostrarà l'editor  (nom => classe)*/
$EDITOR_h3class = array(
	'títol amb klander i línia discontinua' => 'ancora'
);

/*classes dels h4 que mostrarà l'editor  (nom => classe)*/
$EDITOR_h4class = array(
	'títol amb klander i línia discontinua' => 'ancora'
);

/*classes dels h5 que mostrarà l'editor  (nom => classe)*/
$EDITOR_h5class = array(
	'títol amb klander i línia discontinua' => 'ancora'
);

/*classes dels h6 que mostrarà l'editor  (nom => classe)*/
$EDITOR_h6class = array(
	'títol amb klander i línia discontinua' => 'ancora'
);


/*classes dels li que mostrarà l'editor  (nom => classe)*/
$EDITOR_liclass = array(
'Títol caixa opcions' => 'caixaTitol'
);

/*elements que es poden insertar des de l'editor (nom => html)*/
$EDITOR_elements = array(
'Pujar' => '<p class="top"><a href="#content">Subir</a></p>'
);

/*no funciona*/
/*$EDITOR_estils = array(
array('nom' => 'h1', 'element' => 'h1', 'opcions' => array('hola'=>'adeu', 'hola2'=>'adeu'))
);*/

$EDITOR_formats = array('p', 'h3', 'h4', 'h5', 'h6');

?>
