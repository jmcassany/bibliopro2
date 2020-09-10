<?php

	/*registre de les plantilles per les editores*/
	//cada entrada és una editora
	// id => array('nom' => 'Nom de l'editora', 'fitxers' => array amb tots els fitxers a copiar[, 'imageSizes' => info])
	// imageSizes - opcional, informació sobre les diverses mides d'imatges que es generaran
	//              array(array('size' => mida, 'prefix' => prefix), array......)

	// la opció 'config' està desaconsellada, el fitxer que si posi tindrà el mateix comportament que els altres
	// si el nom comença per carpeta/, el fitxer és buscarà en la carpeta indicado, peró l'editora creado no tindrà questa carpeta
	// els nom dels fitxer poden començar per prefix-, que s'eliminara en el moment de crear l'editora
	$tipusdinamiques=array(
	  0 => array(
			'nom' => 'Notícies',
			'fitxers' => array('config.inc', 'noticies-index.tpl', 'noticies-index.php', 'noticies-view.php', 'noticies-view0.tpl', '.htaccess'),
			'imageSizes' => array(array('size' => 120, 'prefix' => 'thumb-'), array('size' => 240, 'prefix' => 'med-'),  array('size' => 800, 'prefix' => '')),
		),
	  1 => array(
			'nom' => 'Comité',
			'fitxers' => array('comite-config.inc', 'comite-index.tpl', 'comite-index.php', 'comite-view.php', 'comite-view0.tpl', '.htaccess'),
			'imageSizes' => array(array('size' => 98, 'prefix' => 'thumb-'), array('size' => 130, 'prefix' => 'logo-'),  array('size' => 800, 'prefix' => '')),
		),
		2 => array(
			'nom' => 'Faqs',
			'fitxers' => array('config.inc', 'faqs-index.tpl', 'faqs-index.php', 'faqs-view.php', 'faqs-view0.tpl', '.htaccess'),
		),
		3 => array(
			'nom' => 'Patrocinadors',
			'fitxers' => array('config.inc', 'patro-index.tpl', 'patro-index.php', 'patro-view.php', 'patro-view0.tpl', '.htaccess'),
			'imageSizes' => array(array('size' => 676, 'prefix' => 'thumb-')),
		),
	);

	$dinamiques_imageSizes = array(array('size' => 800, 'prefix' => ''), array('size' => 140, 'prefix' => 'thumb-'));

?>