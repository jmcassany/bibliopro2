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
			<ul id="submenu">
				<li><a href="resum.php?id=|ID|">Informe del butlletí</a></li>
				<li><a href="index.php">Butlletins enviats</a></li>
			</ul>
			<h2>Informe de les respostes rebudes d’un butlletí</h2>
			|T_MISSATGE|
			<div id="detalls">
				Títol: |TITOL|<br />
				Enviat el: |D_ENVIAMENT|<br />
				<br />
			</div>
						|LLISTAT|
						<form action="destinataris.php" method="post" id="cerca">
							<input type="hidden" name="id" value="|ID|" />
							<input type="hidden" name="ordenar" value="|ORDENAR|" />
							<input type="hidden" name="ordre" value="|ORDRE|" />
							Filtrar la llista: 
							<select name="estat" onchange="submit()">|OPTS_ESTAT|</select> &nbsp; 
							<input type="text" name="cerca" value="|CERCA|" />
							<input type="submit" value="" class="boto filtrar" />
						</form>
		</div>
	</div>


						<!-- BLOCK_BEGIN_LLISTAT_CAP  -->
						<form action="destinataris.php" method="post" id="edicio">
						<input type="hidden" name="id" value="|ID|" />
						<input type="hidden" name="ordenar" value="|ORDENAR|" />
						<input type="hidden" name="ordre" value="|ORDRE|" />
						<input type="hidden" name="cerca" value="|CERCA|" />
						<input type="hidden" name="estat" value="|FLT_ESTAT|" />
						<table>
							<thead>
								<tr>
									<th><a href="|LINK_1|">|ICO_1|Correu</a></th>
									<th><a href="|LINK_2|">|ICO_2|Nom</a></th>
									<th><a href="|LINK_3|">|ICO_3|Enviament</a></th>
									<th><a href="|LINK_4|">|ICO_4|Recepció</a></th>
									<th><a href="|LINK_5|">|ICO_5|Estat</a></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="5"><strong>Mostrant del |REG_PRIMER| al |REG_ULTIM|, de |NUM_REGS| destinataris</strong></td>
								</tr>
						<!-- BLOCK_END_LLISTAT_CAP  -->
	
						<!-- BLOCK_BEGIN_LLISTAT_LIN  -->
								<tr>
									<th><a href="mailto:|EMAIL|">|EMAIL|</a> 
										<a href="../../../../news_imatge.php?id=|CRIPTO|" title="url imatge confirmació lectura" target="_blank">[*]</a> 
										<a href="../../../../news_unsubscribe.php?id=|CRIPTO|" title="url desapuntar-se" target="_blank">[*]</a>
									</th>
									<td>|NOM|</td>
									<td>|D_ENVIA|</td>
									<td>|D_REP|</td>
									<td>|ESTAT|</td>
								</tr>
						<!-- BLOCK_END_LLISTAT_LIN  -->
	
						<!-- BLOCK_BEGIN_LLISTAT_PEU  -->
							</tbody>
						</table>
						<div id="navegacio">
							<p class="esq ant">|LINK_ANT|</p>
							<ol class="esq">
								|LINKS_PAGS|
							</ol>
							<p class="dreta seg">|LINK_SEG|</p>
						</div>
						</form>
						<!-- BLOCK_END_LLISTAT_PEU  -->
