<html>
<head>
|METAS|
|EDITOR_HEAD|

<script type="text/javascript" src="|CONFIG_URLADMIN|/js/formularis/jquery.maskedinput-1.1.2.pack.js"></script>
<script type="text/javascript">
jQuery(function($){
   $("#CALENDAR_START_TIME").mask("99/99/9999");
   $("#CALENDAR_END_TIME").mask("99/99/9999");
   $("#START_TIME").mask("99/99/9999");
   $("#END_TIME").mask("99/99/9999");
});
</script>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<div id="contingut">
<!-- CAP�ELERA -->
|CAPCELERA|
<!-- /CAP�ELERA -->

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;margin-bottom:0px">

	<!-- situacio Sou a -->
	<tr>
		<td class="text10" bgcolor="#FDDBCA" style="padding:6px;" colspan="2"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b>Gesti� de continguts din�mics</b></td>

	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td  class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="Sou a" border="0" align="absmiddle">Sou a: <a href="../index.php">Portada</a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php?DIN=|DIN|">|DESCRIPCIOCARPETA|</a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">Actualitzar</font></td>
					<td align="right" style="padding-right:2px;"><a href="../mapaweb.php" onclick="obrir('../mapaweb.php',650,400); return false;" class="text9">Veure mapa del web</a> <a href="javascript:obrir('../mapaweb.php',650,400)"><img src="../comu/ico_mapaweb.gif" alt="Veure mapa del web" width="36" height="18" border="0" align="absmiddle"></a></td>
				</tr>

			</table>
		</td>
	</tr>
	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">Actualitzar registre</td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">

					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<form action="update.php" method="post" enctype="multipart/form-data">
		<!-- FORMULARI ENTRADA -->
		<td colspan="2" style="padding:10px;" valign="top">
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">

			<TR>
			   <TD class=text valign=top width="15%">Pregunta:</TD>
			   <TD valign=top width="85%"><INPUT TYPE="text" NAME="TITOL" VALUE="|TITOL|" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
			</TR>

			<TR>
			   <TD class=text valign=top >Resposta:</TD>
			   <TD valign=top  class=text>
|EDITOR_DESCRIPCIO|
			  </TD>
			</TR>

			<tr>
				<TD class=text valign=top >Visible:</TD>
				<TD valign=top  class=text>|SELECT_FINESTRA3|</td>
			</tr>

			<TR>
			   <TD  valign=top  class="text10" colspan=2><b>|LANG_DATE| |LANG_PUBLISH|:</b>
			   		<!-- dates publicació -->
			   		<table cellpadding="0" cellspacing="0" border="0" width="558" style="border:solid #CCCCCC 1px;">
						<tr>
							<td class="text10" width="80" style="padding:5px;">|LANG_DATE| |LANG_START|: (|LANG_DATEFORMAT|)</td>
							<td class="text10" style="padding:5px;"><input type="text" id="START_TIME" name="START_TIME" value="|START_TIME_DAY|/|START_TIME_MONTH|/|START_TIME_YEAR|" maxlength="10" class="formulari" style="width:80px;"> <button type="reset" id="START_TIME_BUTTON" class="boto_calendari" title="|LANG_DINAMICSFORMSELECTDATA|"><img src="../comu/bt_calendari.gif" alt="|LANG_DINAMICSFORMSELECTDATA|"  /></button>
							<input type="hidden" name="START_TIME_HOUR" value="|START_TIME_HOUR|"><input type="hidden" name="START_TIME_MIN" value="|START_TIME_MIN|"><input type="hidden" name="START_TIME_SEC" value="|START_TIME_SEC|">
							</td>

							<td class="text10" width="80" style="padding:5px;">|LANG_DATE| |LANG_END|: (|LANG_DATEFORMAT|)</td>
							<td class="text10" style="padding:5px;"><input type="text" id="END_TIME" name="END_TIME" value="|END_TIME_DAY|/|END_TIME_MONTH|/|END_TIME_YEAR|" maxlength="10" class="formulari" style="width:80px;"> <button type="reset" id="END_TIME_BUTTON" class="boto_calendari" title="|LANG_DINAMICSFORMSELECTDATA|"><img src="../comu/bt_calendari.gif" alt="|LANG_DINAMICSFORMSELECTDATA|"/></button>
							<input type="hidden" name="END_TIME_HOUR" value="|END_TIME_HOUR|"><input type="hidden" name="END_TIME_MIN" value="|END_TIME_MIN|"><input type="hidden" name="END_TIME_SEC" value="|END_TIME_SEC|">
							</td>
						</tr>
						<tr style="padding:5px;">
							<td class="text10" colspan="4" style="padding:5px;">|LANG_ACTIVATE| |ACTIVAR|</td>
						</tr>
					</table>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "START_TIME",      // id of the input field
        ifFormat       :    "%d/%m/%Y",       // format of the input field
        showsTime      :    false,            // will display a time selector
        button         :    "START_TIME_BUTTON",   // trigger for the calendar (button ID)
        singleClick    :    true,           // double-click mode
        step           :    1,            // show all years in drop-down boxes (instead of every other year as default)
        weekNumbers	   :    false
    });
</script>
<script type="text/javascript">
    Calendar.setup({
        inputField     :    "END_TIME",      // id of the input field
        ifFormat       :    "%d/%m/%Y",       // format of the input field
        showsTime      :    false,            // will display a time selector
        button         :    "END_TIME_BUTTON",   // trigger for the calendar (button ID)
        singleClick    :    true,           // double-click mode
        step           :    1,            // show all years in drop-down boxes (instead of every other year as default)
        weekNumbers	   :    false
    });
</script>

			   </TD>
			</TR>


			<TR>
			   <TD class=text valign=top colspan="2" style="padding-top:10px;">Esculliu categoria: |SELECT_CATEGORY2|
			   </TD>
			</TR>



			<TR>
			   <TD valign=top  colspan=2 style="padding:20px;padding-left:200px;">
			   <INPUT TYPE="hidden" NAME="NOMIMATGEEXIS1" VALUE="|NOMIMATGEEXIS1|" >
 			   <INPUT TYPE="hidden" NAME="NOMIMATGEEXIS2" VALUE="|NOMIMATGEEXIS2|" >
 			   <INPUT TYPE="hidden" NAME="NOMIMATGEEXIS3" VALUE="|NOMIMATGEEXIS3|" >
			   <INPUT TYPE="hidden" NAME="NOMADJUNTEXIS1" VALUE="|NOMADJUNTEXIS1|" >
			   <INPUT TYPE="hidden" NAME="DIN" VALUE="|DIN|" class=boto>
			   <INPUT TYPE="hidden" NAME="MODIFICAT" VALUE="|MODIFICAT|" class=boto>
			   <INPUT TYPE="hidden" NAME="ID" VALUE="|ID|" class=boto>
			   <INPUT TYPE="hidden" NAME="PAGE" VALUE="|PAGE|" class=boto>
			   <INPUT TYPE="submit" NAME="accion" VALUE="Actualitzar" class=boto>
			   </TD>
			</TR>

			</TABLE>

			<!-- taula info -->
<table cellpadding="0" cellspacing="0" border="0" width="98%" style="border-top:solid #000000 2px;">
	<tr>
		<td   class="text9" width="80%" style="border-top:solid #CCCCCC 1px;padding-bottom:5px;padding-top:5px;padding-left:5px;;">

			Creada el |CREATION_DAY|-|CREATION_MONTH|-|CREATION_YEAR| per l'usuari |USUARICREAR| |MODIFICAT|
		</td>

	</tr>
</table>
<!-- /taula info -->

		</td>
		<!-- /FORMULARI ENTRADA -->

	</tr>


</table>
<!-- /PART CENTRAL -->
|PEU|
</form>
</div>
</body>
</html>
