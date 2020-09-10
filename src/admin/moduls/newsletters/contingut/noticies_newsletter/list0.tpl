<table border="0" cellpadding="0" cellspacing="0" width="100%" >		
<tr>
	<td colspan="2">
		<div id="contingut">
			<ul id="submenu">
				|SUBMENU|
			</ul>
		</div>
	</td>
</tr>
<tr>
	<td colspan="2" align="right" style="padding: 0 40px 10px 0">	
		<a href="new.php" class="vermell10b"><img src="../../../../../public/media/comu/admin/icon_afegir_plana.gif" alt="" width="18" height="19" border="0" align="absmiddle"> |LANG_CREARNOTICIA|</a>
	</td>
</tr>
<tr>
	<td colspan="2" align="center">
		<table border="0" cellpadding="0" cellspacing="0" width="93%">
			<tr>
				<td width="50%" align="left" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle">
					<img src="../../../../../public/media/comu/admin/kland_flexa.gif" width="21" height="13" border="0" align="bottom">|LANG_LLISTATIOPCIONS|
				</td>					
				<td width="50%"  bgcolor="#0E449A" valign="middle" align="right">
					<form action="busca.php" method="post">								
					<table cellpadding="2" cellspacing="2" border="0">
					<tr>
						<td width="10"><img src="../../../../../public/media/comu/admin/icon_cerca.gif" alt="" width="10" height="10" border="0" ></td>
						<td><input type="text" name="recerca"  size="25" maxlength="40" style="width:100px;background-color:#FFFFFF" class="text10"></td>																																																
						<td valign="bottom"><input type="submit" name="accion" value="|LANG_CERCAR|" class="text10"></td>
					</tr>
					</table>
					</form>			
				</td>
			</tr>
			<!-- llegendes -->	
			<tr>
				<td colspan="2" align="left" bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10">
					|LANG_LLEGENDES|:&nbsp;&nbsp;&nbsp;
					<img src="../../../../../public/media/comu/admin/icon_veure.gif" alt="" width="19" height="16" border="0" align="absmiddle">|LANG_VEURENOTICIA|&nbsp;&nbsp;&nbsp;
					<img src="../../../../../public/media/comu/admin/icon_modifica.gif" alt="" width="23" height="16" border="0" align="absmiddle" >|LANG_EDITARNOTICIA|&nbsp;&nbsp;&nbsp;
					<img src="../../../../../public/media/comu/admin/icon_borrar.gif" alt="" width="22" height="16" border="0" align="absmiddle">|LANG_ELIMINARNOTICIA|&nbsp;&nbsp;&nbsp;
				</td>
			</tr>
			<!-- /llegendes -->
			<!-- navegacio pag -->	
			<tr>
				<td colspan="2" bgcolor="#F7F7F7" style="padding:5px;border-bottom:solid #CCCCCC 1px;border-top:solid #000000 1px;" >
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
							<td align="left" class="text10"><img src="../../../../../public/media/comu/admin/icon_pag.gif" alt="" width="8" height="10" border="0" align="absmiddle" style="margin-right:5px;">|PAGEPREV|</td>
							<td class="text10" align="center">|PAGE| de |PMAX| - |PAGELIST| </td>
							<td align="right" class="text10">|PAGENEXT|<img src="../../../../../public/media/comu/admin/icon_pag.gif" width="8" height="10" alt="" border="0" align="absmiddle" style="margin-left:5px;"></td>
						</tr>
					</table>  
				</td>
			</tr>
			<!-- /navegacio pag -->
		</table>
	</td>
</tr>
</table>

<form action="delete.php" method="post" name="mainform">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<!-- LLISTAT PAGINES -->
	<td colspan="2" valign="top" align="center">
		<table border="0" cellpadding="0" cellspacing="0" width="93%">					
			<tr bgcolor="#efefef">
				<td class="gris11b" width="20%" valign="top" align="left" style="padding-left:5px;padding-top:5px;padding-bottom:5px;">&nbsp;</td>
				<td class="gris11b" width="45%" valign="top" align="left" style="padding-left:5px;padding-top:5px;padding-bottom:5px;"><a href="list.php?ordenar=titol&ordre=|ORDRE|&PAGE=|PAGE|" style="background-color:|COLOR1|;" class="titolllistat">|ICO1|Títol notícia</a></td>
				<td class="gris11b" width="15%" valign="top" align="left" style="padding-left:5px;padding-top:5px;padding-bottom:5px;"><a href="list.php?ordenar=data&ordre=|ORDRE|&PAGE=|PAGE|" style="background-color:|COLOR2|;" class="titolllistat">|ICO2||LANG_CREACIO|</a></td>
				<td class="gris11b" width="10%" valign="top" align="left" style="padding-left:5px;padding-top:5px;padding-bottom:5px;"><a href="list.php?ordenar=estat&ordre=|ORDRE|&PAGE=|PAGE|" style="background-color:|COLOR3|;" class="titolllistat">|ICO3||LANG_ESTAT|</a></td>
			</tr>	
			<!-- BLOCK_BEGIN_ROW1  -->
			<tr>
				<td style="border-bottom:solid #cccccc 1px;" align="center">
					<a href="javascript:veure(|ID|)"><img src="../../../../../public/media/comu/admin/icon_veure.gif" alt="|LANG_VEURENOTICIA|" width="19" height="16" border="0" align="absmiddle"></a>
                                            |GESTIO_NOTICIES|
				</td>
				<td class="gris11" valign="top" align="left" style="border-bottom:solid #cccccc 1px;border-left:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">|TITOL|</td>
				<td class="gris11" valign="top" align="left" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">|CREATION_DAY|/|CREATION_MONTH|/|CREATION_YEAR|</td>
				<td class="gris11" valign="top" align="left" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">|STATUS_X|</td>
			</tr>	
			<!-- BLOCK_END_ROW1  -->
			<!-- BLOCK_BEGIN_ROW2  -->
			<tr>
				<td style="border-bottom:solid #cccccc 1px;" align="center">
					<a href="javascript:veure(|ID|)"><img src="../../../../../public/media/comu/admin/icon_veure.gif" alt="|LANG_VEURENOTICIA|" width="19" height="16" border="0" align="absmiddle"></a>
                                            |GESTIO_NOTICIES|
				</td>
				<td class="gris11" valign="top" align="left" style="border-bottom:solid #cccccc 1px;border-left:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">|TITOL|</td>
				<td class="gris11" valign="top" align="left" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">|CREATION_DAY|/|CREATION_MONTH|/|CREATION_YEAR|</td>
				<td class="gris11" valign="top" align="left" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">|STATUS_X|</td>
			</tr>	
			<!-- BLOCK_END_ROW2  -->	
		</table>
	</td>
	<!-- LLISTAT PAGINES -->
</tr>
<tr>
	<td colspan="2" valign="top" align="center">
		<!-- navegacio pag -->	
		<table cellpadding="0" cellspacing="0" border="0" width="93%" style="padding:5px;border-bottom:solid #CCCCCC 1px;border-top:solid #CCCCCC 1px;" bgcolor="#F7F7F7">
			<tr>
				<td align="left" class="text10"><img src="../../../../../public/media/comu/admin/icon_pag.gif" width="8" height="10" alt="" border="0" align="absmiddle" style="margin-right:5px;">|PAGEPREV|</td>
				<td class="text10" align="center">|PAGE| de |PMAX| - |PAGELIST| </td>
				<td align="right" class="text10">|PAGENEXT|<img src="../../../../../public/media/comu/admin/icon_pag.gif" width="8" height="10" alt="" border="0" align="absmiddle" style="margin-left:5px;"></td>
			</tr>
		</table>
		<!-- /navegacio pag -->
		
		<!-- CONFIRMACIO BORRAR -->			
		<table border="0" cellspacing="4" cellpadding="4" width="93%" bgcolor="#ECECEC" height="33" style="border-top:solid #000000 1px;">
		<tr>
			<td class="text" align="left">&nbsp;
				|LANG_CONFIRMACIOELIMINACIO|&nbsp;<img src="../../../../../public/media/comu/admin/icon_borrar.gif" alt="" width="22" height="16" border="0" align="absmiddle">
				<input type="checkbox" name="CONFIRM" value="TRUE" align="absmiddle">
				<input type="image" src="../../../../../public/media/comu/admin/confirma_elimina.gif" name="accio" value="" alt="|LANG_ELIMINAR|" align="absmiddle">
			</td>
		</tr>
		</table>	
		<!-- /CONFIRMACIO BORRAR -->	
	</td>	
</tr>
</table>
</form>