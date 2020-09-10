<html>
<head>
|METAS|
	<script type="text/javascript">
		$(document).ready(function() {
			$('#TIPO').change(function() {
				if ($(this).val() == '2' || $(this).val() == '3' || $(this).val() == '4') {
					$('#PROTEGIDO_LOGIN').attr('checked', 'checked');
				}
			})
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
					<td width="70%" class="text10"><img src="|CONFIG_URLADMIN|/comu/icon_plana.gif" width="33" height="18" alt="|LANG_YOUAREIN|" border="0" align="absmiddle">|LANG_YOUAREIN|: <a href="|CONFIG_URLADMIN|/index.php">|LANG_HOME|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="|CONFIG_URLADMIN|/utilitats/index.php">|LANG_UTILS|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../index.php">Gestió de qüestionaris</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../view.php?ID=|ID_CUEST|">Modificar qüestionari</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php?ID_CUEST=|ID_CUEST|">Descarregables</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">Modificar descarregable</font></td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="|CONFIG_URLADMIN|/comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">Modificar descarregable</td>
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
					<TD class=text valign=top width="20%">Tipus:</TD>
					<TD valign=top width="80%">|SELECT_TIPO|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="20%">Fitxer:</TD>
					<TD valign=top width="80%">
						|LINK_FICHERO|
						<input type="file" name="FICHERO" size="50" class="formulari">
					</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="20%">Enllaç <span style="color: #cc0000; font-weight: bold;">*</span>:</TD>
			  	<TD valign=top width="80%"><INPUT TYPE="text" NAME="LINK"  VALUE="|LINK|" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
				</TR>
				<TR>
					<TD class=text valign=top width="20%">Visible al web:</TD>
			  		<TD valign=top width="80%"><INPUT TYPE="checkbox" NAME="VISIBLE" id="VISIBLE" class="radio"|VISIBLE_CHECKED|></TD>
				</TR>
				<TR>
					<TD class=text valign=top width="20%">Protegit login:</TD>
			  		<TD valign=top width="80%"><INPUT TYPE="checkbox" NAME="PROTEGIDO_LOGIN" id="PROTEGIDO_LOGIN" class="radio"|PROTEGIDO_CHECKED|></TD>
				</TR>
				<TR>
					<TD class=text valign=top width="20%">Requereix subllicència:</TD>
			  	<TD valign=top width="80%"><INPUT TYPE="checkbox" NAME="SUBLICENCIA" class="radio"|SUBLICENCIA_CHECKED|></TD>
				</TR>
			</TABLE>
			<fieldset>
				<legend>Preus descarregable</legend>
				<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
					<TR>
						<TD>&nbsp;</TD>
						<TD align="middle" colspan="2"><strong>Lucre</strong></TD>
						<TD align="middle" colspan="2"><strong>No lucre</strong></TD>
						<TD align="middle" colspan="2"><strong>Acadèmic</strong></TD>
					</TR>
					<TR>
						<TD>&nbsp;</TD>
						<TD align="middle">Normal</TD>
						<TD align="middle">Subscripció</TD>
						<TD align="middle">Normal</TD>
						<TD align="middle">Subscripció</TD>
						<TD align="middle">Normal</TD>
						<TD align="middle">Subscripció</TD>
					<TR>
					<TR>
						<TD align="right">Normal</TD>
						<TD valign="top"><INPUT TYPE="text" NAME="PRECIO_LUCRO_IND"  VALUE="|PRECIO_LUCRO_IND|" SIZE="8" MAXLENGTH="11"></TD>
						<TD valign="top"><INPUT TYPE="text" NAME="PRECIO_LUCRO_SUBS"  VALUE="|PRECIO_LUCRO_SUBS|" SIZE="8" MAXLENGTH="11"></TD>
						<TD valign="top"><INPUT TYPE="text" NAME="PRECIO_NO_LUCRO_IND"  VALUE="|PRECIO_NO_LUCRO_IND|" SIZE="8" MAXLENGTH="11"></TD>
						<TD valign="top"><INPUT TYPE="text" NAME="PRECIO_NO_LUCRO_SUBS"  VALUE="|PRECIO_NO_LUCRO_SUBS|" SIZE="8" MAXLENGTH="11"></TD>
						<TD valign="top"><INPUT TYPE="text" NAME="PRECIO_IND_IND"  VALUE="|PRECIO_IND_IND|" SIZE="8" MAXLENGTH="11"></TD>
						<TD valign="top"><INPUT TYPE="text" NAME="PRECIO_IND_SUBS"  VALUE="|PRECIO_IND_SUBS|" SIZE="8" MAXLENGTH="11"></TD>
					</TR>
					<TR>
						<TD align="right">Amèrica llatina</TD>
						<TD valign="top"><INPUT TYPE="text" NAME="PRECIO_LUCRO_IND_AL"  VALUE="|PRECIO_LUCRO_IND_AL|" SIZE="8" MAXLENGTH="11"></TD>
						<TD valign="top"><INPUT TYPE="text" NAME="PRECIO_LUCRO_SUBS_AL"  VALUE="|PRECIO_LUCRO_SUBS_AL|" SIZE="8" MAXLENGTH="11"></TD>
						<TD valign="top"><INPUT TYPE="text" NAME="PRECIO_NO_LUCRO_IND_AL"  VALUE="|PRECIO_NO_LUCRO_IND_AL|" SIZE="8" MAXLENGTH="11"></TD>
						<TD valign="top"><INPUT TYPE="text" NAME="PRECIO_NO_LUCRO_SUBS_AL"  VALUE="|PRECIO_NO_LUCRO_SUBS_AL|" SIZE="8" MAXLENGTH="11"></TD>
						<TD valign="top"><INPUT TYPE="text" NAME="PRECIO_IND_IND_AL"  VALUE="|PRECIO_IND_IND_AL|" SIZE="8" MAXLENGTH="11"></TD>
						<TD valign="top"><INPUT TYPE="text" NAME="PRECIO_IND_SUBS_AL"  VALUE="|PRECIO_IND_SUBS_AL|" SIZE="8" MAXLENGTH="11"></TD>
					</TR>
				</TABLE>
			</fieldset>
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0" style="padding-top: 5px;">
				<TR>
					<TD class=text valign=top>Descàrregues realitzades: <strong>|CONTADOR|</TD>
				</TR>
			</TABLE>
			<hr />
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
				<TR>
					<TD class=text valign=top><span style="color: #cc0000; font-weight: bold;">*</span> L'enllaç només apareixerà si no s'ha indicat cap fitxer</TD>
				</TR>
			</TABLE>
			<hr />
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
				<TR>
					<TD class=text valign=top width="20%"></TD>
						<INPUT TYPE="hidden" NAME="ID" VALUE="|ID|" class=boto>
						<INPUT TYPE="hidden" NAME="ID_CUEST" VALUE="|ID_CUEST|" class=boto>
						<INPUT TYPE="hidden" NAME="PAGE" VALUE="|PAGE|" class=boto>
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