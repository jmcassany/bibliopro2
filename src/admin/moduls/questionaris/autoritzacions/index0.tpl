<html>
<head>
|METAS|
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<!-- CAP�ELERA -->
|CAPCELERA|
<!-- /CAP�ELERA -->

<!-- PART CENtrAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="|CONFIG_URLADMIN|/comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b>Gestió de qüestionaris</b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="70%" class="text10"><img src="|CONFIG_URLADMIN|/comu/icon_plana.gif" width="33" height="18" alt="|LANG_YOUAREIN|" border="0" align="absmiddle">|LANG_YOUAREIN|: <a href="|CONFIG_URLADMIN|/index.php">|LANG_HOME|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="|CONFIG_URLADMIN|/utilitats/index.php">|LANG_UTILS|</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../index.php">Gestió de qüestionaris</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php">Autoritzacions</a><img src="|CONFIG_URLADMIN|/comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">Sol·licitud d'autoritzacions</font></td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="|CONFIG_URLADMIN|/comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">Sol·licitud d'autoritzacions</td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<!-- FORMULARI ENtrADA -->
		<td colspan="2" style="padding:10px;" valign="top">
			<form id="form" name="form" action="enviament.php" method="post" enctype="multipart/form-data">
			<table width="100%" cellpadding="5" cellspacing="0" border="0">
				<tr>
					<td colspan="2">Enviament de sol·licitud d'autoritzacions d'instruments als autors:</td>
				</tr>
				<tr>
					<td class=text valign=top width="20%">Instrument:</td>
					<td valign=top width="80%">
						<select required id="instrument" name="instrument" class="chosen">
							<option >-</option>	
							|OPTIONS_CUESTIONARIS|
						</select>
					</td>
				</tr>
				<tr>
					<td class=text valign=top width="20%">Seleccioneu l'autor:</td>
					<td valign=top width="80%">
						<select required id="autors" name="autors" class="chosen">
							<option value="-">-</option>	
						</select>
					</td>
				</tr>
				<tr>
					<td class=text valign=top width="20%">Nom de l'autor:</td>
					<td valign=top width="80%"><input type="text" required id="nom" name="nom" value="" size="40" maxlength="250" class="formulari"></td>
				</tr>
				<tr>
					<td class=text valign=top width="20%">Email:</td>
					<td valign=top width="80%"><input type="email" required id="email" name="email" value="" size="40" maxlength="250" class="formulari"></td>
				</tr>

				<tr>
					<td class="text" valign=top width="20%">Text:</td>
					<td valign="top" width="80%">
					<?phph
						|editor_text|
					?>
					</td>
				</tr>

			</table>
			<table width="100%" cellpadding="5" cellspacing="0" border="0">
				<tr>
					<td class=text valign=top width="20%"></td>
						<input type="submit" name="accion" value="Enviar sol·licitud" class="boto" />
					</td>
				</tr>
			</table>
			</form>
		</td>
		<!-- /FORMULARI ENtrADA -->
	</tr>
</table>
<!-- /PART CENtrAL -->
|PEU|
<script type="text/javascript">
	$().ready(function(){
		$('#instrument').change(function(){
			var valor = $(this).val();
			if(valor && valor != '-'){
				$.ajax({
				  type: "POST",
				  url: './ajax.php',
				  data: {'function': 'getOptionsAutors', 'params': valor},
				  success: function(data){
				  	$('#autors').empty();
				  	$('#nom').val('');
				  	$('#email').val('');
				  	$('#autors').append(data);
				  }
				});
			}
		});
		$('#autors').change(function(){
			var valor = $(this).val();
			if(valor && valor != '-'){
				$.ajax({
				  type: "POST",
				  url: './ajax.php',
				  dataType: 'json',
				  data: {'function': 'getInfoAutor', 'params': valor},
				  success: function(data){
				  	$('#nom').val(data['NOM']);
				  	$('#email').val(data['EMAIL']);
				  }
				});
			}
		});
	})
</script>
</body>
</html>