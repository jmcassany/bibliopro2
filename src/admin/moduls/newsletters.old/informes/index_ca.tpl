	<div id="contenidor" class="informes">
		<div id="cap">
			<h1>Houdini butlletins</h1>
			<ul id="principal">
				<li><a href="../campanyes/index.php" class="crear">Gestionar butlletins</a></li>
				<li><a href="../contingut/index.php" class="butlletins">Gestionar contingut</a></li>
				<li><a href="../llistes/index.php" class="llistes">Llistes de subscriptors</a></li>
				<li><a href="../informes/index.php" class="informes actiu">Informes</a></li>
			</ul>
		</div>
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
							<th><a href="resum.php?id=|ID|">|TITOL|</a> <!--|PREVIEW|--></th>
							<td>|D_ENVIAMENT|</td>
							<td>|NUM_DESTINATARIS|</td>
							<td><a href="resum.php?id=|ID|">[Informe]</a></td>							
							
							<td><!--<a href="../campanyes/duplica.php?id=|ID|"><img src="../media/gif/bt_duplica.gif" width="71" height="27" alt="Duplica" /></a>--></td>
							
							<td><a href="elimina.php?id=|ID|"><img src="../media/comu/bt_esborrar.gif" width="71" height="27" alt="Esborrar" /></a></td>
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
(preview <a href="../campanyes/mostra.php?id=|ID|&amp;fmt=1" onclick="javascript:return launchPreview('../campanyes/mostra.php?id=|ID|&amp;fmt=1')">HTML</a>)
<!-- BLOCK_END_PREVIEW_1  -->
	
<!-- BLOCK_BEGIN_PREVIEW_2  -->
(preview <a href="../campanyes/mostra.php?id=|ID|&amp;fmt=1" onclick="javascript:return launchPreview('../campanyes/mostra.php?id=|ID|&amp;fmt=1')">HTML</a> 
<a href="../campanyes/mostra.php?id=|ID|&amp;fmt=2" onclick="javascript:return launchPreview('../campanyes/mostra.php?id=|ID|&amp;fmt=2')">TEXT</a>)
<!-- BLOCK_END_PREVIEW_2  -->
	
<!-- BLOCK_BEGIN_PREVIEW_3  -->
(preview <a href="../campanyes/mostra.php?id=|ID|&amp;fmt=2" onclick="javascript:return launchPreview('../campanyes/mostra.php?id=|ID|&amp;fmt=2')">TEXT</a>)
<!-- BLOCK_END_PREVIEW_3  -->
