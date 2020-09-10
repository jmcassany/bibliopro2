<html>
<head>
|METAS|

	<script type="text/javascript">
		$(document).ready(function() {
			$('#IDAUTORES_ORIGINAL_TODOS').dblclick(function() {
				var v = $(this).children('option:selected').val();
				var t = $(this).children('option:selected').text();
				$('#IDAUTORES_ORIGINAL').append('<option value="' + v + '" selected="selected">' + t + '</option>');
			});
			$('#IDAUTORES_ORIGINAL').dblclick(function() {
				$(this).children('option:selected').remove();
			});
			$('#IDAUTORES_CAST_TODOS').dblclick(function() {
				var v = $(this).children('option:selected').val();
				var t = $(this).children('option:selected').text();
				$('#IDAUTORES_CAST').append('<option value="' + v + '" selected="selected">' + t + '</option>');
			});
			$('#IDAUTORES_CAST').dblclick(function() {
				$(this).children('option:selected').remove();
			});
			// a l'enviar el form seleccionem tots els options dels selects d'autors
			$('#f1').submit(function() {
				$('#IDAUTORES_ORIGINAL').children('option').attr('selected', 'selected');
				$('#IDAUTORES_CAST').children('option').attr('selected', 'selected');
			});
		});
	</script>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<!-- CAP�ELERA -->
|CAPCELERA|
<!-- /CAP�ELERA -->

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="|CONFIG_URLADMIN|/comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b>Gestió de qüestionaris</b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="70%" class="text10"><img src="|CONFIG_URLADMIN|/comu/icon_plana.gif" width="33" height="18" alt="|LANG_YOUAREIN|" border="0" align="absmiddle">|LANG_YOUAREIN|: <a href="|CONFIG_URLADMIN|/index.php">|LANG_HOME|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="|CONFIG_URLADMIN|/utilitats/index.php">|LANG_UTILS|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php">Gestió de qüestionaris</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">Modificar qüestionari</font></td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="|CONFIG_URLADMIN|/comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">Modificar qüestionari</td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<form action="|ACCIO_FORM|.php" method="post" enctype="multipart/form-data" id="f1">
		<!-- FORMULARI ENTRADA -->
		<td colspan="2" style="padding:10px;" valign="top">
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
				<TR>
					<TD class=text valign=top width="30%">Id cuest:</TD>
					<TD valign=top width="40%"><INPUT TYPE="hidden" NAME="ID_CUEST"  VALUE="|ID_CUEST|">|ID_CUEST|</TD>
					<TD class=text valign=top width="12%">Versió:</TD>
					<TD valign=top width="40%"><INPUT TYPE="hidden" NAME="VERSION"  VALUE="|VERSION|">|VERSION|</TD>
					<TD class=text valign=top width="12%">Sigles:</TD>
					<TD valign=top width="40%"><INPUT TYPE="text" NAME="SIGLAS"  VALUE="|SIGLAS|" SIZE="30" MAXLENGTH="20"></TD>
				</TR>
				<TR>
					<TD class=text valign=top width="20%">Estat:</TD>
					<TD colspan="5" valign=top width="20%">
						<label for="IDENTIFICADO">
							<input type="checkbox" name="IDENTIFICADO" id="IDENTIFICADO"|IDENTIFICADO_CHECKED| />
							<span>Identificado</span>
						</label>&nbsp;&nbsp;
						<label for="DISPONIBLE">
							<input type="checkbox" name="DISPONIBLE" id="DISPONIBLE"|DISPONIBLE_CHECKED| />
							<span>Disponible</span>
						</label>&nbsp;&nbsp;
						<label for="EVALUADO">
							<input type="checkbox" name="EVALUADO" id="EVALUADO"|EVALUADO_CHECKED| />
							<span>Evaluado</span>
						</label>&nbsp;&nbsp;
					</TD>
				</TR>
				<TR>
			</TABLE>
			<fieldset>
				<legend>Original</legend>
				<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
					<TR>
						<TD class=text valign=top width="20%">Nom:</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="NOM_ORIGINAL"  VALUE="|NOM_ORIGINAL|" SIZE="50" MAXLENGTH="200" class="formulari"></TD>
					</TR>
					<TR>
						<TD colspan="2">
							<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
								<TR>
									<TD valign=top width="50%">
										<strong>Autors disponibles:</strong><br />
										|SELECT_AUTORES_ORIGINAL_TODOS|
									</TD>
									<TD valign=top width="50%">
										<strong>Autor(s):</strong><br />
										|SELECT_AUTORES_ORIGINAL|
									</TD>
								</TR>
							</TABLE>
						</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">+Info autor(s):</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="AUTORES_EXTRA_ORIGINAL"  VALUE="|AUTORES_EXTRA_ORIGINAL|" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Referència:</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="REFERENCIA_ORIGINAL"  VALUE="|REFERENCIA_ORIGINAL|" SIZE="50" MAXLENGTH="100" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Link referència:</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="REFERENCIA_ORIGINAL_LINK"  VALUE="|REFERENCIA_ORIGINAL_LINK|" SIZE="50" MAXLENGTH="100" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Correspondència</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="CORRESPONDENCIA_ORIGINAL"  VALUE="|CORRESPONDENCIA_ORIGINAL|" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Link correspondència</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="CORRESPONDENCIA_ORIGINAL_LINK"  VALUE="|CORRESPONDENCIA_ORIGINAL_LINK|" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Email:</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="EMAIL_CONTACTO_ORIGINAL"  VALUE="|EMAIL_CONTACTO_ORIGINAL|" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Telèfon:</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="TELEFONO_CONTACTO_ORIGINAL"  VALUE="|TELEFONO_CONTACTO_ORIGINAL|" SIZE="50" MAXLENGTH="32" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Idioma:</TD>
						<TD valign=top width="80%">|SELECT_IDIOMA|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Pais:</TD>
						<TD valign=top width="80%">|SELECT_PAIS|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Copyright:</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="COPYRIGHT_ORIGINAL"  VALUE="|COPYRIGHT_ORIGINAL|" SIZE="50" MAXLENGTH="50" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top>Altres:</TD>
						<TD valign=top >
|EDITOR_OTROS_ORIGINAL|
						</TD>
					</TR>
<!--					<TR>
						<TD class=text valign=top width="20%">Altres:</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="OTROS_ORIGINAL"  VALUE="|OTROS_ORIGINAL|" SIZE="50" MAXLENGTH="50" class="formulari"></TD>
					</TR>-->
				</TABLE>
			</fieldset>
			<hr>
			<fieldset>
				<legend>Versió espanyola</legend>
				<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
					<TR>
						<TD class=text valign=top width="20%">Nom:</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="NOM_CAST"  VALUE="|NOM_CAST|" SIZE="50" MAXLENGTH="200" class="formulari"></TD>
					</TR>
					<TR>
						<TD colspan="2">
							<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
								<TR>
									<TD valign=top width="50%">
										<strong>Autors disponibles:</strong><br />
										|SELECT_AUTORES_CAST_TODOS|
									</TD>
									<TD valign=top width="50%">
										<strong>Autor(s):</strong><br />
										|SELECT_AUTORES_CAST|
									</TD>
								</TR>
							</TABLE>
						</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">+Info autor(s):</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="AUTORES_EXTRA_CAST"  VALUE="|AUTORES_EXTRA_CAST|" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Referència:</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="REFERENCIA_CAST"  VALUE="|REFERENCIA_CAST|" SIZE="50" MAXLENGTH="100" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Link referència:</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="REFERENCIA_CAST_LINK"  VALUE="|REFERENCIA_CAST_LINK|" SIZE="50" MAXLENGTH="100" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Correspondencia</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="CORRESPONDENCIA_CAST"  VALUE="|CORRESPONDENCIA_CAST|" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Link correspondencia</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="CORRESPONDENCIA_CAST_LINK"  VALUE="|CORRESPONDENCIA_CAST_LINK|" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Email:</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="EMAIL_CONTACTO_CAST"  VALUE="|EMAIL_CONTACTO_CAST|" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Telèfon:</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="TELEFONO_CONTACTO_CAST"  VALUE="|TELEFONO_CONTACTO_CAST|" SIZE="50" MAXLENGTH="32" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Idioma:</TD>
						<TD valign=top width="80%">|SELECT_IDIOMA_CAST|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Copyright:</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="COPYRIGHT_CAST"  VALUE="|COPYRIGHT_CAST|" SIZE="50" MAXLENGTH="50" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top>Altres:</TD>
						<TD valign=top >
|EDITOR_OTROS_CAST|
						</TD>
					</TR>
<!--					<TR>
						<TD class=text valign=top width="20%">Altres:</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="OTROS_CAST"  VALUE="|OTROS_CAST|" SIZE="50" MAXLENGTH="50" class="formulari"></TD>
					</TR>-->
				</TABLE>
			</fieldset>
			<hr />
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
				<TR>
					<TD class=text valign=top width="20%">Tipus de contingut:</TD>
					<TD valign=top width="80%">|SELECT_CONTENIDO|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="20%">Malalties:</TD>
					<TD valign=top width="80%">|SELECT_ENFERMEDAD|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="20%">Població:</TD>
					<TD valign=top width="80%">|SELECT_POBLACION|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="20%">Edat:</TD>
					<TD valign=top width="80%">|SELECT_EDAD|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="20%">Mides:</TD>
					<TD valign=top width="80%">|SELECT_MEDIDA|</TD>
				</TR>
			</TABLE>
			<hr />
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
				<TR>
					<TD class=text valign=top width="12%">Número items:</TD>
					<TD valign=top width="40%"><INPUT TYPE="text" NAME="NUMERO_ITEMS"  VALUE="|NUMERO_ITEMS|" SIZE="10" MAXLENGTH="128"></TD>
					<TD class=text valign=top width="12%">Dimensions:</TD>
					<TD valign=top width="40%"><INPUT TYPE="text" NAME="DIMENSIONES"  VALUE="|DIMENSIONES|" SIZE="40" MAXLENGTH="1024"></TD>
				</TR>
				<TR>
			</TABLE>
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
				<TR>
					<TD class=text valign=top width="20%">Paraules clau:</TD>
					<TD valign=top width="80%"><INPUT TYPE="text" NAME="PALABRAS_CLAVE"  VALUE="|PALABRAS_CLAVE|" SIZE="30" MAXLENGTH="100" class="formulari"></TD>
				</TR>
				<TR>
					<TD class=text valign=top width="20%">E-mails:</TD>
					<TD valign=top width="80%"><INPUT TYPE="text" NAME="EMAILS"  VALUE="|EMAILS|" SIZE="30" MAXLENGTH="255" class="formulari"></TD>
				</TR>
				<TR>
			</TABLE>
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
				<TR>
					<TD class=text valign=top width="20%">Última modificació:</TD>
					<TD valign=top width="80%">|MODIFICAT|</TD>
				</TR>
			</TABLE>
|LINKS_INFO_LEGAL_DESCARGABLES_OTRAS_VERSIONES|
			<HR>
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
				<TR>
					<TD class=text valign=top width="20%"></TD>
						<INPUT TYPE="hidden" NAME="STATUS" VALUE="|STATUS|">
						<INPUT TYPE="hidden" NAME="ID" VALUE="|ID|">
						<INPUT TYPE="hidden" NAME="PAGE" VALUE="|PAGE|">
						<INPUT TYPE="hidden" NAME="USUARI" VALUE="|USUARI|">
						<INPUT TYPE="submit" NAME="accion" VALUE="Enviar" class=boto>
					</TD>
				</TR>
			</TABLE>
		</td>
		<!-- /FORMULARI ENTRADA -->
	</tr>
</table>
<!-- /PART CENTRAL -->
|PEU|
</form>
</body>
</html>