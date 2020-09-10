<?php

require ('../../config_admin.inc');
accessGroupPermCheck('rss');

require('rss.php');

?>
<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;padding:20px;">
	<tr>
		<td class="text" align="center">

<?php


$result = db_query('SELECT * FROM VIEWRSS WHERE ID=\''.$ID.'\'');
$row = db_fetch_array($result);

  $plantillafile = $CONFIG_PATHTEMPLATERSS.'/'.$row['PLANTILLA'];

  $rssfile = $CONFIG_PATHRSS.'/'.$row['NOM'].'.inc';
  $targeturl = urlDir($CONFIG_URLRSS).'/'.$row['NOM'].'.inc';
  if (file_exists($plantillafile)) {

     $fitxer = fopen($plantillafile, 'r');
     $content = fread($fitxer,filesize($plantillafile));
     fclose($fitxer);
     $content = str_replace(array('|CONFIG_PATHBASE|','|LINKRSS|','|MAXRSS|'),array($CONFIG_PATHBASE,$row['LINKRSS'],$row['MAXRSS']), $content);
     $fitxer = fopen($rssfile, 'w+');
     fwrite($fitxer, $content);
     fclose($fitxer);
     if (!empty($CONFIG_PERMFILES)) {
       chmod($rssfile, $CONFIG_PERMFILES);
     }

     echo '<b>Visualitzador creat</b><br><a href="veure.php?rss='.$row['NOM'].'" target="_blank" class="text">'.$targeturl.'</a><br><br>';
  }





echo ("<b><a href=\"index.php\" class=\"vinclenoticia\">".t("continue")."</a></b>");

 //insertar registre d'accions
 register_add("Visualitzador rss generat", $row['NOM'].' ('.$row['DESCRIPCIO'].')');
 //fi


?>
</tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
