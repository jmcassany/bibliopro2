<html>
<head>
|METAS|
<script type="text/javascript">
function ordenar(){
  var url= document.fapartats.apartat.options[document.fapartats.apartat.selectedIndex].value;
  if ((document.fapartats.apartat.options[document.fapartats.apartat.selectedIndex].value)!=0){document.location= url;}
}
</script>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0"  onload="carregat();">

<!-- CAP�ELERA -->
|CAPCELERA|
<!-- /CAP�ELERA -->

<div id="carregant" style="width: 100%; height: 100%; text-align: center;"><br><br>Carregant...</div>
<div id="contingut" style="display: none">
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
					<td width="60%" class="text10"><img src="|CONFIG_URLADMIN|/comu/icon_plana.gif" width="33" height="18" alt="|LANG_YOUAREIN|" border="0" align="absmiddle">|LANG_YOUAREIN|: <a href="|CONFIG_URLADMIN|/index.php">|LANG_HOME|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="|CONFIG_URLADMIN|/utilitats/index.php">|LANG_UTILS|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">Gestió de qüestionaris</font></td>
					<td class="vermell10b" align="right">
						<a href="nou.php" class="vermell10b"><img src="|CONFIG_URLADMIN|/comu/inserta_menu.gif" alt="Crear nou qüestionari" width="26" height="19" border="0" align="absmiddle">
						Crear nou qüestionari</a>
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
					<td  style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="|CONFIG_URLADMIN|/comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">Qüestionaris (|TOTAL|)</td>
					<td   bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">
					<!-- buscador -->
						<form action="index.php" method="post">
						<input type="hidden" name="path" value="|PATH|">
						<table cellpadding="2" cellspacing="2" border="0">
							<tr>
								<td width="10"><img src="|CONFIG_URLADMIN|/comu/icon_cerca.gif" alt="" width="10" height="10" border="0" ></td>
								<td><input type="text" name="cerca"  size="25" maxlength="40" style="width:100px;background-color:#FFFFFF" class="text10"></td>
								<td valign="bottom"><input type="submit" name="accion" value="|LANG_SEARCH|" class="text10"></td>
							</tr>
						</form>
						</table>
					</td>
				</tr>
				<!-- llegendes -->
				<tr>
					<td  bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10">
						<a href="usuaris/index.php"><img src="|CONFIG_URLADMIN|/comu/icon_gestio_usu.gif" alt="Gestionar usuaris" border="0" align="absmiddle"></a> <a href="usuaris/index.php">Gestionar usuaris</a>&nbsp;&nbsp;&nbsp;
					</td>
					<td align="right" bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10">
						<a href="autoritzacions/index.php"><img src="|CONFIG_URLADMIN|/comu/icon_user.gif" alt="Gestionar autoritzacions" border="0" align="absmiddle">Gestionar autoritzacions</a>&nbsp;&nbsp;&nbsp;
						<a href="autors/index.php"><img src="|CONFIG_URLADMIN|/comu/icon_user.gif" alt="Gestionar autors" border="0" align="absmiddle">Gestionar autors</a>&nbsp;&nbsp;&nbsp;
						<a href="csv.php"><img src="|CONFIG_URLADMIN|/comu/ico_export_dades.gif" alt="Exportar a CSV" border="0" align="absmiddle"></a> <a href="csv.php">Exportar a CSV</a>
					</td>
				</tr>
				<tr>
					<td colspan="2" bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10">
						<a href="poblacio/index.php"><img src="|CONFIG_URLADMIN|/comu/questionaris/icon-hodini-poblacions.gif" alt="Gestionar poblacions" border="0" align="absmiddle"></a> <a href="poblacio/index.php">Gestionar poblacions</a>&nbsp;&nbsp;&nbsp;
						<a href="edat/index.php"><img src="|CONFIG_URLADMIN|/comu/questionaris/icon-hodini-edats.gif" alt="Gestionar edats" border="0" align="absmiddle"></a> <a href="edat/index.php">Gestionar edats</a>&nbsp;&nbsp;&nbsp;
						<a href="mida/index.php"><img src="|CONFIG_URLADMIN|/comu/questionaris/icon-hodini-conceptes.gif" alt="Gestionar mesures" border="0" align="absmiddle"></a> <a href="mida/index.php">Gestionar conceptes</a>&nbsp;&nbsp;&nbsp;
						<a href="malalties/index.php"><img src="|CONFIG_URLADMIN|/comu/questionaris/icon-hodini-malalties.gif" alt="Gestionar malalties" border="0" align="absmiddle"></a> <a href="malalties/index.php">Gestionar malalties</a>&nbsp;&nbsp;&nbsp;
						<a href="contingut/index.php"><img src="|CONFIG_URLADMIN|/comu/questionaris/icon-hodini-continguts.gif" alt="Gestionar tipus de contingut" border="0" align="absmiddle"></a> <a href="contingut/index.php">Gestionar tipus contingut</a>&nbsp;&nbsp;&nbsp;
					</td>
				</tr>
				<tr>
					<td  bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10">
						<img src="|CONFIG_URLADMIN|/comu/icon_veure.gif" alt="|LANG_VIEW|" width="23" height="16" border="0" align="absmiddle" >|LANG_VIEW|&nbsp;&nbsp;&nbsp;
						<img src="|CONFIG_URLADMIN|/comu/icon_modifica.gif" alt="|LANG_EDIT|" width="23" height="16" border="0" align="absmiddle" >|LANG_EDIT|&nbsp;&nbsp;&nbsp;
						<img src="|CONFIG_URLADMIN|/comu/icon_borrar.gif" alt="|LANG_DELETE|" width="22" height="16" border="0" align="absmiddle">|LANG_DELETE|
					</td>
					<td align="right" bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10">
						<a href="idiomes/index.php"><img src="|CONFIG_URLADMIN|/comu/sitemap/html.gif" alt="Gestionar autors" border="0" align="absmiddle"></a> <a href="idiomes/index.php">Gestionar idiomes</a>&nbsp;&nbsp;&nbsp;
						<a href="paisos/index.php"><img src="|CONFIG_URLADMIN|/comu/icon_mon.gif" alt="Gestionar països" border="0" align="absmiddle"></a> <a href="paisos/index.php">Gestionar països</a>
					</td>
				</tr>
				<!-- /navegacio pag -->
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
					<td class="gris11b" ></td>
					<td class="gris11b"  valign="top" style="padding-left:0px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ordenar=siglas&amp;ordre=|ORDRE|"  style="background-color:|COLOR4|;" class="titolllistat">|ICO4|Sigles</a></td>
					<td class="gris11b"  valign="top" style="padding-left:0px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ordenar=&amp;ordre=|ORDRE|"  style="background-color:|COLOR1|;" class="titolllistat">|ICO1|Nom</a></td>
					<td class="gris11b"  valign="top" style="padding-left:10px;padding-top:5px;padding-bottom:5px;">Autor(s)</td>
					<td class="gris11b"  valign="top" style="padding-left:10px;padding-top:5px;padding-bottom:5px;">Autor(s) adapt.</td>
					<td class="gris11b"  valign="top" style="padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ordenar=idioma&amp;ordre=|ORDRE|"  style="background-color:|COLOR2|;" class="titolllistat">|ICO2|Idioma</a></td>
					<td class="gris11b"  valign="top" style="padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ordenar=estat&amp;ordre=|ORDRE|"  style="background-color:|COLOR3|;" class="titolllistat">|ICO3|Estat</a></td>
				</tr>
				<!-- BLOCK_BEGIN_ROW  -->
				<tr>
					<td width="16%" style="border-bottom:solid #cccccc 1px;border-right:solid #cccccc 1px;">
						<a href="#" target="_blank"><img src="|CONFIG_URLADMIN|/comu/icon_veure.gif" alt="|LANG_VIEW|" width="19" height="16" border="0" align="absmiddle"></a>
						<a href="view.php?ID=|ID|"><img src="|CONFIG_URLADMIN|/comu/icon_modifica.gif" alt="|LANG_EDIT|" width="23" height="16" border="0" align="absmiddle" ></a>
						&#149;&nbsp;
						<img src="|CONFIG_URLADMIN|/comu/icon_borrar.gif" alt="|LANGDELETE|" width="22" height="16" border="0" align="absmiddle"><input type="checkbox" name="CHECK[|ID|]" value="TRUE" >
					</td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="view.php?ID=|ID|"><img src="|CONFIG_URLADMIN|/comu/icon_menus.gif" alt="" width="22" height="17" border="0" align="absmiddle"></a><a href="view.php?ID=|ID|" class="nompagina" title="|NOM|">|SIGLAS|</a></td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="view.php?ID=|ID|" class="nompagina">|NOM_CAST|</td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="view.php?ID=|ID|" class="nompagina">|AUTORES_ORIGINAL_NOMBRES|</td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="view.php?ID=|ID|" class="nompagina">|AUTORES_CAST_NOMBRES|</td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="view.php?ID=|ID|" class="nompagina">|IDIOMA|</td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="view.php?ID=|ID|" class="nompagina">|ESTAT|</td>
				</tr>
				<!-- BLOCK_END_ROW  -->
			</table>
		</td>
	</tr>

	<!-- LLISTAT PAGINES -->
	<tr>
		<td colspan="2" style="padding:10px;">
		<!-- navegacio pag -->
			<table cellpadding="0" cellspacing="0" border="0" width="100%" style="padding:5px;border-bottom:solid #CCCCCC 1px;border-top:solid #CCCCCC 1px;" bgcolor="#F7F7F7">
				<tr>
					<td class="text10"><img src="|CONFIG_URLADMIN|/comu/icon_pag.gif" width="8" height="10" alt="" border="0" align="absmiddle" style="margin-right:5px;">|PAGEPREV|</td>
					<td class="text10" align="center">|PAGE| de |PMAX| - |PAGELIST| </td>
					<td align="right" class="text10">|PAGENEXT|<img src="|CONFIG_URLADMIN|/comu/icon_pag.gif" width="8" height="10" alt="" border="0" align="absmiddle" style="margin-left:5px;"></td>
				</tr>
			</table>
		<!-- /navegacio pag -->
		<!-- CONFIRMACIO BORRAR -->
			<table border="0" cellspacing="4" cellpadding="4" width="100%" bgcolor="#ECECEC" height="33" style="border-top:solid #000000 1px;">
				<tr>
					<td  class="text">&nbsp;|LANG_CONFIRMDELETE|&nbsp;<img src="|CONFIG_URLADMIN|/comu/icon_borrar.gif" alt="|LANG_DELETE|" width="22" height="16" border="0" align="absmiddle"><input type="checkbox" name="CONFIRM" value="TRUE"><input type="image" src="|CONFIG_URLADMIN|/comu/confirma_elimina.gif" name="accio" value="Borrar" class="text10" align="absmiddle"></td>
				</tr>
			</table>
		<!-- /CONFIRMACIO BORRAR -->
		</td>
	</tr>
</table>
<!-- /PART CENTRAL -->
|PEU|
</form>
</div>
</body>
</html>