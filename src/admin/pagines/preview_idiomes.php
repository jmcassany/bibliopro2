<?php
header("Expires: Mon, 6 Jan 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate"); // Compatibilidad con HTTP/1.1
header("Pragma: no-cache"); // Compatibilidad con HTTP/1.0


require ('../config_admin.inc');
accessGroupPermCheck('page_read');

include_once("estatiques.php");

include("check_moduls.php");

include_once('variables.inc');

$ID=$_GET['ID'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="<?php echo urlHost($CONFIG_URLBASE) ?>">
	<script type="text/javascript">
	function carregat(){
		document.getElementById('carregant').style.display='none';
		document.getElementById('contingut').style.display='inline';
	}
	function validar() {
		if (mainform.accio[0].checked==false && mainform.accio[1].checked==false) {
				result = window.open("<?php echo $CONFIG_URLABSADMIN ?>/php/missatge.php?missatge=<?php echo t("formsmessages1"); ?>","missatge","left=0,top=0,screenX=0,screenY=0,status=no,toolbar=no,width=200,height=200,directory=no,resize=no,scrollbars=no");
				return false;
		}

	}
	</script>
 <style type="text/css">
.titblanc {color: #FFFFFF; font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 12px; text-decoration: none; font-weight: bold; }
.menupreview {color: #333333; font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 10px; text-decoration: none; font-weight: bold; }
.menupreview:hover { text-decoration: underline;color: #333333;}
.text9 {color: #333333; font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 9px; text-decoration: none; }
.peuadmin {
    width: 760px;
    border: 0px;
  }
  .peuadmin .top {
    padding-left: 15px;
    width: 21px;
  }
  .peuadmin .top img{
    border: 0px;
  }
  .peuadmin .credits {
    color: #999999;
    font-size: 9px;
    text-align: center;
    padding:5px;
  }
  .peuadmin .credits img{
    border: 0px;
  }
#tablist{
padding: 3px 0;
margin-left: 0;
margin-bottom: 0;
margin-top: 0.1em;
font: bold 12px Verdana;
}

#tablist li{
list-style: none;
display: inline;
margin: 0;
}


#tablist li {
text-decoration: none;
padding: 6px 1em;
margin-left: 3px;
color:#333333;
border-bottom: none;
background: #778DC3;
font-family: Verdana, Helvetica, Geneva, sans-serif;
font-size: 10px;
}
#tablist li a{
font-family: Verdana, Helvetica, Geneva, sans-serif;
font-size: 10px;
color:#333333;
}
#tablist li a img{
border: 0px
}
#tablist li a:link, #tablist li a:visited{
color: #333333;
}
#tablist li a:hover{
text-decoration: none;
color: #FFFFFF;
}

.botonavegacio {PADDING:5px;BACKGROUND-COLOR:#e9f2f8;BORDER:1px solid #336699;CURSOR:hand;text-decoration: none;line-height: 30px;}
.botonavegacio:hover {color:#0E449A; text-decoration: none;BACKGROUND-COLOR:#FFFFFF;}

.botoportada {font-size:10px;font-family: verdana,arial,helvetica,sans-seriff;background: #F66013;border-bottom: 2px solid #AC430D;border-right: 2px solid #AC430D;border-left: 1px solid #F69470 ;border-top:1px solid #F69470 ;color:#FFFFFF;height:19px;text-decoration:none;cursor: hand;width:75px;font-weight: bold;}

.negre10b {color: #333333; font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 10px; text-decoration: none; font-weight: bold; }

	</style>

</head>
<body style="background-color:#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0"  onload="carregat();">
<form action="<?php echo $CONFIG_URLABSADMIN ?>/pagines/crearestatic_idiomes.php" method="post" name="mainform" onsubmit="return validar();">

<?php
  //crida base de dades

  $result=db_query("select
 ID, ECLASS, SKIN, CATEGORY1, CATEGORY2, STATUS, VISIBILITY, CREATION, START_TIME, END_TIME, MODIFICAT,
 USUARICREAR, USUARIMODI, NOMPAG, DESCRIPCIO,IDIOMA,REFERENCIA,METATITOL, METADESCRIPCIO, METAKEYS,
 PARE, PLANTILLAID, MENU1, MENU2, MENU3, BANNER1, BANNER2, BANNER3, TEXTC1, TEXTC2, TEXTC3, TEXTC4, TEXTC5, TEXTC6,
 TEXTC7, TEXTC8, TEXTC9, TEXTC10, TEXTC11, TEXTC12, TEXTC13, TEXTC14, TEXTC15, TEXTC16, TEXTC17, TEXTC18, TEXTC19,
 TEXTC20, TEXTC21, TEXTC22, TEXTC23, TEXTC24, TEXTC25, TEXTC26, TEXTC27, TEXTC28, TEXTC29, TEXTC30, TEXTC31, TEXTC32,
 TEXTC33, TEXTC34, TEXTC35, TEXTC36, TEXTC37, TEXTC38, TEXTC39, TEXTC40, TEXTC41, TEXTC42, TEXTC43, TEXTC44, TEXTC45,
 IMATGE1, IMATGE2, IMATGE3, IMATGE4, IMATGE5, IMATGE6, IMATGE7, IMATGE8, IMATGE9, IMATGE10, IMATGE11, IMATGE12,
 IMATGE13, IMATGE14, IMATGE15, IMATGE16, IMATGE17, IMATGE18, IMATGE19, IMATGE20, IMATGE21, IMATGE22, IMATGE23,
 IMATGE24, IMATGE25, ADJUNT1, ADJUNT2, ADJUNT3, ADJUNT4, ADJUNT5, ADJUNT6, ADJUNT7, ADJUNT8, ADJUNT9, ADJUNT10,
 ALT1, ALT2, ALT3, ALT4, ALT5, ALT6, ALT7, ALT8, ALT9, ALT10, CERCADOR,
 OP1, OP2, OP3, OP4, OP5
  from ESTATICA where ID=$ID");
  $row = db_fetch_array($result);

  for ($i = 1; $i <=$PAGE_max_textl; $i++) {
    $row['TEXTL'.$i] = db_select_text('ESTATICA', 'TEXTL'.$i, 'ID = '.$row['ID']);
  }

  $valors = generate_page ($row, true);

?>

<!-- CAPÇELERA -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:left">
	<tr>
		<td  width="93" rowspan="4" bgcolor="#0E449A" style="padding-right:10px;" valign="bottom"><img src="<?php echo $CONFIG_URLABSADMIN ?>/comu/paisos/pict_areacontrol.jpg" width="93" height="134" alt=""></td>
		<td bgcolor="#0E449A" class="titblanc" style="padding-left:10px;padding-bottom:10px;padding-top:5px;"  colspan="2">
<?php
if (accessGroupPerm('page_publish')) {
?>
			<table cellpadding="0" cellspacing="0" border="0" width="600">
				<tr>
					<td valign="top" bgcolor="#ffffff">
						<table cellpadding="0" cellspacing="0" border="0" width="235">
							<tr>
								<td bgcolor="#152E6D" style="padding:5px;padding-bottom:3px;"><span class="titblanc">Pas 1. <span style="color:#FF9900"><?php echo t("staticpagepreviewselect") ?></span></span></td>
							</tr>
							<tr>
								<td bgcolor="#152E6D" class="text9" style="padding:5px;padding-top:0px;color:#B7BED5" ><?php echo t("staticpagepreviewselectlong") ?></td>
							</tr>
							<tr>
								<td bgcolor="#ffffff" style="padding:5px;padding-top:10px;" align="center">
								<?php
								for($i=0;$i<count($CONFIG_idiomes[$CONFIG_IDIOMA]);$i++){
									$trozos = explode ("_", $CONFIG_idiomes[$CONFIG_IDIOMA][$i]);
									$numerocategoria=$trozos['0'];
									$idioma=$trozos['1'];
									$codiidioma=$trozos['2'];
									//inserta la nova plana
									$tab=$i+1;

									echo "<img src=\"".$CONFIG_URLABSADMIN."/comu/paisos/".$codiidioma.".gif\" width=\"18\" height=\"14\" alt=\"".$idioma."\" ><input type=\"checkbox\" name=\"".$codiidioma."\" value=\"1\" style=\"margin-right:20px;margin-bottom:1px;\" >";
									// a la mitad fer un br
									if($tab==(count($CONFIG_idiomes[$CONFIG_IDIOMA])/2))echo "<br />";

								}
								?>

								</td>
							</tr>
						</table>

					</td>
					<td valign="top" style="padding-left:5px;padding-right:5px;" >
						<table cellpadding="0" cellspacing="0" border="0" width="235">
							<tr>
								<td bgcolor="#152E6D" style="padding:5px;padding-bottom:3px;" colspan="2"><span class="titblanc">Pas 2. <span style="color:#FF9900"><?php echo t("staticpagepreviewapply") ?></span></span></td>
							</tr>
							<tr>
								<td bgcolor="#152E6D" class="text9" style="padding:5px;padding-top:0px;color:#B7BED5" colspan="2"><?php echo t("staticpagepreviewapplylong") ?></td>
							</tr>
							<tr>
								<td bgcolor="#ffffff" style="padding:5px;padding-top:10px;padding-bottom:10px;" align="center" class="negre10b">
								<img src="<?php echo $CONFIG_URLABSADMIN ?>/comu/ico_generat_on.gif" alt="<?php echo t("publish"); ?>" width="28" height="19" border="0" align="absmiddle"><?php echo t("publish"); ?><br /><input type="radio" name="accio" value="publish">
								</td>
								<td bgcolor="#ffffff" style="padding:5px;padding-top:10px;padding-bottom:10px;" align="center" class="negre10b">
								<img src="<?php echo $CONFIG_URLABSADMIN ?>/comu/ico_generat_off.gif" alt="<?php echo t("unpublish"); ?>" width="28" height="19" border="0" align="absmiddle"><?php echo t("unpublish"); ?><br /><input type="radio" name="accio" value="unpublish">


								</td>
							</tr>
						</table>

					</td>
					<td valign="top"  bgcolor="#ffffff">
						<table cellpadding="0" cellspacing="0" border="0" width="160">
							<tr>
								<td bgcolor="#152E6D" style="padding:5px;padding-bottom:3px;"><span class="titblanc">Pas 3. <span style="color:#FF9900"><?php echo t("staticpagepreviewaction") ?></span></span></td>
							</tr>
							<tr>
								<td bgcolor="#152E6D" class="text9" style="padding:5px;padding-top:0px;color:#B7BED5" ><?php echo t("staticpagepreviewactionlong") ?></td>
							</tr>
							<tr>
								<td bgcolor="#ffffff" style="padding:5px;padding-top:15px;" align="center">
<input type="hidden" name="id_idioma"  value="<?php echo $row['ID'] ?>" />
<input type="hidden" name="carpeta"  value="<?php echo $row['PARE'] ?>" />
<input type="submit" name="go"  value="<?php echo t('go') ?> »" class="botoportada" style="height:30px;" />

								</td>
							</tr>
						</table>

					</td>

				</tr>
			</table>
<?php
}
?>
		</td>
	</tr>
	<tr>
		<td bgcolor="#466DAE" height="1" colspan="2"><img src="<?php echo $CONFIG_URLABSADMIN ?>/comu/bl.gif"  width="1" height="1" border="0" ></td>
	</tr>
	<tr>
		<td bgcolor="#18357D" height="1" colspan="2"><img src="<?php echo $CONFIG_URLABSADMIN ?>/comu/bl.gif"  width="1" height="1" border="0" ></td>
	</tr>
	<tr>
		<td bgcolor="#0E449A" style="padding-top:10px;">
		<ul id="tablist">
<?php
//crear pestanyes idiomes
if ($row['REFERENCIA']!=0) {
  $referencia = $row['REFERENCIA'];
}
else {
  $referencia = $row['ID'];
}
$resultidioma=db_query("select ID,IDIOMA from ESTATICA where (ESTATICA.ID = '".$referencia."') OR (ESTATICA.REFERENCIA = '".$referencia."') ORDER BY ID ASC");
$text_idiomes = array();
foreach ($CONFIG_idiomes[$CONFIG_IDIOMA] as $value) {
  $trosos = explode ("_", $value);
  $text_idiomes[$trosos[2]] = $trosos[1];
}
while($rowidioma = db_fetch_array($resultidioma)) {
  if ($row['ID'] == $rowidioma['ID']){
    echo '<li class="seleccionat" style="background-color: #FFFFFF;"><img src="'.$CONFIG_URLABSADMIN.'/comu/paisos/'.$rowidioma['IDIOMA'].'.gif" width="18" height="14" alt="'.$text_idiomes[$rowidioma['IDIOMA']].'" align="absmiddle" border="0">&nbsp;'.$text_idiomes[$rowidioma['IDIOMA']].'&nbsp;&nbsp;</li>';
  }else{
    echo '<li><a href="'.$CONFIG_URLABSADMIN.'/pagines/preview_idiomes.php?ID='.$rowidioma['ID'].'&carpeta='.$row['PARE'].'"><img src="'.$CONFIG_URLABSADMIN.'/comu/paisos/'.$rowidioma['IDIOMA'].'.gif" width="18" height="14" alt="'.$text_idiomes[$rowidioma['IDIOMA']].'" align="absmiddle" border="0">&nbsp;'.$text_idiomes[$rowidioma['IDIOMA']].'</a></li>';
  }
}
?>


</ul>
		</td>
		<td align="right" bgcolor="#0E449A" style="padding-right:20px;">
		<a href="<?php echo $CONFIG_URLABSADMIN ?>/pagines/index.php?carpeta=<?php echo $carpeta; ?>"  class="botonavegacio" style="height:25px;">&nbsp;<?php echo t("cancel"); ?>&nbsp;</a>
		</td>
	</tr>

</table>
<!-- /CAPÇELERA -->

<table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#D6D6D6">

	<tr><td colspan="3" bgcolor="#000000" height="3"><img src="<?php echo $CONFIG_URLABSADMIN ?>/comu/bl.gif"  width="1" height="3" border="0" ></td></tr>
	<tr><td colspan="3" bgcolor="#5C5C5C" height="1"><img src="<?php echo $CONFIG_URLABSADMIN ?>/comu/bl.gif"  width="1" height="1" border="0" ></td></tr>
	<tr><td colspan="3" bgcolor="#898989" height="1"><img src="<?php echo $CONFIG_URLABSADMIN ?>/comu/bl.gif"  width="1" height="1" border="0" ></td></tr>
	<tr><td colspan="3" bgcolor="#D1D1D1" height="1"><img src="<?php echo $CONFIG_URLABSADMIN ?>/comu/bl.gif"  width="1" height="1" border="0" ></td></tr>
</table>
<br />
</form>


<div id="carregant" style="position: absolute; left:250px; top:175px; background-color: #FFFFFF; layer-background-color: #FFFFFF;">
<?php echo t("loading"); ?>
</div>
<div id="contingut" style="display: none;">
<table  cellpadding="0" cellspacing="0" border="0"  bgcolor="#FFFFFF">
<?php
if (accessGroupPerm('page_edit')) {
?>
	<tr>
		<td style="padding-left:105px;"><?php echo "<a href=\"".$CONFIG_URLABSADMIN."/pagines/edita.php?ID=".$row['ID']."&carpeta=".$row['PARE']."\"><img src=\"".$CONFIG_URLABSADMIN."/comu/icon_modifica.gif\" alt=\"Editar\" width=\"23\" height=\"16\" border=\"0\" align=\"absmiddle\">Modificar aquesta plana</a>"; ?></td>
	</tr>
<?php
}
?>
	<tr>
		<td style="padding-left:105px;padding-top:5px;">

<?php

if (!is_array($valors)) {
  echo $valors;
}
else {
  echo $valors['normal'];
}
db_free_result($result);

?>
</td>
	</tr>
</table>
<!-- /taula per mostrar preview plana -->
<br />
<table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#D6D6D6">
	<tr><td colspan="3" bgcolor="#D1D1D1" height="1"><img src="<?php echo $CONFIG_URLABSADMIN ?>/comu/bl.gif"  width="1" height="1" border="0" ></td></tr>
	<tr><td colspan="3" bgcolor="#898989" height="1"><img src="<?php echo $CONFIG_URLABSADMIN ?>/comu/bl.gif"  width="1" height="1" border="0" ></td></tr>
	<tr><td colspan="3" bgcolor="#5C5C5C" height="1"><img src="<?php echo $CONFIG_URLABSADMIN ?>/comu/bl.gif"  width="1" height="1" border="0" ></td></tr>
	<tr><td colspan="3" bgcolor="#000000" height="3"><img src="<?php echo $CONFIG_URLABSADMIN ?>/comu/bl.gif"  width="1" height="3" border="0" ></td></tr>
	<tr><td colspan="3" bgcolor="#0E449A" height="15"><img src="<?php echo $CONFIG_URLABSADMIN ?>/comu/bl.gif"  width="1" height="15" border="0" ></td></tr>
</table>
<br />
<?php echo htmlFoot(); ?>
</div>
</body>
</html>
