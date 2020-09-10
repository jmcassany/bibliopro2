<?php

require ('../config_admin.inc');
accessGroupPermCheck('dinamic_delete');

include_once("dinamiques.php");

//COMPROVEM SI TE ACCES A AQUEST MODUL
include("check_moduls.php");
//FI COMPROVEM SI TE ACCES A AQUEST MODUL

if (!isset($_POST['CONFIRM']) || $_POST['CONFIRM'] !='TRUE') {
  htmlPageError(t("errorstaticpagesdelconfirm"));
}

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

$missatge = '';

if (!isset($_POST['CHECK'])) {
  $missatge = t("errordeletenocheck");
}
else {

  /*per tots els elemtens a esborrar*/
  foreach($_POST['CHECK'] as $key => $value) {

	// obtenim les imatges i adjunts de l'entrada
	$info_query = db_query("SELECT * FROM $TAULA WHERE ID='$key'");
	$info_row = db_fetch_array($info_query);


	$imageSizes = $dinamiques_imageSizes;
	if (isset($tipusdinamiques[$tipuseditora]['imageSizes'])) {
		$imageSizes = $tipusdinamiques[$tipuseditora]['imageSizes'];
	}


	// esborrem les imatges de l'entrada
	for($i=1; $i <= 3; $i++) {

		if(!empty($info_row["IMATGE$i"])) {


			foreach ($imageSizes as $value) {
				$prefix = '';
				if (isset($value['prefix'])) {
					$prefix = trim($value['prefix']);
				}
				if(file_exists($CONFIG_PATHUPLOADIM.'/'.$prefix.$info_row['IMATGE'.$i])) {
					unlink($CONFIG_PATHUPLOADIM.'/'.$prefix.$info_row['IMATGE'.$i]);
				}
			}


		}
	}

	// esborrem els documents adjunts de l'entrada
	for($i=1; $i <= 3; $i++) {

		if(!empty($info_row["ADJUNT$i"])) if(file_exists($CONFIG_PATHUPLOADAD.'/'.$info_row["ADJUNT$i"])) unlink($CONFIG_PATHUPLOADAD.'/'.$info_row["ADJUNT$i"]);

	}



	//esborrem l'entrada
    db_query('delete from '.$TAULA.' where ID = '.$key);

    $missatge.= "&#149;&nbsp;".t("dinamicsregistrydelete").". ID: $key.<br><br>";

    /*insertar registre d'accions*/
    register_add(t("dinamicsregistrydelete"), $key);

  }
  include("createxml.inc");
  createrss($DIN);
}

echo $missatge;
?>
<b><a href="index.php?DIN=<?php echo $DIN; ?>&amp;PAGE=<?php echo $pagina ?>" class="botonavegacio"><?php echo t("continue"); ?></a></b>
</td></tr>
</table>
</body>
</html>
