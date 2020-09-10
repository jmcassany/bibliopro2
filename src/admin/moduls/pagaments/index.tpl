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
	$("#data_cobrament_desde").mask("9999-99-99");
	$("#data_cobrament_fins").mask("9999-99-99");
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
<table border="0" cellpadding="0" cellspacing="0" width="960" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="|CONFIG_URLADMIN|/comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b>Gestió de pagaments</b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="65%" class="text10"><img src="|CONFIG_URLADMIN|/comu/icon_plana.gif" width="33" height="18" alt="|LANG_YOUAREIN|" border="0" align="absmiddle">|LANG_YOUAREIN|: <a href="|CONFIG_URLADMIN|/index.php">|LANG_HOME|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="|CONFIG_URLADMIN|/utilitats/index.php">|LANG_UTILS|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">Gestió de pagaments</font></td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="|CONFIG_URLADMIN|/comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">Pagaments (|TOTAL|)</td>
					<td style="padding: 4px; background: #0E449A;" class="blanc10b" valign="middle" align="right">
					<!-- buscador -->
						<form action="index.php" method="post">
						<input type="hidden" name="path" value="|PATH|">
						<table cellpadding="2" cellspacing="2" border="0">
							<tr>
								<td valign="middle" align="right">
									<label for="pagament">
										<span style="color: #fff;">Forma de pagament:</span>
										<select name="pagament" id="pagament">
											<option value="">Quaselvol</option>
											<option value="1">Tarjeta de crédito</option>
											<option value="2">Transferencia</option>
										</select>
									</label>&nbsp;&nbsp;&nbsp;
									<label for="facturat">
										<span style="color: #fff;">Facturat:</span>
										<select name="facturat" id="facturat">
											<option value="">Quaselvol</option>
											<option value="0">No</option>
											<option value="1">Sí</option>
										</select>
									</label>
								</td>
							</tr>
							<tr>
								<td valign="middle" align="right">
									<label for="data_cobrament_desde">
										<span style="color: #fff;">Data cobrament des de:</span>
										<input type="text" name="data_cobrament_desde" id="data_cobrament_desde" maxlength="19" size="19">
									</label>
									<label for="data_cobrament_fins">
										<span style="color: #fff;">fins</span>
										<input type="text" name="data_cobrament_fins" id="data_cobrament_fins" maxlength="19" size="19">
									</label>
								</td>
							</tr>
							<tr>
								<td valign="middle" align="right">
									<label for="user">
										<span style="color: #fff;">Usuari:</span>
										|SELECT_USUARIS|
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
						<img src="|CONFIG_URLADMIN|/comu/icon_modifica.gif" alt="|LANG_EDIT|" width="23" height="16" border="0" align="absmiddle" >|LANG_EDIT|
					</td>
					<td bgcolor="#ECECEC" style="padding:5px;border-bottom:solid #CCCCCC 1px;" class="text10" align="right">
						<a href="subllicencies/index.php"><img src="|CONFIG_URLADMIN|/comu/questionaris/icona-subllicencies.gif" alt="Subllicències" border="0" align="absmiddle" /></a> <a href="subllicencies/index.php">Subllicències</a>&nbsp;&nbsp;&nbsp;
						<a href="descarregues/index.php"><img src="|CONFIG_URLADMIN|/comu/questionaris/icona-descarregues.gif" alt="Descarregues" border="0" align="absmiddle" /></a> <a href="descarregues/index.php">Descàrregues</a>&nbsp;&nbsp;&nbsp;
						|LINK_SUBSCRIPCIONS|
						<a href="donacions/index.php"><img src="|CONFIG_URLADMIN|/comu/questionaris/icona-donacions.gif" alt="Donacions" border="0" align="absmiddle" /></a> <a href="donacions/index.php">Donacions</a>
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
					<td class="gris11b"  valign="top" style="padding:8px;">Tipus</td>
					<td class="gris11b"  valign="top" style="padding:8px"><a href="index.php?ordenar=import&amp;ordre=|ORDRE|"  style="background-color:|COLOR4|;" class="titolllistat">|ICO4|Import</a></td>
					<td class="gris11b"  valign="top" style="padding:8px;"><a href="index.php?ordenar=albara&amp;ordre=|ORDRE|"  style="background-color:|COLOR5|;" class="titolllistat">|ICO5|Núm. alb.</a></td>
					<td class="gris11b"  valign="top" style="padding:8px;"><a href="index.php?ordenar=data&amp;ordre=|ORDRE|"  style="background-color:|COLOR1|;" class="titolllistat">|ICO1|Data sol·licitud</a></td>
					<td class="gris11b"  valign="top" style="padding:8px;"><a href="index.php?ordenar=estat&amp;ordre=|ORDRE|"  style="background-color:|COLOR6|;" class="titolllistat">|ICO6|Estat</a></td> 
					<td class="gris11b"  valign="top" style="padding:8px;"><a href="index.php?ordenar=cobrament&amp;ordre=|ORDRE|"  style="background-color:|COLOR7|;" class="titolllistat">|ICO7|Data cobrament</a></td>
					<td class="gris11b"  valign="top" style="padding:8px;"><a href="index.php?ordenar=facturat&amp;ordre=|ORDRE|"  style="background-color:|COLOR8|;" class="titolllistat">|ICO8|Fact</a></td>
					<td class="gris11b"  valign="top" style="padding:8px;"><a href="index.php?ordenar=usuario&amp;ordre=|ORDRE|"  style="background-color:|COLOR2|;" class="titolllistat">|ICO2|Usuari</a></td>
				</tr>
				<!-- BLOCK_BEGIN_ROW  -->
				<tr>
					<td width="20" style="border-bottom:solid #cccccc 1px;border-right:solid #cccccc 1px;">
						<a href="|LINK_TO_VIEW||ID|"><img src="|CONFIG_URLADMIN|/comu/icon_modifica.gif" alt="|LANG_EDIT|" width="23" height="16" border="0" align="absmiddle" ></a>
					</td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding:8px;background:#|COLOR|">|TIPO|</td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding:8px;background:#|COLOR|"><a href="|LINK_TO_VIEW||ID|" class="nompagina">|IMPORT|€</a></td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding:8px;background:#|COLOR|"><a href="|LINK_TO_VIEW||ID|" class="nompagina">|NUM_ALBARAN|</a></td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding:8px;background:#|COLOR|"><a href="|LINK_TO_VIEW||ID|" class="nompagina">|FECHA_SOLICITUD|</a></td>
 					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding:8px;background:#|COLOR|"><a href="|LINK_TO_VIEW||ID|" class="nompagina">|STATUS_LABEL|</a></td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding:8px;background:#|COLOR|"><a href="|LINK_TO_VIEW||ID|" class="nompagina">|FECHA_COBRO|</a></td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding:8px;background:#|COLOR|"><a href="|LINK_TO_VIEW||ID|" class="nompagina">|FACTURAT|</a></td>
					<td class="gris10" valign="top" style="border-bottom:solid #cccccc 1px;padding:8px;background:#|COLOR|"><a href="|LINK_TO_VIEW||ID|" class="nompagina">|USUARIO|</a></td>
				</tr>
				<!-- BLOCK_END_ROW  -->
			</table>
		</td>
	</tr>

</table>
<!-- /PART CENTRAL -->
|PEU|
</form>
</div>
</body>
</html>