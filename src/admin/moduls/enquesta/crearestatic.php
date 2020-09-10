<?php

require ('../../config_admin.inc');
accessGroupPermCheck('poll');

require('enquesta.php');


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

$result = db_query('SELECT * FROM ENQUESTA WHERE ID=\''.$ID.'\'');
$row = db_fetch_array($result);


  $plantillafile = $CONFIG_PATHTEMPLATEPOLL.'/'.$row['PLANTILLA'];

  $file = $CONFIG_PATHPOLL.'/'.$row['NOM'].'.inc';
  $targeturl = urlDir($CONFIG_URLPOLL).'/'.$row['NOM'].'.inc';
  if (file_exists($plantillafile)) {

     $fitxer = fopen($plantillafile, 'r');
     $content = fread($fitxer,filesize($plantillafile));
     fclose($fitxer);
     $content = str_replace(array('|CONFIG_PATHBASE|','|ENQUESTA|', '|CONFIG_URLVOTA|'),array($CONFIG_PATHBASE,$ID, $CONFIG_URLVOTA), $content);
     $fitxer = fopen($file, 'w+');
     fwrite($fitxer, $content);
     fclose($fitxer);
     if (!empty($CONFIG_PERMFILES)) {
       chmod($file, $CONFIG_PERMFILES);
     }

     echo '<b>Visualitzador creat</b><br><a href="veure.php?poll='.$row['NOM'].'" target="_blank" class="text">'.$targeturl.'</a><br><br>';
  }


echo ("<b><a href=\"index.php\" class=\"vinclenoticia\">".t("continue")."</a></b>");

 //insertar registre d'accions
 register_add("Enquesta generada", $row['NOM'].' ('.$row['DESCRIPCIO'].')');
 //fi


?>
</tr>
</table>
<?php echo htmlFoot(); ?>
</body>
</html>
