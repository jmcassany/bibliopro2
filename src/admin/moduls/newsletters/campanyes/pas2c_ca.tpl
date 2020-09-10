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
			<form action="pas2c.php" method="post">
			<input type="hidden" name="accio" value="desar" />
			<input type="hidden" name="id" value="|ID|" />
			<input type="hidden" name="idCam" value="|IDC|" />
			|T_MISSATGE|
				<h2><span>Segon pas.</span> Previsualitzar el butlletí </h2>
				
				|BOTO_PAS_SEGUENT2|
				
				<!-- <a href="mostra.php?id=|ID|" target="_blank" class="previ"><img src="../media/comu/bt_previsual.jpg" width="286" height="39" alt="Previsualitzar la meva Newsletter" /></a><br /> -->
						
				<h2>Què desitgeu fer ara?</h2>
				<dl>
					<dt><label for="rebre">Test: rebre el butlletí al vostre correu</label></dt>
					<dd>Trieu aquesta opció per fer una prova i envieu-vos el butlletí al vostre correu per comprovar que es veu correctament.
						<span><input type="radio" id="rebre" name="TIPUS" value="1" |TIPUS_1| /></span>
						<label for="EMAIL">Indiqueu l’adreça de correu: <input type="text" id="EMAIL" name="EMAIL" value="|EMAIL|" /></label>
					</dd>
					<dt><label for="canvis">Fer canvis al butlletí </label></dt>
					<dd>Aquesta opció us permet anar enrere i fer modificacions al butlletí.
						<span><input type="radio" id="canvis" name="TIPUS" value="2" |TIPUS_2| /></span></dd>
					<dt><label for="destins">Triar els destinataris que rebran el butlletí</label></dt>
					<dd>Aquesta opció us envia al pas següent, la tria de la llista de subscriptors que han de rebre el butlletí.
						<span><input type="radio" id="destins" name="TIPUS" value="3" |TIPUS_3| /></span></dd>
				</dl>
				<div id="botons">
					<a href="|enrere|" class="boto anterior">Anterior</a>
					<input type="submit" value="Continuar" class="boto continuar" />
				</div>
			</form>
		</div>
	</div>


					<!-- BLOCK_BEGIN_ERROR1  -->
					<div class="missat_err">Si us plau, seleccioneu una opció</div>
					<!-- BLOCK_END_ERROR1  -->

					<!-- BLOCK_BEGIN_ERROR2  -->
					<div class="missat_err">Si us plau, introduïu una adreça de correu per fer la prova d’enviament, o bé comproveu que l’heu escrit correctament.</div>
					<!-- BLOCK_END_ERROR2  -->

					<!-- BLOCK_BEGIN_ERROR3  -->
					<div class="missat_err">No s'ha pogut enviar el correu, si us plau torne-ho a provar més tard</div>
					<!-- BLOCK_END_ERROR3  -->

					<!-- BLOCK_BEGIN_INFO1  -->
					<div class="missat_ok"><p><strong>Informació</strong></p><br />Butlletí de test enviat correctament.</div>
					<!-- BLOCK_END_INFO1  -->
					
					
					
	<!-- BLOCK_BEGIN_BOTO_PAS2  -->
			<iframe src="|FRAME|" width="100%" height="400px" frameborder="0"></iframe>
	<!-- BLOCK_END_BOTO_PAS2  -->

