|PHP_VARS|<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="|IDIOMA_PAG|" lang="|IDIOMA_PAG|">

	<head>

|block-static-metas_css|

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
						<p class="rss right"><a href="!RUTA!/index.xml"><acronym title="Really Simple Sindication">RSS</acronym></a></p>
						<h2><span>|TITOLSECCIO|</span></h2>
					</div></div>

					<form action="" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
						<div class="search searchDinamic clearfix">
							<h3><span>Buscador de noticias</span></h3>
							<fieldset>
								<label for="CATEGORY2">
									<span>Categoría:</span>
									<select name="CATEGORY2" id="CATEGORY2">!OPTIONS_CATEGORIES!</select>
								</label>
								<label for="keywords">
									<span>Palabras:</span>
									<input type="text" name="keywords" id="keywords" />
								</label>
								<input type="image" src="|CONFIG_NOMCARPETA|/media/img/bt_faqs_search.png" name="searchFaqs" value="Buscar" alt="Buscar" class="searchFaqs" />
							</fieldset>
						</div>
					</form>

					!MOSTRANT!

					<ul class="listing">
<!-- BLOCK_BEGIN_ROW  -->
						<li class="element clearfix">
							!CATEGORY_DATE!
							!TITOL!
							!IMATGE1!
							!RESUM!
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

|block-static-footer|

|block-static-supporters|

	</body>

</html>