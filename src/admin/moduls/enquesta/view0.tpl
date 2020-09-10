<html>
<head>
|METAS|
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<!-- CAPÇELERA -->
|CAPCELERA|
<!-- /CAPÇELERA -->

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">			
	
	<!-- situacio Sou a -->
	<tr>
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b>|LANG_POLLTITLE|</b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">	
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td width="50%" class="text10"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="|LANG_YOUAREIN|" border="0" align="absmiddle">|LANG_YOUAREIN|: <a href="../../index.php">|LANG_HOME|</a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="../../utilitats/index.php">|LANG_UTILS|</a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><a href="index.php">|LANG_POLLTITLE|</a><img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0"><font class="blau10b">|LANG_POLLMODIF|</font></td>

				</tr>

			</table>
		</td>
	</tr>
	
	<!-- /situacio Sou a -->

	<tr>
		<td colspan="2" style="padding:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="50%" style="padding:8px;" bgcolor="#0E449A" class="blanc10b" valign="middle"><img src="../../comu/kland_flexa.gif" width="21" height="13" border="0" align="bottom">|LANG_POLLMODIF|</td>
					<td width="50%"  bgcolor="#0E449A" class="blanc10b" valign="middle" align="right">					
					
					</td>
				</tr>				
			</table>
		</td>
	</tr>

	<tr>
		<form action="|ACCIO_FORM|.php" method="post" enctype="multipart/form-data">
		<!-- FORMULARI ENTRADA -->
		<td colspan="2" style="padding:10px;" valign="top">
			<TABLE width="100%" cellpadding="5" cellspacing="0" border="0"> 
			
			
			<TR> 
			   <TD class=text valign=top width="20%">|LANG_NAME|:</TD>
			   <TD valign=top width="80%"><INPUT TYPE="text" NAME="NOM"  VALUE="|NOM|" SIZE="50" MAXLENGTH="250" class="formulari"></TD>
			</TR>	
			<TR> 
			   <TD class=text valign=top width="20%">|LANG_DESCRIPTION|:</TD>
			   <TD valign=top width="80%"><INPUT TYPE="text" NAME="DESCRIPCIO"  VALUE="|DESCRIPCIO|" SIZE="50" MAXLENGTH="250" class="formulari"></TD> 
			</TR>	
			<TR>
			   <TD class=text valign=top width="20%">|LANG_POLLTEMPLATE|:</TD>
			   <TD valign=top width="80%">|SELECT_PLANTILLA|</TD>
			</TR>

   				<tr>
					<td class=text valign=top width="20%">
						|LANG_STATUS|:
					</td>
					<td valign=top width="80%"> |SELECT_STATUS|	</td>
				</tr>

				<tr>
					<td class=text valign=top width="20%">|LANG_TITLE|: </td>
					<td valign=top width="80%"><input type="text" name="TITOL" VALUE="|TITOL|" maxlength="250" class="formulari"></td></td>
				</tr>


			<TR>
			   <TD  valign=top  class="text10" colspan=2><b>|LANG_DATE| |LANG_PUBLISH|:</b>
			   		<!-- vincles -->
					<table cellpadding="0" cellspacing="0" border="0" width="558" style="border:solid #CCCCCC 1px;">
						<tr style="padding:5px;">
							<td class="text10" width="80">|LANG_FORMDATE| |LANG_START|:</td>
							<td class="text10"><input type="text" name="START_TIME_DAY" value="|START_TIME_DAY|" maxlength="2" class="formulari" style="width:25px;">
								/ <input type="text" name="START_TIME_MONTH" value="|START_TIME_MONTH|" maxlength="2" class="formulari" style="width:25px;">
				                / <input type="text" name="START_TIME_YEAR" value="|START_TIME_YEAR|" maxlength="4" class="formulari" style="width:50px;"> (|LANG_DATEFORMAT|)
							</td>

						</tr>
						<tr style="padding:5px;" width="80">
							<td class="text10">|LANG_DATE| |LANG_END|</td>
							<td class="text10"><input type="text" name="END_TIME_DAY" value="|END_TIME_DAY|" maxlength="2" class="formulari" style="width:25px;">
				              	/ <input type="text" name="END_TIME_MONTH" value="|END_TIME_MONTH|" maxlength="2" class="formulari" style="width:25px;">
				                / <input type="text" name="END_TIME_YEAR" value="|END_TIME_YEAR|" maxlength="4" class="formulari" style="width:50px;"> (|LANG_DATEFORMAT|)
							</td>
						</tr>
						<tr style="padding:5px;" width="80">
							<td class="text10" colspan="2">|LANG_ACTIVATE| |ACTIVAR|</td>

						</tr>
					</table>


			   </TD>
			</TR>

		

			<TR>   
			   <TD valign=top  colspan=2 style="padding:20px;padding-left:200px;">  	
			   <INPUT TYPE="hidden" NAME="ID" VALUE="|ID|">
			   <INPUT TYPE="hidden" NAME="USUARI" VALUE="|USUARI|">
			   <INPUT TYPE="hidden" NAME="USUARI" VALUE="|USUARI|" class=boto>
			   <INPUT TYPE="submit" NAME="accion" VALUE="|LANG_UPDATE|" class=boto>
			   
			   </TD> 
			</TR>
			
			</TABLE> 	
			
			<!-- taula info -->
<table cellpadding="0" cellspacing="0" border="0" width="98%" style="border-top:solid #000000 2px;">		
	<tr>		
		<td   class="text9" width="80%" style="border-top:solid #CCCCCC 1px;padding-bottom:5px;padding-top:5px;padding-left:5px;;">

			|LANG_BANNERSCREATEDATA| |CREATION_DAY|-|CREATION_MONTH|-|CREATION_YEAR| |LANG_FOR| |USUARICREAR| |TEXTMODIFICAT|
		</td>
		
	</tr>
</table>	
<!-- /taula info -->
					
		</td>
		<!-- /FORMULARI ENTRADA -->
		
	</tr>
			
	
</table>
<!-- /PART CENTRAL -->
|PEU|
</form>
</body>
</html>

