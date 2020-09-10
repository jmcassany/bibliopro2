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




					<!-- BLOCK_BEGIN_LLISTA_CATEGORIES  -->
					<p><a href="index.php">Realitzar una cerca</a></p>
					!LLISTA_CATEGORIES!
					<!-- BLOCK_END_LLISTA_CATEGORIES  -->




					<!-- llistat de entrades -->

					<!-- BLOCK_BEGIN_INDEX_LLISTAT_INTRO_CATEGORIA  -->
					<p id="mostrant">Mostrant <strong>de !ITEMS_INICI! a !ITEMS_FI!</strong> de !ITEMS_TOTAL! entrades disponibles</p>
					<ul class="noticies">
					<!-- BLOCK_END_INDEX_LLISTAT_INTRO_CATEGORIA  -->
						<!-- BLOCK_BEGIN_ROW  -->
						<li class="clearfix">
							!IMATGE1!
							<h3>!TITOL!</h3>
							!CATEGORIA!
							!CREATION!
							!RESUM!
							!MES!

						</li>
						<!-- BLOCK_END_ROW  -->

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

					<!-- llistat de entrades -->
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
