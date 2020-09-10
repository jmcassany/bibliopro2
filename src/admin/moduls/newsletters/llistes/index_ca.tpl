	<div id="contenidor" class="llistes">
		<div id="contingut">
			<ul id="submenu">
				<li>Llistes de subscriptors</li>
				<li><a href="crea.php">Crear nova llista</a></li>
			</ul>
			<h2 class="esq">Llistes de subscriptors</h2>
			<a href="crea.php" class="novaLlista"><img src="../media/comu/bt_crear_nova_llista.gif" width="156" height="39" alt="Crear nova llista" /></a>
			|LLISTAT|
		</div>
	</div>


					<!-- BLOCK_BEGIN_LLISTAT_CAP  -->
			<table>
				<thead>
					<tr>
						<th>Nom</th>
						<th>Creació</th>
						<th>Subscriptors</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<!-- BLOCK_END_LLISTAT_CAP  -->

					<!-- BLOCK_BEGIN_LLISTAT_LIN  -->
					<tr>
						<th><a href="detalls.php?id=|ID|">|TITOL|</a></th>
						<td>|D_ALTA|</td>
						<td>|NUM_SUBSCRITS|</td>
						<td><a href="detalls.php?id=|ID|"><img src="../media/comu/bt_editar.gif" width="71" height="27" alt="Editar" /></a></td>
						<td><a href="elimina.php?id=|ID|"><img src="../media/comu/bt_esborrar.gif" width="71" height="27" alt="Esborrar" /></a></td>
					</tr>
					<!-- BLOCK_END_LLISTAT_LIN  -->

					<!-- BLOCK_BEGIN_LLISTAT_PEU  -->
				</tbody>
			</table>	
			|PAGINACIO|
					<!-- BLOCK_END_LLISTAT_PEU  -->

			<!-- BLOCK_BEGIN_PAGINACIO  -->
			<div id="navegacio">
				<p class="esq ant">|LINK_ANT|</p>
				<ol class="esq">
					|LINKS_PAGS|
				</ol>
				<p class="dreta seg">|LINK_SEG|</p>
			</div>
			<!-- BLOCK_END_PAGINACIO  -->
