<html>
<head>
|METAS|
<script type="text/javascript" src="|CONFIG_URLADMIN|/js/formularis/jquery.maskedinput-1.1.2.pack.js"></script>
<script type="text/javascript">
jQuery(function($){
  $("#FECHA_COBRO").mask("9999-99-99 99:99:99");
	$("#FECHA_FACTURA").mask("9999-99-99 99:99:99");
	$("#FECHA_VALIDEZ").mask("9999-99-99 99:99:99");
	$("#FECHA_INICIO").mask("9999-99-99");
	$("#FECHA_FINAL").mask("9999-99-99");
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
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="|CONFIG_URLADMIN|/comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b>Gestió de pagaments</b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="70%" class="text10"><img src="|CONFIG_URLADMIN|/comu/icon_plana.gif" width="33" height="18" alt="|LANG_YOUAREIN|" border="0" align="absmiddle">|LANG_YOUAREIN|: <a href="|CONFIG_URLADMIN|/index.php">|LANG_HOME|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="|CONFIG_URLADMIN|/utilitats/index.php">|LANG_UTILS|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../index.php">Gestió de pagaments</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php">Subllicències</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">Modificar subllicència</font></td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="|CONFIG_URLADMIN|/comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">Modificar subllicència</td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<form action="|ACCIO_FORM|.php" method="post" enctype="multipart/form-data">
		<!-- FORMULARI ENTRADA -->
		<td colspan="2" style="padding:10px;" valign="top">
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
				<TR>
					<TD class=text valign=top width="22%">Usuari:</TD>
					<TD valign=top width="40%">|USUARIO|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Qüestionari:</TD>
					<TD valign=top width="40%">|CUESTIONARIO|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Data sol·licitud:</TD>
					<TD valign=top width="40%">|FECHA_SOLICITUD|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Estat:</TD>
					<TD valign=top width="40%">|SELECT_STATUS|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Atorgament:</TD>
					<TD valign=top width="40%">|SELECT_OTORGADA|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Document atorgació:</TD>
					<TD valign=top width="40%">|DOCUMENT_ATORGACIO|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Data atorgada:</TD>
					<TD valign=top width="40%">
						|FECHA_OTORGADA|
						<INPUT TYPE="hidden" NAME="FECHA_OTORGADA" VALUE="|FECHA_OTORGADA|">
					</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Vàlida fins:</TD>
					<TD valign=top width="40%"><INPUT TYPE="text" NAME="FECHA_VALIDEZ" id="FECHA_VALIDEZ" VALUE="|FECHA_VALIDEZ|" SIZE="12" MAXLENGTH="19" class="formulari"></TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Mètode de pagament:</TD>
					<TD valign=top width="40%">|METODO_PAGO|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Import:</TD>
					<TD valign=top width="40%">|PRECIO|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">IVA:</TD>
					<TD valign=top width="40%">|IVA| (|TIPO_IVA|%)</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Total:</TD>
					<TD valign=top width="40%">|TOTAL|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Data cobrament:</TD>
					<TD valign=top width="40%"><INPUT TYPE="text" NAME="FECHA_COBRO" id="FECHA_COBRO" VALUE="|FECHA_COBRO|" SIZE="12" MAXLENGTH="19" class="formulari"></TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Id TPV:</TD>
					<TD valign=top width="40%">|ID_TPV|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Núm. factura:</TD>
					<TD valign=top width="40%"><INPUT TYPE="text" NAME="FACTURA" VALUE="|FACTURA|" SIZE="12" MAXLENGTH="128" class="formulari"></TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Data factura:</TD>
					<TD valign=top width="40%"><INPUT TYPE="text" NAME="FECHA_FACTURA" id="FECHA_FACTURA" VALUE="|FECHA_FACTURA|" SIZE="12" MAXLENGTH="19" class="formulari"></TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Vol factura:</TD>
					<TD valign=top width="40%">|SOLICITA_FACTURA|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="20%">Fitxer factura:</TD>
					<TD valign=top width="80%">
						|LINK_FICHERO_FACTURA|
						<input type="file" name="FICHERO_FACTURA" size="50" class="formulari">
					</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Núm. albarà intern:</TD>
					<TD valign=top width="40%">|NUM_ALBARAN|</TD>
				</TR>
			</TABLE>
			<fieldset style="margin: 15px 0;">
				<legend>Dades sobre l'estudi</legend>
				<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
					<TR>
						<TD class=text valign=top width="12%">Ús:</TD>
						<TD valign=top width="40%">|USO|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Ús (altres):</TD>
						<TD valign=top width="40%">|USO_OTROS|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Finançament:</TD>
						<TD valign=top width="40%">|FINANCIACION_ENTIDAD|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Entidad desde la que solicita la sublicencia:</TD>
						<TD valign=top width="40%">|ENTIDAD_SOLICITANTE|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Promotor:</TD>
						<TD valign=top width="40%">|PROMOTOR|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Títol:</TD>
						<TD valign=top width="40%">|TITULO|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Objectius:</TD>
						<TD valign=top width="40%">|OBJETIVOS|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Data inici:</TD>
						<TD valign=top width="40%"><INPUT TYPE="text" NAME="FECHA_INICIO" id="FECHA_INICIO" VALUE="|FECHA_INICIO|" SIZE="12" MAXLENGTH="19" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Data final:</TD>
						<TD valign=top width="40%"><INPUT TYPE="text" NAME="FECHA_FINAL" id="FECHA_FINAL" VALUE="|FECHA_FINAL|" SIZE="12" MAXLENGTH="19" class="formulari"></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Disseny:</TD>
						<TD valign=top width="40%">|DISENO_ESTUDIO|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Núm administracions:</TD>
						<TD valign=top width="40%">|NUM_ADMINISTRACIONES|</TD>
					</TR>

					|RESPUESTAS|

					<TR>
						<TD class=text valign=top width="12%">Disseny (altres):</TD>
						<TD valign=top width="40%">|DISENO_ESTUDIO_OTROS|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Enfermetat o símptoma:</TD>
						<TD valign=top width="40%">|ENFERMEDAD|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Població:</TD>
						<TD valign=top width="40%">|POBLACION|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Mode admin.:</TD>
						<TD valign=top width="40%">|MODO_ADMIN|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Suport:</TD>
						<TD valign=top width="40%">|SOPORTE_TECNICO|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Comentaris:</TD>
						<TD valign=top width="40%">|COMENTARIOS|</TD>
					</TR>
				</TABLE>
			</fieldset>
			<fieldset style="margin: 15px 0;">
				<legend>Dades facturació</legend>
				<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
					<TR>
						<TD class=text valign=top width="12%">CIF:</TD>
						<TD valign=top width="40%">|FACTURACION_CIF|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Empresari o professional:</TD>
						<TD valign=top width="40%">|FACTURACION_PROFESIONAL|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Nom:</TD>
						<TD valign=top width="40%">|FACTURACION_NOMBRE|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Adreça:</TD>
						<TD valign=top width="40%">|FACTURACION_DIRECCION|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Codi postal:</TD>
						<TD valign=top width="40%">|FACTURACION_CP|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Ciutat:</TD>
						<TD valign=top width="40%">|FACTURACION_CIUDAD|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Pais:</TD>
						<TD valign=top width="40%">|FACTURACION_PAIS|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Canàries, Ceuta o Melilla:</TD>
						<TD valign=top width="40%">|FACTURACION_OTRO_PAIS|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Telèfon:</TD>
						<TD valign=top width="40%">|FACTURACION_TELEFONO|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Fax:</TD>
						<TD valign=top width="40%">|FACTURACION_FAX|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="12%">Email:</TD>
						<TD valign=top width="40%">|FACTURACION_EMAIL|</TD>
					</TR>
				</TABLE>
			</fieldset>
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
				<TR>
					<TD class=text valign=top>Comentaris interns:</TD>
					<TD valign=top >
|EDITOR_COMENTARIOS_INTERNOS|
					</TD>
				</TR>
			</TABLE>
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
				<TR>
					<TD class=text valign=top width="20%"></TD>
						<INPUT TYPE="hidden" NAME="ID" VALUE="|ID|" class=boto>
						<INPUT TYPE="hidden" NAME="USUARI" VALUE="|USUARI|" class=boto>
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