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
			<form action="exporta_llista.php" method="post">
			<input type="hidden" name="accio" value="desar" />
			<input type="hidden" name="id" value="|ID|" />
			|T_MISSATGE|
				<h2>Exportar llista de subscriptors</h2>
				<dl>
					<dt><label for="exportar">Seleccioneu quins subscriptors voleu exportar</label></dt>
					<dd>Podeu exportar tots els subscriptors de la llista o bé només una part, segons que mostra el desplegable que teniu a continuació.
						<span><input type="radio" id="exportar" name="TIPUS" value="1" checked="checked" /></span>
						<label for="seleccioneu">Seleccioneu els subscriptors: <select name="ESTAT">|OPTS_ESTAT|</select></label></dd>
				</dl>
				<div id="botons">
					<a href="detalls.php?id=|ID|" class="boto anterior">Anterior</a>
					<input type="submit" value="Exportar" class="boto continuar" />
				</div>
			</form>
		</div>
	</div>


					<!-- BLOCK_BEGIN_ERROR1  -->
					<div class="missat_err">No hi ha subscriptors a exportar!</div>
					<!-- BLOCK_END_ERROR1  -->

					<!-- BLOCK_BEGIN_INFO1  -->
					<div class="missat_ok">
			<p><strong>Informació</strong></p>
			<table>
				<tr>
					<th>Correus exportats:</th>
					<td>|NUM_OK|</td>
				</tr>
			</table>
					</div>
					<!-- BLOCK_END_INFO1  -->
