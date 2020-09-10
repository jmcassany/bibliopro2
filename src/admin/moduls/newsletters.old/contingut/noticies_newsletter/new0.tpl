|FCK1|
<form action="create.php" method="post" name="env_dades" enctype="multipart/form-data">
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;">			
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
	<td colspan="2" style="padding-left:10px;padding-right:10px;padding-top:10px;text-align:right;">	
		<img src="../../../../../public/media/comu/admin/bot_enrera_blau.gif" border="0" style="vertical-align:middle;" /> <a href="list.php">|LANG_TORNAR|</a>
	</td>
</tr>
<tr>
	<td colspan="2" style="padding:5px;">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle">
					<img src="../../../../../public/media/comu/admin/kland_flexa.gif" width="21" height="13" border="0" align="bottom">|LANG_CREARNOTICIA|
				</td>					
			</tr>				
		</table>
	</td>
</tr>
<tr>
	<td colspan="2" style="padding:10px;" valign="top">
		<table width="100%" cellpadding="5" cellspacing="5" border="0">
		<!--
		<TR> 
		   <TD class=text valign=top width="20%">|LANG_ESTAT|:</TD> 
		   <TD valign=top width="80%">
		   	|SELECT_STATUS|
		   </TD> 
		</TR>
		-->
		<input type="hidden" name="STATUS" value="1">
		<TR> 
		   <TD class=text valign=top width="20%">|LANG_MODEL|:</TD> 
		   <TD valign=top width="80%"><select name="MODEL" style="width:150px;">|MODEL|</select></TD> 
		</TR>
		<!--
		<TR> 
		   <TD class=text valign=top width="20%">Títol notícia:</TD> 
		   <TD valign=top width="80%"><INPUT TYPE="text" NAME="TITOL" SIZE="60" MAXLENGTH="150"></TD> 
		</TR> 
		<TR> 
		   <TD class=text valign=top width="20%">|LANG_SUBTITOL|:</TD> 
		   <TD valign=top width="80%"><INPUT TYPE="text" NAME="SUBTITOL" SIZE="60" MAXLENGTH="150"></TD> 
		</TR> 
		<TR> 
		   <TD class=text valign=top width="20%">|LANG_DATALLOC|:</TD> 
		   <TD valign=top width="80%"><INPUT TYPE="text" NAME="DATA_LLOC" SIZE="60" MAXLENGTH="150"></TD> 
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
		   <TD class=text valign=top width="20%">|LANG_NOM|:</TD> 
		   <TD valign=top width="80%"><INPUT TYPE="text" NAME="NOM" SIZE="60" MAXLENGTH="150"></TD> 
		</TR> 
		<TR> 
		   <TD class=text valign=top width="20%">|LANG_CARREC|:</TD> 
		   <TD valign=top width="80%"><INPUT TYPE="text" NAME="CARREC" SIZE="60" MAXLENGTH="150"></TD> 
		</TR> 
		<tr>
			<td colspan="2">
				&nbsp;
			</td>
		</tr> 
		<TR> 
		   <TD class=text valign=top width="20%">|LANG_IMATGES|:</TD> 
		   <TD valign=top width="80%" class="text10">
				Text: <INPUT TYPE="text" NAME="IMATGE3" SIZE="60" MAXLENGTH="60"><br>
		   		<input type="file" name="img[]" size="60"><br />
		   		<select name="IMATGE2">
		   			<option value="85">85px</option>
		   			<option value="170">170px</option>
		   			<option value="380">380px</option>
		   		</select>
				(|LANG_FORMATS|: <b>.jpg</b> <b>.gif</b> | |LANG_MIDAMAXIMA|: <b>500K</b>)
		   </TD> 
		</TR> 
		<tr>
			<td colspan="2">
				&nbsp;
			</td>
		</tr>
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
		<TR > 			  
		   <TD valign=top colspan="2" class="text10" style="background-color:#EAEAEA;padding:5px 10px;">	
		   <h3 class="opcions"><a href="javascript:toggleLayer('capaOpcions');" title="Mostrar altres opcions">Opcions avançades >></a></h3>		  
		   <div id="capaOpcions">
		   		<strong>|LANG_LINKSNOTICIESNEWSLETTER|</strong>:<br /><br />
		   		<input type="hidden" name="MESINFO" value="1">
				Nom del document: <INPUT TYPE="text" NAME="NOMAD5" SIZE="60" MAXLENGTH="60"><br>
				<input type="file" name="file4" size="60"><br>
				(|LANG_FORMATS|: <b>.pdf</b> <b>.doc</b> <b>.xls</b> <b>.ppt</b> <b>.zip</b> | |LANG_MIDAMAXIMA|: <b>500K</b>)<br><br>
				|LANG_ANEUALWEB|:<br><input type="text" name="LINK2" size="60"><br>
			</div>
		   </TD> 
		</TR> 
		-->
		<tr>
			<td colspan="2">
				&nbsp;
			</td>
		</tr>
		<TR>   
		   <TD colspan="2" style="border-top:solid #0E449A 1px;">
		   		<br>
		   		<input type="hidden" name="USUARI_HOUDINI" value="|USUARI_HOUDINI|">
				<!--<INPUT TYPE="Button" NAME="accion" VALUE="|LANG_CREARNOTICIA|" onclick="javascript:dades();"> -->
				<INPUT TYPE="submit" NAME="accion" VALUE="|LANG_CREARNOTICIA|" />
		   </TD> 
		</TR>
		</table>
	</td>
</tr>
</table>
</form>