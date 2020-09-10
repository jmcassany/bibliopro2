<html>
<head>
|METAS|
<script type="text/javascript">
function ordenar(){
  var url= document.fapartats.apartat.options[document.fapartats.apartat.selectedIndex].value;
  if ((document.fapartats.apartat.options[document.fapartats.apartat.selectedIndex].value)!=0){document.location= url;}
}
</script>
<script type="text/javascript" src="|CONFIG_URLADMIN|/js/formularis/jquery.maskedinput-1.1.2.pack.js"></script>
<script type="text/javascript">
jQuery(function($){
	$("#data_subl_desde").mask("9999-99-99");
	$("#data_subl_fins").mask("9999-99-99");
});
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
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="|CONFIG_URLADMIN|/comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b>Gestió de pagaments</b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="65%" class="text10"><img src="|CONFIG_URLADMIN|/comu/icon_plana.gif" width="33" height="18" alt="|LANG_YOUAREIN|" border="0" align="absmiddle">|LANG_YOUAREIN|: <a href="|CONFIG_URLADMIN|/index.php">|LANG_HOME|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="|CONFIG_URLADMIN|/utilitats/index.php">|LANG_UTILS|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../index.php">Gestió de pagaments</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">Subllicències</font></td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="|CONFIG_URLADMIN|/comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">Subllicències (|TOTAL|)</td>
					<td style="padding: 4px; background: #0E449A;" class="blanc10b" valign="middle" align="right">
					<!-- buscador -->
						<form action="index.php" method="post">
						<input type="hidden" name="path" value="|PATH|">
						<table cellpadding="2" cellspacing="2" border="0">
							<tr>
								<td valign="middle" align="right">
									<label for="user">
										<span style="color: #fff;">Usuari:</span>
										|SELECT_USUARIS|
									</label>&nbsp;&nbsp;&nbsp;
									<label for="autor">
										<span style="color: #fff;">Autor:</span>
										|SELECT_AUTORS|
									</label>
								</td>
							</tr>
							<tr>
								<td valign="middle" align="right">
									<label for="pagament">
										<span style="color: #fff;">Forma de pagament:</span>
										<select name="pagament" id="pagament">
											<option value="">Qualsevol</option>
											<option value="1">Tarjeta de crédito</option>
											<option value="2">Transferencia</option>
										</select>
									</label>&nbsp;&nbsp;&nbsp;
									<label for="facturat">
										<span style="color: #fff;">Facturat:</span>
										<select name="facturat" id="facturat">
											<option value="">Qualsevol</option>
											<option value="0">No</option>
											<option value="1">Sí</option>
										</select>
									</label>
								</td>
							</tr>
							<tr align="right">
								<td valign="middle" align="right">
									<label for="data_subl_desde">
										<span style="color: #fff;">Data validesa des de:</span>
										<input type="text" name="data_subl_desde" id="data_subl_desde" maxlength="19" size="19">
									</label>
									<label for="data_subl_fins">
										<span style="color: #fff;">fins</span>
										<input type="text" name="data_subl_fins" id="data_subl_fins" maxlength="19" size="19">
									</label>
								</td>
							</tr>
							<tr>
								<td valign="middle" align="right">
									<label for="estat">
										<span style="color: #fff;">Estat:</span>
										<select name="estat" id="estat">
											<option value="">Qualsevol</option>
											<option value="0">Inactiva</option>
											<option value="1">Activa</option>
										</select>
									</label>&nbsp;&nbsp;&nbsp;
									<label for="atorgament">
										<span style="color: #fff;">Atorgament:</span>
										<select name="atorgament" id="atorgament">
											<option value="">Qualsevol</option>
											<option value="0">Pendent</option>
											<option value="1">Pendent tercers</option>
											<option value="2">Atorgada</option>
											<option value="3">Denegada</option>
										</select>
									</label>&nbsp;&nbsp;&nbsp;
									<img src="|CONFIG_URLADMIN|/comu/icon_cerca.gif" alt="" width="10" height="10" border="0" > <input type="text" name="cerca" size="25" maxlength="40" style="width:100px;background-color:#FFFFFF" class="text10"> <input type="submit" name="accion" value="|LANG_SEARCH|" class="text10">
								</td>
							</tr>
						</form>
						</table>
					</td>
				</TR>
				<!-- llegendes -->
				<tr>
					<td bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10">
						<img src="|CONFIG_URLADMIN|/comu/icon_modifica.gif" alt="|LANG_EDIT|" width="23" height="16" border="0" align="absmiddle" >|LANG_EDIT|&nbsp;&nbsp;&nbsp;
						<img src="|CONFIG_URLADMIN|/comu/icon_borrar.gif" alt="|LANG_DELETE|" width="22" height="16" border="0" align="absmiddle">|LANG_DELETE|
					</td>
					<td align="right" bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10">
						<a href="csv.php?|CERCA_PARAMS|">
							<img src="|CONFIG_URLADMIN|/comu/ico_export_dades.gif" alt="Exportar a CSV" border="0" align="absmiddle">
						</a>
						<a href="csv.php?|CERCA_PARAMS|">Exportar a CSV</a>
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
					<td class="gris11b"  valign="top" style="padding-left:0px;padding-top:5px;padding-bottom:5px;">Qüestionari</td>
					<td class="gris11b"  valign="top" style="padding-left:0px;padding-top:5px;padding-bottom:5px;">Import</td>
					<td class="gris11b"  valign="top" style="padding-left:0px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ordenar=data&amp;ordre=|ORDRE|"  style="background-color:|COLOR1|;" class="titolllistat">|ICO1|Data sol·licitud</a></td>
					<td class="gris11b"  valign="top" style="padding-left:0px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ordenar=otorgada&amp;ordre=|ORDRE|"  style="background-color:|COLOR2|;" class="titolllistat">|ICO2|Estat</a></td>
					<td class="gris11b"  valign="top" style="padding-left:0px;padding-top:5px;padding-bottom:5px;"><a href="index.php?ordenar=usuario&amp;ordre=|ORDRE|"  style="background-color:|COLOR3|;" class="titolllistat">|ICO3|Usuari</a></td>
				</tr>
				<!-- BLOCK_BEGIN_ROW  -->
				<tr>
					<td width="100" style="border-bottom:solid #cccccc 1px;border-right:solid #cccccc 1px;">
						<a href="view.php?ID=|ID|"><img src="|CONFIG_URLADMIN|/comu/icon_modifica.gif" alt="|LANG_EDIT|" width="23" height="16" border="0" align="absmiddle" ></a>
						&#149;&nbsp;
						<img src="|CONFIG_URLADMIN|/comu/icon_borrar.gif" alt="|LANGDELETE|" width="22" height="16" border="0" align="absmiddle"><input type="checkbox" name="CHECK[|ID|]" value="TRUE" >
					</td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;background:#|COLOR|"><a href="view.php?ID=|ID|"><img src="|CONFIG_URLADMIN|/comu/icon_menus.gif" alt="" width="22" height="17" border="0" align="absmiddle"></a><a href="view.php?ID=|ID|" class="nompagina">|CUESTIONARIO|</a></td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:5px;padding-top:5px;padding-bottom:5px;background:#|COLOR|"><a href="|LINK_TO_VIEW||ID|" class="nompagina">|IMPORT|€</a></td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:0px;padding-top:5px;padding-bottom:5px;background:#|COLOR|"><a href="view.php?ID=|ID|" class="nompagina">|FECHA_SOLICITUD|</a></td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:0px;padding-top:5px;padding-bottom:5px;background:#|COLOR|"><a href="view.php?ID=|ID|" class="nompagina">|OTORGADA|</a></td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:0px;padding-top:5px;padding-bottom:5px;background:#|COLOR|"><a href="view.php?ID=|ID|" class="nompagina">|USUARIO|</a></td>
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