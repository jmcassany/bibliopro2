<?php

require ('../config_admin.inc');
accessGroupPermCheck('page_edit');

include_once("estatiques.php");

   include("check_moduls.php");

if(isset($_GET['accio'])){
  $accio = $_GET['accio'];
}
else {
  $accio = 0;
}




//capçelera de situacio
$situacio ="<a href='index.php?carpeta=".$carpeta."'>".$nomcarpeta."</a><img src=\"../comu/kland_etsa.gif\" width=\"19\" height=\"5\" border=\"0\">";
//fi capçelera de situacio

$data = date('Y-m-d H:i:s', time());//+21000 per usa


$ID=$_GET['ID'];


  $result=db_query("select
  ESTATICA.ID,
  ESTATICA.ECLASS, ESTATICA.SKIN, ESTATICA.CATEGORY1, ESTATICA.CATEGORY2, ESTATICA.STATUS, ESTATICA.VISIBILITY,
  ESTATICA.CREATION, ESTATICA.START_TIME, ESTATICA.END_TIME, ESTATICA.MODIFICAT, ESTATICA.USUARICREAR,
  ESTATICA.USUARIMODI, ESTATICA.NOMPAG, ESTATICA.DESCRIPCIO,ESTATICA.IDIOMA,ESTATICA.REFERENCIA,ESTATICA.METATITOL,
  ESTATICA.METADESCRIPCIO, ESTATICA.METAKEYS, ESTATICA.PARE, ESTATICA.PLANTILLAID, ESTATICA.MENU1,
  ESTATICA.MENU2, ESTATICA.MENU3, ESTATICA.BANNER1, ESTATICA.BANNER2, ESTATICA.BANNER3, ESTATICA.TEXTC1,
  ESTATICA.TEXTC2, ESTATICA.TEXTC3, ESTATICA.TEXTC4, ESTATICA.TEXTC5, ESTATICA.TEXTC6, ESTATICA.TEXTC7, ESTATICA.TEXTC8,
  ESTATICA.TEXTC9, ESTATICA.TEXTC10, ESTATICA.TEXTC11, ESTATICA.TEXTC12, ESTATICA.TEXTC13, ESTATICA.TEXTC14,
  ESTATICA.TEXTC15, ESTATICA.TEXTC16, ESTATICA.TEXTC17, ESTATICA.TEXTC18, ESTATICA.TEXTC19, ESTATICA.TEXTC20,
  ESTATICA.TEXTC21, ESTATICA.TEXTC22, ESTATICA.TEXTC23, ESTATICA.TEXTC24, ESTATICA.TEXTC25, ESTATICA.TEXTC26,
  ESTATICA.TEXTC27, ESTATICA.TEXTC28, ESTATICA.TEXTC29, ESTATICA.TEXTC30, ESTATICA.TEXTC31, ESTATICA.TEXTC32,
  ESTATICA.TEXTC33, ESTATICA.TEXTC34, ESTATICA.TEXTC35, ESTATICA.TEXTC36, ESTATICA.TEXTC37, ESTATICA.TEXTC38,
  ESTATICA.TEXTC39, ESTATICA.TEXTC40, ESTATICA.TEXTC41, ESTATICA.TEXTC42, ESTATICA.TEXTC43, ESTATICA.TEXTC44,
  ESTATICA.TEXTC45, ESTATICA.IMATGE1, ESTATICA.IMATGE2, ESTATICA.IMATGE3, ESTATICA.IMATGE4, ESTATICA.IMATGE5,
  ESTATICA.IMATGE6, ESTATICA.IMATGE7, ESTATICA.IMATGE8, ESTATICA.IMATGE9, ESTATICA.IMATGE10, ESTATICA.IMATGE11,
  ESTATICA.IMATGE12, ESTATICA.IMATGE13, ESTATICA.IMATGE14, ESTATICA.IMATGE15, ESTATICA.IMATGE16, ESTATICA.IMATGE17,
  ESTATICA.IMATGE18, ESTATICA.IMATGE19, ESTATICA.IMATGE20, ESTATICA.IMATGE21, ESTATICA.IMATGE22, ESTATICA.IMATGE23,
  ESTATICA.IMATGE24, ESTATICA.IMATGE25, ESTATICA.ADJUNT1, ESTATICA.ADJUNT2, ESTATICA.ADJUNT3, ESTATICA.ADJUNT4,
  ESTATICA.ADJUNT5, ESTATICA.ADJUNT6, ESTATICA.ADJUNT7, ESTATICA.ADJUNT8, ESTATICA.ADJUNT9, ESTATICA.ADJUNT10,
  ESTATICA.ALT1, ESTATICA.ALT2, ESTATICA.ALT3, ESTATICA.ALT4, ESTATICA.ALT5, ESTATICA.ALT6, ESTATICA.ALT7,
  ESTATICA.ALT8, ESTATICA.ALT9, ESTATICA.ALT10, ESTATICA.CERCADOR,
  ESTATICA.OP1, ESTATICA.OP2, ESTATICA.OP3, ESTATICA.OP4, ESTATICA.OP5,
  PLANTILLA.DESCRIPCIO as DESC_PLANTILLA ,PLANTILLA.IMATGES,PLANTILLA.TEXTLLARG,PLANTILLA.TEXTCURT,PLANTILLA.NOM as PLANTILLANOM,PLANTILLA.ADJUNTS,PLANTILLA.OP
  from ESTATICA LEFT JOIN PLANTILLA ON ESTATICA.PLANTILLAID = PLANTILLA.ID where ESTATICA.ID = '$ID'");


$trobats = db_num_rows($result);

if ($trobats == '0'){
  htmlPageError(t("staticpageerrornotfound"), array('../index.php'));
}

$row = db_fetch_array($result);

for ($i = 1; $i <=$PAGE_max_textl; $i++) {
  $row['TEXTL'.$i] = db_select_text('ESTATICA', 'TEXTL'.$i, 'ID = '.$row['ID']);
}


//comprovar q la plantilla sigui correcta
$result3=db_query("select PARE, ECLASS from PLANTILLA where ID='".$row['PLANTILLAID']."'");
$row3 = db_fetch_array($result3);
if (($row3['ECLASS'] == 2 && $row3['PARE'] == $row['PARE']) || ($row3['ECLASS'] == 1 && preg_match('#^'.folderPath($row3['PARE']) . '#',folderPath($row['PARE'])))) {
  register_add(t("staticpagesregistryfolder"), $row['NOMPAG']);
  $missatge = "<b>".$row['NOMPAG']."</b> - ". t("staticpagesinfochangefolderok")."<br><br><br><a href=\"edita.php?ID=$ID&carpeta=".$row['PARE']."\" class=\"botonavegacio\">".t("edit")." ".t("page")."</a>&nbsp;&nbsp;&nbsp;<a href=\"index.php?carpeta=$carpeta\" class=\"botonavegacio\">".t("continuesamefolder")."</a>&nbsp;&nbsp;&nbsp;<a href=\"index.php?carpeta=".$row['PARE']."\" class=\"botonavegacio\">".t("gonewfolder")."</a>";
}else{
  goto_url('canvia_plantilla.php?ID='.$ID.'&carpeta='.$row['PARE'].'&missatge=1');
}
//fi comprovar plantilla


?>
<html>
<head>
<?php echo htmlMetas(); ?>

<style type="text/css">
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
text-decoration: none;

}
#tablist li a:link, #tablist li a:visited{
color: #333333;
}
#tablist li a:hover{
text-decoration: none;
color: #FFFFFF;
}

#pest {
	margin: 5px 0;
	padding: 0;
	list-style: none;
}
#pest li {
	float: left;
	padding: 0;
	margin: 0;
}
#pest a {
	background-color: #778DC3;
	color: #fff;
	display: block;
	padding: 5px;
	margin-right: 3px;
	text-decoration: none;
	font-weight: bold;
}
#pest a.actiu {
	background-color: #0E449A;
}
</style>

<script type="text/javascript">
function refrescar(){
  location.reload();
}

function mostraropcionsavan(){
  document.getElementById('opcionsavanboto').style.display='none';
  document.getElementById('opcionsavan').style.display='inline';
}
function amagaropcionsavan(){
  document.getElementById('opcionsavanboto').style.display='inline';
  document.getElementById('opcionsavan').style.display='none';
}

function preview() {
	target = $('#form').attr('target');
	action = $('#form').attr('action');
	$('#form').attr('target', 'preview');
	$('#form').attr('action', 'live_preview.php');
	$('#form').submit();
	$('#form').attr('target', '');
	$('#form').attr('action', action);
}
$().ready(function(){
	$('#preview-tab').hide();
	$('#preview-link').click(function(){
		preview();
		$('#form-tab').hide();
		$('#preview-tab').show();
		return false;
	});
	$('#form-link').click(function(){
		$('#preview-tab').hide();
		$('#form-tab').show();
		return false;
	});
})

</script>
<?php echo editor_head($row['IDIOMA']); ?>

</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" >

<div id="contingut">
<form action="update.php" method="post" name="FORM" id="form">
<input type="hidden" name="MODIFICAT" value="<?php echo $data ?>" >

<?php


//saber titols plantilla
$result2=db_query("select *  from PLANTILLA_DESC where PLANTILLA = '".$row['PLANTILLAID']."'");
$row2 = db_fetch_array($result2);

$row2 = str_replace("|", "", $row2);



////saber titols plantilla

$quantstextcurts=$row['TEXTCURT'];
$quantstextllargs=$row['TEXTLLARG'];
$quantesimatges=$row['IMATGES'];
$quantsadjunts=$row['ADJUNTS'];
$quantsalts=$row['IMATGES'];
$quantsop=$row['OP'];
$iniciatextcurts=1;
$iniciatextllargs=1;
$iniciaimatges=0;
$iniciaadjunts=0;
$iniciaalts=1;
$iniciaop=1;

//title pagina
if ($row['METATITOL'] == "")$row['METATITOL']="$CONFIG_SITENAME";

//imatges
for($i=1;$i<=20;$i++){
	$camp="IMATGE".$i;
	if ($row[$camp] != "")$iniciaimatges++;
}


//adjunts
for($i=1;$i<=10;$i++){
	$camp="ADJUNT".$i;
	if ($row[$camp] != "")$iniciaadjunts++;
}
?>

<?php echo htmlHeader(); ?>


<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;padding-left:10px;padding-right:10px;">
	<!-- situacio Sou a -->
	<tr>
		<td class="text10" bgcolor="#FDDBCA" style="padding:6px;" colspan="2"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("staticpagestitle"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td class="text10" width="75"><img src="../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>:&nbsp;</td>
					<td  class="text10"><a href="../index.php"><?php echo t("home"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><?php echo $situacio; ?><font class="blau10b"><?php echo $row['NOMPAG']; ?></font></td>
					<td  class="text10"  width="160" align="right" style="padding-right:5px;"><a href="index.php?carpeta=<?php echo $carpeta; ?>"  class="vermell9" title="<?php echo t("backnotsave"); ?>"><b><?php echo t("cancel"); ?></b><img src="../comu/icon_cancelar.gif" alt="<?php echo t("backnotsave"); ?>" width="26" height="19" border="0" align="absmiddle" hspace="5"></a></td>

				</tr>
			</table>
		</td>
	</tr>
	<!-- /situacio Sou a -->

	<tr>
		<td class="text" style="padding-right:0px;padding-top:10px;" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin-bottom:5px;">
<tr>
		<td bgcolor="#0E449A" style="padding-top:15px;">
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
    echo '<li class="seleccionat" style="background-color: #FFFFFF;"><img src="../comu/paisos/'.$rowidioma['IDIOMA'].'.gif" width="18" height="14" alt="'.$text_idiomes[$rowidioma['IDIOMA']].'" align="absmiddle" border="0">&nbsp;'.$text_idiomes[$rowidioma['IDIOMA']].'&nbsp;&nbsp;</li>';
  }else{
    echo '<li><a href="edita.php?ID='.$rowidioma['ID'].'&carpeta='.$row['PARE'].'"><img src="../comu/paisos/'.$rowidioma['IDIOMA'].'.gif" width="18" height="14" alt="'.$text_idiomes[$rowidioma['IDIOMA']].'" align="absmiddle" border="0">&nbsp;'.$text_idiomes[$rowidioma['IDIOMA']].'</a></li>';
  }
}

?>


</ul>
</td>

	</tr>

</table>
<!-- PART CENTRAL DADES-->

<ul id="pest">
	<li><a href="#form-tab" id="form-link" class="actiu">Formulari</a></li>
	<li><a href="#preview-tab" id="preview-link">Preview</a></li>
</ul>
<div id="form-tab" style="clear:both">
<!-- Primer bloc -->
<table cellpadding="0"  cellspacing="0" border="0" width="98%" >
	<tr>
		<td width="70%" valign="top">
			<table cellpadding="0"  cellspacing="0" border="0" width="98%" style="border:solid #F66114 1px;">
				<tr>
					<td class="text10" style="padding:15px;"><img src="../comu/icon_pag.gif" alt="<?php echo t("staticpagesnamepage"); ?>" width="8" height="10" border="0" align="absmiddle">&nbsp;<b><?php echo t("staticpagesnamepage"); ?></b></td>
					<td width="70%"  style="padding:15px;"><input type="text" name="NOMPAG" value="<?php echo $row['NOMPAG']; ?>" maxlength="100" class="formulari" style="width:300px;"></b>
					</td>
				</tr>
				<tr>
					<td class="text10" style="padding:15px;padding-top:0px;"><img src="../comu/kl_blau.gif" width="12" height="10" border="0" align="absmiddle"><b><?php echo t("description"); ?></b>
					<br />(Molla de pa)
					</td>
					<td width="70%" style="padding:15px;padding-top:0px;"><input type="text" name="DESCRIPCIO" value="<?php echo filtreQuote($row['DESCRIPCIO']); ?>" maxlength="100" class="formulari" style="width:300px;"></td>
				</tr>
			</table>
		</td>

		<td align="right" width="30%" valign="top">
			<table cellpadding="0"  cellspacing="0" border="0" width="98%" style="border:solid #BBCEE3 1px;">
 				<tr>
					<td class="text10" style="padding:4px;"  colspan="2">
					<img src="../comu/kl_blau.gif" width="12" height="10" border="0" align="absmiddle"><b><?php echo t("template") ?></b><br>
					</td>
				</tr>

 				<tr>
					<td class="text10" style="padding:5px;padding-left:15px;" colspan="2">
                    <?php echo $row['DESC_PLANTILLA']; ?>
					</td>
				</tr>
				<tr>
					<td class="text10" style="padding:10px;">
					<a href="../plantilles/veure.php?plantilla=<?php echo $row['PLANTILLAID']; ?>" target="_blank" class="vermell9" style="color:#FF6600" title="<?php echo t("view")." ".t("template"); ?>"><img src="../comu/ico_plantilla_veure2.gif" alt="<?php echo t("view")." ".t("template"); ?>" width="29" height="23" border="0" align="absmiddle" style="margin-right:10px;"><?php echo t("view"); ?></a>
					</td>
					<td class="text10" style="padding:10px;">
					<a href="canvia_plantilla.php?ID=<?php echo $row['ID']; ?>&carpeta=<?php echo $row['PARE']; ?>"  class="vermell9" style="color:#FF6600" title="<?php echo t("change")." ".t("template"); ?>"><img src="../comu/ico_canviar.gif" alt="<?php echo t("change")." ".t("template"); ?>" width="32" height="20" border="0" align="absmiddle" style="margin-right:4px;margin-left:4px;"><?php echo t("change"); ?></a>
					</td>
				</tr>
			</table>
		</td>

	</tr>
</table>
<!-- /Primer bloc -->

<div align="right" style="padding-right:2px;padding-top:5px;"><a href="../mapaweb.php" onclick="obrir('../mapaweb.php',650,400); return false;" class="text9"><?php echo t("viewmapweb"); ?></a> <a href="javascript:obrir('../mapaweb.php',650,400)"><img src="../comu/ico_mapaweb.gif" alt="<?php echo t("viewmapweb"); ?>" width="36" height="18" border="0" align="absmiddle"></a></div>
<br>
<table cellpadding="2" cellspacing="2" border="0" width="98%">

<?php

		for($i=1;$i<=45;$i++){

			$camp="TEXTC".$i;

			if ($iniciatextcurts<=$quantstextcurts){ echo ("<tr><td class=\"text10\" width=\"20%\" valign=\"top\"><img src=\"../comu/kl_blau.gif\" width=\"12\" height=\"10\" border=\"0\" align=\"absmiddle\">".$row2[$camp].":</td><td width=\"80%\" valign=\"top\"><input type=\"text\" name=\"TEXTC$i\" value=\"".stripslashes(filtreQuote($row[$camp]))."\" maxlength=\"255\" class=\"formulari\" style=\"width:100%\"></td></tr>");$iniciatextcurts++;}
		}




		//textllarg
		for($i=1;$i<=10;$i++){

			$camp="TEXTL".$i;
			if ($iniciatextllargs<=$quantstextllargs){ echo ("
			<tr><td class=\"text10\" width=\"20%\" valign=\"top\">
			<img src=\"../comu/kl_blau.gif\" width=\"12\" height=\"10\" border=\"0\" align=\"absmiddle\">$row2[$camp]:</td><td width=\"80%\" valign=\"top\">");


echo editor_entry($camp, $row[$camp],'Antaviana');


            echo "</td></tr>";

			$iniciatextllargs++;
			}
		}


		for($i=1;$i<=5;$i++){

			$camp="OP".$i;

			if ($iniciaop<=$quantsop){
				$selected = '';
				if ($row[$camp] == 1) {
					$selected = ' selected="selected"';
				}
				echo ("<tr><td class=\"text10\" width=\"20%\" valign=\"top\"><img src=\"../comu/kl_blau.gif\" width=\"12\" height=\"10\" border=\"0\" align=\"absmiddle\">".$row2[$camp].":</td>
<td width=\"80%\" valign=\"top\">
<select name=\"OP$i\">
<option value=\"0\">No</option>
<option value=\"1\"".$selected.">Sí</option>
</select>

</td></tr>");$iniciaop++;}
		}



		if ($quantesimatges > 0){
			echo ("</table><br><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"98%\" style=\"padding:10px;border:solid #CCCCCC 1px;\">	");
			//alts imatges
			echo ("<tr><td class=\"text10\" colspan=\"2\" ><b>".t("alts").":</b></td></tr>\n");
			echo ("<tr><td style=\"padding-top:0px;\"><table cellpadding=\"2\" cellspacing=\"2\" border=\"0\">");
			for($i=1;$i<=20;$i++){
				$camp="ALT".$i;
				if ($iniciaalts<=$quantsalts){ echo ("<tr><td class=\"text10\" width=\"20%\" valign=\"top\"><img src=\"../comu/kl_blau.gif\" width=\"12\" height=\"10\" border=\"0\" align=\"absmiddle\">$row2[$camp]:</td><td width=\"80%\" valign=\"top\"><input type=\"text\" name=\"ALT$i\" value=\"".filtreQuote($row[$camp])."\" maxlength=\"255\" class=\"formulari\"></td></tr>");$iniciaalts++;}
			}

		echo ("</table>");
		}

		echo ("</td></tr></table>");










?>
<!-- /PART CENTRAL DADES-->


<br>

<!-- TAULA IMATGES + ARXIUS -->
<table cellpadding="0" cellspacing="0" border="0" width="98%">
	<tr>
		<td colspan="2" style="padding-top:15px;padding-bottom:15px;border-bottom:solid #CCCCCC 1px;">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr>
					<!-- taula imatge -->
					<?php
					if ($quantesimatges > 0){
    				echo ("
					<td width=\"50%\" style=\"padding-right:25px;\">
						<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"350\" style=\"border:solid #F66114 1px;\">
							<tr>
								<td width=\"34\" rowspan=\"2\" style=\"padding-top:5px;padding-left:5px;padding-bottom:5px;\" valign=\"top\"><img src=\"../comu/icon_attach_imatges.gif\" alt=\"Imatges\" width=\"34\" height=\"19\" border=\"0\"></td>
								<td class=\"text10\"  style=\"padding-top:5px;padding-bottom:5px;border-bottom:solid #CCCCCC 1px;\" valign=\"top\"><font class=\"blau10b\">".t("staticpagesimages")."</font> ( $iniciaimatges de $quantesimatges )</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td class=\"blau10\"  colspan=\"2\" style=\"padding-top:5px;padding-bottom:5px;\">
									&#149;&nbsp;<a href=\"javascript:obrir('uploadmultiimatges.php?ID=$row[ID]&carpeta=".$carpeta."&imatges=$quantesimatges&PLANTILLAID=$row[PLANTILLAID]',500,350)\" class=\"text10\">".t("create")."/".t("modify")."</a>&nbsp;
					");
					if ($iniciaimatges > 0) echo("&nbsp;&#149;&nbsp;<a href=\"javascript:obrir('imatges.php?ID=$row[ID]&carpeta=$carpeta',500,350)\" class=\"text10\">".t("view")."</a>&nbsp;&nbsp;&nbsp;&#149;&nbsp;<a href=\"javascript:obrir('imatges.php?ID=$row[ID]&carpeta=$carpeta&eliminar=1',500,350)\" class=\"text10\">".t("delete")."</a>");

					echo ("
								</td>

							</tr>
						</table>
					</td>
					");
					}
					?>
					<!-- /taula imatge -->

					<!-- taula adjunt -->
					<?php
					if ($quantsadjunts > 0){
    				echo ("
					<td width=\"50%\">
						<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"350\" style=\"border:solid #F66114 1px;\">
							<tr>
								<td width=\"34\" rowspan=\"2\" style=\"padding-top:5px;padding-left:5px;padding-bottom:5px;\" valign=\"top\"><img src=\"../comu/icon_attach_files.gif\" alt=\"Adjunts\" width=\"34\" height=\"19\" border=\"0\"></td>
								<td class=\"text10\"   style=\"padding-top:5px;padding-bottom:5px;border-bottom:solid #CCCCCC 1px;\" valign=\"top\"><font class=\"blau10b\">".t("staticpagesfiles")."</font> ( $iniciaadjunts de $quantsadjunts )</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan=\"2\" class=\"blau10\" style=\"padding-top:5px;padding-bottom:5px;\">
									&#149;&nbsp;<a href=\"javascript:obrir('uploadmultiarxius.php?ID=$row[ID]&arxius=$quantsadjunts&PLANTILLAID=$row[PLANTILLAID]',500,350)\" class=\"text10\">".t("create")."/".t("modify")."</a>&nbsp;
					");
					if ($iniciaadjunts > 0) echo("&nbsp;&#149;&nbsp;<a href=\"javascript:obrir('adjunts.php?ID=$row[ID]&carpeta=$carpeta',500,350)\" class=\"text10\">".t("view")."</a>&nbsp;&nbsp;&nbsp;&#149;&nbsp;<a href=\"javascript:obrir('adjunts.php?ID=$row[ID]&carpeta=$carpeta&eliminar=1',500,350)\" class=\"text10\">".t("delete")."</a>");

					echo ("
								</td>

							</tr>
						</table>
					</td>
					");
					}
					?>
					<!-- /taula adjunts -->

				</tr>
			</table>
		</td>
	</tr>
	<!--
	<tr>
		<td colspan="2" style="border-bottom:solid #CCCCCC 1px;padding-bottom:10px;padding-top:3px;"><a href="javascript:refrescar()" class="text9">Actualitza la pàgina per veure les modificacions fetes a imatges o arxius</a></td>
	</tr>
	 -->
</table>
<br>
<!-- /TAULA IMATGES + ARXIUS -->

<?php
if (accessGroupPerm('avanced_options')) {
?>
<!-- ultim bloc OPCIONS AVANÇADES -->
<div id="opcionsavanboto" style="background-color:#ECECEC;margin-right:15px;padding-left:10px;">
<br />
<table cellpadding="0"  cellspacing="0" border="0" style="background-color:#FFFFFF;padding:5px;border:solid #676766 1px;border-bottom:solid #676766 2px;">
	<tr>
		<td width="31"><a href="#opcions" onclick="javascript:mostraropcionsavan();" width="31"><img src="../comu/ico_opcionsavansades.png" width="31" height="19" alt="<?php echo t("view")." ".t("optionsadvanced");?>" border="0" ></a></td>
		<td style="padding-left:5px;"><a href="#opcions" onclick="javascript:mostraropcionsavan();" class="text" title="<?php echo t("view")." ".t("optionsadvanced");?>"><strong><?php echo t("optionsadvanced");?> &raquo;</strong></a></td>
	</tr>
</table>
<br />
</div>
<div id="opcionsavan" style="display: none;" >
<div  style="background-color:#ECECEC;margin-right:15px;padding-left:10px;">


<br>
<!-- METAS bloc -->
<table cellpadding="0"  cellspacing="0" border="0" width="98%" style="border:solid  #CCCCCC 1px;">

	<tr>
		<td class="text10" style="padding:5px;" colspan="2"><img src="../comu/ico_fletxa_opcions.gif" width="12" height="10" border="0" align="absmiddle"><b>Metas</b></td>

	</tr>

	<tr>
		<td class="text10" style="padding-left:5px;padding-bottom:5px;"><?php echo t("title"); ?></td>
		<td width="80%"  style="padding-left:5px;padding-bottom:5px;"><input type="text" name="METATITOL" value="<?php echo filtreQuote($row['METATITOL']); ?>" maxlength="500" class="formulari" style="width:450px;"></b></td>
	</tr>
	<tr>
		<td class="text10" style="padding-left:5px;padding-bottom:5px;"><?php echo t("description"); ?></td>
		<td width="80%"  style="padding-left:5px;padding-bottom:5px;"><input type="text" name="METADESCRIPCIO" value="<?php echo filtreQuote($row['METADESCRIPCIO']); ?>" maxlength="500" class="formulari" style="width:450px;"></b></td>
	</tr>
	<tr>
		<td class="text10" style="padding-left:5px;padding-bottom:5px;"><?php echo t("keywords"); ?></td>
		<td width="80%" style="padding-left:5px;padding-bottom:5px;"><input type="text" name="METAKEYS" value="<?php echo filtreQuote($row['METAKEYS']); ?>" maxlength="500" class="formulari" style="width:450px;"></td>
	</tr>
</table>
<!-- /METAS bloc -->
<br>
<table cellpadding="0" cellspacing="0" border="0" width="98%" style="margin-top:10px;border:solid #CCCCCC 1px;padding:5px;">
<?php
if (file_exists($CONFIG_PATHADMIN.'/moduls/menus')) {
  require_once($CONFIG_PATHADMIN.'/moduls/menus/funcions.inc');
?>
	<tr>
		<td class="text10" style="padding-bottom:5px;"><img src="../comu/ico_fletxa_opcions.gif" width="12" height="10" border="0" align="absmiddle"><b><?php echo t("staticpagesselectoptions"); ?></b></td>

	</tr>
	<tr>
		<td class="text10">
		<?php echo t("left"); ?>:
		<select class="formulari" name="MENU1" style="width:150px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
echo menu_list($row['MENU1'], 0, $carpeta, $row['IDIOMA']);
			?>
		</select>
		&nbsp;&nbsp;&nbsp;
		<?php echo t("right"); ?>:
		<select class="formulari" name="MENU2" style="width:150px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
echo menu_list($row['MENU2'], 0, $carpeta, $row['IDIOMA']);
			?>
		</select>
		&nbsp;&nbsp;&nbsp;
		<?php echo t("up"); ?>:
		<select class="formulari" name="MENU3" style="width:150px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
echo menu_list($row['MENU3'], 1, $carpeta, $row['IDIOMA']);
			?>
		</select>


		</td>
	</tr>
<?php
}
if (file_exists($CONFIG_PATHADMIN.'/moduls/composicions')) {
?>
	<tr>
		<td class="text10" style="padding-top:8px;padding-bottom:5px;"><img src="../comu/ico_fletxa_opcions.gif" width="12" height="10" border="0" align="absmiddle"><b><?php echo t("staticpagesselectoptionsbanner"); ?></b></td>

	</tr>

	<tr>
		<td class="text10">
		<?php echo t("left"); ?>:
		<select class="formulari" name="BANNER1" style="width:150px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
option_dinamic($row['BANNER1']);
			?>
		</select>
		&nbsp;&nbsp;&nbsp;
		<?php echo t("right"); ?>:
		<select class="formulari" name="BANNER2" style="width:150px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
option_dinamic($row['BANNER2']);
			?>
		</select>
		&nbsp;&nbsp;&nbsp;
		<?php echo t("up"); ?>:
		<select class="formulari" name="BANNER3" style="width:150px;">
			<option value=""><?php echo t("none"); ?></option>
			<?php
option_dinamic($row['BANNER3']);
			?>
		</select>
		</td>
	</tr>
<?php
}
?>


</table>
<br>
<table cellpadding="0"  cellspacing="0" border="0" width="98%" style="border:solid  #CCCCCC 1px;">

	<tr>
		<td class="text10" style="padding:5px;" colspan="2">
<?php
if ($row['REFERENCIA'] != 0) {
	echo '<a href="copiaridioma.php?ID='.$row['ID'].'&amp;carpeta='.$carpeta.'">'.t('staticpagesareacontrolduplicatelang').'</a>';
}
?>
		</td>
	</tr>

</table>

<br />
<!-- <a href="#opcions" onclick="javascript:amagaropcionsavan();">Amagar opcions avançades</a>  -->
</div>
</div>
<?php
}
?>
<br />

<?php
		echo ("<input type=\"hidden\" name=\"PLANTILLAID\" value=\"$row[PLANTILLAID]\">");
		echo ("<input type=\"hidden\" name=\"NOMPAGVELL\" value=\"$row[NOMPAG]\">");
		echo ("<input type=\"hidden\" name=\"ACTION\" value=\"UPDATE\">");
		echo ("<input type=\"hidden\" name=\"USUARIMODI\" value=\"".accessGetLogin()."\">");
		echo ("<input type=\"hidden\" name=\"PARE\" value=\"$carpeta\">");
		echo ("<input type=\"hidden\" name=\"ID\" value=\"$row[ID]\">");
		echo ("<input type=\"hidden\" name=\"accio\" value=\"$accio\">");
		echo ("<center><br><input type=\"submit\" name=\"Submit2\" value=\"".t("update")." ".t("page")."\"></center>");


?>
					<br><br>








</div>
<div id="preview-tab">
<iframe id="preview" name="preview" style="border: 1px solid #000; width: 100%; height: 300px"></iframe>
</div>





<!-- taula info -->
<table cellpadding="0" cellspacing="0" border="0" width="98%" style="border-top:solid #000000 2px;">
	<tr>
		<td   class="text9" width="80%" style="border-top:solid #CCCCCC 1px;padding-bottom:5px;padding-top:5px;padding-left:5px;;">

			<?php
				echo t("staticpagescreate")."&nbsp;";
				$row['USUARICREAR']= ucfirst ($row['USUARICREAR']);
				$data=explode(" ",$row['CREATION']);
				$data=explode("-",$data[0]);
				echo($data['2']."-".$data['1']."-".$data['0']." ".t("for")." ".$row['USUARICREAR']."");
				if ($row['MODIFICAT'] != '0000-00-00 00:00:00'){
				 $data=explode(" ",$row['MODIFICAT']);
				 $data=explode("-",$data['0']);
				 echo ("&nbsp;".t("staticpagemodify")." ".$data['2']."-".$data['1']."-".$data['0']." ".t("for")."  ".$row['USUARIMODI']."");
				}
			?>
		</td>

	</tr>
</table>
<!-- /taula info -->

					</td>


				</tr>
			</table>



		</td>

	</tr>
</table>

<?php
	db_free_result($result);
	db_free_result($result2);
    echo htmlFoot();
?>


</form>
</div>



<?php
if ($quantstextllargs == 0) {
?>
<script type="text/javascript">
OnComplete();
</script>
<?php
}
?>

</body>
</html>
