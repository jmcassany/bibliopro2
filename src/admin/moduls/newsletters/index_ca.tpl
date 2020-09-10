	<div id="contenidor" class="inicirapid">
		<!-- 
		<div id="cap">
			<h1>Houdini butlletins</h1>
			<ul id="principal">
				<li><a href="campanyes/index.php" class="crear">Gestionar butlletins</a></li>
				<li><a href="contingut/index.php" class="butlletins">Gestionar contingut</a></li>
				<li><a href="llistes/index.php" class="llistes">Llistes de subscriptors</a></li>
				<li><a href="informes/index.php" class="informes">Informes</a></li>
			</ul>
		</div>
		 -->
		<div id="contingut">
			<ul id="submenu">
				<li><a href="campanyes/pas1.php">Crear nou butlletí</a></li>
				<li><a href="llistes/crea.php">Crear nova Llista</a></li>
				<li><a href="contingut/noticies_newsletter/new.php"">Crear nova notícia</a></li>
			</ul>

			<h2>Butlletins pendents d’enviar</h2>
			<table>
				<thead>
					<tr>
						<th>Nom</th>
						<th>Creació</th>
						<th>Modificació</th>
						<th>Pas 1</th>
						<th>Pas 2</th>
						<th>Pas 3</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				|LINIES_DESADES|
				</tbody>
			</table>

			<h2>Darrers butlletins enviats</h2>
			<table>
				<thead>
					<tr>
						<th>Nom</th>
						<th>Data env.</th>
						<th>Destinataris</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				|LINIES_ENVIADES|
				</tbody>
			</table>
		</div>
	</div>


					<!-- BLOCK_BEGIN_LINIA_DESADES  -->
						<tr>
							<th><a href="campanyes/resum.php?IdCam=|ID|">|TITOL|</a></th>
							<td>|D_ALTA|</td>
							<td>|D_MODIF|</td>
							<td>|PAS1|</td>
							<td>|PAS2|</td>
							<td>|PAS3|</td>
							<td><a href="campanyes/resum.php?IdCam=|ID|"><img src="media/comu/bt_editar.gif" width="71" height="27" alt="Editar" /></a></td>
							<td><a href="campanyes/elimina.php?IdCam=|ID|"><img src="media/comu/bt_esborrar.gif" width="71" height="27" alt="Esborrar" /></a></td>
						</tr>
					<!-- BLOCK_END_LINIA_DESADES  -->

<!-- BLOCK_BEGIN_PAS_OK  --><img src="media/comu/ico_enviatok2.jpg" alt="Correcte" width="21" height="21" /><!-- BLOCK_END_BOTO_PAS_OK  -->
<!-- BLOCK_BEGIN_PAS_KO  --><img src="media/comu/ico_enviat_error2.jpg" alt="Incorrecte" width="21" height="21" /><!-- BLOCK_END_BOTO_PAS_KO  -->


					<!-- BLOCK_BEGIN_LINIA_ENVIADES  -->
						<tr>
							<th><a href="informes/resum.php?IdCam=|ID|">|TITOL|</a></th>
							<td>|D_ENVIAMENT|</td>
							<td>|NUM_DESTINATARIS|</td>
							<td><a href="informes/resum.php?IdCam=|ID|"><img src="media/gif/bt_veurela.gif" width="71" height="27" alt="Veure" /></a></td>
							<td><a href="campanyes/duplica.php?IdCam=|ID|"><img src="media/gif/bt_duplica.gif" width="71" height="27" alt="Duplicar" /></a></td>
							<td><a href="campanyes/elimina.php?IdCam=|ID|"><img src="media/gif/bt_esborrar.gif" width="71" height="27" alt="Esborrar" /></a></td>
						</tr>
					<!-- BLOCK_END_LINIA_ENVIADES  -->
