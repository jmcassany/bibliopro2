	<div id="contenidor" class="crear">
		<div id="contingut">
			<ul id="submenu">
				<li><a href="index.php">Butlletins pendents d'enviar</a></li>
				<li><a href="pas1.php">Crear nou Butlletí</a></li>
				<li>Butlletins enviats</li>
			</ul>
			<h2>Butlletins enviats</h2>
			
			|LLISTAT|
		</div>
	</div>


			<!-- BLOCK_BEGIN_LLISTAT_CAP  -->
			<table>
				<thead>
					<tr>
						<th>Nom de la campanya</th>
						<th>Data d'enviament</th>
						<th>Destinataris</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
			<!-- BLOCK_END_LLISTAT_CAP  -->

					<!-- BLOCK_BEGIN_LLISTAT_LIN  -->
						<tr>
							<th><a href="../informes/resum.php?IdCam=|ID|">|TITOL|</a></th>
							<td>|D_ENVIAMENT|</td>
							<td>|NUM_DESTINATARIS|</td>
							<td><a href="../informes/resum.php?IdCam=|ID|"><img src="../media/gif/bt_veurela.gif" width="71" height="27" alt="Veure-la" /></a></td>
							<td><a href="duplica.php?IdCam=|ID|"><img src="../media/gif/bt_duplica.gif" width="71" height="27" alt="Duplica" /></a></td>
							<td><a href="elimina.php?IdCam=|ID|"><img src="../media/gif/bt_esborrar.gif" width="71" height="27" alt="Esborrar" /></a></td>
						</tr>
					<!-- BLOCK_END_LLISTAT_LIN  -->

			<!-- BLOCK_BEGIN_LLISTAT_PEU  -->
				</tbody>
			</table>
			|PAGINACIO|
			<!-- BLOCK_END_LLISTAT_PEU  -->

<!-- BLOCK_BEGIN_PREVIEW_1  -->
(preview <a href="mostra.php?id=|ID|&amp;fmt=1" onclick="javascript:return launchPreview('mostra.php?IdCam=|ID|&amp;fmt=1')">HTML</a>)
<!-- BLOCK_END_PREVIEW_1  -->
	
<!-- BLOCK_BEGIN_PREVIEW_2  -->
(preview <a href="mostra.php?IdCam=|ID|&amp;fmt=1" onclick="javascript:return launchPreview('mostra.php?IdCam=|ID|&amp;fmt=1')">HTML</a> 
<a href="mostra.php?IdCam=|ID|&amp;fmt=2" onclick="javascript:return launchPreview('mostra.php?IdCam=|ID|&amp;fmt=2')">TEXT</a>)
<!-- BLOCK_END_PREVIEW_2  -->
	
<!-- BLOCK_BEGIN_PREVIEW_3  -->
(preview <a href="mostra.php?IdCam=|ID|&amp;fmt=2" onclick="javascript:return launchPreview('mostra.php?IdCam=|ID|&amp;fmt=2')">TEXT</a>)
<!-- BLOCK_END_PREVIEW_3  -->

			<!-- BLOCK_BEGIN_PAGINACIO  -->
			<div id="navegacio">
				<p class="esq ant">|LINK_ANT|</p>
				<ol class="esq">
					|LINKS_PAGS|
				</ol>
				<p class="dreta seg">|LINK_SEG|</p>
			</div>
			<!-- BLOCK_END_PAGINACIO  -->
