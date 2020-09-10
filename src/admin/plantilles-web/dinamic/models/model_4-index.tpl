<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="|IDIOMA_PAG|" lang="|IDIOMA_PAG|">
<head>

|block-static-metas_css|

<style type="text/css">@import url(|CONFIG_NOMCARPETA|/media/js/jscalendar/calendar.css);</style>
<script type="text/javascript" src="|CONFIG_NOMCARPETA|/media/js/jscalendar/calendar.js"></script>

<script type="text/javascript" src="|CONFIG_NOMCARPETA|/media/js/jscalendar/lang/calendar-ca.js"></script>
<script type="text/javascript" src="|CONFIG_NOMCARPETA|/media/js/jscalendar/calendar-setup.js"></script>
</head>
<body id="tresColumnes">
	<div id="contenidor">

		|block-static-capsalera|
		<p>Ets a: |SITUACIO| </p>
		<p>Apartat: |APARTAT| </p>
		<div id="contingut" class="clearfix">
			<div id="menuPrincipal">
				|MENUESQUERRA|

				|BANNERESQUERRA|

			</div>
			<!-- /menuPrincipal -->
			<hr/>
			<div id="contingutPrincipal" class="clearfix">
				<div id="contingutApartat">
					<h2>|TITOLSECCIO|</h2>
					<p>|SUBTITOLSECCIO|</p>
					<p>|TEXTSECCIO|</p>
					<p>|INTRODUCCIO|</p>



					<form action="" method="get">
						<fieldset>
							<div>

								<input type="text" value="|TEXT_CERCA|" id="cerca" name="cerca"/> <input type="submit" value="Cercar" />

								<label for="categories">Categoria:
									!SELECT_CATEGORIES!
								</label>
								Per data: de <input type="text" id="datainici" name="datainici"  value="!DATA_INICI!" maxlength="10" />
              <button type="reset" id="datainici_trigger_b" class="boto_calendari">Calendari de selecció</button> a <input name="datafi" type="text" id="datafi" value="!DATA_FI!" maxlength="10" />
				<button type="reset" id="datafi_trigger_b" class="boto_calendari">Calendari de selecció</button>
							</div>
						</fieldset>
					</form>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "datainici",      // id of the input field
        ifFormat       :    "%d/%m/%Y",       // format of the input field
        showsTime      :    false,            // will display a time selector
        button         :    "datainici_trigger_b",   // trigger for the calendar (button ID)
        singleClick    :    true,           // double-click mode
        step           :    1,            // show all years in drop-down boxes (instead of every other year as default)
        weekNumbers	   :    false
    });
</script>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "datafi",      // id of the input field
        ifFormat       :    "%d/%m/%Y",       // format of the input field
        showsTime      :    false,            // will display a time selector
        button         :    "datafi_trigger_b",   // trigger for the calendar (button ID)
        singleClick    :    true,           // double-click mode
        step           :    1,            // show all years in drop-down boxes (instead of every other year as default)
        weekNumbers	   :    false
    });
</script>





					<!-- BLOCK_BEGIN_CAPSAL_RESULTATS_CERCA  -->
					<h3>Resultats de la cerca</h3>
					<!-- BLOCK_END_CAPSAL_RESULTATS_CERCA  -->


					<!-- llistat de entrades -->

					<!-- BLOCK_BEGIN_INDEX_LLISTAT_INTRO_CATEGORIA  -->
					<p id="mostrant">Mostrant <strong>de !ITEMS_INICI! a !ITEMS_FI!</strong> de !ITEMS_TOTAL! entrades disponibles</p>
					<ul class="noticies">
					<!-- BLOCK_END_INDEX_LLISTAT_INTRO_CATEGORIA  -->
						<!-- BLOCK_BEGIN_ROW  -->
						<li class="clearfix">
							!IMATGE1!
							<h3>!TITOL!</h3>
							!CATEGORIA!
							!CREATION!
							!RESUM!
							!MES!

						</li>
						<!-- BLOCK_END_ROW  -->

					<!-- BLOCK_BEGIN_PAGINADOR  -->
					</ul>
					<!-- paginador -->
					<div id="navegacioPagines">
						<p>!PAGEPREV!</p>
						<p id="pag">Pàg. <strong>!PAGE!</strong> de !PMAX!:</p>
						!PAGELIST!
						<p>!PAGENEXT!</p>
					</div>
					<!-- /paginador -->
					<!-- BLOCK_END_PAGINADOR  -->

					<!-- llistat de entrades -->
				</div>
				<div id="menuSecundari">
					|BANNERDRETA|

				</div>
			</div>
			<!-- /contingutPrincipal -->
			<hr/>
		</div>
		<!-- /contingut -->

|block-static-peu|

	</div>
</body>
</html>
