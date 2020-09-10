<html>
<head>
|METAS|
<script type="text/javascript">
function ordenar(){
  if(document.fapartats.ordre[0].checked){
    var ordre=document.fapartats.ordre[0].value;
  }
  if(document.fapartats.ordre[1].checked){
    var ordre=document.fapartats.ordre[1].value;
  }
  var url= document.fapartats.apartat.options[document.fapartats.apartat.selectedIndex].value+'&ordre='+ordre;
  if ((document.fapartats.apartat.options[document.fapartats.apartat.selectedIndex].value)!=0){result = location = url;}
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
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;margin-bottom:0px">

	<!-- situacio Sou a -->
	<tr>
		<td class="text10" bgcolor="#FDDBCA" style="padding:6px;" colspan="2"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b>|LANGTITOL|</b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="80%" class="text10">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td valign="top" width="33"><img src="../comu/icon_plana.gif" width="33" height="18" alt="Sou a" border="0" align="absmiddle"></td>
								<td class="text10">|LANGETSA|: <a href="../index.php">|LANGHOME|</a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">|DESCRIPCIOCARPETA|</font></td>
							</tr>
						</table>

					</td>
					<td width="20%" class="vermell10b" align="right">
|NEWPAGE|
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
					<td  style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">|LANGLISTPAGES| (|TOTAL|)</td>
					<td   bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">
					<!-- buscador -->
						<form action="index.php" method="post">
						<table cellpadding="2" cellspacing="2" border="0">
                            <input type="hidden" name="carpeta" value="|CARPETA|">
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
|MOVE_LEGEND|
						<img src="../comu/icon_generar.gif" alt="|LANGGENERATE|" width="23" height="16" border="0" align="absmiddle">|LANGGENERATE|&nbsp;&nbsp;&nbsp;
|DELETE_LEGEND|
					</td>
					<form name="fapartats" >
					<td  bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text9" align="right">
						<!-- combos -->
							<select name="apartat" class="formulari" style="font-size:10px;width:100px;" onchange="ordenar()">
								<option value="#">|LANGORDERBY|:</option>
								<option value="index.php?ordenar=nom&carpeta=|CARPETA|">|LANGNAME|</option>
								<option value="index.php?ordenar=data&carpeta=|CARPETA|">|LANGCREATION|</option>
								<option value="index.php?ordenar=datamodi&carpeta=|CARPETA|">|LANGMODIFY|</option>
							</select>
						<!-- /combos -->
						<input type="radio" name="ordre" value="Asc" checked>Asc
						<input type="radio" name="ordre" value="Desc">Desc
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
		<input type="hidden" name="carpeta" value="|CARPETA|">
		<!-- LLISTAT PAGINES -->
		<td colspan="2" style="padding:10px;" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<!-- BLOCK_BEGIN_ROW  -->
				<tr>
					<td width="30%" style="border-bottom:solid #cccccc 1px;border-right:solid #cccccc 1px;">
						<a href="veure.php?pagina=|LINK|" target="_blank"><img src="../comu/icon_veure.gif" alt="Veure la p�gina generada actual" width="19" height="16" border="0" align="absmiddle"></a>
|EDIT_OPTION|
|CLONE_OPTION|
|MOVE_OPTION|
						<a href="preview.php?ID=|ID|&carpeta=|CARPETA|"><img src="../comu/|ICONAGENERAR|" alt="Generar la p�gina" width="23" height="16" border="0" align="absmiddle"></a>
|DELETE_OPTION|
					</td>
|PAGE_INFO|
<td class="gris10" width="42%" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">|ICONESIDIOMA|&nbsp;|DESCRIPCIO|</td>
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
</div>
</body>
</html>

