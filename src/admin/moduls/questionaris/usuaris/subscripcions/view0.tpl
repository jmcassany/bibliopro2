<html>
<head>
|METAS|
<script type="text/javascript" src="|CONFIG_URLADMIN|/js/formularis/jquery.maskedinput-1.1.2.pack.js"></script>
<script type="text/javascript">
jQuery(function($){
  $("#FECHA_ACTIVACION").mask("9999-99-99 99:99:99");
	$("#FECHA_FACTURA").mask("9999-99-99 99:99:99");
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
					<td width="70%" class="text10"><img src="|CONFIG_URLADMIN|/comu/icon_plana.gif" width="33" height="18" alt="|LANG_YOUAREIN|" border="0" align="absmiddle">|LANG_YOUAREIN|: <a href="|CONFIG_URLADMIN|/index.php">|LANG_HOME|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="|CONFIG_URLADMIN|/utilitats/index.php">|LANG_UTILS|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../index.php">Gestió de qüestionaris</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../index.php">Usuaris</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php">Subscripcions</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">Modificar subscripció</font></td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="|CONFIG_URLADMIN|/comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">Modificar subscripció</td>
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
					<TD class=text valign=top width="22%">Estat subscripció:</TD>
					<TD valign=top width="40%">|SELECT_STATUS|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Data sol·licitud:</TD>
					<TD valign=top width="40%">|FECHA_SOLICITUD|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="20%">Data activació:</TD>
					<TD valign=top width="40%"><INPUT TYPE="text" NAME="FECHA_ACTIVACION" VALUE="|FECHA_ACTIVACION|" id="FECHA_ACTIVACION" SIZE="12" MAXLENGTH="19" class="formulari"></TD>
				<TR>
				<TR>
					<TD class=text valign=top width="22%">Vàlida fins:</TD>
					<TD valign=top width="40%">|FECHA_VALIDEZ|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Mètode de pagament:</TD>
					<TD valign=top width="40%">|METODO_PAGO|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="22%">Import:</TD>
					<TD valign=top width="40%">|PRECIO|</TD>
				<TR>
				<TR>
					<TD class=text valign=top width="22%">IVA:</TD>
					<TD valign=top width="40%">|IVA| (|TIPO_IVA|%)</TD>
				<TR>
				<TR>
					<TD class=text valign=top width="22%">Total:</TD>
					<TD valign=top width="40%">|TOTAL|</TD>
				<TR>
				</TR>
					<TD class=text valign=top width="22%">Id TPV:</TD>
					<TD valign=top width="40%">|ID_TPV|</TD>
				<TR>
				<TR>
					<TD class=text valign=top width="22%">Núm. factura:</TD>
					<TD valign=top width="40%"><INPUT TYPE="text" NAME="FACTURA" VALUE="|FACTURA|" SIZE="12" MAXLENGTH="128" class="formulari"></TD>
				<TR>
				<TR>
					<TD class=text valign=top width="22%">Data factura:</TD>
					<TD valign=top width="40%"><INPUT TYPE="text" NAME="FECHA_FACTURA" VALUE="|FECHA_FACTURA|" id="FECHA_FACTURA" SIZE="12" MAXLENGTH="128" class="formulari"></TD>
				<TR>
				<TR>
					<TD class=text valign=top width="22%">Vol factura:</TD>
					<TD valign=top width="40%">|SOLICITA_FACTURA|</TD>
				<TR>
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
				<TR>
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