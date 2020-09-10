|FCK1|
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
					<td align="left"  style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle">
						<img src="../../../../../public/media/comu/admin/kland_flexa.gif" width="21" height="13" border="0" align="bottom" /> Editar caixa
					</td>					
				</tr>				
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
		<form action="update.php" method="post" name="env_dades" enctype="multipart/form-data">
		<table border="0" cellpadding="5" cellspacing="5" width="93%">
			<TR> 
			   <TD align="left" class=text valign=top width="20%">|LANG_ESTAT|:</TD> 
			   <TD align="left" valign=top width="80%">
			   	|SELECT_STATUS|
			   </TD> 
			</TR> 	
			<tr>
				<td colspan="2">
					&nbsp;
				</td>
			</tr>
			<TR> 
			   <TD align="left" class=text valign=top width="20%">Nom</TD> 
			   <TD align="left" valign=top width="80%"><INPUT TYPE="text" NAME="TITOL" SIZE="60" MAXLENGTH="150" value="|TITOL|" class="formulari" /></TD> 
			</TR> 
			<!-- <tr>
				<td colspan="2">
					&nbsp;
				</td>
			</tr>
			<TR> 
			   <TD  valign=top  class="text" colspan=2><b>|LANG_IMATGE|:</b>
					<table cellpadding="0" cellspacing="0" border="0" width="100%" style="padding:5px;border:solid #CCCCCC 1px;">
					<tr>
						<td  style="padding:5px;">|IMATGE|</td>
					</tr>
					<tr>
						<td style="padding:5px;" valign="top" class="text10">
							<input type=file name="img[]" size="60">
							<br>
							(|LANG_FORMATS|: <b>.jpg</b> | |LANG_MIDAMAXIMA|: <b>500K</b>)
						</td>
					</tr>
					</table>			   		
			   </TD> 
			</TR> -->		
			<tr>
				<td colspan="2">
					&nbsp;
				</td>
			</tr>
			<TR> 
		  		<TD align="left" class=text valign=top width="20%">Text:</TD> 
			    <TD align="left" valign=top width="80%">
			   		|FCK2|
				</TD> 
			</TR>
			<tr>
				<td colspan="2">
					&nbsp;
				</td>
			</tr>
			<TR>   
			   <TD colspan="2" style="border-top:solid #0E449A 1px;" align="center">
			   		<input type="hidden" name="USUARI_HOUDINI" value="|USUARI_HOUDINI|" />
					<INPUT TYPE="hidden" NAME="NOMIMATGEEXIS" VALUE="|NOMIMATGEEXIS|" />
				    <INPUT TYPE="hidden" NAME="NOMADJUNTEXIS" VALUE="|NOMADJUNTEXIS|" /> 
					<INPUT TYPE="hidden" NAME="ID" VALUE="|ID|" /> 
					<INPUT TYPE="submit" NAME="accion" VALUE="|LANG_APLICARCANVIS|" style="padding:5px" /> 
			   </TD> 
			</TR>
			</table>
			</form>
		</td>
		
	</tr>
</table>

<br />