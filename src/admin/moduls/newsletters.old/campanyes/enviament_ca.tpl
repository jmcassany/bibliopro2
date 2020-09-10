<div id="contenidor" class="crear pas4">
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
				<li>Enviar un nou Butlletí</li>
				<li><a href="index_enviades.php">Veure els butlletins enviats</a></li>
				
			</ul>
			<ol id="passos">
				<li class="pas1"><span>Pas 1</span> Definició</li>
				<li class="pas2"><span>Pas 2</span> Contingut</li>
				<li class="pas3"><span>Pas 3</span> Destinataris</li>
				<li class="pas4 actiu"><span>Pas 4</span> Enviament</li>
			</ol>
			|T_MISSATGE|
			<h2>Lliurament del butlletí<span>(en procés)</span></h2>
			<h3>Procés</h3>
			<p class="enviant">
				<span class="text">Enviant... <span id="actual">1</span> de |NUM_ENVIAMENTS| butlletins (<span id="percentage">0%</span>)</span>
				<span style="width: 12%" class="barra" id="percbarra"></span>
			</p>
			<h3 id="encurs">S'està enviant el butlletí</h3>
			<table id="lliur">
			</table>
			<div id="report_final" style="display: none;">
				<h3>Enviament  finalitzat</h3>
				<p>Heu enviat <span id="numok">1</span> missatges correctament i <span id="numko">1</span> missatges no han pogut ser enviats.<br /><br /></p>
			
				<a href="../informes/resum.php?id=|ID|"><img src="../media/gif/bt_tornar.jpg" width="120" height="39" alt="Tornar" /></a>
			</div>
		</div>
	</div>

<!-- BLOCK_BEGIN_LINIA_OK  --><th>Butlletí enviat correctament a:</th><td>|EMAIL|</td><!-- BLOCK_END_LINIA_OK  -->
<!-- BLOCK_BEGIN_LINIA_KO  --><th>Error d'enviament a:<br />|ERROR|</th><td>|EMAIL|</td><!-- BLOCK_END_LINIA_KO  -->
