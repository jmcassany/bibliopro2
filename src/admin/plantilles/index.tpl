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
		<td colspan="2" class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b>|LANGPLANTILLATITOL|</b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="|LANGETSA|" border="0" align="absmiddle">|LANGETSA|: <a href="../index.php">|LANGHOME|</a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">|LANGPLANTILLATITOL|</font></td>
					<td width="50%" class="vermell10b" align="right">
|NEWTEMPLATE|
					</td>
				</tr>
			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">|LANGLLISTA| (|TOTAL|)</td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">
					<!-- buscador -->
						<form action="index.php" method="post">
						<table cellpadding="2" cellspacing="2" border="0">
							<tr>
								<td width="10"><img src="../comu/icon_cerca.gif" alt="" width="10" height="10" border="0" ></td>
								<td><input type="text" name="cerca"  size="25" maxlength="40" style="width:100px;background-color:#FFFFFF" class="text10"></td>
								<td valign="bottom"><input type="submit" name="accion" value="|LANGCERCA|" class="text10"></td>
							</tr>
						</form>
						</table>
					</td>
				</tr>
				<!-- llegendes -->
				<tr>
					<td colspan="2" bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10">

						<img src="../comu/icon_veure.gif" alt="Veure" width="19" height="16" border="0" align="absmiddle">|LANGVIEW|&nbsp;&nbsp;&nbsp;
|EDIT_LEGEND|
|CLONE_LEGEND|
|DELETE_LEGEND|
					</td>
				</tr>
				<!-- /llegendes -->
  				|RESULTAT|
			</table>
		</td>
	</tr>




	<tr>
		<form action="delete.php" method="post">
		<!-- LLISTAT PAGINES -->
		<td colspan="2" style="padding:10px;" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr bgcolor="#efefef">
					<td class="gris11b" width="15%"></td>
					<td class="gris11b" width="50%" valign="top" style="padding-left:0px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ordenar=nom&ordre=|ORDRE|"  style="background-color:|COLOR1|;" class="titolllistat">|ICO1||LANGTEMPLATE|</a></td>
					<td class="gris11b" width="15%" valign="top" style="padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ordenar=data&ordre=|ORDRE|"  style="background-color:|COLOR2|;" class="titolllistat">|ICO2||LANGCREATIONDATE|</a></td>
					<td class="gris11b" width="20%" valign="top" style="padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ordenar=carpeta&ordre=|ORDRE|"  style="background-color:|COLOR3|;" class="titolllistat">|ICO3||LANGCARPETA|</a></td>

				</tr>

				<!-- BLOCK_BEGIN_ROW  -->
				<tr>
					<td width="20%" style="border-bottom:solid #cccccc 1px;border-right:solid #cccccc 1px;">
						<a href="veure.php?plantilla=|ID|" target="_blank"><img src="../comu/icon_veure.gif" alt="Veure" width="19" height="16" border="0" align="absmiddle"></a>
|EDIT_OPTION|
|CLONE_OPTION|
|DELETE_OPTION|
					</td>
|TEMPLATE_INFO|
				</tr>
				<!-- BLOCK_END_ROW  -->
			</table>
		</td>
		<!-- LLISTAT PAGINES -->

	</tr>

	<tr>
		<td colspan="2" style="padding:10px;">
		<!-- navegacio pag -->
			<table cellpadding="0" cellspacing="0" border="0" width="100%" style="padding:5px;border-bottom:solid #CCCCCC 1px;border-top:solid #CCCCCC 1px;" bgcolor="#F7F7F7">
				<tr>
					<td class="text10"><img src="../comu/icon_pag.gif" width="8" height="10" alt="" border="0" align="absmiddle" style="margin-right:5px;">|PAGEPREV|</td>
					<td class="text10" align="center">|PAGE| de |PMAX| - |PAGELIST| </td>
					<td align="right" class="text10">|PAGENEXT|<img src="../comu/icon_pag.gif" width="8" height="10" alt="" border="0" align="absmiddle" style="margin-left:5px;"></td>
				</tr>
			</table>
		<!-- /navegacio pag -->
|DELETE_CONFIRM|
		</td>
	</tr>
</table>
<!-- /PART CENTRAL -->
|PEU|
</form>

</body>
</html>

