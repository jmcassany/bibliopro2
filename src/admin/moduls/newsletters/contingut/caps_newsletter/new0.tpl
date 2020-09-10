<table border="0" cellpadding="0" cellspacing="0" width="100%">			
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
			<img src="../../../../../public/media/comu/admin/bot_enrera_blau.gif" border="0" style="vertical-align:middle;" /> <a href="list.php">|LANG_TORNAR|</a>
		</td>
	</tr>

	<tr>
		<td colspan="2" align="center">
		<table border="0" cellpadding="0" cellspacing="0" width="93%">
				<tr>
					<td style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle">
						<img src="../../../../../public/media/comu/admin/kland_flexa.gif" width="21" height="13" border="0" align="bottom"> Crear capçalera
					</td>					
				</tr>				
			</table>
		</td>
	</tr>
	<tr>
		<form action="create.php" method="post" name="env_dades" enctype="multipart/form-data">
		<td colspan="2" align="center">
		<table border="0" cellpadding="5" cellspacing="5" width="93%">
			<TR> 
			   <TD class=text valign=top width="20%">|LANG_ESTAT|:</TD> 
			   <TD valign=top width="80%">
			   	|SELECT_STATUS|
			   </TD> 
			</TR> 	
			<TR> 
			   <TD class=text valign=top width="20%">Nom:</TD> 
			   <TD valign=top width="80%"><INPUT TYPE="text" NAME="TITOL" SIZE="60" MAXLENGTH="150" class="formulari"></TD> 
			</TR> 
			<TR> 
			   <TD class=text valign=top width="20%">Imatge:</TD> 
			   <TD valign=top width="80%" class="text10">
			   		<input type="file" name="img[]" size="60"><br><br>
					(|LANG_FORMATS|: <b>.jpg</b> | |LANG_MIDAMAXIMA|: <b>500K</b> | |LANG_MIDESRECOMANADES|: 571px × 80px</b>)
			   </TD> 
			</TR> 
			<tr>
				<td colspan="2">
					&nbsp;
				</td>
			</tr>
			<TR>   
			   <TD colspan="2" style="border-top:solid #0E449A 1px;" align="center">
			   		<br>
					<INPUT TYPE="submit" NAME="accion" VALUE="Crear capçalera" style="padding:5px"> 
			   </TD> 
			</TR>
			</table>
		</td>
		<input type="hidden" name="USUARI_HOUDINI" value="|USUARI_HOUDINI|">
		</form>
	</tr>
</table>

<br />