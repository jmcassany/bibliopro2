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
					<td width="70%" class="text10"><img src="|CONFIG_URLADMIN|/comu/icon_plana.gif" width="33" height="18" alt="|LANG_YOUAREIN|" border="0" align="absmiddle">|LANG_YOUAREIN|: <a href="|CONFIG_URLADMIN|/index.php">|LANG_HOME|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="|CONFIG_URLADMIN|/utilitats/index.php">|LANG_UTILS|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../index.php">Gestió de qüestionaris</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../view.php?ID=|ID|">Modificar qüestionari</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">Subllicència</font></td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="|CONFIG_URLADMIN|/comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">Modificar qüestionari (informació legal)</td>
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
					<TD class=text valign=top width="18%">Autorización autor original:</TD>
					<TD valign=top width="40%">|SELECT_AUT_ORIGINAL|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="18%">Autorización autor adaptación:</TD>
					<TD valign=top width="40%">|SELECT_AUT_ADAPTACION|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="18%">Tipo autorización otorgada:</TD>
					<TD valign=top width="40%">|SELECT_TIPO_AUT|</TD>
				</TR>
			</TABLE>
			<fieldset>
				<legend><strong>Contracte</strong></legend>
				<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
					<TR>
						<TD class=text valign=top width="20%">Data:</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="FECHA_CONTRATO"  VALUE="|FECHA_CONTRATO|" SIZE="20" MAXLENGTH="128"></TD>
						<TD class=text valign=top width="20%">Codi:</TD>
						<TD valign=top width="80%"><INPUT TYPE="text" NAME="CODIGO_CONTRATO"  VALUE="|CODIGO_CONTRATO|" SIZE="15" MAXLENGTH="32"></TD>
					</TR>
					<TR>
						<TD colspan="2" class=text valign=top width="20%">Institucions firmants:</TD>
						<TD colspan="2" valign=top width="80%"><INPUT TYPE="text" NAME="INSTITUCIONES_CONTRATO"  VALUE="|INSTITUCIONES_CONTRATO|" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
					</TR>
					<TR>
						<TD colspan="2" class=text valign=top width="20%">Fitxer contracte:</TD>
						<TD colspan="2" valign=top width="80%">
							|LINK_FICHERO_CONTRATO|
							<input type="file" name="FICHERO_CONTRATO" size="50" class="formulari">
						</TD>
					</TR>
					<TR>
						<TD colspan="2" class=text valign=top width="20%">Visible web:</TD>
						<TD colspan="2" valign=top width="80%"><INPUT TYPE="checkbox" NAME="VISIBLE_WEB"  VALUE="|VISIBLE_WEB|" class="radio"|VISIBLE_CHECKED|></TD>
					</TR>
				</TABLE>
			</fieldset>
			<hr>
			<TABLE cellpadding="5" cellspacing="0" border="0">
				<TR>
					<TD class=text valign=top>Subllicència per BiblioPRO:</TD>
					<TD valign=top align="left"><INPUT TYPE="checkbox" NAME="SUBLICENCIA_BIBLIOPRO" class="radio"|SUBLICENCIA_BIBLIOPRO_CHECKED|></TD>
				</TR>
			</TABLE>
			<hr>
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
				<TR>
					<TD class=text valign=top width="30%">Comentaris (ús intern):</TD>
					<TD valign=top width="40%"><INPUT TYPE="text" NAME="COMENTARIOS"  VALUE="|COMENTARIOS|" SIZE="50" MAXLENGTH="255" class="formulari"></TD>
				</TR>
				<TR>
					<TD class=text valign=top width="30%">Explicació sol·licitud:</TD>
					<TD valign=top width="40%">|EDITOR_EXPLICACION|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="30%">Text acceptació llicència:</TD>
					<TD valign=top width="40%">|EDITOR_ACEPTACION|</TD>
				</TR>
				<TR>
					<TD class=text valign=top width="18%">Fitxer subllicència:</TD>
					<TD valign=top width="40%">
						|LINK_FICHERO_SUBLICENCIA|
						<input type="file" name="FICHERO_SUBLICENCIA" size="50" class="formulari">
					</TD>
				</TR>
			</TABLE>
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0">
				<TR>
					<TD class=text valign=top width="20%"></TD>
						<INPUT TYPE="hidden" NAME="STATUS" VALUE="1" class=boto>
						<INPUT TYPE="hidden" NAME="ID" VALUE="|ID|" class=boto>
						<INPUT TYPE="hidden" NAME="VISIBILITY" VALUE="|VISIBILITY|" class=boto>
						<INPUT TYPE="hidden" NAME="USUARI" VALUE="|USUARI|" class=boto>
						<INPUT TYPE="submit" NAME="accion" VALUE="Enviar" class=boto>
					</TD>
				</TR>
			</TABLE>
			<HR>
			<TABLE width="100%" cellpadding="15" cellspacing="3" border="0">
				<TR>
					<TD class="text" valign="middle" width="33%" style="background: #dfdfdf;">
						<a href="preus/index.php?ID_SUBLICENCIA=|ID|"><img src="|CONFIG_URLADMIN|/comu/questionaris/icona-preus.gif" alt="" border="0" style="vertical-align: middle;" /></a>
						<a href="preus/index.php?ID_SUBLICENCIA=|ID|"><strong>Modificar preus de la subllicència</strong></a>
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