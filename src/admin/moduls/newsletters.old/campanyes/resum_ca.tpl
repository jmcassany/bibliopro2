<div id="contenidor" class="crear lliurament">
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
				<li><a href="index.php">Butlletins pendents d'enviar</a></li>
				<li>Crear nou Butlletí</li>
				<li><a href="index_enviades.php">Veure els butlletins enviats</a></li>
				
			</ul>
			<ol id="passos">
				<li class="pas1"><span>Pas 1</span> Definició</li>
				<li class="pas2"><span>Pas 2</span> Contingut</li>
				<li class="pas3"><span>Pas 3</span> Destinataris</li>
				<li class="pas4"><span>Pas 4</span> Enviament</li>
			</ol>
			<h2>Resum de les dades del butlletí</h2>
			|T_MISSATGE|
			|PAS1|
			|PAS2|
			|PAS3|
			|BOTO_PAS_SEGUENT|
		</div>
	</div>


<!-- BLOCK_BEGIN_BOTO_PAS1  -->
			<form action="pas2.php?id=|ID|" method="post">
				<input type="submit" value="Definir contingut" class="boto enviartots" />
			</form>
<!-- BLOCK_END_BOTO_PAS1  -->

<!-- BLOCK_BEGIN_BOTO_PAS2  -->
			<form action="pas3.php?id=|ID|" method="post">
				<input type="submit" value="Definir destinataris" class="boto enviartots" />
			</form>
<!-- BLOCK_END_BOTO_PAS2  -->

<!-- BLOCK_BEGIN_BOTO_PAS3  -->
			<form action="pas4.php?id=|ID|" method="post">
				<input type="submit" value="Definir enviament" class="boto enviartots" />
			</form>
<!-- BLOCK_END_BOTO_PAS3  -->

				<!-- BLOCK_BEGIN_PAS1  -->
			<h3>Qui l'envia</h3>
			<table>
				<tr>
					<th>Nom del butlletí:</th>
					<td>|TITOL|</td>
				</tr>
				<tr>
					<th>Assumpte:</th>
					<td>|SUBJECT|</td>
				</tr>
				<tr>
					<th>Nom de qui l’envia:</th>
					<td>|NOM|</td>
				</tr>
				<tr>
					<th>Adreça de qui l’envia:</th>
					<td>|EMAIL| |REPLY_TO|</td>
				</tr>
			</table>
			<a href="pas1.php?id=|ID|"><img src="../media/comu/bt_editar.jpg" width="120" height="39" alt="Editar" /></a>
				<!-- BLOCK_END_PAS1  -->

				<!-- BLOCK_BEGIN_PAS2  -->
			<h3>Contingut</h3>
			|INFO_PAS2|
			<a href="pas2.php?id=|ID|"><img src="../media/comu/bt_editar.jpg" width="120" height="39" alt="Editar" /></a>
			
				<!-- BLOCK_END_PAS2  -->

					<!-- BLOCK_BEGIN_PAS2_1  -->
					<table>
						<tr>
							<th>HTML</th>
							<td><a href="mostra.php?id=|ID|&amp;fmt=1" onclick="javascript:return launchPreview('mostra.php?id=|ID|&amp;fmt=1')">preview</a></td>
						</tr>
					</table>
					<!-- BLOCK_END_PAS2_1  -->

					<!-- BLOCK_BEGIN_PAS2_2  -->
					<table>
						<tr>
							<th>HTML</th>
							<td><a href="mostra.php?id=|ID|&amp;fmt=1" onclick="javascript:return launchPreview('mostra.php?id=|ID|&amp;fmt=1')">preview</a></td>
						</tr>
<!--
						<tr>
							<th>TEXT</th>
							<td><a href="mostra.php?id=|ID|&amp;fmt=2" onclick="javascript:return launchPreview('mostra.php?id=|ID|&amp;fmt=2')">preview</a></td>
						</tr>
-->
					</table>
					<!-- BLOCK_END_PAS2_2  -->

					<!-- BLOCK_BEGIN_PAS2_3  -->
<!--
					<table>
						<tr>
							<th>TEXT</th>
							<td><a href="mostra.php?id=|ID|&amp;fmt=2" onclick="javascript:return launchPreview('mostra.php?id=|ID|&amp;fmt=2')">preview</a></td>
						</tr>
					</table>
-->
					<!-- BLOCK_END_PAS2_3  -->

				<!-- BLOCK_BEGIN_PAS3  -->
			<h3>Destinataris</h3>
					<table>
					|INFO_PAS3|
					</table>
			<a href="pas3.php?id=|ID|"><img src="../media/comu/bt_editar.jpg" width="120" height="39" alt="Editar" /></a>
				<!-- BLOCK_END_PAS3  -->

					<!-- BLOCK_BEGIN_PAS3_MANUAL  -->
						<tr>
							<th>Entrats manualment</th>
							<td>|NOMBRE| subscriptors <a href="pas3b.php?id=|ID|&amp;edita=1">view/edit</a> <a href="resum.php?id=|ID|&amp;llista=0&amp;accio=eliminadesti" onclick="javascript:return checkDeleteList('|ID|','0','|NOMBRE|')">eliminar</a></td>
						</tr>
					<!-- BLOCK_END_PAS3_MANUAL  -->

					<!-- BLOCK_BEGIN_PAS3_LLISTA  -->
						<tr>
							<th>|NOM_LLISTA|</th>
							<td>|NOMBRE| subscriptors <a href="resum.php?id=|ID|&amp;llista=|ID_LLISTA|&amp;accio=eliminadesti" onclick="javascript:return checkDeleteList('|ID|','|ID_LLISTA|','|NOMBRE|')">eliminar</a></td>
						</tr>
					<!-- BLOCK_END_PAS3_LLISTA  -->

					<!-- BLOCK_BEGIN_PAS3_TOTAL  -->
						<tr>
							<th>TOTAL</th>
							<td><b>|NOMBRE|</b> subscriptors</td>
						</tr>
					<!-- BLOCK_END_PAS3_TOTAL  -->

					<!-- BLOCK_BEGIN_PAS3_TOTAL_NO_UNICS  -->
						<tr>
							<th>TOTAL</th>
							<td>|NOMBRE| subscriptors, <b>|UNICS|</b> subscriptors diferents</td>
						</tr>
					<!-- BLOCK_END_PAS3_TOTAL_NO_UNICS  -->
