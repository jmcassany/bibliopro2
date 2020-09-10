	<div id="contenidor" class="llistes">
		<div id="contingut">
			<ul id="submenu">
				<li><a href="index.php">Llistes de subscriptors</a></li>
				<li><a href="crea.php">Crear nova llista</a></li>
			</ul>
			<form action="importa_llista.php" method="post">
			<input type="hidden" name="accio" value="desar" />
			<input type="hidden" name="id" value="|ID|" />
			|T_MISSATGE|
				<h2>Importar subscriptors des d'una llista</h2>
				<dl>
					<dt><label for="importar">Seleccionar la llista</label></dt>
					<dd>rieu una de les llistes de subscriptors ja existents que es mostren a sota. Les adreces que conté s’afegiran automàticament a la llista que esteu editant.
						<span><input type="radio" id="importar" name="TIPUS" value="1" checked="checked" /></span>
						<label for="seleccioneu">Seleccioneu la llista: <select name="LLISTA">|OPTS_LLISTA|</select></label></dd>
				</dl>
				<div id="botons">
					<a href="detalls.php?id=|ID|" class="boto anterior">Anterior</a>
					|IMPORTAR|
				</div>
			</form>
		</div>
	</div>


					<!-- BLOCK_BEGIN_ERROR1  -->
					<div class="missat_err">La llista d’origen de dades que heu seleccionat no es troba. Si us plau, torneu-la a seleccionar.</div>
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
