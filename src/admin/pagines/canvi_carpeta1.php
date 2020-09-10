<?php
require ('../config_admin.inc');
accessGroupPermCheck('page_edit');
include ("check_moduls.php");
include_once ("estatiques.php");
include_once("variables.inc");

if (isset($_POST['ID'])) {
    $ID = $_POST['ID'];
} else {
    $ID = $_GET['ID'];
}

//COMPROVEM SI TE ACCES A AQUEST MODUL
include ("check_moduls.php");

//FI COMPROVEM SI TE ACCES A AQUEST MODUL

if (isset($_POST['carpetaselect'])) {

    //if (isset($_POST['canviar'])) {
    $result = db_query("select ID, NOMPAG, PARE from ESTATICA where (ID='$ID') OR (REFERENCIA='$ID')");
    $resultUpdate = db_query("UPDATE ESTATICA SET PARE='" . $_POST['PARE'] . "',USUARIMODI='" . accessGetLogin() . "',MODIFICAT=now() where (ID='$ID') OR (REFERENCIA='$ID')");

    if ($resultUpdate) {
        $content = '';

        while ($row = db_fetch_array($result)) {
            $content.= "<br><div><b>" . $row['NOMPAG'] . "</b> - " . t("staticpagesinfochangefolderok") . "&nbsp;&nbsp;&nbsp;<a href=\"edita.php?ID=" . $row['ID'] . "&carpeta=" . $_POST['PARE'] . "\"><img src=\"../comu/icon_modifica.gif\" style=\"border:0;\" />" . t("edit") . " " . t("page") . "</a></div>";

            //canviar la pagina fisica de lloc
            $targetfilenameOrig = $CONFIG_PATHBASE . '/' . folderPath($row['PARE']) . '/' . $row['NOMPAG'];
            $targetfilenameDest = $CONFIG_PATHBASE . '/' . folderPath($_POST['PARE']) . '/' . $row['NOMPAG'];



			$valors = generate_page ($row);
			$resultat = create_page($row['NOMPAG'], $row['PARE'], $valors['normal']);
			delete_page($row['NOMPAG'], $_POST['PARE']);


//            if (file_exists("$targetfilenameOrig")) {
//                copy($targetfilenameOrig, $targetfilenameDest);
//                unlink($targetfilenameOrig);
//            }





        }
        $content.= "<br><br><div><a href=\"index.php?carpeta=" . $_POST['carpeta'] . "\" class=\"botonavegacio\">" . t("continuesamefolder") . "</a>&nbsp;&nbsp;&nbsp;<a href=\"index.php?carpeta=" . $_POST['PARE'] . "\" class=\"botonavegacio\">" . t("gonewfolder") . "</a></div><br>";
    }
	else {
		$content= "<br><div>No s'ha pogut moure la pàgina</div>";
		$content.= "<br><br><div><a href=\"index.php?carpeta=" . $_POST['carpeta'] . "\" class=\"botonavegacio\">" . t("continuesamefolder") . "</a></div><br>";
	}
}
else {
    $result1 = db_query("select NOMPAG,PARE from ESTATICA where ID = '$ID'");
    $row = db_fetch_array($result1);
    $NOMPAG = $row['NOMPAG'];
    $carpetaactual = folderPath($row['PARE']);
    db_free_result($result1);
    $content = '
<form action="' . $_SERVER['PHP_SELF'] . '" method="post" name="FORM" >
	<!-- /situacio Sou a -->
	<tr>
		<td class="text" >




<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:10px;" bgcolor="#F0F0F0">
  <tr>
		<td class="text10"  valign="top">
			<img src="../comu/icon_escull_plantilla.gif" alt="' . t("staticpagesmovepagemessage") . '" width="28" vspace="5" height="22" border="0" align="absmiddle"><b>' . t("staticpagesmovepagemessage") . '</b><br>
			<!-- PART CENTRAL DADES-->
			<select name="PARE" class="formulari" style="width:100%" >
' . staticFolderSelect($carpeta) . '
			</select>
		</td>
	</tr>
	<tr>
	<td class="text10" >
		<table cellpadding="2" cellspacing="2" border="0" bgcolor="#FFFFFF" width="100%" style="border:solid #CCCCCC 1px;margin: 10px 0px">
			<tr>
				<td class="text10">' . t("page") . ': <b>' . $NOMPAG . '</b></td>
				</tr>
				<tr>
				<td class="text10">' . t("staticpagescarpetnow") . ': <b>' . $carpetaactual . '</b> </td>
			</tr>
		</table>
	</td>
	</tr>
	<tr>
	<td colspan="2">
		<input type="hidden" name="carpeta" value="' . $carpeta . '">
		<INPUT TYPE="hidden" NAME="ID"  class="formulari" value="' . $ID . '">
		<input type="submit" name="carpetaselect" id="carpetaselect" value="' . t("continue") . '"><br><br>
		<a href="index.php?carpeta=' . $carpeta . '"></a>
	</td>
	</tr>
</table>
';
}

//capçelera de situacio
$situacio = "<a href='index.php?carpeta=" . $carpeta . "'>" . $nomcarpeta . "</a><img src=\"../comu/kland_etsa.gif\" width=\"19\" height=\"5\" border=\"0\">";

//fi capçelera de situacio

?>
<html>
<head>
<?php echo htmlMetas(); ?>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" name="FORM" >
<?php echo htmlHeader(); ?>

<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="760" style="border:solid #F66013 5px;margin:10px;padding:5px;">
	<!-- situacio Sou a -->
	<tr>
		<td class="text10" bgcolor="#FDDBCA" style="padding:6px;" colspan="2"><img src="../comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b><?php echo t("staticpagestitle"); ?></b></td>
	</tr>
	<tr>
		<td  style="padding-left:5px;padding-right:5px;padding-top:5px;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td width="80%" class="text10"><img src="../comu/icon_plana.gif" width="33" height="18" alt="<?php echo t("youarein"); ?>" border="0" align="absmiddle"><?php echo t("youarein"); ?>: <a href="../index.php"><?php echo t("home"); ?></a><img src="../comu/kland_etsa.gif" width="19" height="5"  border="0"><? echo $situacio; ?><font class="blau10b"><?php echo t("staticpagesmovepage"); ?></font></td>
					<td width="20%" class="vermell10b" align="right">
				</td>
				</tr>
			</table>
		</td>
	</tr>


	<!-- /situacio Sou a -->
	<tr>
		<td class="text" >

<?php
echo $content;
?>



		</td>

	</tr>
</table>
<?php echo htmlFoot(); ?>
</form>
</body>
</html>
