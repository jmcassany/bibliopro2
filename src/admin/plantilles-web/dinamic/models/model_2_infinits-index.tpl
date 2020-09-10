<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="|IDIOMA_PAG|" lang="|IDIOMA_PAG|">
<head>

|block-static-metas_css|

</head>
<body id="tresColumnes">
	<div id="contenidor">

		|block-static-capsalera|
		<p>Ets a: |SITUACIO| </p>
		<p>Apartat: |APARTAT| </p>
		<div id="contingut" class="clearfix">
			<div id="menuPrincipal">
				|MENUESQUERRA|

				|BANNERESQUERRA|

			</div>
			<!-- /menuPrincipal -->
			<hr/>
			<div id="contingutPrincipal" class="clearfix">
				<div id="contingutApartat">
					<h2>|TITOLSECCIO|</h2>
					<p>|SUBTITOLSECCIO|</p>
					<p>|TEXTSECCIO|</p>
					<p>|INTRODUCCIO|</p>

					<!-- llistat de categories -->
					<!-- BLOCK_BEGIN_INDEX_CATEGORIA  -->
					<h2>Llista de categories</h2>
					!NUM_SUB_CATEGORIES!
					<ul>
					<!-- BLOCK_END_INDEX_CATEGORIA  -->

					<!-- BLOCK_BEGIN_INDEX_ITEM_CATEGORIA  -->
						<li>
							!IMATGE!
							<h3><a href="index.php?CATEGORY2=!ID!">!NOM!</a></h3>
							!NUM_SUBCATEGORIES!
							!NUM_ELEMENTS!
							!DESCRIPCIO!
							<p class="mes"><a href="index.php?CATEGORY2=!ID!">Entrar <span>a la categoria !NOM!</span></a></p>
						</li>
					<!-- BLOCK_END_INDEX_ITEM_CATEGORIA  -->
					<!-- BLOCK_BEGIN_FI_INDEX_CATEGORIA  -->
					</ul>
					<!-- BLOCK_END_FI_INDEX_CATEGORIA  -->

					<!-- fi llistat de categories -->




					<!-- llistat de subcategories -->

					<!-- BLOCK_BEGIN_INDEX_SUB_CATEGORIA  -->
					<h2>Llista de subcategories</h2>
					!LINK_CATEGORIA_PARE!
					<div id="intro">
						!IMATGE!
						<h3>!NOM!</h3>
						<p>(!N_ELEMENTS!)</p>
						!DESCRIPCIO!
					</div>
					<ul>
					<!-- BLOCK_END_INDEX_SUB_CATEGORIA  -->
						<!-- BLOCK_BEGIN_INDEX_ITEM_SUB_CATEGORIA  -->
						<li class="clearfix">
							!IMATGE!
							<div class="text foto">
								<h4><a href="index.php?CATEGORY2=!ID!">!NOM!</a></h4>
								!NUM_SUBCATEGORIES!
								!NUM_ELEMENTS!
								!DESCRIPCIO!
								<p class="mes"><a href="index.php?CATEGORY2=!ID!">Entrar <span>a la galeria !NOM!</span></a></p>
							</div>
						</li>
						<!-- BLOCK_END_INDEX_ITEM_SUB_CATEGORIA  -->
					<!-- BLOCK_BEGIN_FI_INDEX_SUB_CATEGORIA  -->
					</ul>
					<!-- BLOCK_END_FI_INDEX_SUB_CATEGORIA  -->

					<!-- fi llistat de subcategories -->



					<!-- llistat de entrades -->

					<!-- BLOCK_BEGIN_INDEX_LLISTAT_INTRO_CATEGORIA  -->
					<h2>Intro categoria</h2>
					<div id="intro">
						!IMATGE!
						<h3>!NOM!</h3>
						<p>(!N_ELEMENTS!)</p>
						!DESCRIPCIO!
					</div>
					<p id="mostrant">Mostrant <strong>de !ITEMS_INICI! a !ITEMS_FI!</strong> de !ITEMS_TOTAL! entrades disponibles</p>
					<ul>
					<!-- BLOCK_END_INDEX_LLISTAT_INTRO_CATEGORIA  -->

						<!-- BLOCK_BEGIN_INDEX_LLISTAT_ROW  -->
						<li class="clearfix">
							!IMATGE1!
							<h3>!TITOL!</h3>
							!CATEGORIA!
							!CREATION!
							!RESUM!
							!MES!

						</li>
						<!-- BLOCK_END_INDEX_LLISTAT_ROW  -->
					<!-- BLOCK_BEGIN_PAGINADOR  -->
					</ul>
					<!-- paginador -->
					<div id="navegacioPagines">
						<p>!PAGEPREV!</p>
						<p id="pag">Pàg. <strong>!PAGE!</strong> de !PMAX!:</p>
						!PAGELIST!
						<p>!PAGENEXT!</p>
					</div>
					<!-- /paginador -->
					<!-- BLOCK_END_PAGINADOR  -->

					<!-- fi llistat de entrades -->
				</div>
				<div id="menuSecundari">
					|BANNERDRETA|

				</div>
			</div>
			<!-- /contingutPrincipal -->
			<hr/>
		</div>
		<!-- /contingut -->

|block-static-peu|

	</div>
</body>
</html>
