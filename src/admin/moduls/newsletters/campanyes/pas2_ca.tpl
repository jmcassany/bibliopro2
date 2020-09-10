	<div id="contenidor" class="crear pas2">
		<div id="contingut">
			<ul id="submenu">
				<li><a href="index.php">Butlletins pendents d'enviar</a></li>
				<li>Crear nou Butlletí</li>
				<li><a href="index_enviades.php">Veure els butlletins enviats</a></li>
				
			</ul>
			<!-- <ol id="passos">
				<li class="pas1"><span>Pas 1</span> Definició</li>
				<li class="pas2 actiu"><span>Pas 2</span> Contingut</li>
				<li class="pas3"><span>Pas 3</span> Destinataris</li>
				<li class="pas4"><span>Pas 4</span> Enviament</li>
			</ol> -->
			<form action="pas2.php" method="post">
			<input type="hidden" name="accio" value="desar" />
			<input type="hidden" name="id" value="|ID|" />
			|T_MISSATGE|
				<h2><span>Segon pas.</span> Tria del format del butlletí</h2>
				<dl>
					<dt><label for="htmltext">HTML<!-- i text senzill (opció per defecte)--></label></dt>
					<dd><!--Aquesta opció detecta automàticament quin tipus de suport té el programa de correu del receptor i li mostra l'opció correcta.-->Models ja definits en HTML
						<span><input type="radio" id="htmltext" name="TIPUS" value="2" |TIPUS_2| /></span></dd>
				</dl>

				<!-- <h3 class="opcions"><a href="javascript:toggleLayer('capaOpcions');" title="Mostrar altres opcions">Altres opcions >></a></h3> -->
				<div id="capaOpcions">
					<dl class="opcions">
						<dt><label for="html">Només HTML</label></dt>
						<dd>Permet l’ús de codi HTML i imatges.
							<span><input type="radio" id="html" name="TIPUS" value="1" |TIPUS_1| /></span></dd>
					
						<dt><label for="text">Només text senzill</label></dt>
						<dd>Aquesta opció assegura que el missatge podrà ser vist per tots els receptors i redueix la possibilitat que el butlletí sigui identificat accidentalment com a correu no desitjat.
							<span><input type="radio" id="text" name="TIPUS" value="3" |TIPUS_3| /></span></dd>
					</dl>
				</div>

				<div id="botons">
					<a href="pas1.php?id=|ID|" class="boto anterior">Anterior</a>
					<input type="submit" value="Continuar" class="boto continuar" />
				</div>
			</form>
		</div>
	</div>


					<!-- BLOCK_BEGIN_ERROR1  -->
					<div class="missat_err">Si us plau, seleccioneu un format per al butlletí</div>
					<!-- BLOCK_END_ERROR1  -->

|MOSTRARALTRESOPCIONS|					
