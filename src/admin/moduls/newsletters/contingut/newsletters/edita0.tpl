			<div id="frontpage_controls" class="clearfix">
				<ul class="extra clearfix">
					<li class="preview"><a href="../../campanyes/mostra.php?IdCam=|ID_CAMPANYA|" target="_blank">Previsualitza el butlletí</a></li>
					<li class="help"><a href="#TB_inline?height=170&amp;width=300&amp;inlineId=hiddenModalContent&amp;modal=true" class="thickbox">Ajuda</a></li>
				</ul>
				<ul class="actions clearfix">
					<li class="add" id="add_box"><a class="addNewBox iframe" href="afegir-caixa.php?IdCam=|ID_CAMPANYA|" title="Omple els camps i apreta el botó d'Escollir entrades">Afegeix més caixes</a></li>
				</ul>
			</div>
			<!-- /frontpage_controls -->

            <form action="update.php" method="post" enctype="multipart/form-data" accept-charset="UTF-8" id="newsletterForm">
			<div id="content" class="clearfix">
				<input type="hidden" name="ID" value="|ID|" />
				<input type="hidden" name="publicar" value="1" />
				<input type="hidden" name="idCam" value="|ID_CAMPANYA|" />

				<div class="clearfix">
				    |CAPÇALERA|
					|BLOCS|
				</div>
				<!-- /clearfix -->

				<div class="previewButton"><input type="submit" value="Previsualitza el butlletí &raquo;" class="send" /></div>
			</div>
			<!-- /content -->

			</form>
			
			
			<!-- PopUp Ajuda -->
			<div id="hiddenModalContent" style="display:none">
				<h2>Ajuda</h2>
				<ul>
					<li style="padding:5px">&bull; (xxx) Nom categoria perque no es mostri al newsletter.</li>
					<li style="padding:5px">&bull; Dins la secció Contingut, els registres d'origens RSS són comuns per a tots els usuaris, els gestiona l'administrador i les notícies estan filtrades per model.</li>					
				</ul>
				<p style="text-align:center"><input type="submit" id="Login" value="&nbsp;&nbsp;D'acord&nbsp;&nbsp;" onclick="tb_remove()" /></p>
			</div>