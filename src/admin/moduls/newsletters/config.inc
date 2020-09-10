<?php
$pathBase = $_SERVER['DOCUMENT_ROOT'];
require_once ($pathBase . '/admin/moduls/newsletters/media/php/funcionsbasiques.php');
require_once $pathBase . '/lib/funcions_base.inc';

$CONFIG_PATHCAMPANYES = $pathBase . '/admin/moduls/newsletters/';

$LANG = "ESP";
$ITEMS['LANG']['ENG'] = array( 'ENG_English', 'ESP_Spanish', 'CAT_Catalan' );
$ITEMS['LANG']['ESP'] = array( 'ENG_Inglés', 'ESP_Español', 'CAT_Catalán' );
$ITEMS['LANG']['CAT'] = array( 'ENG_Anglès', 'ESP_Espanyol', 'CAT_Català' );

/* Constants utilitzades a l'eina */
define('TAULA_NEWSLETTERS','newsletter_newsletter');
define('TAULA_NLTONOTICIES','newsletter_nltonoticies');
define('TAULA_NLTOBANNERS','newsletter_nltobanner');
define('TAULA_CLICSNOTICIES','newsletter_clicsnoticies');
define('TAULA_CLICSBANNERS','newsletter_clicsbanners');
define('TAULA_CAMPANYES','newsletter_campanyes');
define('TAULA_USUARIS','USERS');
define('TAULA_NOTICIESNEWSLETTER','newsletter_noticies');
define('TAULA_CAPÇALERES','newsletter_headers');
define('TAULA_BANNERS','newsletter_banners');
define('TAULA_CAIXETES','newsletter_caixes');
define('TAULA_RSS', 'newsletter_rsssources');
define('TAULA_REGISTRES_RSS', 'newsletter_rss');
define('TAULA_BLOCS','newsletter_blocs');
define('TAULA_DESTINATARIS', 'newsletter_destinataris');
define('TAULA_LLISTES', 'newsletter_llistes');
define('TAULA_SUBSCRIPTORS', 'newsletter_subscriptors');
define('TAULA_BOUNCES', 'newsletter_bounces');

$CONFIG_PRE_NOMCARPETA = $CONFIG_NOMCARPETA;
$CONFIG_NOMCARPETA2 = $CONFIG_NOMCARPETA; //x les imatges i adjunts de la editora de houdini
$CONFIG_DOMAIN = $_SERVER['SERVER_NAME'].$CONFIG_PRE_NOMCARPETA;
$CONFIG_NOMCARPETA =  '/public';
$CONFIG_URLSITE = 'http://'.$CONFIG_DOMAIN.$CONFIG_PRE_NOMCARPETA;
$CONFIG_URLBASE = 'http://'.$CONFIG_DOMAIN.$CONFIG_NOMCARPETA;
$CONFIG_URLBASE_NL = 'http://'.$CONFIG_DOMAIN.$CONFIG_NOMCARPETA;
$CONFIG_URLMEDIA = $CONFIG_URLBASE . '/media/';
$CONFIG_PATHMEDIA = $CONFIG_PATHBASE . $CONFIG_NOMCARPETA . '/media/';
$CONFIG_NLADMINURLBASE = 'http://' . $CONFIG_DOMAIN . '/admin/moduls/newsletters';
$CONFIG_NLADMINPATHBASE = $CONFIG_PATHBASE . '/admin/moduls/newsletters';
$CONFIG_PATHUPLOADAD_NL = $CONFIG_PATHMEDIA.'upload/noticies_newsletter/files/';
$CONFIG_PATHUPLOADIM_NL = $CONFIG_PATHMEDIA.'upload/noticies_newsletter/imgs/';
$CONFIG_PATHUPLOADBANNER = $CONFIG_PATHMEDIA.'upload/banners_newsletter/';
$CONFIG_PATHUPLOADANUNCI = $CONFIG_PATHMEDIA.'upload/peu_noticia/';
$CONFIG_PATHUPLOADCAPS = $CONFIG_PATHMEDIA.'upload/caps/';
$CONFIG_URLUPLOADAN = $CONFIG_URLMEDIA.'/upload/peu_noticia/';
$CONFIG_URLUPLOADAD_NL = $CONFIG_URLMEDIA.'/upload/noticies_newsletter/files/';
$CONFIG_URLUPLOADIM_NL = $CONFIG_URLMEDIA.'/upload/noticies_newsletter/imgs/';
$CONFIG_URLUPLOADCAPS = $CONFIG_URLMEDIA.'/upload/caps/';
$CONFIG_URLUPLOADBANNER = $CONFIG_URLMEDIA.'/upload/banners_newsletter/';
$CONFIG_URLBUTLLETINS = $CONFIG_URLBASE.'/butlletins/';
$CONFIG_PATHBUTLLETINS = $CONFIG_PATHBASE . $CONFIG_NOMCARPETA . '/butlletins';

require_once($CONFIG_PATHCAMPANYES.'config_bd.inc');
require_once ($CONFIG_PATHBASE . '/public/media/lang/lang_ca.php');

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
		'EMAIL_VALID' => '#^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$#i',
//'EMAIL_EXTRACTOR' => "/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i",
		'EMAIL_EXTRACTOR' => "#[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,4}#i",

);

$CONFIG_editoresNL = array(
0 => array('nom' => 'Notícies', 'valor' => 'noticies', 'id' => ''),
1 => array('nom' => 'Banners', 'valor' => 'galeries', 'id' => ''),
2 => array('nom' => 'Caixes', 'valor' => 'caixes', 'id' => ''),
3 => array('nom' => 'Notícias Houdini(Castellà)', 'valor' => 'noticies-houdini', 'id' => '7')
//7 => array('nom' => 'Bloc', 'valor' => 'blog', 'id' => ''),
//8 => array('nom' => 'Origen RSS', 'valor' => 'rss', 'id' => '')
);

$origensRSS = origensRSS(); 
if(isset($origensRSS[0]) && !empty($origensRSS[0])){
    $CONFIG_editoresNL = array_merge($CONFIG_editoresNL, $origensRSS);
}

$CONFIG_estilsCaixa = array(
0 => array('nom' => 'normal', 'valor' => 'Normal'),
1 => array('nom' => 'highlighted', 'valor' => 'Destacat')
);

$CONFIG_estilsLlistat = array(
0 => array('nom' => 'normal', 'valor' => 'Files'),
1 => array('nom' => 'double', 'valor' => 'Columnes')
);

$CONFIG_estilsElement = array(
0 => array('nom' => 'normal', 'valor' => 'Normal'),
1 => array('nom' => 'highlighted', 'valor' => 'Destacat')
);

$default['path'] = 'default';
$default['cap'] = 'capsal_newsletter3.jpg';
$default['idioma'] = 'es';
$default['email'] = 'bibliopro@bibliopro.org';
$default['from_name_es'] = 'BiblioPro Newsletter';
$default['from_name_ca'] = 'BiblioPro Newsletter';

/* Configuració dels models de butlletis */
$MODELS[0] = array(
       'id_model' => 0,                                     // ID del model  
       'nom' => 'Butlletí BiblioPro',                       // Nom del model
       'idioma' => 'es',                                    // Idioma del butlletí TODO: Aplicar idioma a tots els aprtats 
       'format_data' => '%A, %d de %B de %Y',               // Format de la data que apareixerà al butlletí
       'llistaSubscriptorsNovesAltes'=> 9,                  // Llista de subscriptors a la que es donen d'alta els usuaris d'aquest tipus de bloc
       'width_imatges_llistat' => '150px',                  // Mida de les imatges en el llistat
       'prefix_imatges_llistat' => 'p',                     // Prefix de les imatges en el llistat p = 150px
       'width_imatges_fitxa' => '300px',                    // Mida de les imatges a la fitxa
       'width_text_fitxa' => '400px',                       // Mida de la caixa de text a la fitxa
       'estils_noticia_destacats' => 'background-color:#FDD1A1',    // Estils de les caixes quan es marquen en destacat 
       'destacats' => true,                                 // Es poden destacar blocs i notícies
       'filescolumnes' => true,                             // Es pot canviar el mode a files / columnes
       'num_apartats' => 2,                                 // Número de blocs que té el model de butlletí  
       'continguts_apartats' => array('editora','banners i caixetes'),  // Continguts dels blocs del butlletí 
       'configuracio_apartats' => array('left','right')); //Definim la composició de les caixes: dreta, centre ='' o esquerra

/* Configuració dels models de butlletis */
$MODELS[1] = array(
       'id_model' => 1,                                         // ID del model  
       'nom' => 'Comunicats',                                   // Nom del model
       'idioma' => 'es',                                        // Idioma del butlletí TODO: Aplicar idioma a tots els aprtats 
       'format_data' => '%A, %d de %B de %Y',                   // Format de la data que apareixerà al butlletí
       'llistaSubscriptorsNovesAltes'=> 9,                      // Llista de subscriptors a la que es donen d'alta els usuaris d'aquest tipus de bloc
       'width_imatges_llistat' => '150px',                      // Mida de les imatges en el llistat
       'prefix_imatges_llistat' => 'p',                         // Prefix de les imatges en el llistat p = 150px
       'width_imatges_fitxa' => '300px',                        // Mida de les imatges a la fitxa
       'width_text_fitxa' => '400px',                           // Mida de la caixa de text a la fitxa
       'estils_noticia_destacats' => 'background-color:#FDD1A1',    // Estils de les caixes quan es marquen en destacat 
       'destacats' => false,                                    // Es poden destacar blocs i notícies
       'filescolumnes' => false,                                // Es pot canviar el mode a files / columnes
       'num_apartats' => 1,                                     // Número de blocs que té el model de butlletí  
       'continguts_apartats' => array('editora'),               // Continguts dels blocs del butlletí 
       'configuracio_apartats' => array('')); //Definim la composició de les caixes: dreta, centre ='' o esquerra

$MODELS[2] = array(
       'id_model' => 2,                                         // ID del model  
       'nom' => 'Comunicats (Sense peu ni capçalera)',          // Nom del model
       'idioma' => 'es',                                        // Idioma del butlletí TODO: Aplicar idioma a tots els aprtats 
       'format_data' => '%A, %d de %B de %Y',                   // Format de la data que apareixerà al butlletí
       'llistaSubscriptorsNovesAltes'=> 9,                      // Llista de subscriptors a la que es donen d'alta els usuaris d'aquest tipus de bloc
       'width_imatges_llistat' => '150px',                      // Mida de les imatges en el llistat
       'prefix_imatges_llistat' => 'p',                         // Prefix de les imatges en el llistat p = 150px
       'width_imatges_fitxa' => '300px',                        // Mida de les imatges a la fitxa
       'width_text_fitxa' => '400px',                           // Mida de la caixa de text a la fitxa
       'estils_noticia_destacats' => 'background-color:#FDD1A1',    // Estils de les caixes quan es marquen en destacat 
       'destacats' => false,                                    // Es poden destacar blocs i notícies
       'filescolumnes' => false,                                // Es pot canviar el mode a files / columnes
       'num_apartats' => 1,                                     // Número de blocs que té el model de butlletí  
       'continguts_apartats' => array('editora'),               // Continguts dels blocs del butlletí 
       'configuracio_apartats' => array('')); //Definim la composició de les caixes: dreta, centre ='' o esquerra

require_once($CFG_CAMPANYES['PATH_FUNCIONS']."tipic_db.php");
require_once($CFG_CAMPANYES['PATH_FUNCIONS']."tipic_funcions.php");

$curbutlletins = '';
$curcontingut = '';
$cursubscriptors = '';
$curinformes = '';
$curconfig = '';
$elementsCaixa = '';
$elementsCaixa2 = '';
$estilsCaixa = '';
$estilsCaixa2 = '';
$elementsLlistat = '';
$elementsLlistat2 = '';
$estilsLlistat = '';
$estilsLlistat2 = '';
$elementsElement = '';
$elementsElement2 = '';
$estilsElement = '';
$estilsElement2 = '';

if(!getenv('testserver')){
    $mail_sendtype = 'smtp';
    $mail_defaultFrom = 'noreply@bibliopro.cat';
    $mail_encode = 'utf-8';
    $mail_port = '587';
    $mail_host = 'smtp.mailgun.org';
    $mail_SMTPAuth = false;
    $mail_username = 'postmaster@bibliopro.org';
    $mail_password = '32adce013f0993ed79a9e12caa949c7d';
}
?>