	<div id="contenidor" class="resum informes">
		<div id="contingut">
			<ul id="submenu">
				<li><a href="index.php">Informes dels butlletins enviats</a></li>
			</ul>
				<div class="esq">
					<h2>Informe de l'enviament del butlletí</h2>
					|T_MISSATGE|
					<div id="informe">
						<h3>|TITOL|</h3>
						<p>Enviat a: <strong>|NUM_ENVIAMENTS|</strong> subscriptors el |D_ENVIAMENT|</p>
						<table>
							<caption>Informe de l'enviament de la Newsletter</caption>
							<tr id="ok">
								<th class="ok">Enviaments realitzats:</th>
								<td>|NUM_ENVIAMENTS|</td>
							</tr>
							<tr>
								<th class="noResposta">Enviaments amb èxit i sense resposta:</th>
								<td>|NUM_NORESPO|</td>
							</tr>
							<tr>
								<th class="error">Errors en l'enviament:</th>
								<td>|ENVIATS_KO|</td>
							</tr>
							<tr>
								<th class="llegits">Correus llegits:</th>
								<td>|NUM_LLEGITS|</td>
							</tr>
							<tr>
								<th class="baixes">Baixes de subscriptors:</th>
								<td>|NUM_UNSUBSC|</td>
							</tr>
						</table>
					</div>
					
					<br/><br/>
					
				</div>
				<div class="dreta grafica">
<!--
					<h3>Situació actual dels |NUM_ENVIAMENTS| correus enviats:</h3>
					<img src="grafic_resposta.php?a=|ENVIATS_KO_NUM|&amp;b=|NUM_LLEGITS_NUM|&amp;c=|NUM_UNSUBSC_NUM|&amp;d=|NUM_NORESPO_NUM|&amp;width=200&amp;height=200" alt="Situació actual dels |NUM_ENVIAMENTS| correus enviats" />
-->
					<h3>Visualització prèvia:</h3>
					<ul>
						|PREVIEW|
					</ul>
					<h3>Altres Opcions:</h3>
					<p style="padding-bottom:2em;">
						<a href="destinataris.php?IdCam=|ID|">Veure resposta dels correus enviats</a>
						<br/><br/>
						<a href="clics.php?IdCam=|ID|">Veure clics a les notícies del butlletí</a>
						<br/><br/>
						<a href="clics_banners.php?IdCam=|ID|">Veure clics als banners del butlletí</a>
					</p>
				
				</div>
		</div>
	</div>


						<!-- BLOCK_BEGIN_PREVIEW_1  -->
						<li><a href="../campanyes/mostra.php?IdCam=|ID|&amp;fmt=1" target="_blank"><acronym title="HyperText Markup Language">HTML</acronym></a></li>
						<!-- BLOCK_END_PREVIEW_1  -->
	
						<!-- BLOCK_BEGIN_PREVIEW_2  -->
						<li><a href="../campanyes/mostra.php?IdCam=|ID|&amp;fmt=1" target="_blank"><acronym title="HyperText Markup Language">HTML</acronym></a></li>
<!--
						<li><a href="../campanyes/mostra.php?IdCam=|ID|&amp;fmt=2" onclick="javascript:return launchPreview('../campanyes/mostra.php?IdCam=|ID|&amp;fmt=2')">Text</a></li>
-->
						<!-- BLOCK_END_PREVIEW_2  -->
	
						<!-- BLOCK_BEGIN_PREVIEW_3  -->
<!--
						<li><a href="../campanyes/mostra.php?IdCam=|ID|&amp;fmt=2" onclick="javascript:return launchPreview('../campanyes/mostra.php?IdCam=|ID|&amp;fmt=2')">Text</a></li>
-->
						<!-- BLOCK_END_PREVIEW_3  -->
