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
					<td width="85%" class="text10"><img src="|CONFIG_URLADMIN|/comu/icon_plana.gif" width="33" height="18" alt="|LANG_YOUAREIN|" border="0" align="absmiddle">|LANG_YOUAREIN|: <a href="|CONFIG_URLADMIN|/index.php">|LANG_HOME|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="|CONFIG_URLADMIN|/utilitats/index.php">|LANG_UTILS|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../../index.php">Gestió de qüestionaris</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../../view.php?ID=|ID_SUBLICENCIA|">Modificar qüestionari</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../view.php?ID=|ID_SUBLICENCIA|">Subllicència</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">Preus</font></td>
					<td class="vermell10b" align="right">
						<a href="nou.php?ID_SUBLICENCIA=|ID_SUBLICENCIA|" class="vermell10b"><img src="|CONFIG_URLADMIN|/comu/inserta_menu.gif" alt="Crear nou preu" width="26" height="19" border="0" align="absmiddle">
						Crear preu</a>
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
					<td  style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="|CONFIG_URLADMIN|/comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">Preus (|TOTAL|)</td>
				</TR>
				<!-- llegendes -->
				<tr>
					<td colspan="2"  bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10">
						<img src="|CONFIG_URLADMIN|/comu/icon_modifica.gif" alt="|LANG_EDIT|" width="23" height="16" border="0" align="absmiddle" >|LANG_EDIT|&nbsp;&nbsp;&nbsp;
						<img src="|CONFIG_URLADMIN|/comu/icon_borrar.gif" alt="|LANG_DELETE|" width="22" height="16" border="0" align="absmiddle">|LANG_DELETE|
					</td>
				</tr>
				<!-- /navegacio pag -->
  				|RESULTAT|
			</table>
		</td>
	</tr>

	<tr>
		<form action="delete.php?ID_SUBLICENCIA=|ID_SUBLICENCIA|" method="post">
		<!-- LLISTAT PAGINES -->
		<td colspan="2" style="padding:10px;" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr bgcolor="#efefef">
					<td class="gris11b" ></td>
					<td class="gris11b"  valign="top" style="padding-left:0px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ID_SUBLICENCIA=|ID_SUBLICENCIA|&amp;ordenar=hasta&amp;ordre=|ORDRE|"  style="background-color:|COLOR2|;" class="titolllistat">|ICO2|Núm admin. fins</a></td>
					<td class="gris11b"  valign="top" style="padding-left:0px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ID_SUBLICENCIA=|ID_SUBLICENCIA|&amp;ordenar=lucro&amp;ordre=|ORDRE|"  style="background-color:|COLOR3|;" class="titolllistat">|ICO3|Preu lucre</a></td>
					<td class="gris11b"  valign="top" style="padding-left:0px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ID_SUBLICENCIA=|ID_SUBLICENCIA|&amp;ordenar=nolucro&amp;ordre=|ORDRE|"  style="background-color:|COLOR4|;" class="titolllistat">|ICO4|Preu no lucre</a></td>
					<td class="gris11b"  valign="top" style="padding-left:0px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ID_SUBLICENCIA=|ID_SUBLICENCIA|&amp;ordenar=ind&amp;ordre=|ORDRE|"  style="background-color:|COLOR5|;" class="titolllistat">|ICO5|Preu acadèmic</a></td>
				</tr>
				<!-- BLOCK_BEGIN_ROW  -->
				<tr>
					<td width="25%" style="border-bottom:solid #cccccc 1px;border-right:solid #cccccc 1px;">
						<a href="view.php?ID_SUBLICENCIA=|ID_SUBLICENCIA|&amp;ID=|ID|"><img src="|CONFIG_URLADMIN|/comu/icon_modifica.gif" alt="|LANG_EDIT|" width="23" height="16" border="0" align="absmiddle" ></a>
						&#149;&nbsp;
						<img src="|CONFIG_URLADMIN|/comu/icon_borrar.gif" alt="|LANGDELETE|" width="22" height="16" border="0" align="absmiddle"><input type="checkbox" name="CHECK[|ID|]" value="TRUE" >
					</td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="view.php?ID_SUBLICENCIA=|ID_SUBLICENCIA|&amp;ID=|ID|" class="nompagina" title="|IDIOMA|">|NUM_HASTA|</a></td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="view.php?ID_SUBLICENCIA=|ID_SUBLICENCIA|&amp;ID=|ID|" class="nompagina" title="|IDIOMA|">|LUCRO|</a></td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="view.php?ID_SUBLICENCIA=|ID_SUBLICENCIA|&amp;ID=|ID|" class="nompagina" title="|IDIOMA|">|NO_LUCRO|</a></td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="view.php?ID_SUBLICENCIA=|ID_SUBLICENCIA|&amp;ID=|ID|" class="nompagina" title="|IDIOMA|">|INDIVIDUAL|</a></td>
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