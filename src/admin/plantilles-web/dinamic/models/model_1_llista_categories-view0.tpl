<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="|IDIOMA_PAG|" lang="|IDIOMA_PAG|">
<head>

|block-static-metas_css|

</head>
<body id="tresColumnes" class="fitxa">
	<div id="contenidor">

		|block-static-capsalera|
		<p>Ets a: !SITUACIO! </p>
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
					<p id="historic"><a href="index.php">Històric</a></p>
					<form action="index.php" class="clearfix" method="get">
						<fieldset>
							<p>Llistar per categoria</p>
							!SELECT_CATEGORIES!
						</fieldset>
					</form>
					!CATEGORIA!
					!CREATION!
					<h3>!TITOL!</h3>
					!SUBTITOL!

					!IMATGE1!
					!IMATGE2!
					!IMATGE3!

					!DESCRIPCIO!

					!INFO_REL!
				</div>
				<div id="menuSecundari">
					!LLISTA_CATEGORIES!
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
