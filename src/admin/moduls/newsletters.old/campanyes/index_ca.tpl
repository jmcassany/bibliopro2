	<div id="contenidor" class="crear">
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
				<li>Butlletins pendents d'enviar</li>
				<li><a href="pas1.php">Crear nou Butlletí</a></li>
				<li><a href="index_enviades.php">Butlletins enviats</a></li>
			</ul>
			<h2>Butlletins pendents d'enviar</h2>
			
			|LLISTAT|
			<ol>
				<li><strong>Pas 1:</strong> Definició del Butlletí a enviar</li>
				<li><strong>Pas 2:</strong> Selecció del contingut del Butlletí</li>
				<li><strong>Pas 3:</strong> Selecció dels destinataris del Butlletí</li>
			</ol>	
		</div>
	</div>
	

			<!-- BLOCK_BEGIN_LLISTAT_CAP  -->
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
				<!-- BLOCK_END_LLISTAT_CAP  -->

					<!-- BLOCK_BEGIN_LLISTAT_LIN  -->
						<tr>
							<th><a href="resum.php?id=|ID|">|TITOL|</a></th>
							<td>|D_ALTA|</td>
							<td>|D_MODIF|</td>
							<td>|PAS1|</td>
							<td>|PAS2|</td>
							<td>|PAS3|</td>
							<td><a href="resum.php?id=|ID|"><img src="../media/gif/bt_resum.gif" width="71" height="27" alt="Resum" /></a></td>
							<td><a href="elimina.php?id=|ID|"><img src="../media/gif/bt_esborrar.gif" width="71" height="27" alt="Esborrar" /></a></td>
						</tr>
					<!-- BLOCK_END_LLISTAT_LIN  -->

			<!-- BLOCK_BEGIN_LLISTAT_PEU  -->
				</tbody>
			</table>
			|PAGINACIO|
			<!-- BLOCK_END_LLISTAT_PEU  -->

<!-- BLOCK_BEGIN_PAS_OK  --><img src="../media/comu/ico_enviatok2.jpg" alt="Correcte" width="21" height="21" /><!-- BLOCK_END_BOTO_PAS_OK  -->
<!-- BLOCK_BEGIN_PAS_KO  --><img src="../media/comu/ico_enviat_error2.jpg" alt="Incorrecte" width="21" height="21" /><!-- BLOCK_END_BOTO_PAS_KO  -->

			<!-- BLOCK_BEGIN_PAGINACIO  -->
			<div id="navegacio">
				<p class="esq ant">|LINK_ANT|</p>
				<ol class="esq">
					|LINKS_PAGS|
				</ol>
				<p class="dreta seg">|LINK_SEG|</p>
			</div>
			<!-- BLOCK_END_PAGINACIO  -->
