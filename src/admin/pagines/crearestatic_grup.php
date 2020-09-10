<?php

require ('../config_admin.inc');
accessGroupPermCheck('page_publish');

include_once("estatiques.php");

/*limitar creació nomes a la carpeta*/
$limit_path = '';
if (isset($_GET['carpeta'])) {
  $carpeta = $_GET['carpeta'];
}
else if (isset($_POST['carpeta'])) {
  $carpeta = $_POST['carpeta'];
}
if (isset($carpeta)) {
  include("check_moduls.php");
  $limit_path = 'PARE = \''.$carpeta.'\' AND';
}

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
		<td colspan="2" class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("utils"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td width="50%" class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="Sou a" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../index.php"><?php echo t("home"); ?></a>
                    <img src="../comu/kland_etsa.gif" width="19" height="5"  border="0">
                    <a href="../utilitats/index.php"><?php echo t("utils"); ?></a>
                    <img src="../comu/kland_etsa.gif" width="19" height="5"  border="0">
                    <font class="blau10b">
<?php
if (isset($_GET['carpeta'])) {
  echo t("generatepagesfolders").' '.$_GET['carpeta'];
}
else {
  echo t("generateallpages");
}
?>
                    </font>
                    </td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td class="text" colspan="2" style="padding:20px;">

<?php

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
   from ESTATICA where ".$limit_path." STATUS = 1");


while($row = db_fetch_array($result)) {

  for ($i = 1; $i <=$PAGE_max_textl; $i++) {
    $row['TEXTL'.$i] = db_select_text('ESTATICA', 'TEXTL'.$i, 'ID = '.$row['ID']);
  }
  $plantilla = '';
  if (isset($row['PLANTILLAID'])) {
    $plantillaq = db_query("select NOM from PLANTILLA where ID=".$row['PLANTILLAID']);
    $row2 = db_fetch_array($plantillaq);
    $plantilla = $row2['NOM'];
  }

  $valors = generate_page ($row);
  if (!is_array($valors)) {
          echo '
<img src="../comu/houdini_alerta.gif" alt="Alert" border="0" align="absmiddle">
<font class="grana">'.$valors.' '.$plantilla.'.</font>
<br><br>
';

  }
  else {

    $resultat = create_page($row['NOMPAG'], $row['PARE'], $valors['normal']);

    if(!empty($resultat)) {
          echo '
<img src="../comu/houdini_alerta.gif" alt="Alert" border="0" align="absmiddle">
<font class="grana">'.$resultat.' '.$plantilla.'.</font>
<br><br>
';

    }
    else {
      $pagina = folderPath($row['PARE']).'/'.$row['NOMPAG'];
      $ruta_final = str_replace("//", "/", $pagina);
      $ruta_final = $CONFIG_URLBASE."/".$ruta_final;
      echo '
<img src="../comu/miniico_nova.gif" alt="Ok" border="0" align="left" >
<font class="blau11b">'.t("staticpagescreateok").'</font> |
<a href="'.$ruta_final.'" target="_blank" class="text">'.$ruta_final.'</a>
<br><br>
';

      db_query("UPDATE ESTATICA SET STATUS='1' where ID=".$row['ID']);
      /*insertar registre d'accions*/
      register_add(t("staticpagesregistrygenerate"), $row['PARE']);

    }
  }


}


echo ("<br /><a href=\"../utilitats/index.php\" class=\"botonavegacio\">".t("back")." ".t("to")." ".t("utils")."</a>");

db_free_result($result);

?>
</tr>
</table>
</div>
<?php echo htmlFoot(); ?>
</body>
</html>
