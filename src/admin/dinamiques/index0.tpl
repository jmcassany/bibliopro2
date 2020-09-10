<html>
<head>
|METAS|
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<!-- CAPÇELERA -->
|CAPCELERA|
<!-- /CAPÇELERA -->

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;margin-bottom:0px">

	<!-- situacio Sou a -->
	<tr>
		<td class="text10" bgcolor="#FDDBCA" style="padding:6px;" colspan="2"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b>|LANGTITOL|</b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="60%" class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="|LANGETSA|" border="0" align="absmiddle">|LANGETSA|: <a href="../index.php">|LANGHOME|</a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">|DESCRIPCIOCARPETA|</font></td>
					<td width="40%" class="vermell10b" align="right">
|EDITACATEGORIA|&nbsp;&nbsp;&nbsp;
|NEW|
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
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">|LANGLIST| (|TOTAL|)</td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">
					<!-- buscador -->
						<form action="index.php" method="post">
						<input type="hidden" name="DIN" value="|DIN|">
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
					<td  bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10">
						<img src="../comu/icon_veure.gif" alt="|LANGVIEW|" width="19" height="16" border="0" align="absmiddle">|LANGVIEW|&nbsp;&nbsp;&nbsp;
|EDIT_LEGEND|
|CLONE_LEGEND|
|DELETE_LEGEND|
					</td>
					<td align="right" bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10">
					|RUTAWEB|
					</td>
				</tr>
				<!-- /llegendes -->
  				|RESULTAT|
			</table>
		</td>
	</tr>




	<tr>
		<form action="delete.php" method="post">
		<input type="hidden" name="DIN" value="|DIN|">
		<input type="hidden" name="PAGE" value="|PAGE|">
		<!-- LLISTAT PAGINES -->
		<td colspan="2" style="padding:5px;" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr bgcolor="#efefef">
					<td class="gris11b" ></td>
					<td class="gris11b"  valign="top" style="padding-left:0px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ordenar=titol&ordre=|ORDRE|&DIN=|DIN|"  style="background-color:|COLOR1|;" class="titolllistat">|ICO1||LANGLISTTITOL|</a></td>
					<td class="gris11b"  valign="top" style="padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ordenar=data&ordre=|ORDRE|&DIN=|DIN|"  style="background-color:|COLOR2|;" class="titolllistat">|ICO2||LANGLISTCREATION|</a></td>
					<td class="gris11b"  valign="top" style="padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ordenar=estat&ordre=|ORDRE|&DIN=|DIN|"  style="background-color:|COLOR3|;" class="titolllistat">|ICO3||LANGLISTSTATUS|</a></td>
					<td class="gris11b"  valign="top" style="padding-left:10px;padding-top:5px;padding-bottom:5px;padding-right:3px;"><a href="index.php?ordenar=ordre&ordre=|ORDRE|&DIN=|DIN|"  style="background-color:|COLOR4|;" class="titolllistat">|ICO4||LANGLISTORDER|</a></td>

				</tr>

				<!-- BLOCK_BEGIN_ROW  -->
				<tr>
					<td width="26%" style="border-bottom:solid #cccccc 1px;border-right:solid #cccccc 1px;">
						<a href="|LINK|/view.php?ID=|ID|" target="_blank"><img src="../comu/icon_veure.gif" alt="Veure" width="19" height="16" border="0" align="absmiddle"></a>
|EDIT_OPTION|
|CLONE_OPTION|
						<a href="moure.php?ID=|ID|&DIN=|DIN|&accio=up&;PAGE=|PAGE|"><img src="../comu/icon_pujaform.gif" alt="Pujar" width="13" height="14" border="0" align="absmiddle"   style="margin-right:4px;"></a>
						<a href="moure.php?ID=|ID|&DIN=|DIN|&accio=down&;PAGE=|PAGE|" ><img src="../comu/icon_baixaform.gif" alt="Baixar" width="13" height="14" border="0" align="absmiddle" ></a>
|DELETE_OPTION|
					</td>
|INFO|
				</tr>
				<!-- BLOCK_END_ROW  -->
			</table>
		</td>
		<!-- LLISTAT PAGINES -->

	</tr>

	<tr>
		<td colspan="2" style="padding:5px;">
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
