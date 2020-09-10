<?php
require_once('/var/www/html/config.php');
$id = '14';
$idioma = 'es';
$pare = '10';
$filAriadnaArray = array(0 => array('link' => '//index.html' , 'title' => 'Portada' , 'nom' => 'Portada') , 1 => array('link' => '/informacion-patrocinio/index.html' , 'title' => 'Información para y sobre PATROCINIO' , 'nom' => 'Información para y sobre PATROCINIO') , 2 => array('link' => '' , 'title' => 'Nuestros patrocinadores' , 'nom' => 'Nuestros patrocinadores'));
$folderArray = array(10 => 'informacion-patrocinio');
$folderIds = array(0 => 10);
$folderUrl = '/informacion-patrocinio';
$pageUrl = '/informacion-patrocinio';

$nomTaula = 'editora_14'; $pageUrl = $_SERVER["REQUEST_URI"]
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

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
			<meta property="og:url" content="http://www.bibliopro.org'.$folderUrl.'/'.$row['ID'].'/'.sanitize_title($row['NOM_CAST']).'">
			<link rel="canonical" href="http://www.bibliopro.org'.$folderUrl.'/'.$row['ID'].'/'.sanitize_title($row['NOM_CAST']).'">  		
				';
			}else{
		?>
		<title>!METAS_TITLE!Nuestros patrocinadores - BiblioPRO</title>
		<meta name="description" content="Los patrocinadores de BiblioPRO" />
		<meta name="Keywords" content="patrocinadores, sponsors, bibliopro, imim, empro, BiblioPRO, patrocinio, donaciones, financiación, necesidades, actividades, patrocinadores" />
		<meta name="google-site-verification" content="q6MqBy0Joeng23ZiYqyvcmvuh1qop3DOB-W1oIlRHXE" />
		<?php
			}
		?>
		<link rel="shortcut icon" href="/media/img/favicon.ico" type="image/x-icon" />
		<link rel="start" href="http://www.bibliopro.org" title="BiblioPRO" />
		<link href="/media/css/style.css" rel="stylesheet" media="all" type="text/css" />
		<link href="/media/css/print.css" rel="stylesheet" media="print" type="text/css" />

		<script type="text/javascript">
			urlBase = '';
		</script>
		<script type="text/javascript" src="/media/js/jquery.min.js"></script>
		<script type="text/javascript" src="/media/js/base.js"></script>
		<script type="text/javascript" src="/media/js/politicacookies.js"></script>

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
$directori = '10,14';
$url = '/informacion-patrocinio/patrocinadores';
$rutaplana = ($pos = strpos('/informacion-patrocinio/patrocinadores', '?')) ? substr('/informacion-patrocinio/patrocinadores', 0, ($pos-1)) : '/informacion-patrocinio/patrocinadores';
$directoris = explode(',', $directori);
@include("/var/www/html//media/menus//menu_principal.inc")
?>
		</div>
		<!-- /menu -->

		<div id="page">

			<div id="content" class="clearfx">

				<div id="content_nav" class="clearfix">

					<p class="section">Información para y sobre PATROCINIO</p>
<?php
$directori = '10,14';
$url = '/informacion-patrocinio/patrocinadores';
$rutaplana = ($pos = strpos('/informacion-patrocinio/patrocinadores', '?')) ? substr('/informacion-patrocinio/patrocinadores', 0, ($pos-1)) : '/informacion-patrocinio/patrocinadores';
$directoris = explode(',', $directori);
@include("/var/www/html//media/menus//informacion-patrocinio.inc")
?>

					<p class="button"><a href="/buscador/">Buscar cuestionario</a></p>

				</div>
				<!-- /content_nav -->

				<div id="content_main">

					<div class="heading"><div class="wrapper clearfix">
						<div class="breadcrumbs clearfix"><a href="/index.html" title="Portada">Portada</a> > <a href="/informacion-patrocinio/index.html" title="Información para y sobre PATROCINIO">Información para y sobre PATROCINIO</a></div>
						<h2><span>Nuestros patrocinadores</span></h2>
					</div></div>

					<ul class="sponsors listing">
<!-- BLOCK_BEGIN_ROW  -->
						<li class="element clearfix">
							!IMATGE1!
							!TITOL!
							!DESCRIPCIO!
						</li>
<!-- BLOCK_END_ROW  -->
					</ul>

					!PAGELIST!

					<p class="top"><a href="#content_main">Subir</a></p>

				</div>
				<!-- /content_main -->

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