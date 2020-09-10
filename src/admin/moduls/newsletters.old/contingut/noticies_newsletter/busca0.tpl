<table border="0" cellpadding="0" cellspacing="0" width="760" style="border-right:solid #F66013 5px;border-left:solid #F66013 5px;border-top:solid #F66013 5px;margin:10px 10px 0 10px;">				
<tr>
	<td colspan="2" style="padding-left:10px;padding-top:10px;padding-right:10px;">	
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="text10"><img src="../../../../../public/media/comu/admin/icon_plana.gif" alt="" width="33" height="18" border="0" align="absmiddle">|LANG_SOUA|: <font class="blau10b">|LANG_NEWSLETTERS|</font></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td colspan="2">
		<div id="contenidor" class="butlletins">
			<div id="cap">
				<h1>Houdini butlletins</h1>
				<ul id="principal">
					<li><a href="../../campanyes/index.php" class="crear">Gestionar butlletins</a></li>
					<li><a href="../index.php" class="butlletins">Gestionar contingut</a></li>
					<li><a href="../../llistes/index.php" class="llistes">Llistes de subscriptors</a></li>
					<li><a href="../../informes/index.php" class="informes">Informes</a></li>
				</ul>
			</div>
			<div id="contingut">
				<ul id="submenu">
					<li>Notícies</li>
					<li><a href="../categories_noticies/list.php">Categories</a></li>
					<li><a href="../banners_newsletter/list.php">Banners</a></li>
					<!--<li><a href="../caps_newsletter/list.php">Capçaleres</a></li>-->
				</ul>
			</div>
		</div>
	</td>
</tr>
<tr>
	<td colspan="2" style="padding-left:10px;padding-top:10px;padding-right:10px;">	
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="text10"><img src="../../../../../public/media/comu/admin/icon_plana.gif" alt="" width="33" height="18" border="0" align="absmiddle"><font class="blau10b">|LANG_RESULCERCA|</font></td>
				<td align="right"><img src="../../../../../public/media/comu/admin/bot_enrera_blau.gif" alt="" border="0" align="absmiddle"> <a href="list.php">|LANG_TORNAR|</a></td>
			</tr>
		</table>
	</td>
</tr>
<!-- /situacio ets a -->
<tr>
	<td colspan="2" style="padding:5px;">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle">
					<img src="../../../../../public/media/comu/admin/kland_flexa.gif" width="21" height="13" border="0" align="bottom">|LANG_LLISTATIOPCIONS|
				</td>					
				<td width="50%"  bgcolor="#0E449A" valign="middle" align="right">
					<form action="busca.php" method="post">								
					<table cellpadding="2" cellspacing="2" border="0">
					<tr>
						<td width="10"><img src="../../../../../public/media/comu/admin/icon_cerca.gif" alt="" width="10" height="10" border="0" ></td>
						<td><input type="text" name="recerca" value="|RECERCA|"  size="25" maxlength="40" style="width:100px;background-color:#FFFFFF" class="text10"></td>																																																
						<td valign="bottom"><input type="submit" name="accion" value="|LANG_CERCAR|" class="text10"></td>
					</tr>
					</table>
					</form>			
				</td>
			</tr>
			<!-- llegendes -->	
			<tr>
				<td colspan="2" bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10">
					|LANG_LLEGENDES|:&nbsp;&nbsp;&nbsp;
					<img src="../../../../../public/media/comu/admin/icon_veure.gif"  width="19" height="16" border="0" align="absmiddle">|LANG_VEURENOTICIA|&nbsp;&nbsp;&nbsp;
					<img src="../../../../../public/media/comu/admin/icon_modifica.gif"  width="23" height="16" border="0" align="absmiddle" >|LANG_EDITARNOTICIA|&nbsp;&nbsp;&nbsp;
					<img src="../../../../../public/media/comu/admin/icon_borrar.gif"  width="22" height="16" border="0" align="absmiddle">|LANG_ELIMINARNOTICIA|&nbsp;&nbsp;&nbsp;
				</td>
			</tr>
			<!-- /llegendes -->
			<!-- navegacio pag -->	
			<tr>
				<td colspan="2" bgcolor="#F7F7F7" style="padding:5px;border-bottom:solid #CCCCCC 1px;border-top:solid #000000 1px;" >
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
							<td class="text10"><img src="../../../../../public/media/comu/admin/icon_pag.gif" alt="" width="8" height="10" border="0" align="absmiddle" style="margin-right:5px;">|PAGEPREV|</td>
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
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border-right:solid #F66013 5px;border-left:solid #F66013 5px;border-bottom:solid #F66013 5px;margin:0 10px 10px 10px;">
<tr>
	<!-- LLISTAT PAGINES -->
	<td colspan="2" style="padding:10px;" valign="top">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">					
			<tr bgcolor="#efefef">
				<td class="gris11b" width="20%" valign="top" style="padding-left:5px;padding-top:5px;padding-bottom:5px;">&nbsp;</td>
				<td class="gris11b" width="45%" valign="top" style="padding-left:5px;padding-top:5px;padding-bottom:5px;"><a href="busca.php?ordenar=titol&ordre=|ORDRE|&recerca=|RECERCA|&PAGE=|PAGE|" style="background-color:|COLOR1|;" class="titolllistat">|ICO1|Títol notícia</a></td>
				<td class="gris11b" width="10%" valign="top" style="padding-left:5px;padding-top:5px;padding-bottom:5px;"><a href="busca.php?ordenar=model&ordre=|ORDRE|&recerca=|RECERCA|&PAGE=|PAGE|" style="background-color:|COLOR4|;" class="titolllistat">|ICO4||LANG_MODEL|</a></td>
				<td class="gris11b" width="15%" valign="top" style="padding-left:5px;padding-top:5px;padding-bottom:5px;"><a href="busca.php?ordenar=data&ordre=|ORDRE|&recerca=|RECERCA|&PAGE=|PAGE|" style="background-color:|COLOR2|;" class="titolllistat">|ICO2||LANG_CREACIO|</a></td>
				<td class="gris11b" width="10%" valign="top" style="padding-left:5px;padding-top:5px;padding-bottom:5px;"><a href="busca.php?ordenar=estat&ordre=|ORDRE|&recerca=|RECERCA|&PAGE=|PAGE|" style="background-color:|COLOR3|;" class="titolllistat">|ICO3||LANG_ESTAT|</a></td>
			</tr>	
			<!-- BLOCK_BEGIN_ROW1  -->
			<tr>
				<td style="border-bottom:solid #cccccc 1px;" align="center">
					<a href="javascript:veure(|ID|)"><img src="../../../../../public/media/comu/admin/icon_veure.gif" alt="|LANG_VEURENOTICIA|" width="19" height="16" border="0" align="absmiddle"></a>
					|GESTIO_NOTICIES|
				</td>
				<td class="gris11" valign="top" style="border-bottom:solid #cccccc 1px;border-left:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">|TITOL|</td>
				<td class="gris11" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">|MODEL|</td>
				<td class="gris11" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">|CREATION_DAY|/|CREATION_MONTH|/|CREATION_YEAR|</td>
				<td class="gris11" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">|STATUS_X|</td>
			</tr>	
			<!-- BLOCK_END_ROW1  -->
			<!-- BLOCK_BEGIN_ROW2  -->
			<tr>
				<td style="border-bottom:solid #cccccc 1px;" align="center">
					<a href="javascript:veure(|ID|)"><img src="../../../../../public/media/comu/admin/icon_veure.gif" alt="|LANG_VEURENOTICIA|" width="19" height="16" border="0" align="absmiddle"></a>
					|GESTIO_NOTICIES|
				</td>
				<td class="gris11" valign="top" style="border-bottom:solid #cccccc 1px;border-left:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">|TITOL|</td>
				<td class="gris11" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">|MODEL|</td>
				<td class="gris11" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">|CREATION_DAY|/|CREATION_MONTH|/|CREATION_YEAR|</td>
				<td class="gris11" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">|STATUS_X|</td>
			</tr>	
			<!-- BLOCK_END_ROW2  -->	
		</table>
	</td>
	<!-- LLISTAT PAGINES -->
</tr>
<tr>
	<td colspan="2" style="padding:10px;">
		<!-- navegacio pag -->	
		<table cellpadding="0" cellspacing="0" border="0" width="100%" style="padding:5px;border-bottom:solid #CCCCCC 1px;border-top:solid #CCCCCC 1px;" bgcolor="#F7F7F7">
			<tr>
				<td class="text10"><img src="../../../../../public/media/comu/admin/icon_pag.gif" width="8" height="10" alt="" border="0" align="absmiddle" style="margin-right:5px;">|PAGEPREV|</td>
				<td class="text10" align="center">|PAGE| de |PMAX| - |PAGELIST| </td>
				<td align="right" class="text10">|PAGENEXT|<img src="../../../../../public/media/comu/admin/icon_pag.gif" width="8" height="10" alt="" border="0" align="absmiddle" style="margin-left:5px;"></td>
			</tr>
		</table>
		<!-- /navegacio pag -->
		<!-- CONFIRMACIO BORRAR -->			
		<table border="0" cellspacing="4" cellpadding="4" width="100%" bgcolor="#ECECEC" height="33" style="border-top:solid #000000 1px;">
		<tr>
			<td class="text">&nbsp;
				|LANG_CONFIRMACIOELIMINACIO|&nbsp;<img src="../../../../../public/media/comu/admin/icon_borrar.gif" alt="Eliminar" width="22" height="16" border="0" align="absmiddle">
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