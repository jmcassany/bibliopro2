	<div id="contenidor" class="informes">
		<div id="contingut">
			<h2 class="esq">Informes dels butlletins enviats</h2>
					|LLISTAT|
		</div>
	</div>


			<!-- BLOCK_BEGIN_LLISTAT_CAP  -->
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
			<!-- BLOCK_END_LLISTAT_CAP  -->

					<!-- BLOCK_BEGIN_LLISTAT_LIN  -->
						<tr>
							<th><a href="resum.php?IdCam=|ID|">|TITOL|</a> <!--|PREVIEW|--></th>
							<td>|D_ENVIAMENT|</td>
							<td>|NUM_DESTINATARIS|</td>
							<td><a href="resum.php?IdCam=|ID|">[Informe]</a></td>							
							
							<td><!--<a href="../campanyes/duplica.php?id=|ID|"><img src="../media/gif/bt_duplica.gif" width="71" height="27" alt="Duplica" /></a>--></td>
							
							<td><a href="elimina.php?IdCam=|ID|"><img src="../media/comu/bt_esborrar.gif" width="71" height="27" alt="Esborrar" /></a></td>
						</tr>
					<!-- BLOCK_END_LLISTAT_LIN  -->

					<!-- BLOCK_BEGIN_LLISTAT_PEU  -->
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

<!-- BLOCK_BEGIN_PREVIEW_1  -->
(preview <a href="../campanyes/mostra.php?IdCam=|ID|&amp;fmt=1" onclick="javascript:return launchPreview('../campanyes/mostra.php?IdCam=|ID|&amp;fmt=1')">HTML</a>)
<!-- BLOCK_END_PREVIEW_1  -->
	
<!-- BLOCK_BEGIN_PREVIEW_2  -->
(preview <a href="../campanyes/mostra.php?IdCam=|ID|&amp;fmt=1" onclick="javascript:return launchPreview('../campanyes/mostra.php?IdCam=|ID|&amp;fmt=1')">HTML</a> 
<a href="../campanyes/mostra.php?IdCam=|ID|&amp;fmt=2" onclick="javascript:return launchPreview('../campanyes/mostra.php?IdCam=|ID|&amp;fmt=2')">TEXT</a>)
<!-- BLOCK_END_PREVIEW_2  -->
	
<!-- BLOCK_BEGIN_PREVIEW_3  -->
(preview <a href="../campanyes/mostra.php?IdCam=|ID|&amp;fmt=2" onclick="javascript:return launchPreview('../campanyes/mostra.php?IdCam=|ID|&amp;fmt=2')">TEXT</a>)
<!-- BLOCK_END_PREVIEW_3  -->
