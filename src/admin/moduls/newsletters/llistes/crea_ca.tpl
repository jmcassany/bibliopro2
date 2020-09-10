	<div id="contenidor" class="llistes">
		<div id="contingut">
			<ul id="submenu">
				<li><a href="index.php">Llistes de subscriptors</a></li>
				<li>Crear nova llista</li>
			</ul>
			<form action="crea.php" method="post">
			<input type="hidden" name="accio" value="desar" />
			|T_MISSATGE|
				<h2>Crear una nova llista de subscriptors</h2>
				<dl>
					<dt><span>1</span> Tipus de llista</dt>
					<dd>
					<dl>
						<dt><label for="si">Llista d’usuaris sense confirmació</label></dt>
						<dd>Aquest tipus de llista permet afegir l’adreça de qualsevol subscriptor però no es fa cap pas per comprovar que l’adreça realment pertany a aquella persona. 
							<span><input type="radio" id="si" name="TIPUS" value="1" |TIPUS_1| /></span></dd>
						<dt><label for="mestard">Llista d’usuaris amb confirmació </label></dt>
						<dd>En aquests tipus de llista, l’usuari rep un correu de confirmació per verificar que l’adreça és correcta i està interessat a rebre els butlletins. Aquest correu conté un vincle que l’usuari ha de clicar com a confirmació per ser donat d’alta com a subscriptor.
							<span><input type="radio" id="mestard" name="TIPUS" value="2" |TIPUS_2| /></span></dd>
					</dl>
					</dd>
					<dt><span>2</span> Nom de la llista</dt>
					<dd>Introduïu un nom que defineixi de manera prou aclaridora la llista de subscriptors. 
						<label for="nom">Indiqueu el nom: <input type="text" id="nom" name="NOM" value="|NOM|" /></label></dd>
				</dl>
				<div id="botons">
					<a href="index.php" class="boto anterior">Anterior</a>
					<input type="submit" value="Continuar" class="boto continuar" />
				</div>
			</form>
		</div>
	</div>


					<!-- BLOCK_BEGIN_ERROR1  -->
					<div class="missat_err">Si us plau, indiqueu un nom a la llista</div>
					<!-- BLOCK_END_ERROR1  -->

					<!-- BLOCK_BEGIN_ERROR2  -->
					<div class="missat_err">Si us plau, seleccioneu una de les dues opcions de llista</div>
					<!-- BLOCK_END_ERROR2  -->
