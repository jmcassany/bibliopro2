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
				<li>Llistes de subscriptors</li>
				<li><a href="crea.php">Crear nova llista</a></li>
			</ul>
			<h2>Eliminar llista de subscriptors</h2>
			
			<table>
				<thead>
					<tr>
						<th>Nom de la llista</th>
						<th>Destinataris</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th><a href="detalls.php?id=|ID|">|NOM|</a></th>
						<td>|NUM_SUBSCRITS|</td>
					</tr>
				</tbody>
			</table>
			<form action="elimina.php" method="post" id="eliminar">
				<input type="hidden" name="accio" value="desar" />
				<input type="hidden" name="id" value="|ID|" />
				<p>Estàs segur de voler eliminar definitivament aquesta llista i tots els seus subscriptors ?</p>
				<div id="botons">
					<a href="javascript:history.go(-1);" class="boto cancel">Cancel·lar</a>
					<input type="submit" value="Eliminar" class="boto elimin" />
				</div>
			</form>
		</div>
	</div>