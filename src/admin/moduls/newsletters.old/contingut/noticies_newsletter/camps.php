<?php
$data['CAMPS'] = '
		<TR> 
		   <TD class=text valign=top width="20%">'.$messages['descripcio'].':</TD> 
		   <TD valign=top width="80%">
				'.$data['FCK2'].'
			</TD> 
		</TR>
		<TR> 
		   <TD class=text valign=top width="20%">'.$messages['nom'].':</TD> 
		   <TD valign=top width="80%"><INPUT TYPE="text" NAME="NOM" SIZE="60" MAXLENGTH="150" value="'.$data['NOM'].'"></TD> 
		</TR> 
		<TR> 
		   <TD class=text valign=top width="20%">'.$messages['carrec'].':</TD> 
		   <TD valign=top width="80%"><INPUT TYPE="text" NAME="CARREC" SIZE="60" MAXLENGTH="150" value="'.$data['CARREC'].'"></TD> 
		</TR> 
		<TR> 
		   <TD  valign=top  class="text" colspan=2><b>'.$messages['imatges'].':</b>
				<table cellpadding="0" cellspacing="0" border="0" width="100%" style="padding:5px;border:solid #CCCCCC 1px;">
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-bottom:solid #CCCCCC 1px;">
							<tr>
								<td style="padding:5px;" valign="top" class="text10">
									'.$data['IMATGE1'].'
								</td>
							</tr>
						</table>
						<br>
						<table cellpadding="0" cellspacing="0" border="0" width="100%">
							<tr>
								<td style="padding:5px;" class="text10">
									Text: <INPUT TYPE="text" NAME="IMATGE3" value="'.$data['IMATGE3'].'" SIZE="60" MAXLENGTH="60"><br />
									<input type=file name="img[]" size="60"><br />
									'.$data['PIXELS_IMG'].'<br />
									<br />
									('.$messages['formats'].': <b>.jpg</b> <b>.gif</b> | '.$messages['midamaxima'].': <b>500K</b>)
								</td>
							</tr>
						</table>
					</td>
				</tr>
				</table>			   		
		   </TD> 
		</TR>
		<TR> 
		   <TD  valign=top  class="text" colspan=2><b>'.$messages['adjunts'].':</b>
				<table cellpadding="0" cellspacing="0" border="0" width="100%" style="padding:5px;border:solid #CCCCCC 1px;">
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-bottom:solid #CCCCCC 1px;">
							<tr>
								<td width="20%" valign="top" style="padding:5px;">'.$data['ADJUNT1'].'</td>
								<td style="padding:5px;" class="text10">
									'.$messages['nomarxiu'].' 1: <INPUT TYPE="text" NAME="NOMAD1" SIZE="60" MAXLENGTH="60" value="'.$data['NOMAD1'].'"><br>
									<input type="file" name="file0" size="60" style="margin-top:5px;"><br>
								</td>
							</tr>
						</table>
						<br>
						<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-bottom:solid #CCCCCC 1px;">
							<tr>
								<td width="20%" valign="top" style="padding:5px;">'.$data['ADJUNT2'].'</td>
								<td style="padding:5px;" class="text10">
									'.$messages['nomarxiu'].' 2: <INPUT TYPE="text" NAME="NOMAD2" SIZE="60" MAXLENGTH="60" value="'.$data['NOMAD2'].'"><br>
									<input type="file" name="file1" size="60" style="margin-top:5px;"><br>
								</td>
							</tr>
						</table>
						<br>
						<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-bottom:solid #CCCCCC 1px;">
							<tr>
								<td width="20%" valign="top" style="padding:5px;">'.$data['ADJUNT3'].'</td>
								<td style="padding:5px;" class="text10">
									'.$messages['nomarxiu'].' 3: <INPUT TYPE="text" NAME="NOMAD3" SIZE="60" MAXLENGTH="60" value="'.$data['NOMAD3'].'"><br>
									<input type="file" name="file2" size="60" style="margin-top:5px;"><br>
								</td>
							</tr>
						</table>
						<br>
						<table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-bottom:solid #CCCCCC 1px;">
							<tr>
								<td width="20%" valign="top" style="padding:5px;">'.$data['ADJUNT4'].'</td>
								<td style="padding:5px;" class="text10">
									'.$messages['nomarxiu'].' 4: <INPUT TYPE="text" NAME="NOMAD4" SIZE="60" MAXLENGTH="60" value="'.$data['NOMAD4'].'"><br>
									<input type="file" name="file3" size="60" style="margin-top:5px;"><br>
								</td>
							</tr>
						</table>
						<br>
						<table cellpadding="0" cellspacing="0" border="0" width="100%">
							<tr>
								<td width="20%" valign="top" style="padding:5px;">&nbsp;</td>
								<td style="padding:5px;" class="text10">
									('.$messages['formats'].': <b>.pdf</b> <b>.doc</b> <b>.xls</b> <b>.ppt</b> <b>.zip</b> | '.$messages['midamaxima'].': <b>4.5M</b>)	
								</td>
							</tr>
						</table>
					</tr>
				</tr>
				</table>  		
		   </TD> 
		</TR>
		';
?>