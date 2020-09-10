	<div id="contenidor" class="crear pas1">
		<div id="contingut">
			<ul id="submenu">
				<li><a href="index.php">Butlletins pendents d'enviar</a></li>
				<li>Crear nou Butlletí</li>
				<li><a href="index_enviades.php">Veure els butlletins enviats</a></li>
				
			</ul>
			<!-- <ol id="passos">
				<li class="pas1 actiu"><span>Pas 1</span> Definició</li>
				<li class="pas2"><span>Pas 2</span> Contingut</li>
				<li class="pas3"><span>Pas 3</span> Destinataris</li>
				<li class="pas4"><span>Pas 4</span> Enviament</li>
			</ol> -->
			<form action="pas1.php" method="post">
			<input type="hidden" name="accio" value="desar" />
			<input type="hidden" name="idCam" value="|ID|" />
			<input type="hidden" name="TIPUS" value="2" />
			|T_MISSATGE|
				<h2><span>Primer pas.</span> Propietats del nou butlletí</h2>
				<dl>
					<dt><span>1</span> Nom del Butlletí</dt>
					<dd>Doneu-li un nom fàcilment identificable, perquè el pugueu reconèixer en futures operacions.
						<label for="TITOL">Indiqueu el nom: <input type="text" id="TITOL" name="TITOL" value="|TITOL|" /></label></dd>
					<dt><span>2</span> Assumpte del Butlletí</dt>
					<dd>Aquest text apareixerà com assumpte del correu que envieu als subscriptors.
						<label for="SUBJECT">Indiqueu l'assumpte: <input type="text" id="SUBJECT" name="SUBJECT" value="|SUBJECT|" /></label></dd>
					<dt><span>3</span> Qui envia el Butlletí</dt>
					<dd>Aquest nom apareixerà en el correu que rebran els vostres subscriptors.
						<label for="NOM">Indiqueu el nom: <input type="text" id="NOM" name="NOM" value="|NOM|" /></label></dd>
					<dt><span>4</span> L'adreça des d'on s'envia el Butlletí</dt>
					<dd>L’adreça que introduïu apareixerà com a emissora del butlletí. 
						<label for="EMAIL">Indiqueu el correu: <input type="text" id="EMAIL" name="EMAIL" value="|EMAIL|" /></label></dd>
					<dt><span>5</span> Adreça de rebot (transparent per l'usuari)</dt>
					<dd>Adreça on arribaran els correus rebotats. Aquesta adreça no apareixerà el butlletí.
						<label for="EMAIL_REPLY">Indiqueu el correu: <input type="text" id="EMAIL_REPLY" name="EMAIL_REPLY" value="|EMAIL_REPLY|" /></label></dd>
					<dt><span>6</span> Número del butlletí</dt>
                    <dd>Número per identificar l'edició del butlletí. Apareixerà a la capçalera
                        <label for="IDNL">Indiqueu el número: <input type="text" id="IDNL" name="IDNL" value="|IDNL|" /></label></dd>	
				</dl>
				<div id="botons">
					<a href="index.php" class="boto anterior">Anterior</a>
					<input type="submit" value="Continuar" class="boto continuar" />
				</div>
			</form>
		</div>
	</div>


					<!-- BLOCK_BEGIN_ERROR1  -->
					<div class="missat_err">Si us plau, introduïu un nom per al butlletí</div>
					<!-- BLOCK_END_ERROR1  -->

					<!-- BLOCK_BEGIN_ERROR2  -->
					<div class="missat_err">Si us plau, introduïu un assumpte per al butlletí</div>
					<!-- BLOCK_END_ERROR2  -->

					<!-- BLOCK_BEGIN_ERROR3  -->
					<div class="missat_err">Si us plau, introduïu el nom de qui envia el butlletí</div>
					<!-- BLOCK_END_ERROR3  -->

					<!-- BLOCK_BEGIN_ERROR4  -->
					<div class="missat_err">Si us plau, introduïu una adreça de correu des d’on s’envia la campanya o bé comproveu que l’heu escrit correctament.</div>
					<!-- BLOCK_END_ERROR4  -->

					<!-- BLOCK_BEGIN_ERROR5  -->
					<div class="missat_err">L’adreça de correu de resposta que heu introduït no sembla tenir una sintaxi correcta. Si us plau, reviseu que l’hàgiu escrit correctament</div>
					<!-- BLOCK_END_ERROR5  -->
