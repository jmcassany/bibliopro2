<div id="contenidor" class="crear pas2">
		<div id="cap">
			<h1>Houdini butlletins</h1>
			<ul id="principal">
				<li><a href="../campanyes/index.php" class="crear actiu">Gestionar butlletins</a></li>
				<li><a href="../contingut/index.php" class="butlletins">Gestionar contingut</a></li>
				<li><a href="../llistes/index.php" class="llistes">Llistes de subscriptors</a></li>
				<li><a href="../informes/index.php" class="informes">Informes</a></li>
			</ul>
		</div>
		<div id="contingut">
			<ul id="submenu">
			
				<li><a href="index.php">Butlletins pendents d'enviar</a></li>
				<li>Crear nou Butlletí</li>
				<li><a href="index_enviades.php">Veure els butlletins enviats</a></li>
				
			</ul>
			<ol id="passos">
				<li class="pas1"><span>Pas 1</span> Definició</li>
				<li class="pas2 actiu"><span>Pas 2</span> Contingut</li>
				<li class="pas3"><span>Pas 3</span> Destinataris</li>
				<li class="pas4"><span>Pas 4</span> Enviament</li>
			</ol>
			<form action="pas2b.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="accio" value="desar" />
			<input type="hidden" name="id" value="|ID|" />
			|T_MISSATGE|
				<h2><span>Segon pas.</span> Tipus de Contingut</h2>
				<dl>					
					
					<dt><label for="enganxar">Enganxar contingut en Text pla</label></dt>
					<dd>
						<span><input type="radio" id="enganxar" name="TIPUS" value="2" checked="checked" /></span>
						<label for="enganxeu"><span class="enganxar">Enganxeu aquí el contingut en format Text pla:</span> <textarea id="enganxeu" name="NOTES" rows="8" cols="40">|NOTES|</textarea></label>
<!--
						<br />Tags especials permesos: [[email]] [[codi]]. Exemples:
						<br /><br />&raquo; Aquest correu s'envia a [[email]]. Si no vol rebre més correus podeu &lt;a href="|WEBSITE|/news_unsubscribe.php?id=[[codi]]"&gt;donar-vos de baixa de la llista&lt;/a&gt;.
-->
					</dd>
<!--
					<dt><label for="AFEGIR1">Afegir vincle de baixa automàticament</label></dt>
					<dd>Aquesta opció afegeix automàticament un codi per donar-se de baixa de la llista de subscriptors. Si no està inclòs al disseny de la maqueta, se n’afegeix un per defecte.
						<span><input type="checkbox" id="AFEGIR1" name="AFEGIR1" |AFEGIR1| /></span>
					</dd>
-->
					<input type="hidden" id="AFEGIR1" name="AFEGIR1" |AFEGIR1| />

				</dl>
				<div id="botons">
					<a href="pas2.php?id=|ID|" class="boto anterior">Anterior</a>
					<input type="submit" value="Continuar" class="boto continuar" />
				</div>
			</form>
		</div>
	</div>


					<!-- BLOCK_BEGIN_ERROR1  -->
					<div class="missat_err">Manca triar entre importar o enganxar!</div>
					<!-- BLOCK_END_ERROR1  -->

					<!-- BLOCK_BEGIN_ERROR2  -->
					<div class="missat_err">El fitxer no es troba o està buit!</div>
					<!-- BLOCK_END_ERROR2  -->

					<!-- BLOCK_BEGIN_ERROR3  -->
					<div class="missat_err">El contingut no pot estar buit!</div>
					<!-- BLOCK_END_ERROR3  -->

					<!-- BLOCK_BEGIN_ERROR4  -->
					<div class="missat_err">Cal triar algun butlletí!</div>
					<!-- BLOCK_END_ERROR4  -->
