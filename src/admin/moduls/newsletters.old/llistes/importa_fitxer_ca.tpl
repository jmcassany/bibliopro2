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
			<form action="importa_fitxer.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="accio" value="desar" />
			<input type="hidden" name="id" value="|ID|" />
			|T_MISSATGE|
				<h2>Importar subscriptors des d'un fitxer</h2>
				<dl>
					<dt><label for="importar">Importar contingut</label></dt>
					<dd>Seleccioneu un arxiu que contingui adreces de correu. Les adreces s’afegiran automàticament a la llista que esteu editant. 
						<span><input type="radio" id="importar" name="TIPUS" value="1" checked="checked" /></span>
						<label for="seleccioneu">Seleccioneu l’arxiu: <input type="file" id="seleccioneu" name="EMAILS" /></label></dd>
					<dt><label for="acceptar">Certifiqueu la validesa dels correus que voleu importar.</label></dt>
					<dd>Cal que marqueu aquesta casella per certificar la validesa de les adreces de correu, com a mesura de seguretat per evitar spam (correu no desitjat). 
						<span><input type="checkbox" id="acceptar" name="CONFIRMA" /></span>
					</dd>
				</dl>
				<div id="botons">
					<a href="detalls.php?id=|ID|" class="boto anterior">Anterior</a>
					<input type="submit" value="Importar" class="boto continuar" />
				</div>
			</form>
		</div>
	</div>


					<!-- BLOCK_BEGIN_ERROR1  -->
					<div class="missat_err">El fitxer que heu seleccionat no es troba o està buit. Si us plau, torneu-lo a seleccionar.</div>
					<!-- BLOCK_END_ERROR1  -->

					<!-- BLOCK_BEGIN_ERROR2  -->
					<div class="missat_err">Cal que marqueu la casella que certifica la legitimitat de les adreces de correu que voleu afegir.</div>
					<!-- BLOCK_END_ERROR2  -->

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
