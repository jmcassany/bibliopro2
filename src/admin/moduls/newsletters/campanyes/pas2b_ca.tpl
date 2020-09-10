<div id="contenidor" class="crear pas2">
		<div id="contingut">
			<ul id="submenu">
				<li><a href="index.php">Butlletins pendents d'enviar</a></li>
				<li>Crear nou Butlletí</li>
				<li><a href="index_enviades.php">Veure els butlletins enviats</a></li>
			</ul>
<!--			<ol id="passos">-->
<!--				<li class="pas1"><span>Pas 1</span> Definició</li>-->
<!--				<li class="pas2 actiu"><span>Pas 2</span> Contingut</li>-->
<!--				<li class="pas3"><span>Pas 3</span> Destinataris</li>-->
<!--				<li class="pas4"><span>Pas 4</span> Enviament</li>-->
<!--			</ol>-->
			<form action="pas2b.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="accio" value="desar" />
			<input type="hidden" name="idCam" value="|ID|" />
			
			|T_MISSATGE|
				<h2><span>Segon pas.</span> Tipus de Contingut</h2>
				<dl>
					<dt><label for="butlleti_new">|TITOLCONFIGURARBUTLLETI| butlletí a partir d'un model</label></dt>
					<dd>|DESCRIPCONFIGURARBUTLLETI|
						<span>|RADIOCONFIGURARBUTLLETI|</span></dd>			
					
				</dl>
				
				<h3 class="opcions"><a href="javascript:toggleLayer('capaOpcions');" title="Hide the DIV">Altres opcions >></a></h3>
				<div id="capaOpcions">
				<dl class="opcions">
					<dt><label for="importar">Importar contingut</label></dt>
					<dd>Seleccioneu l’arxiu HTML que heu maquetat com a butlletí en un altre programa.
						<span><input type="radio" id="importar" name="TIPUS" value="1" |TIPUS_1| /></span>
						<label for="seleccioneu">Seleccioneu l’arxiu: <input type="file" id="seleccioneu" name="FITXER" /></label></dd>
					<dt><label for="enganxar">Enganxar contingut en HTML</label></dt>
					<dd>
						<span><input type="radio" id="enganxar" name="TIPUS" value="2" |TIPUS_2| /></span>
						<label for="enganxeu"><span class="enganxar">Enganxeu aquí el contingut en format HTML:</span> <textarea id="enganxeu" name="NOTES" rows="8" cols="40">|NOTES|</textarea></label>
<!--
						<br />Etiquetes especials permeses: [[email]] [[codi]]. Exemples:
						<br /><br />&raquo; Aquest correu s'envia a [[email]]. Si no vol rebre més correus podeu &lt;a href="|WEBSITE|/news_unsubscribe.php?id=[[codi]]"&gt;donar-vos de baixa de la llista&lt;/a&gt;.
						<br /><br />&raquo; &lt;img src="|WEBSITE|/news_imatge.php?id=[[codi]]" alt="lectura" /&gt; imatge per confirmar lectura.
-->
					</dd>
<!--
					<dt><label for="AFEGIR1">Afegir vincle de baixa automàticament</label></dt>
					<dd>Aquesta opció afegeix automàticament un codi per donar-se de baixa de la llista de subscriptors. Si no està inclòs al disseny de la maqueta, se n’afegeix un per defecte. 
						<span><input type="checkbox" id="AFEGIR1" name="AFEGIR1" |AFEGIR1| /></span>
					</dd>
					<dt><label for="AFEGIR2">Afegir codi de lectura automàticament</label></dt>
					<dd>El codi de lectura és necessàri per comprovar si el destinatari ha llegit el correu. Seleccioneu aquesta opció si voleu usar aquesta utilitat. 
						<span><input type="checkbox" id="AFEGIR2" name="AFEGIR2" |AFEGIR2| /></span>
					</dd>
-->
					<input type="hidden" id="AFEGIR1" name="AFEGIR1" |AFEGIR1| />
					<input type="hidden" id="AFEGIR2" name="AFEGIR2" |AFEGIR2| />

				</dl>
				</div>
				<div id="botons">
					<!-- <a href="pas2.php?IdCam=|ID|" class="boto anterior">Anterior</a> -->
					<a href="pas1.php?IdCam=|ID|" class="boto anterior">Anterior</a>
					<input type="submit" value="Continuar" class="boto continuar" />
				</div>
			</form>
		</div>
	</div>


					<!-- BLOCK_BEGIN_ERROR1  -->
					<div class="missat_err">Si us plau, seleccioneu una opció</div>
					<!-- BLOCK_END_ERROR1  -->

					<!-- BLOCK_BEGIN_ERROR2  -->
					<div class="missat_err">El fitxer que heu seleccionat no es troba o està buit. Si us plau, torneu-lo a seleccionar. </div>
					<!-- BLOCK_END_ERROR2  -->

					<!-- BLOCK_BEGIN_ERROR3  -->
					<div class="missat_err">El camp del contingut HTML per al butlletí està buit. Si us plau, introduïu-hi contingut</div>
					<!-- BLOCK_END_ERROR3  -->

					<!-- BLOCK_BEGIN_ERROR4  -->
					<div class="missat_err">Si us plau, seleccioneu un butlletí</div>
					<!-- BLOCK_END_ERROR4  -->
|MOSTRARALTRESOPCIONS|					
