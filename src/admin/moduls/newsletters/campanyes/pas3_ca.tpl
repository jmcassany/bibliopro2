<div id="contenidor" class="crear pas3">
		<div id="contingut">
			<ul id="submenu">
				<li><a href="index.php">Butlletins pendents d'enviar</a></li>
				<li>Crear nou Butlletí</li>
				<li><a href="index_enviades.php">Veure els butlletins enviats</a></li>
				
			</ul>
<!--			<ol id="passos">-->
<!--				<li class="pas1"><span>Pas 1</span> Definició</li>-->
<!--				<li class="pas2"><span>Pas 2</span> Contingut</li>-->
<!--				<li class="pas3 actiu"><span>Pas 3</span> Destinataris</li>-->
<!--				<li class="pas4"><span>Pas 4</span> Enviament</li>-->
<!--			</ol>-->
			<form action="pas3.php" method="post">
			<input type="hidden" name="accio" value="desar" />
			<input type="hidden" name="idCam" value="|ID|" />
			|T_MISSATGE|
				<h2><span>Tercer pas (I).</span> Selecció dels destinataris del butlletí</h2>
				<dl>
					<dt><label for="seleccionar">Seleccionar una llista de subscriptors que ja existeix</label></dt>
					<dd>Trieu una de les llistes de subscriptors que es mostren a sota com a destinataris del butlletí.
						<span><input type="radio" id="seleccionar" name="TIPUS" value="1" |TIPUS_1| /></span>
						<ul id="subscriptors">
							|LIS_LLISTES|
						</ul><br style="clear:both"/></dd>
					<dt><label for="afegir">Afegir els subscriptors manualment</label></dt>
					<dd>Afegiu manualment les adreces dels subscriptors que han de rebre el butlletí.
						<span><input type="radio" id="afegir" name="TIPUS" value="2" |TIPUS_2| /></span></dd>


					<!-- <dt><label for="ldap">Afegir usuaris LDAP</label></dt>
					<dd>
						<span><input type="radio" id="ldap" name="TIPUS" value="3" |TIPUS_3| /></span></dd>
						 -->
				</dl>
				<div id="botons">
					<a href="pas2c.php?IdCam=|ID|" class="boto anterior">Anterior</a>
					<input type="submit" value="Continuar" class="boto continuar" />
				</div>
			</form>
		</div>
	</div>


					<!-- BLOCK_BEGIN_LI_LLISTA  -->
							<li><label for="llistat|ID|"><input type="checkbox" id="llistat|ID|" name="LLISTA[|ID|]" value="|ID|" |MARCAT| class="check" onclick="javascript:document.getElementById('seleccionar').checked = true;"/> |TITOL| (|NUM_SUBSCRITS| subscriptors)</label></li>
					<!-- BLOCK_END_LI_LLISTA  -->

					<!-- BLOCK_BEGIN_ERROR1  -->
					<div class="missat_err">Si us plau, seleccioneu una de les dues opcions</div>
					<!-- BLOCK_END_ERROR1  -->

					<!-- BLOCK_BEGIN_ERROR2  -->
					<div class="missat_err">Heu decidit enviar el butlletí a una llista de subscriptors que ja existeix, però no heu triat cap llista. Si us plau, seleccioneu-ne una.</div>
					<!-- BLOCK_END_ERROR2  -->

