<div id="contenidor" class="crear pas4">
		<div id="contingut">
			<ul id="submenu">
				<li><a href="index.php">Butlletins pendents d'enviar</a></li>
				<li>Crear nou Butlletí</li>
				<li><a href="index_enviades.php">Veure els butlletins enviats</a></li>
				
			</ul>
<!--			<ol id="passos">-->
<!--				<li class="pas1"><span>Pas 1</span> Definició</li>-->
<!--				<li class="pas2"><span>Pas 2</span> Contingut</li>-->
<!--				<li class="pas3"><span>Pas 3</span> Destinataris</li>-->
<!--				<li class="pas4 actiu"><span>Pas 4</span> Enviament</li>-->
<!--			</ol>-->
			<form action="pas4.php" method="post">
			<input type="hidden" name="accio" value="desar" />
			<input type="hidden" name="idCam" value="|ID|" />
			|T_MISSATGE|
				<h2><span>Quart pas (I).</span> Enviament del butlletí</h2>
				<dl>
					<dt><label for="rebre">Test final: rebre el butlletí al vostre correu</label></dt>
					<dd>Com a mesura de seguretat, podeu fer una darrera prova i enviar-vos el butlletí per comprovar que es veu correctament.
						<span><input type="radio" id="rebre" name="TIPUS" value="1" |TIPUS_1| /></span>
						<label for="EMAIL">Indiqueu l’adreça de correu: <input type="text" id="EMAIL" name="EMAIL" value="|EMAIL|" /></label>
					</dd>
					<dt><label for="canvis">Enviar el butlletí</label></dt>
					<dd>Aquesta opció envia un butlletí a cadascun dels subscriptors de la llista seleccionada. 
						<p class="destacat"><strong>Important:</strong> el procés d’enviament es fa des del servidor i no es pot aturar. Per tant, assegureu-vos que tots els paràmetres del butlletí han estat comprovats i es veuen correctament. </p>
						<span><input type="radio" id="canvis" name="TIPUS" value="2" |TIPUS_2| /></span>
						<label for="EMAIL2">Indiqueu l’adreça de confirmació de l’enviament: <input type="text" id="EMAIL2" name="EMAIL2" value="|EMAIL2|" /></label>
					</dd>
				</dl>
				<div id="botons">
					<a href="pas3.php?IdCam=|ID|" class="boto anterior">Anterior</a>
					<input type="submit" value="Enviar" class="boto continuar" />
				</div>
			</form>
		</div>
	</div>


					<!-- BLOCK_BEGIN_ERROR1  -->
					<div class="missat_err">Si us plau, seleccioneu una de les dues opcions de la pantalla</div>
					<!-- BLOCK_END_ERROR1  -->

					<!-- BLOCK_BEGIN_ERROR2  -->
					<div class="missat_err">Si us plau, introduïu una adreça de correu per fer la prova d’enviament, o bé comproveu que l’heu escrit correctament.</div>
					<!-- BLOCK_END_ERROR2  -->

					<!-- BLOCK_BEGIN_ERROR3  -->
					<div class="missat_err">No s'ha pogut enviar el correu de test, proveu-ho més tard</div>
					<!-- BLOCK_END_ERROR3  -->

					<!-- BLOCK_BEGIN_INFO1  -->
					<div class="missat_ok"><p><strong>Informació</strong></p><br />Butlletí de test enviat correctament a |EMAIL|.</div>
					<!-- BLOCK_END_INFO1  -->

					<!-- BLOCK_BEGIN_ERROR5  -->
					<div class="missat_err">Si us plau, introduïu una adreça de correu per a la confirmació de l’enviament, o bé reviseu que l’hàgiu escrit correctament. </div>
					<!-- BLOCK_END_ERROR5  -->

