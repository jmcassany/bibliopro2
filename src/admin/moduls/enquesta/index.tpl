<html>
<head>
|METAS|
<script type="text/javascript">
function ordenar(){
  var url= document.fapartats.apartat.options[document.fapartats.apartat.selectedIndex].value;
  if ((document.fapartats.apartat.options[document.fapartats.apartat.selectedIndex].value)!=0){document.location = url;}
}
</script>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0"  onload="carregat();">

<!-- CAPÇELERA -->
|CAPCELERA|
<!-- /CAPÇELERA -->

<div id="carregant" style="width: 100%; height: 100%; text-align: center;"><br><br>Carregant...</div>
<div id="contingut" style="display: none">
<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">			
	
	<!-- situacio Sou a -->
	<tr>
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b>|LANG_POLLTITLE|</b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">	
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				
				<tr>
					<td width="50%" class="text10"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="|LANG_YOUAREIN|" border="0" align="absmiddle">|LANG_YOUAREIN|: <a href="../../index.php">|LANG_HOME|</a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../../utilitats/index.php">|LANG_UTILS|</a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">|LANG_POLLTITLE|</font></td>
					
					<td class="vermell10b" align="right">
						<a href="nou.php" class="vermell10b"><img src="../../comu/inserta_menu.gif" alt="|LANG_POLLCREATE|" width="26" height="19" border="0" align="absmiddle">
						|LANG_POLLCREATE|</a>

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
					<td  style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">|LANG_POLL| (|TOTAL|)</td>
					<td   bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">
					<!-- buscador -->
						<form action="index.php" method="post">
						<input type="hidden" name="path" value="|PATH|">						
						<table cellpadding="2" cellspacing="2" border="0">
							<tr>
								<td width="10"><img src="../../comu/icon_cerca.gif" alt="" width="10" height="10" border="0" ></td>
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
						
						<img src="../../comu/icon_veure.gif" alt="|LANG_VIEW|" width="19" height="16" border="0" align="absmiddle">|LANG_VIEW|&nbsp;&nbsp;&nbsp;
						<img src="../../comu/icon_modifica.gif" alt="|LANG_EDIT|" width="23" height="16" border="0" align="absmiddle" >|LANG_EDIT|&nbsp;&nbsp;&nbsp;
<!--					    <img src="../../comu/icon_duplica.gif" alt="|LANG_DUPLICATE|" width="20" height="16" border="0" align="absmiddle" >|LANG_DUPLICATE|&nbsp;&nbsp;&nbsp; -->
						<img src="../../comu/icon_borrar.gif" alt="|LANG_DELETE|" width="22" height="16" border="0" align="absmiddle">|LANG_DELETE|
					</td>
					<form name="fapartats" >
					<td  bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10" align="right">
						<!-- combos -->					
							<select name="apartat" class="formulari" style="font-size:10px;width:100px;" onchange="ordenar()">
								<option value="#">|LANG_ORDERBY|:</option>
								<option value="index.php?ordenar=nom">|LANG_NAME|</option>
								<option value="index.php?ordenar=data">|LANG_DATE|</option>
							</select>
						<!-- /combos -->
					</td>				
					</form>
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
				
				<!-- BLOCK_BEGIN_ROW  -->
				<tr>
					<td width="25%" style="border-bottom:solid #cccccc 1px;border-right:solid #cccccc 1px;">
						<a href="veure.php?poll=|NOM|" target="_blank"><img src="../../comu/icon_veure.gif" alt="|LANG_VIEW|" width="19" height="16" border="0" align="absmiddle"></a>
						<a href="view.php?ID=|ID|"><img src="../../comu/icon_modifica.gif" alt="|LANG_EDIT|" width="23" height="16" border="0" align="absmiddle" ></a>
<!--						<a href="duplicar.php?ID=|ID|"><img src="../../comu/icon_duplica.gif" alt="|LANG_DUPLICATE|" width="20" height="16" border="0" align="absmiddle" ></a> -->
                        <a href="preguntes/index.php?ENQUESTA=|ID|"><img src="../../comu/ico_resposta_nova.gif" alt="Respostes" width="16" height="12" border="0" align="absmiddle" ></a>
						&#149;&nbsp;
						<img src="../../comu/icon_borrar.gif" alt="|LANG_DELETE|" width="22" height="16" border="0" align="absmiddle"><input type="checkbox" name="CHECK[|ID|]" value="TRUE" >
					</td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="view.php?ID=|ID|"><img src="../../comu/icon_menus.gif" alt="Creat: |CREATION|" width="22" height="17" border="0" align="absmiddle"></a><a href="view.php?ID=|ID|" class="nompagina" title="Creat: |CREATION| |NOM|">|DESCRIPCIO|</a></td>
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
					<td class="text10"><img src="../../comu/icon_pag.gif" width="8" height="10" alt="" border="0" align="absmiddle" style="margin-right:5px;">|PAGEPREV|</td>
					<td class="text10" align="center">|PAGE| de |PMAX| - |PAGELIST| </td>
					<td align="right" class="text10">|PAGENEXT|<img src="../../comu/icon_pag.gif" width="8" height="10" alt="" border="0" align="absmiddle" style="margin-left:5px;"></td>
				</tr>
			</table>
		<!-- /navegacio pag -->
		<!-- CONFIRMACIO BORRAR -->			
			<table border="0" cellspacing="4" cellpadding="4" width="100%" bgcolor="#ECECEC" height="33" style="border-top:solid #000000 1px;">
				<tr>
					<td  class="text">&nbsp;|LANG_CONFIRMDELETE|&nbsp;<img src="../../comu/icon_borrar.gif" alt="|LANG_DELETE|" iwidth="22" height="16" border="0" align="absmiddle"><input type="checkbox" name="CONFIRM" value="TRUE"><input type="image" src="../../comu/confirma_elimina.gif" name="accio" value="Borrar" class="text10" align="absmiddle"></td>
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

