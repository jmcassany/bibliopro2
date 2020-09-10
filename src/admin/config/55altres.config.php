<?php

/*directoris amb que ha de treballar el pfb*/
$pfb_dirs = array(
'css' => array('path' => $CONFIG_PATHCSS, 'url' => $CONFIG_URLCSS, 'desc' => 'Fulls d\'estils'),
'js' => array('path' => $CONFIG_PATHJS, 'url' => $CONFIG_URLJS, 'desc' => 'Javascript'),
'plantilles' => array('path' => $CONFIG_PATHTEMPLATE, 'url' => $CONFIG_URLTEMPLATE, 'desc' => 'Plantilles'),
'imatges' => array('path' => $CONFIG_PATHCOMU, 'url' => $CONFIG_URLCOMU, 'desc' => 'Imatges')
);

/*comfiguracio de les pagines estatiques*/
$PAGE_max_textl = 10;

/*carpetes que no es poden crear*/
$FOLDER_exclude = array('/admin', '/media', '/config', '/lib', '/public');

/*configuració del registre*/
$CONFIG_registre_days = 60; /*dies que duraran les entrades*/

/*pàgina per mostrar els resultats de l'enquesta*/
$CONFIG_URLVOTA = 'result-enquesta.php';


// tipus de llistat de la pàgina d'index
$CONFIG_tipusIndex = 'arbre'; /*arbre , llista*/

/*configuració d'usuaris*/
$USERS_admin = 'admin'; //usuari que és admin total

/*permissos dels fitxers i carpetes generades per apache*/
$CONFIG_PERMFOLDERS = 0777; // 0755;
$CONFIG_PERMFILES = 0666; // 0644;


/*configuració modul analytics*/
$ANALYTICS_type = 'google-analytics'; //tipus de programa => google-analytics, piwik
$ANALYTICS_params = null;
// null -> desactiva
// google-analitics => array('tracking code')
// piwik => array('id', 'url')
$ANALYTICS_automatic = false;
// true -> afegei automaticament abans del </body>
// false -> substitueix la variable |ANALYTIC|

/*configuració modul phpvars*/
$PHPVARS_automatic = false;
// true -> afegeix automaticament el php al inici de la pàgina
// false -> substitueix la variable |PHP_VARS|

/*text que es posa als alts del pujar*/
$Pujar_alt = array('ca' => 'Pujar', 'es' => 'Subir', 'en' => 'Top', 'fr' => 'Monter');


$LANG="ESP";

?>
