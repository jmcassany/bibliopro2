	<div id="contenidor" class="inicirapid">
		<div id="cap">
			<h1>Gestor de Newletters</h1>
		</div>
		<div id="contingut">
			<h2 id="inicirapid"> Administrador</h2>
			|T_MISSATGE|
			<form action="tria_usuari.php" method="post">
				<input type="hidden" name="accio" value="desar" />
				<dl>
					<dt><span>&raquo;</span> Selecció de l'usuari</dt>
					<dd>Podeu accedir a l'eina com a administrador o simular una sessió de qualsevol dels usuaris creats. La segona opció us pot ser útil per veure els butlletins que ha creat cada usuari.
						<label for="USUARI">Indiqueu aqu&iacute; l'usuari: 
							<!--<input type="text" id="USUARI" name="USUARI" value="|USUARI|" />-->
							<select id="USUARI" name="USUARI">
								|USUARI|
							</select>
						</label>
					</dd>
				</dl>
				<input type="submit" value="Continuar" class="boto continuar" />
			</form>
		</div>
	</div>


					<!-- BLOCK_BEGIN_ERROR1  -->
					<div class="missat_err">Manca l'usuari o és incorrecte!</div>
					<!-- BLOCK_END_ERROR1  -->

