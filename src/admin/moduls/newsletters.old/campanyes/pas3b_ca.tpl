<div id="contenidor" class="crear pas3">
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
				<li class="pas2"><span>Pas 2</span> Contingut</li>
				<li class="pas3 actiu"><span>Pas 3</span> Destinataris</li>
				<li class="pas4"><span>Pas 4</span> Enviament</li>
			</ol>
			<form action="pas3b.php" method="post">
			<input type="hidden" name="accio" value="desar" />
			<input type="hidden" name="id" value="|ID|" />
			|T_MISSATGE|
				<h2><span>Tercer pas (II).</span> Afegir els subscriptors manualment</h2>
				<dl>
					<dt><label for="enganxar">Enganxar text amb correus</label></dt>
					<dd>Afegiu manualment una o diverses adreces de correu. Les adreces s’afegiran automàticament al premer el botó Importar.
						<span><input type="radio" id="enganxar" name="TIPUS" value="2" checked="checked" /></span>
						<label for="enganxeu"><span class="enganxar">Enganxeu aquí les adreces:</span> <textarea id="enganxeu" name="EMAILS" rows="8" cols="40">|EMAILS|</textarea></label></dd>
				</dl>
				<div id="botons">
					<a href="pas3.php?id=|ID|" class="boto anterior">Anterior</a>
					<a href="resum.php?id=|ID|" class="boto">Continuar</a>
					<!--<input type="submit" value="Importar" class="boto continuar" />-->
					|IMPORTAR|
				</div>
			</form>
		</div>
	</div>


					<!-- BLOCK_BEGIN_ERROR1  -->
					<div class="missat_err">No s'ha detectat cap adreça de correu</div>
					<!-- BLOCK_END_ERROR1  -->

					<!-- BLOCK_BEGIN_INFO1  -->
					<div class="missat_ok">
			<p><strong>Informació</strong></p>
			<table>
				<tr>
					<th>Correus afegits:</th>
					<td>|NUM_OK|</td>
				</tr>
				<tr>
					<th>No afegits per duplicats:</th>
					<td>|NUM_NOK_DUPLI|</td>
				</tr>
			</table>
					</div>
					<!-- BLOCK_END_INFO1  -->
