<html>
<head>
|METAS|
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
					<td width="70%" class="text10"><img src="|CONFIG_URLADMIN|/comu/icon_plana.gif" width="33" height="18" alt="|LANG_YOUAREIN|" border="0" align="absmiddle">|LANG_YOUAREIN|: <a href="|CONFIG_URLADMIN|/index.php">|LANG_HOME|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="|CONFIG_URLADMIN|/utilitats/index.php">|LANG_UTILS|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../index.php">Gestió de qüestionaris</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php">Usuaris</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">Modificar usuari</font></td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="|CONFIG_URLADMIN|/comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">Modificar usuari</td>
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
				<INPUT TYPE="hidden" NAME="EMAIL"  VALUE="|EMAIL|">
				<TR>
					<TD class=text valign=top width="20%">Correu electrònic:</TD>
					<TD valign=top width="80%">|EMAIL|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="20%">Nom:</TD>
					<TD valign=top width="80%">|NOMBRE|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="20%">Tipus entitat:</TD>
<!-- 					<TD valign=top width="80%">|SELECT_TIPO_ENTIDAD|</TD> -->
					<TD valign=top width="80%">|TIPO_ENTIDAD|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="20%">Pais:</TD>
<!-- 					<TD valign=top width="80%">|SELECT_PAIS|</TD> -->
					<TD valign=top width="80%">|PAIS|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="20%">Ceuta o Melilla:</TD>
					<TD valign=top width="80%">|OTRO_PAIS|</TD>
				</TR>
			</TABLE>
			<fieldset>
				<legend>Dades de contacte</legend>
				<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
					<TR>
						<TD class=text valign=top width="20%">Nom entitat:</TD>
						<TD valign=top width="80%"><!--<INPUT TYPE="text" NAME="ENTIDAD_NOMBRE"  VALUE="-->|ENTIDAD_NOMBRE|<!--" SIZE="40" MAXLENGTH="255" class="formulari">--></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Tipus centre treball:</TD>
<!-- 						<TD valign=top width="80%">|SELECT_TIPO_CENTRO_TRABAJO|</TD> -->
						<TD valign=top width="80%">|TIPO_CENTRO_TRABAJO|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Adreça entitat:</TD>
						<TD valign=top width="80%"><!--<INPUT TYPE="text" NAME="ENTIDAD_DIRECCION"  VALUE="-->|ENTIDAD_DIRECCION|<!--" SIZE="40" MAXLENGTH="255" class="formulari">--></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Població entitat:</TD>
						<TD valign=top width="80%"><!--<INPUT TYPE="text" NAME="ENTIDAD_CIUDAD"  VALUE="-->|ENTIDAD_CIUDAD|<!--" SIZE="40" MAXLENGTH="128" class="formulari">--></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Codi postal entitat:</TD>
						<TD valign=top width="80%"><!--<INPUT TYPE="text" NAME="ENTIDAD_CP"  VALUE="-->|ENTIDAD_CP|<!--" SIZE="10" MAXLENGTH="16" class="formulari">--></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Telèfon entitat:</TD>
						<TD valign=top width="80%"><!--<INPUT TYPE="text" NAME="ENTIDAD_TELEFONO"  VALUE="-->|ENTIDAD_TELEFONO|<!--" SIZE="10" MAXLENGTH="16" class="formulari">--></TD>
					</TR>
				</TABLE>
			</fieldset>
			<hr />
			<fieldset>
				<legend>Dades de facturació</legend>
				<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
					<TR>
						<TD class=text valign=top width="20%">Nom facturació:</TD>
						<TD valign=top width="80%"><!--<INPUT TYPE="text" NAME="FACTURACION_NOMBRE"  VALUE="-->|FACTURACION_NOMBRE|<!--" SIZE="40" MAXLENGTH="255" class="formulari">--></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">CIF facturació:</TD>
						<TD valign=top width="80%"><!--<INPUT TYPE="text" NAME="FACTURACION_CIF"  VALUE="-->|FACTURACION_CIF|<!--" SIZE="10" MAXLENGTH="20" class="formulari">--></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Prof. o empresa:</TD>
						<TD valign=top width="80%"><!--<INPUT TYPE="text" NAME="FACTURACION_CIF"  VALUE="-->|FACTURACION_PROFESIONAL|<!--" SIZE="10" MAXLENGTH="20" class="formulari">--></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Adreça facturació:</TD>
						<TD valign=top width="80%"><!--<INPUT TYPE="text" NAME="FACTURACION_DIRECCION"  VALUE="-->|FACTURACION_DIRECCION|<!--" SIZE="40" MAXLENGTH="255" class="formulari">--></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Pais facturació:</TD>
						<!--<TD valign=top width="80%">|SELECT_PAIS_FACTURACIO|</TD>-->
						<TD valign=top width="80%">|FACTURACION_PAIS|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Ceuta o Melilla:</TD>
						<TD valign=top width="80%">|FACTURACION_OTRO_PAIS|</TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Codi postal facturació:</TD>
						<TD valign=top width="80%"><!--<INPUT TYPE="text" NAME="FACTURACIION_CP"  VALUE="-->|FACTURACION_CP|<!--" SIZE="10" MAXLENGTH="16" class="formulari">--></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Telèfon facturació:</TD>
						<TD valign=top width="80%"><!--<INPUT TYPE="text" NAME="FACTURACION_TELEFONO"  VALUE="-->|FACTURACION_TELEFONO|<!--" SIZE="10" MAXLENGTH="16" class="formulari">--></TD>
					</TR>
					<TR>
						<TD class=text valign=top width="20%">Email facturació:</TD>
						<TD valign=top width="80%"><!--<INPUT TYPE="text" NAME="FACTURACION_EMAIL"  VALUE="-->|FACTURACION_EMAIL|<!--" SIZE="40" MAXLENGTH="255" class="formulari">--></TD>
					</TR>
				</TABLE>
			</fieldset>
			<hr />
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
				<TR>
					<TD class=text valign=top width="10%">Newsletter:</TD>
					<TD valign=top width="80%"><INPUT TYPE="checkbox" NAME="NEWSLETTER" class="radio"|NEWSLETTER_CHECKED|></TD>
				</TR>
			</TABLE>
			<hr />
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
				<TR>
					<TD class=text valign=top width="20%"></TD>
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