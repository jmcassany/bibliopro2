	<div id="contenidor" class="llistes resum">
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
				|T_MISSATGE|
			<div class="esq">
				<h2>Subscriptors de la llista</h2>
				<ul>
					<li>Nom: <strong>|NOM|</strong></li>
					<li>Tipus: |TIPUS|</li>
					<li>Nombre de subscrits: |NUM_SUBSCRITS|</li>
				</ul>
				<a href="edita.php?id=|ID|"><img src="../media/gif/bt_editar.jpg" width="120" height="39" alt="Editar" /></a>
			</div>
			<div class="dreta">
				<h3>Afegir subscripcions:</h3>
				<ul>
					<li><a href="importa_manual.php?id=|ID|">Escriure’ls manualment</a></li>
					<li><a href="importa_csv.php?id=|ID|">Importar-los d'un fitxer CSV</a></li>
					<li><a href="importa_llista.php?id=|ID|">Importar-los des d’una altra llista</a></li>
				</ul>
				<h3>Altres accions:</h3>
				<ul>
					<li><a href="exporta_llista.php?id=|ID|">Exportar la llista de subscriptors a un fitxer CSV</a></li>
				</ul>
			</div>

						|LLISTAT|
						<form action="detalls.php" method="post" id="cerca">
							<input type="hidden" name="id" value="|ID|" />
							<input type="hidden" name="ordenar" value="|ORDENAR|" />
							<input type="hidden" name="ordre" value="|ORDRE|" />
							Filtrar la llista:
							<select name="estat" onchange="submit()">|OPTS_ESTAT|</select> &nbsp;
							<input type="text" name="cerca" value="|CERCA|" />
							<input type="submit" value="" class="boto filtrar" />
						</form>

		</div>
	</div>


						<!-- BLOCK_BEGIN_LLISTAT_CAP  -->
						<form action="detalls.php" method="post" id="edicio">
						<input type="hidden" name="id" value="|ID|" />
						<input type="hidden" name="ordenar" value="|ORDENAR|" />
						<input type="hidden" name="ordre" value="|ORDRE|" />
						<input type="hidden" name="cerca" value="|CERCA|" />
						<input type="hidden" name="estat" value="|FLT_ESTAT|" />
						<table>
							<thead>
								<tr>
									<th><a href="|LINK_1|">|ICO_1|Email</a></th>
									<th><a href="|LINK_2|">|ICO_2|Cognoms, Nom</a></th>
									<th><a href="|LINK_3|">|ICO_3|Alta</a></th>
									<th><a href="|LINK_4|">|ICO_4|Estat</a></th>
									<th>Accions</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="5"><strong>Mostrant del |REG_PRIMER| al |REG_ULTIM|, de |NUM_REGS| subscriptors</strong></td>
								</tr>
						<!-- BLOCK_END_LLISTAT_CAP  -->

						<!-- BLOCK_BEGIN_LLISTAT_LIN  -->
								<tr>
									<th><a href="subscriptor.php?id=|ID|&amp;sub=|IDSUB|">|EMAIL|</a></th>
									<td>|COGNOMS|, |NOM|</td>
									<td>|D_ALTA|</td>
									<td>|ESTAT|</td>
									<td><input type="checkbox" name="CHECK[|IDSUB|]" /></td>
								</tr>
						<!-- BLOCK_END_LLISTAT_LIN  -->

						<!-- BLOCK_BEGIN_LLISTAT_PEU  -->
							</tbody>
						</table>
						<p id="aplicar">Aplicar l'acció <select name="accio">|OPTS_ACCIO|</select> als usuaris seleccionats de la llista.&nbsp; <input type="submit" value="" class="boto aplica" /></p>
						<div id="navegacio">
							<p class="esq ant">|LINK_ANT|</p>
							<ol class="esq">
								|LINKS_PAGS|
							</ol>
							<p class="dreta seg">|LINK_SEG|</p>
						</div>
						</form>
						<!-- BLOCK_END_LLISTAT_PEU  -->


					<!-- BLOCK_BEGIN_ERROR1  -->
					<div class="missat_err">No heu seleccionat cap subscriptor per aplicar l’acció. Si us plau seleccioneu els subscriptors als que voleu aplicar-la.</div>
					<!-- BLOCK_END_ERROR1  -->

					<!-- BLOCK_BEGIN_ERROR2  -->
					<div class="missat_err">Seleccioneu l’acció que voleu aplicar sobre els usuaris que heu triat.</div>
					<!-- BLOCK_END_ERROR2  -->

					<!-- BLOCK_BEGIN_INFO1  -->
					<div class="missat_ok">
			<p><strong>Informació</strong></p>
			<table>
				<tr>
					<th>Subscriptors marcats:</th>
					<td>|NUM_OK|</td>
				</tr>
				<tr>
					<th>No marcats per errors:</th>
					<td>|NUM_NOK|</td>
				</tr>
			</table>
					</div>
					<!-- BLOCK_END_INFO1  -->

					<!-- BLOCK_BEGIN_INFO2  -->
					<div class="missat_ok">
			<p><strong>Informació</strong></p>
			<table>
				<tr>
					<th>Subscriptors eliminats:</th>
					<td>|NUM_OK|</td>
				</tr>
				<tr>
					<th>No eliminats per errors:</th>
					<td>|NUM_NOK|</td>
				</tr>
			</table>
					</div>
					<!-- BLOCK_END_INFO2  -->
