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
					<li><a href="../noticies_newsletter/list.php">Notícies</a></li>
					<li>Categories</li>
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
					<img src="../../../../../public/media/comu/admin/kland_flexa.gif" width="21" height="13" border="0" align="bottom">|LANG_CREARCATEGORIA|
				</td>					
			</tr>				
		</table>
	</td>
</tr>
<tr>
	<form action="create.php" method="post" name="env_dades" enctype="multipart/form-data">
	<td colspan="2" style="padding:10px;" valign="top">
		<table width="100%" cellpadding="5" cellspacing="5" border="0">
		<TR> 
		   <TD class=text valign=top width="20%">|LANG_ESTAT|:</TD> 
		   <TD valign=top width="80%">
		   	|SELECT_STATUS|
		   </TD> 
		</TR> 	
		<TR> 
		   <TD class=text valign=top width="20%">Títol categoria:</TD> 
		   <TD valign=top width="80%"><INPUT TYPE="text" NAME="TITOL" SIZE="60" MAXLENGTH="150"></TD> 
		</TR> 
		<input type="hidden" name="COLOR" value="#8b1f30">
		<tr>
			<td colspan="2">
				&nbsp;
			</td>
		</tr>
		<TR>   
		   <TD colspan="2" style="border-top:solid #0E449A 1px;">
		   		<br>
				<INPUT TYPE="Button" NAME="accion" VALUE="|LANG_CREARCATEGORIA|" onclick="javascript:dades();"> 
		   </TD> 
		</TR>
		</table>
	</td>
	<input type="hidden" name="ORDRECAT" value="|ORDRECAT|">
	<input type="hidden" name="USUARI_HOUDINI" value="|USUARI_HOUDINI|">
	</form>
</tr>
</table>