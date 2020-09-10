	<div id="contenidor" class="llistes">
		<div id="cap">
			<h1>Houdini butlletins</h1>
			<ul id="principal">
				<li><a href="../campanyes/index.php" class="crear">Gestionar butlletins</a></li>
				<li><a href="../contingut/index.php" class="butlletins">Gestionar contingut</a></li>
				<li><a href="../llistes/index.php" class="llistes actiu">Llistes de subscriptors</a></li>
				<li><a href="../informes/index.php" class="informes">Informes</a></li>
			</ul>
		</div>
		<div id="contingut">
			<ul id="submenu">
				<li><a href="index.php">Llistes de subscriptors</a></li>
				<li><a href="crea.php">Crear nova llista</a></li>
			</ul>
			<form action="importa_manual.php" method="post">
			<input type="hidden" name="accio" value="desar" />
			<input type="hidden" name="id" value="|ID|" />
			|T_MISSATGE|
				<h2>Afegir subscriptors manualment</h2>
				<dl>
					<dt><label for="enganxar">Enganxar text amb correus</label></dt>
					<dd>Afegiu manualment una o diverses adreces de correu. Les adreces s’afegiran automàticament a la llista que esteu editant.
						<span><input type="radio" id="enganxar" name="TIPUS" value="2" checked="checked" /></span>
						<label for="enganxeu"><span class="enganxar">Enganxeu aquí les adreces:</span> <textarea id="enganxeu" name="EMAILS" rows="8" cols="40">|EMAILS|</textarea></label></dd>
				</dl>
				<div id="botons">
					<a href="detalls.php?id=|ID|" class="boto anterior">Anterior</a>
					|IMPORTAR|
				</div>
			</form>
		</div>
	</div>


					<!-- BLOCK_BEGIN_ERROR1  -->
					<div class="missat_err">No s'ha detectat cap adreça de correu al text que heu introduït. Si us plau, comproveu que l’hàgiu escrit amb una sintaxi correcta.</div>
					<!-- BLOCK_END_ERROR1  -->

					<!-- BLOCK_BEGIN_INFO1  -->
					<div class="missat_ok">
			<p><strong>Informació</strong></p>
			<table>
				<tr>
					<th>Correus detectats:</th>
					<td>|NUM_EMAILS|</td>
				</tr>
				<tr>
					<th>Afegits:</th>
					<td>|NUM_OK|</td>
				</tr>
				<tr>
					<th>No afegits per duplicats:</th>
					<td>|NUM_NOK_DUPLI|</td>
				</tr>
				<tr>
					<th>No afegits per error:</th>
					<td>|NUM_NOK_ERROR|</td>
				</tr>
			</table>
					</div>
					<!-- BLOCK_END_INFO1  -->
