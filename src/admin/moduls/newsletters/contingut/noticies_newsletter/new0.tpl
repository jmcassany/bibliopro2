|FCK1|
<form action="create.php" method="post" name="env_dades" enctype="multipart/form-data">
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
				<td align="left" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle">
					<img src="../../../../../public/media/comu/admin/kland_flexa.gif" width="21" height="13" border="0" align="bottom">|LANG_CREARNOTICIA|
				</td>					
			</tr>				
		</table>
	</td>
</tr>
<tr>
	<td colspan="2" align="center">
		<table border="0" cellpadding="5" cellspacing="5" width="93%">
		<!-- 
		<TR> 
		   <TD class=text valign=top width="20%">|LANG_ESTAT|:</TD> 
		   <TD valign=top width="80%">
		   	|SELECT_STATUS|
		   </TD> 
		</TR>
		 -->
		 <tr>
			<td colspan="2">
				&nbsp;
			</td>
		</tr>	
		<input type="hidden" name="STATUS" value="1">
		<!--
		<TR>
		   <TD align="left" class=text valign=top width="20%">|LANG_MODEL|:</TD>
		   <TD align="left" valign=top width="80%">
		   	<select name="MODEL" class="formulari" style="width:150px;">
		   		|MODEL|
		   	</select>
		   </TD>
		</TR>
	    -->
		<TR> 
		   <TD class=text valign=top width="20%">Títol notícia:</TD> 
		   <TD valign=top width="80%"><INPUT TYPE="text" NAME="TITOL" SIZE="60" MAXLENGTH="150" class="formulari"></TD> 
		</TR> 
		<TR> 
		   <TD class=text valign=top width="20%">|LANG_RESUM|:</TD> 
		   <TD valign=top width="80%">
		   		|FCK3|
			</TD> 
		</TR>
		<TR> 
		   <TD class=text valign=top width="20%">|LANG_DESCRIPCIO|:</TD> 
		   <TD valign=top width="80%">
		   		|FCK2|
			</TD> 
		</TR>
		<TR> 
           <TD class=text valign=top width="20%">Text imatge:</TD> 
           <TD valign=top width="80%" class="text10">
               <INPUT TYPE="text" NAME="IMATGE3" SIZE="60" MAXLENGTH="60">
           </TD> 
        </TR>
        <TR> 
           <TD class=text valign=top width="20%">|LANG_IMATGES|:</TD> 
           <TD valign=top width="80%" class="text10">
                <input type="file" name="img[]" size="60"><br />
                (|LANG_FORMATS|: <b>.jpg</b> <b>.gif</b> | |LANG_MIDAMAXIMA|: <b>500K</b> | Tamany mínim: <b>500px</b> horitzontal)
           </TD> 
        </TR> 
		<TR> 
		   <TD class=text valign=top width="20%">|LANG_ADJUNTS|:</TD> 
		   <TD valign=top width="80%" class="text10">
		   		<span>|LANG_NOMARXIU| 1: <INPUT TYPE="text" NAME="NOMAD1" SIZE="60" MAXLENGTH="60" ></<br>
				<input type="file" name="file0" size="60" style="margin-top:5px;"><br><br>
				|LANG_NOMARXIU| 2: <INPUT TYPE="text" NAME="NOMAD2" SIZE="60" MAXLENGTH="60"><br>
				<input type="file" name="file1" size="60" style="margin-top:5px;"><br><br>
				|LANG_NOMARXIU| 3: <INPUT TYPE="text" NAME="NOMAD3" SIZE="60" MAXLENGTH="60"><br>
				<input type="file" name="file2" size="60" style="margin-top:5px;"><br><br>
				|LANG_NOMARXIU| 4: <INPUT TYPE="text" NAME="NOMAD4" SIZE="60" MAXLENGTH="60"><br>
				<input type="file" name="file3" size="60" style="margin-top:5px;"><br><br>
				(|LANG_FORMATS|: <b>.pdf</b> <b>.doc</b> <b>.xls</b> <b>.ppt</b> <b>.zip</b> | |LANG_MIDAMAXIMA|: <b>4.5M</b>)
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
		   		<input type="hidden" name="MODEL" value=0 />
		   		<input type="hidden" name="USUARI_HOUDINI" value="|USUARI_HOUDINI|">
				<!--<INPUT TYPE="Button" NAME="accion" VALUE="|LANG_CREARNOTICIA|" onclick="javascript:dades();"> -->
				<INPUT TYPE="submit" NAME="accion" VALUE="|LANG_CREARNOTICIA|" style="padding:5px;" />
		   </TD> 
		</TR>
		</table>
	</td>
</tr>
</table>
</form>