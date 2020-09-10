<?php
require ('../config_admin.inc');
accessGroupPermCheck('page_publish');

include_once("estatiques.php");

//COMPROVEM SI TE ACCES A AQUEST MODUL
include("check_moduls.php");
//FI COMPROVEM SI TE ACCES A AQUEST MODUL
include_once('variables.inc');

?>
<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="carregat();">

<?php echo htmlHeader(); ?>
<div id="carregant" style="width: 780px; height: 100%; text-align: center;"><br><br><?php echo t("generating"); ?></div>
<div id="contingut" style="width: 780px;display: none">
<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;margin-bottom:0px">

	<!-- situacio Sou a -->
	<tr>
		<td colspan="2" class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("staticpagestitle"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">

		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td class="text"  style="padding:20px;" valign="top" width="70%">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
			<tr>
				<td bgcolor="#0E449A" class="blanc11b" style="padding:5px;height:30px;">
				<?php
				if (isset($_POST['accio']) && $_POST['accio']=='publish'){
				  echo t("staticpagesareacontrolgenerate");
				}elseif (isset($_POST['accio']) && $_POST['accio']=='unpublish'){
				  echo t("staticpagesareacontrolungenerate");
				}

				?>
				</td>
			</tr>
		</table>

<?php

/*
$result=db_query('select
ID, ECLASS, SKIN, CATEGORY1, CATEGORY2, STATUS, VISIBILITY, CREATION, START_TIME, END_TIME, MODIFICAT,
USUARICREAR, USUARIMODI, NOMPAG, DESCRIPCIO,IDIOMA,REFERENCIA,METATITOL, METADESCRIPCIO, METAKEYS,
PARE, PLANTILLAID, MENU1, MENU2, MENU3, BANNER1, BANNER2, BANNER3, TEXTC1, TEXTC2, TEXTC3, TEXTC4, TEXTC5, TEXTC6,
TEXTC7, TEXTC8, TEXTC9, TEXTC10, TEXTC11, TEXTC12, TEXTC13, TEXTC14, TEXTC15, TEXTC16, TEXTC17, TEXTC18, TEXTC19,
TEXTC20, TEXTC21, TEXTC22, TEXTC23, TEXTC24, TEXTC25, TEXTC26, TEXTC27, TEXTC28, TEXTC29, TEXTC30, TEXTC31, TEXTC32,
TEXTC33, TEXTC34, TEXTC35, TEXTC36, TEXTC37, TEXTC38, TEXTC39, TEXTC40, TEXTC41, TEXTC42, TEXTC43, TEXTC44, TEXTC45,
IMATGE1, IMATGE2, IMATGE3, IMATGE4, IMATGE5, IMATGE6, IMATGE7, IMATGE8, IMATGE9, IMATGE10, IMATGE11, IMATGE12,
IMATGE13, IMATGE14, IMATGE15, IMATGE16, IMATGE17, IMATGE18, IMATGE19, IMATGE20, IMATGE21, IMATGE22, IMATGE23,
IMATGE24, IMATGE25, ADJUNT1, ADJUNT2, ADJUNT3, ADJUNT4, ADJUNT5, ADJUNT6, ADJUNT7, ADJUNT8, ADJUNT9, ADJUNT10,
ALT1, ALT2, ALT3, ALT4, ALT5, ALT6, ALT7, ALT8, ALT9, ALT10, CERCADOR
from ESTATICA where ID=\''.$_POST['id_idioma'].'\' OR REFERENCIA=\''.$_POST['id_idioma'].'\'');
*/
if (count($_POST['entrys']) > 0) {
  $pages = array();
  foreach($_POST['entrys'] as $value) {
    $pages[] = 'ID = '.$value;
  }
  $pages = implode(' OR ', $pages);
  $result=db_query('select
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
 from ESTATICA where PARE=\''.$carpeta.'\' and  ('.$pages.')');
}



$menuopcionsedita = '';
$missatge = '';
while($row = db_fetch_array($result)) {

  /*menu*/
  $codiidioma=$row['IDIOMA'];
  for($i=0;$i<count($CONFIG_idiomes[$CONFIG_IDIOMA]);$i++){
    $trozos = explode ("_", $CONFIG_idiomes[$CONFIG_IDIOMA][$i]);
    if($codiidioma==$trozos['2']) {
      $nomidioma=$trozos['1'];
    }
  }
  $iconaeditar = '';
  if (accessGroupPerm('page_edit')) {
    $pagina = folderPath($row['PARE']).'/'.$row['NOMPAG'];
    $iconaeditar = "
<a href=\"edita.php?ID=".$row['ID']."&carpeta=".$row['PARE']."\">
<img src=\"../comu/icon_modifica.gif\" alt=\"Editar\" width=\"23\" height=\"16\" border=\"0\" align=\"absmiddle\"></a>
";
  }
  $menuopcionsedita .="
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"margin-bottom:5px;\">
<tr>
<td width=\"60%\" class=\"text9\">
<img src=\"../comu/paisos/".$codiidioma.".gif\" width=\"18\" height=\"14\" border=\"0\" alt=\"".$nomidioma."\" align=\"absmiddle\">&nbsp;
".$nomidioma."
</td>
<td>
".$iconaeditar."
<a href=\"veure.php?pagina=".$pagina."\" target=\"_blank\">
<img src=\"../comu/icon_veure.gif\" alt=\"Veure la pàgina generada actual\" width=\"19\" height=\"16\" border=\"0\" align=\"absmiddle\"></a>
</td>
</tr>
</table>";

  // mirem si esta seleccionat l'idioma
//  if (!isset($_POST[$codiidioma]) || $_POST[$codiidioma]!='1')
//  {
//    continue;
//  }

  if(isset($_POST['accio']) && $_POST['accio']=='unpublish'){/*accio seleccionada -> despublicar*/

    $resultat = delete_page($row['NOMPAG'], $row['PARE']);
    if ($resultat) {
      $missatge .='
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td style="padding-top:6px;padding-bottom:6px;border-bottom:solid #CCCCCC 1px;font-weight:bold;" width="35%">
      <img src="../comu/paisos/'.$codiidioma.'.gif" border="0" alt="'.$nomidioma.'" align="absmiddle">
      &nbsp;'.$nomidioma.'
    </td>
    <td style="color:#CC0000;padding-top:6px;padding-bottom:6px;border-bottom:solid #CCCCCC 1px;">
      <img src="../comu/ico_simbol_ok.gif" align="absmiddle">
      '.t("staticpagesareacontrolungeneratepage").'
    </td>
  </tr>
</table>';
      db_query("UPDATE ESTATICA SET STATUS='0' where ID=".$row['ID']);
      /*insertar registre d'accions*/
      register_add(t("staticpagesareacontrolungeneratepage"), $row['PARE']);
    }
    else{
      $missatge .='
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td style="padding-top:6px;padding-bottom:6px;border-bottom:solid #CCCCCC 1px;font-weight:bold;" width="35%">
      <img src="../comu/paisos/'.$codiidioma.'.gif" border="0" alt="'.$nomidioma.'" align="absmiddle">
      &nbsp;'.$nomidioma.'
    </td>
    <td style="color:#CC0000;padding-top:6px;padding-bottom:6px;border-bottom:solid #CCCCCC 1px;">
      <img src="../comu/ico_creueta.gif" align="absmiddle">
      '.t("staticpagesareacontrolungeneratepage").'
    </td>
  </tr>
</table>';

    }

    delete_page($row['NOMPAG'], $row['PARE'], true);



  }
  elseif(isset($_POST['accio']) && $_POST['accio']=='publish'){/*accio seleccionada -> publicar*/



    for ($i = 1; $i <=$PAGE_max_textl; $i++) {
      $row['TEXTL'.$i] = db_select_text('ESTATICA', 'TEXTL'.$i, 'ID = '.$row['ID']);
    }

    $valors = generate_page ($row);
    if (!is_array($valors)) {
      $missatge .= '
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td style="padding-top:6px;padding-bottom:6px;border-bottom:solid #CCCCCC 1px;font-weight:bold;" width="35%">
      <img src="../comu/paisos/'.$codiidioma.'.gif" border="0" alt="'.$nomidioma.'" align="absmiddle">
      &nbsp;'.$nomidioma.'
    </td>
    <td style="color:#CC0000;padding-top:6px;padding-bottom:6px;border-bottom:solid #CCCCCC 1px;">
      <img src="../comu/ico_creueta.gif" align="absmiddle">
      '.$valors.'
    </td>
  </tr>
</table>';

    }
    else {

      $resultat = create_page($row['NOMPAG'], $row['PARE'], $valors['normal']);

      if(!empty($resultat)) {
        $missatge .= '
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td style="padding-top:6px;padding-bottom:6px;border-bottom:solid #CCCCCC 1px;font-weight:bold;" width="35%">
      <img src="../comu/paisos/'.$codiidioma.'.gif" border="0" alt="'.$nomidioma.'" align="absmiddle">
      &nbsp;'.$nomidioma.'
    </td>
    <td style="color:#CC0000;padding-top:6px;padding-bottom:6px;border-bottom:solid #CCCCCC 1px;">
      <img src="../comu/ico_creueta.gif" align="absmiddle">
      '.$resultat.'
    </td>
  </tr>
</table>';

      }
      else {
        $pagina = folderPath($row['PARE']).'/'.$row['NOMPAG'];
        $missatge .= '
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td style="padding-top:6px;padding-bottom:6px;border-bottom:solid #CCCCCC 1px;font-weight:bold;" width="35%">
      <img src="../comu/paisos/'.$codiidioma.'.gif" border="0" alt="'.$nomidioma.'" align="absmiddle">
      &nbsp;'.$nomidioma.'
    </td>
    <td style="color:#CC0000;padding-top:6px;padding-bottom:6px;border-bottom:solid #CCCCCC 1px;">
      <img src="../comu/ico_simbol_ok.gif" align="absmiddle">
      '.t("staticpagescreateok").'
    </td>
  </tr>
</table>';

        db_query("UPDATE ESTATICA SET STATUS='1' where ID=".$row['ID']);
        /*insertar registre d'accions*/
        register_add(t("staticpagesregistrygenerate"), $row['PARE']);
      }
    }
  }
  else {
    $missatge .='
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td style="padding-top:6px;padding-bottom:6px;border-bottom:solid #CCCCCC 1px;font-weight:bold;" width="35%">
      <img src="../comu/paisos/'.$codiidioma.'.gif" border="0" alt="'.$nomidioma.'" align="absmiddle">
      &nbsp;'.$nomidioma.'
    </td>
    <td style="color:#CC0000;padding-top:6px;padding-bottom:6px;border-bottom:solid #CCCCCC 1px;">
      '.t("staticpagesareacontrolnothing").'
    </td>
  </tr>
</table>';

  }

}


echo $missatge;

db_free_result($result);



?>
</td>
<td style="padding:20px;" valign="top" >
<?php
echo ("<a href=\"index.php?carpeta=".$_POST['carpeta']."\" class=\"botonavegacio\" style=\"width: 150px;text-align:center\">".t("backtolist")."</a>");
?>
<div style="margin-bottom:10px;"><br /></div>
<?php
echo ("<a href=\"javascript:history.back();\" class=\"botonavegacio\" style=\"width: 150px;text-align:center\">".t("staticpagesareacontrolback")."</a>");
?>
<br /><br />
<fieldset style="width: 150px;padding:10px;">
<legend align="left" class="blau11b">&nbsp;<?php echo t("options"); ?>&nbsp;</legend>
<br />
<?php
echo $menuopcionsedita;
?>
<br />
</fieldset>
</td>
</tr>
</table>
</div>
<?php echo htmlFoot(); ?>
</body>
</html>
