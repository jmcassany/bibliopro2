|PHP_VARS|<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="|IDIOMA_PAG|" lang="|IDIOMA_PAG|">

	<head>

|block-static-metas_css|

		<script type="text/javascript" src="|CONFIG_NOMCARPETA|/media/js/jquery.colorbox.min.js"></script>

	</head>

	<body>

|block-static-header|

		<div id="menu">
|block-static-mbp|
|MENUSUPERIOR|
		</div>
		<!-- /menu -->

		<div id="page">

			<div id="content" class="clearfx">

				<div id="content_nav" class="clearfix">

					<p class="section">|APARTAT|</p>
|MENUESQUERRA|
|block-static-navInfo|

				</div>
				<!-- /content_nav -->

				<div id="content_main">

					<div class="heading"><div class="wrapper clearfix">
						<div class="breadcrumbs clearfix">|SITUACIO|</div>
						<h2><span>|TITOLSECCIO|</span></h2>
					</div></div>

					<div class="border clearfix">
						<p class="right">&laquo; <a href="!RUTA!">Volver al índice de noticias</a></p>
						!CATEGORY_DATE!
						!TITOL!
					</div>

					!IMATGE1!

					!DESCRIPCIO!

					!RELATED!

					<p class="top"><a href="#content_main">Subir</a></p>

				</div>
				<!-- /content_main -->

			</div>
			<!-- /content -->

		</div>
		<!-- /page -->

|block-static-footer|

|block-static-supporters|

	</body>

</html>