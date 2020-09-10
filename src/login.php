<?php

	function login ($error, $url) {

		global $CONFIG_SITENAME, $CONFIG_URLADMIN;

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Script-Type" content="text/javascript" />
		<meta http-equiv="Content-Style-Type" content="text/css" />

		<meta name="author" content="Can Antaviana" />
		<meta name="Copyright" content="BiblioPRO" />
		<?php
			require_once ("funcions_base.inc");
			require_once ("formatting.php");
			if(isset($pageUrl) && $pageUrl=="/buscador/ver.html"){
				echo '<title>'.htmlspecialchars($row['SIGLAS']).' - '.htmlspecialchars($row['NOM_CAST']).' - BiblioPRO</title>
			<meta name="description" content="'.htmlspecialchars($row['NOM_ORIGINAL']).' - Versión en español" />
			<meta name="Keywords" content="'.htmlspecialchars($row['PALABRAS_CLAVE']).','.htmlspecialchars($row['SIGLAS']).'" />
			<meta property="og:locale" content="es_ES" />
			<meta property="og:title" content="'.htmlspecialchars($row['SIGLAS']).' - '.htmlspecialchars($row['NOM_CAST']).' - BiblioPRO"/>
			<meta property="og:description" content="'.htmlspecialchars($row['NOM_ORIGINAL']).' - Versión en español"/>			
			<meta property="og:site_name" content="BiblioPRO" />
			<meta property="og:url" content="http://bibliopro.org'.$folderUrl.'/'.$row['ID'].'/'.sanitize_title($row['NOM_CAST']).'">
			<link rel="canonical" href="http://bibliopro.org'.$folderUrl.'/'.$row['ID'].'/'.sanitize_title($row['NOM_CAST']).'">  		
				';
			}else{
		?>
		<title>Identificación - BiblioPRO</title>
		<meta name="description" content="Identificación en BiblioPRO" />
		<meta name="Keywords" content="" />
		<meta name="google-site-verification" content="q6MqBy0Joeng23ZiYqyvcmvuh1qop3DOB-W1oIlRHXE" />
		<?php
			}
		?>
		<link rel="shortcut icon" href="/media/img/favicon.ico" type="image/x-icon" />
		<link rel="start" href="http://bibliopro.org" title="BiblioPRO" />
		<link href="/media/css/style.css" rel="stylesheet" media="all" type="text/css" />
		<link href="/media/css/print.css" rel="stylesheet" media="print" type="text/css" />

		<script type="text/javascript">
			urlBase = '';
		</script>
		<script type="text/javascript" src="/media/js/jquery.min.js"></script>
		<script type="text/javascript" src="/media/js/base.js"></script>

<?php

	if (!getenv('testserver')) {

?>
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-1194516-2']);
			_gaq.push(['_trackPageview']);
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
<?php

	}

?>

		<script src="/media/js/jquery.validate.min.js" type="text/javascript"></script>
		<script src="/media/js/jquery.validate.messages_es.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#loginForm').validate();
			});
		</script>

	</head>

	<body>

		<div id="acc">
			<ul>
				<li><a href="#menu">Acceso directo al menú</a></li>
				<li><a href="#content_main" accesskey="S">Acceso directo al contenido</a></li>
				<li><a href="#content_sub">Acceso directo al subcontenido</a></li>
			</ul>
		</div>
		<!-- /acc -->

<?php

	if (!is_callable('accessGetLogin') or accessGetLogin() == '') {

?>
		<form action="/login.php" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
			<div id="loginContainer">
				<label for="username">
					<span>Usuario:</span>
					<input type="text" name="LOGIN" id="username" />
				</label>
				<label for="pwd">
					<span>Contraseña:</span>
					<input type="password" name="PASSWD" id="pwd" />
				</label>
				<input type="hidden" name="url" id="url" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" />
				<div><input type="submit" value="Entrar" name="action" id="action" class="send" /></div>
				<div><a href="/contrasena-olvidada.html">¿Contraseña olvidada?</a></div>
			</div>
			<!-- /loginContainer -->
		</form>
<?php

	}

?>

		<div id="header"><div class="wrapper clearfix">
			<h1><a href="/" accesskey="1"><span>BiblioPRO</span></a></h1>
			<div class="identification">
				<div class="options"><div class="b"><div class="l"><div class="r"><div class="tl"><div class="tr"><div class="bl"><div class="br clearfix">
					<ul class="clearfix">
<?php

	if (!is_callable('accessGetLogin') or accessGetLogin() == '') {

?>
						<li class="login"><a href="#loginContainer" class="toggleLoginContainer">Login</a></li>
						<li class="register last"><a href="/registro-usuario.html">Registro</a></li>
<?php

	}
	else {

		$logoutPrefix = strpos($_SERVER['REQUEST_URI'], '?') ? '&amp;' : '?';

?>
						<li class="login"><strong><?php echo accessGetValue('USER_NAME'); ?></strong></li>
						<li class="register last"><a href="<?php echo $_SERVER['REQUEST_URI'] . $logoutPrefix; ?>logout">Desconectar</a></li>
<?php

	}

?>
					</ul>
				</div></div></div></div></div></div></div></div>
			</div>
			<!-- /identification -->
			<ul class="logos">
				<li><a href="http://www.imim.es"><img src="/media/img/logo_imim.jpg" alt="IMIM" id="header-imim" /></a></li>
				<li><a href="http://www.ciberesp.es/"><img src="/media/img/logo-ciberesp.jpg" alt="Ciber - Epidemiología y Salud Pública" /></a></li>
			</ul>
		</div></div>
		<!-- /header -->

		<div id="menu">
<?php

	if (accessGetLogin() != '') {

		$link = '/mbp';

?>
			<ul class="right">
<?php

	if (strpos($_SERVER['REQUEST_URI'], $link) !== false) {

?>
				<li class="current"><a href="<?php echo $link; ?>">Mi BiblioPRO</a></li>
<?php

	}
	else {

?>
				<li><a href="<?php echo $link; ?>">Mi BiblioPRO</a></li>
<?php

	}

?>
			</ul>
<?php

	}

?>
<?php
$directori = '';
$url = '/login.php';
$rutaplana = ($pos = strpos('/login.php', '?')) ? substr('/login.php', 0, ($pos-1)) : '/login.php';
$directoris = explode(',', $directori);
@include("/var/www/html//media/menus//menu_principal.inc")
?>
		</div>
		<!-- /menu -->

		<div id="page">

			<div id="content" class="clearfx">

				<h2>Identificación</h2>

<?php

	// si l'usuari no està identificat, mostrem formulari
	if (!is_callable('accessGetLogin') or accessGetLogin() == '') {

		if ($error) {

?>
					<div class="error">
						<h4>Error en los datos</h4>
						<p>El correo electrónico o la contraseña introducidos no son válidos.</p>
					</div>
<?php

		}

?>

				<form action="/login.php" method="post" enctype="multipart/form-data" accept-charset="UTF-8" id="loginForm">
					<fieldset>
						 <label for="login"><span>Correo electrónico</span>
							<input type="text" name="LOGIN" id="login" value="" class="formulari normal required"  />
						 </label>
						 <label for="passwd"><span>Contraseña</span>
							<input type="password" name="PASSWD" id="passwd" value="" class="formulari required"  />
						 </label>
					</fieldset>
					<input type="hidden" name="url" id="url" value="<?php echo $url ?>" />
					<input type="submit" name="action" id="action" value="Entrar" class="send" />
				</form>

<?php

	}
	// si l'usuari ja està identificat, l'informem
	else {

?>
				<div class="ok">
					<h4>Ya identificado</h4>
					<p>Ya estás identificado en BiblioPRO como <strong><?php echo accessGetValue('USER_NAME'); ?></strong>.</p>
				</div>
<?php

	}

?>

			</div>
			<!-- /content -->

		</div>
		<!-- /page -->

		<div id="footer">
			<ul class="clearfix">
				<li><a href="/avisos-legales.html">Avisos legales</a></li>
				<li><a href="/accesibilidad.html">Accesibilidad</a></li>
				<li><a href="/servicios/preguntas-frecuentes">Preguntas frecuentes</a></li>
				<li><a href="/contacto.html">Contacto</a></li>
			</ul>
		</div>

		<div id="supporters"><div class="wrapper clearfix">
			<div class="clearfix">
				<div class="institutional left">
					<ul>
						<li><a href="http://www.mineco.es" rel="external"><img src="/media/img/logo_ministerio_economia_competitividad.jpg" alt="Ministerio de Economía y Competitividad. Gobierno de España" /></a></li>
						<li><a href="http://europa.eu/legislation_summaries/employment_and_social_policy/job_creation_measures/l60015_es.htm" rel="external"><img src="/media/img/logo_ue.jpg" alt="Fondo Europeo de Desarrollo Regional" /></a></li>
						<li class="nomargin"><a href="http://www.isciii.es" rel="external"><img src="/media/img/logo_salud_carlos_3.jpg" alt="Instituto de Salud Carlos III" /></a></li>
						<li class="text"><a href="http://europa.eu/legislation_summaries/employment_and_social_policy/job_creation_measures/l60015_es.htm" rel="external"><img src="/media/img/logo_ue_texto.jpg" alt="Fondo Europeo de Desarrollo Regional. Una manera de hacer Europa" /></a></li>
					</ul>
				</div>
				<div class="disclaimer right">
					<p>Acción de Soporte a la Investigación y de Transferencia del CIBER en Epidemiología y Salud Pública (CIBERESP), dirigida y desarrollada por el Grupo de investigación en Servicios Sanitarios del IMIM-Hospital del Mar, con el apoyo de la Fundación IMIM.</p>
					<p>© Todos los derechos reservados</p>
				</div>
			</div>
			<div class="entities clearfix">
				<?php @include("/var/www/html//media/caixetes//logos-peu.inc") ?>
			</div>
		</div></div>

	</body>

</html>
<?php

	}

	/*incloure configuració global*/
	require_once ('/var/www/html//media/php/config.php');
	/*incloure llibreria de base de dades*/
	require_once ("database/database.inc");
	/*connectar amb la db*/
	db_connect($db_url_web);
	/*incloure gestio de permissos*/
	require_once ('aw/awaccess.php');
	/*incloure gestio d'usuaris*/
	require_once("aw/dbusers.php");
	/*altres*/
	require_once("aw/awtools.php");
	require_once("aw/awitems.php");

	/*obte els parametres*/

	$url = '';
	if (!empty($_POST['url'])) {
		$url = $_POST['url'];
	}
	else if (!empty($_GET['url'])) {
		$url = $_GET['url'];
	}

	$action = '';
	if (!empty($_POST['action'])) {
		$action = $_POST['action'];
	}
	else if (!empty($_GET['action'])) {
		$action = $_GET['action'];
	}

	/*sortir de sistema*/
	if ($action == 'logout') {
		accessLogout();
		login(0,'');
		exit;
	}

	/*cap acció, mostrar fromulari d'entrada*/
	if ($action != 'Entrar') {
		login(0, $url);
		exit;
	}

	/*no hi ha login o password, mostrar formulari*/
	if ((empty($_POST['LOGIN'])) || (empty($_POST['PASSWD'])) ) {
		login(1, $url);
		exit;
	}

	$LOGIN = $_POST['LOGIN'];
	$PASSWD = $_POST['PASSWD'];

	/*començar validació*/
	$Users = new dbUsers();
	if (!$Users->Ok) {
		exit;
	}

	/*obtenir les dades de l'usuari*/
	$user = $Users->readUser($LOGIN);
	if (!$user) {
		/*usuari no existeix*/
		login(1, $url);
		exit;
	}
	if ($ldap_active) {
		$value = $user['cn'];
	}
	else {
		$value = $LOGIN;
	}

	if (!$Users->validateUser($value, $PASSWD)) {
		/*usuari no existeix*/
		login(1, $url);
		exit;
	}

	$group = strip_tags($user['USERLEVEL']);
	// $PASSWDOK = strip_tags($user['PASSWD']);
	$STATUS = strip_tags($user['STATUS']);
	$EXPIRATION = strip_tags($user['EXPIRATION']);
	$LOGIN = strip_tags($user['LOGIN']);
	$EMAIL = strip_tags($user['EMAIL']);
	$REALNAME = strip_tags($user['REALNAME']);
	/* Si està inactiu el fem fora, si està actiu o en espera pot entrar. */
	if ($STATUS=='1') {
		accessLogout(); // per si un cas no era ell
		login(1, $url);
		exit;
	}
	/* Si està caducat el fem fora */
	$limit=TOOLS_TimestampToInt($EXPIRATION);
	$now=TOOLS_TimestampToInt(TOOLS_GetTimestamp());
	if ($limit!=0 && $now>$limit) {
		accessLogout(); // per si un cas no era ell
		login(1, $url);
		exit;
	}

	// validem l'usuari i n'indiquem la informació
	accessLogin($group, $LOGIN);
	accessSetValue('USER_EMAIL', $EMAIL);
	accessSetValue('USER_NAME', $REALNAME);

	if (!empty($url) and strpos($url, 'login.php') === false) {
		header('Location: ' . str_replace('?logout', '', str_replace('&logout', '', $url)));
	}
	else {
		header('Location: /mbp');
	}

?>