<?php

require ('../../config_admin.inc');
accessGroupPermCheck('poll');

require('enquesta.php');

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
		<td colspan="2" class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="../../../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("utils"); ?></b></td>
	</tr>
	<tr>
		<td colspan="2" style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td width="50%" class="text10"><img src="../../comu/icon_plana.gif" width="33" height="18" alt="Sou a" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../index.php"><?php echo t("home"); ?></a>
                    <img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0">
                    <a href="../../utilitats/index.php"><?php echo t("utils"); ?></a>
                    <img src="../../comu/kland_etsa.gif" width="19" height="5"  border="0">
                    <font class="blau10b">Generar enquestes</font>
                    </td>

				</tr>

			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->

	<tr>
		<td class="text" colspan="2" style="padding:20px;">

<?php


$result = db_query('SELECT * FROM ENQUESTA');


while ($row = db_fetch_array($result)) {


  $plantillafile = $CONFIG_PATHTEMPLATEPOLL.'/'.$row['PLANTILLA'];

  $file = $CONFIG_PATHPOLL.'/'.$row['NOM'].'.inc';
  $targeturl = urlDir($CONFIG_URLPOLL).'/'.$row['NOM'].'.inc';
  if (file_exists($plantillafile)) {

     $fitxer = fopen($plantillafile, 'r');
     $content = fread($fitxer,filesize($plantillafile));
     fclose($fitxer);
     $content = str_replace(array('|CONFIG_PATHBASE|','|ENQUESTA|', '|CONFIG_URLVOTA|'),array($CONFIG_PATHBASE,$row['ID'], $CONFIG_URLVOTA), $content);
     $fitxer = fopen($file, 'w+');
     fwrite($fitxer, $content);
     fclose($fitxer);
     if (!empty($CONFIG_PERMFILES)) {
       chmod($file, $CONFIG_PERMFILES);
     }

	echo '
<img src="../../comu/miniico_nova.gif" alt="Ok" border="0" align="left" ><font class="blau11b">Enquesta creada</font> |<a href="veure.php?poll='.$row['NOM'].'" target="_blank" class="text">'.$row['NOM'].'</a><br><br>
	';

  }
}


db_free_result($result);

?>

<b><a href="../../utilitats/index.php" class="botonavegacio"><?php echo t("continue") ?></a></b>
</tr>
</table>
</div>
<?php echo htmlFoot(); ?>
</body>
</html>
