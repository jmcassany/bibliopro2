<html>
<head>
|METAS|
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<!-- CAPÇELERA -->
|CAPCELERA|
<!-- /CAPÇELERA -->

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">			
	
	<!-- situacio Sou a -->
	<tr>
		<td colspan="2" class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b>|USERSTITOL|</b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">	
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td width="50%" class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="Sou a" border="0" align="absmiddle">|ETSA|: <a href="../index.php">|HOME|</a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">|USERSTITOL|</font></td>
					<td width="50%" class="vermell10b" align="right">
|NEWUSER|
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
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">|USERSLIST|</td>					

					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">
						<form action="index.php" method="post">
						<table cellpadding="2" cellspacing="2" border="0">
							<tr>
								<td width="10"><img src="../comu/icon_cerca.gif" alt="" width="10" height="10" border="0" ></td>
								<td><input type="text" name="cerca"  size="25" maxlength="40" style="width:100px;background-color:#FFFFFF" class="text10"></td>
								<td valign="bottom"><input type="submit" name="accion" value="|LANG_SEARCH|" class="text10"></td>
							</tr>
						</table>
						</form>
					</td>

				</tr>
				<!-- llegendes -->	
				<tr>
					<td colspan="2" bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10">
|EDIT_LEGEND|
|DELETE_LEGEND|
					</td>
					
					
				</tr>
				<!-- /llegendes -->
				
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
					<td class="gris11b" width="45%" valign="top" style="padding-left:0px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ordenar=titol&ordre=|ORDRE|"  style="background-color:|COLOR1|;" class="titolllistat">|ICO1||LANGUSUARI|</a></td>
					<td class="gris11b" width="25%" valign="top" style="padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ordenar=nivell&ordre=|ORDRE|"  style="background-color:|COLOR2|;" class="titolllistat">|ICO2||LANGUSERLEVEL|</a></td>
					<td class="gris11b" width="15%" valign="top" style="padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ordenar=estat&ordre=|ORDRE|"  style="background-color:|COLOR3|;" class="titolllistat">|ICO3||LANGSTATUS|</a></td>
					
				</tr>	
				
				<!-- BLOCK_BEGIN_USER  -->
				<tr>
					<td width="15%" style="border-bottom:solid #cccccc 1px;border-right:solid #cccccc 1px;">
|EDIT_OPTION|
|DELETE_OPTION|
					</td>
|USER_INFO|
				</tr>
				<!-- BLOCK_END_USER  -->

					
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