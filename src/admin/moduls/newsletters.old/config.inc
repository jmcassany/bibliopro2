<?php

	require_once($CONFIG_PATHCAMPANYES.'config_bd.inc');

	$CFG_CAMPANYES = array(
		'PATH_MAILER'   => $CONFIG_PATHCAMPANYES.'../../php/lib/phpmailer/',  // ruta relativa fins la carpeta amb funcions phpmailer
		'PATH_FUNCIONS' => $CONFIG_PATHCAMPANYES.'xin/',  // ruta relativa fins la carpeta amb funcions auxiliars
		'PATH_CHARTS' => $CONFIG_PATHCAMPANYES.'libchart-1.1/libchart/',  // ruta relativa fins la carpeta amb funcions per generar gràfics
		'PATH_CSS' => $CONFIG_PATHCAMPANYES.'media/css/',  // ruta relativa fins la carpeta amb css
		'PATH_IMG' => $CONFIG_PATHCAMPANYES.'media/comu/',  // ruta relativa fins la carpeta amb imatges

		'TIPUS_LLISTA' => array( 
			1 => "Sense confirmació", 
			2 => "Amb confirmació",
		),
		'TIPUS_SUBSCRIPTOR' => array( 
			1 => "Afegit manualment", 
			2 => "Importat d'un fitxer o d'una llista",
			3 => "Subscrit via web",
		),
		'ESTAT_SUBSCRIPTOR' => array( 
			1 => "Actiu", 
			2 => "Donat de baixa per l'administrador",
			3 => "Donat de baixa per petició pròpia",
			4 => "Pendent de confirmació",
		),
		
		'FORMAT_CAMPANYA' => array( 
			1 => "Només Html", 
			2 => "Html i Text",
			3 => "Només Text", 
		),

		'ESTAT_DESTINATARI' => array( 
			0 => "Pendent d'enviar", 
			1 => "Enviat", 
			2 => "Error d'enviament", 
			10 => "Llegit",
			21 => "Donat de baixa",
		),

		//'EMAIL_VALID' => '([a-z0-9\-\_\.]+)@([a-z0-9\-\_\.]+)',
		'EMAIL_VALID' => '^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$',
		//'EMAIL_EXTRACTOR' => "/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i",
		'EMAIL_EXTRACTOR' => "/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i",

	);

	require_once($CFG_CAMPANYES['PATH_FUNCIONS']."tipic_db.php");
	require_once($CFG_CAMPANYES['PATH_FUNCIONS']."tipic_funcions.php");


	/*if (accessGetGroup() >= 5) {  // Administradors
		$LOGIN = accessGetValue('usu_gestionat');		
		if ($LOGIN=='') {  //Si no ha triat l'usuari a gestionar
			header("Location: ".$CONFIG_PATHCAMPANYES."tria_usuari.php");
		}
	} else {*/
		$LOGIN = accessGetLogin();
	//}
	
?>