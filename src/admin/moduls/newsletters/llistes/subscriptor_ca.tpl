	<div id="contenidor" class="llistes">
		<div id="contingut">
			<ul id="submenu">
				<li><a href="detalls.php?id=|ID|">Llista actual</a></li>
				<li><a href="index.php">Llistes de subscriptors</a></li>
			</ul>
			<form action="subscriptor.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="accio" value="desar" />
			<input type="hidden" name="id" value="|ID|" />
			<input type="hidden" name="sub" value="|IDSUB|" />
			|T_MISSATGE|
				<h2>Editar subscriptor</h2>
				<dl>
					<dt><span>1</span> Email del subscriptor</dt>
					<dd><!--Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.-->
						<label for="email">Indiqueu aqu&iacute; el correu:<br/><input type="text" id="email" name="EMAIL" value="|EMAIL|" /><em>Variable per personalitzar el comunicat: [[email]]</em></label>
					</dd>

					<dt><span>2</span> Dades complementàries (opcionals)</dt>
					<dd><!--Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <a href="#">[ + informaci&oacute; ]</a>-->
						<label for="nom">Nom:<br/><input type="text" id="nom" name="NOM" value="|NOM|" /><em>Variable per personalitzar el comunicat: [[nom]]</em></label>
						<label for="cognoms">Cognoms:<br/><input type="text" id="cognoms" name="COGNOMS" value="|COGNOMS|" /><em>Variable per personalitzar el comunicat: [[cognoms]]</em></label>
						<label for="PAIS">País:<br/><input type="text" id="PAIS" name="PAIS" value="|PAIS|" /><em>Variable per personalitzar el comunicat: [[pais]]</em></label>
						<label for="CENTRE">Tipus de centre:<br/><input type="text" id="CENTRE" name="CENTRE" value="|CENTRE|" /><em>Variable per personalitzar el comunicat: [[centre]]</em></label>
						<label for="camp1">Camp 1:<br/><input type="text" id="camp1" name="CAMP1" value="|CAMP1|" /><em>Variable per personalitzar el comunicat: [[camp1]]</em></label>
						<label for="camp2">Camp 2:<br/><input type="text" id="camp2" name="CAMP2" value="|CAMP2|" /><em>Variable per personalitzar el comunicat: [[camp2]]</em></label>
						<label for="camp3">Camp 3:<br/><input type="text" id="camp3" name="CAMP3" value="|CAMP3|" /><em>Variable per personalitzar el comunicat: [[camp3]]</em></label>
						<label for="camp4">Camp 4:<br/><input type="text" id="camp4" name="CAMP4" value="|CAMP4|" /><em>Variable per personalitzar el comunicat: [[camp4]]</em></label>
						<label for="camp5">Camp 5:<br/><input type="text" id="camp5" name="CAMP5" value="|CAMP5|" /><em>Variable per personalitzar el comunicat: [[camp5]]</em></label>
						<label for="link1">Link 1:<br/><input type="text" id="link1" name="LINK1" value="|LINK1|" /><em>Variable per personalitzar el comunicat: [[link1]]</em></label>
						<label for="link2">Link 2:<br/><input type="text" id="link2" name="LINK2" value="|LINK2|" /><em>Variable per personalitzar el comunicat: [[link2]]</em></label>
						<label for="link3">Link 3:<br/><input type="text" id="link3" name="LINK3" value="|LINK3|" /><em>Variable per personalitzar el comunicat: [[link3]]</em></label>
						<label for="adjunt1">Adjunt 1:<br/><input type="file" id="adjunt1" name="file1" /><em>Variable per personalitzar el comunicat: [[adjunt1]]</em><br />|ADJUNT1|</label>
						<label for="adjunt2">Adjunt 2:<br/><input type="file" id="adjunt2" name="file2" /><em>Variable per personalitzar el comunicat: [[adjunt2]]</em><br />|ADJUNT2|</label>
						<label for="adjunt3">Adjunt 3:<br/><input type="file" id="adjunt3" name="file3" /><em>Variable per personalitzar el comunicat: [[adjunt3]]</em><br />|ADJUNT3|</label>
					</dd>

					<dt><span>3</span> Dades internes</dt>
					<dd><!--Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <a href="#">[ + informaci&oacute; ]</a>-->
						<label for="estat">Estat : <select id="estat" name="ESTAT">|OPTS_ESTAT|</select></label>
						<label for="tipus">Tipus : <select id="tipus" name="TIPUS">|OPTS_TIPUS|</select></label>
						<label>Rebots : |BOUNCES|</label>
					</dd>

				</dl>
				<div id="botons">
					<a href="detalls.php?id=|ID|" class="boto anterior">Anterior</a>
					<input type="submit" value="Desar canvis" class="boto continuar" />
				</div>
			</form>
		</div>
	</div>


					<!-- BLOCK_BEGIN_ERROR1  -->
					<div class="missat_err">Manca el email o és incorrecte!</div>
					<!-- BLOCK_END_ERROR1  -->

					<!-- BLOCK_BEGIN_ERROR2  -->
					<div class="missat_err">Aquest email ja existeix a la llista!</div>
					<!-- BLOCK_END_ERROR2  -->

					<!-- BLOCK_BEGIN_ERROR3  -->
					<div class="missat_err">Tipus de subscriptor incorrecte!</div>
					<!-- BLOCK_END_ERROR3  -->

					<!-- BLOCK_BEGIN_ERROR4  -->
					<div class="missat_err">Estat del subscriptor incorrecte!</div>
					<!-- BLOCK_END_ERROR4  -->
