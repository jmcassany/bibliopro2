<?php
	include("config.php");


	accessCheckLevel(2, $CONFIG_PRE_NOMCARPETA.'/admin/');
	function accessCheckLevel($level,$url){
		global $level_user;

		$level_user = $_SESSION['access']['level'];

		if($level_user >= $level){
			return true;
		}else{
			header("Location: $url");
			exit;
		}
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
	<title><?php echo t("website"); ?></title>
	<link rel="STYLESHEET" type="text/css" href="../../../../../public/media/css/estils.css">
</head>

<body bgcolor="#ffffff" topmargin="5" leftmargin="5" marginheight="0" marginwidth="0">
<br><br>
<table align="center" cellpadding="0" cellspacing="0" style="border:solid #008152 1px;padding:20px;" width="450">
<tr>
	<td class="text">

<?php
	// --------------------
	// PARAMETERS DEFAULT
	// --------------------

	if (empty($LANG))       { $LANG=$DEFAULT_LANG; }
	if (empty($CLASS))      { $CLASS=$DEFAULT_CLASS; }

	if (empty($CONFIRM)) { echo "<B>".t("error1").".</B><br><br><a href=\"javascript:history.back();\">".t("tornar")."</a>\n"; exit; }

	// ------------------
	// CARDS INSTANTATION
	// ------------------

	$dbCards = new dbCards($CARDS_TABLE);
	if (!$dbCards->Ok) { echo "<B>".t("error2").".</B><br><br><a href=\"javascript:history.back();\">".t("tornar")."</a>\n"; exit; }

	// ----------------
	// CARDS DELETION
	// ----------------

    if ($CONFIRM!='TRUE'){

		echo "<B>".t("activarconfirmacio")."</B><br><br><a href=\"javascript:history.back();\">".t("tornar")."</a>\n";
		exit;

	}else{

       // fem un loop per les variables POST per detectar les CHECK_?
       while ( list($key, $value)=each($_POST) )
       {
           if (strpos($key,'CHECK_')===false){
		   		// no fem res
           }else{
		   		// esborrem el thread N del forum F
                $n=substr($key,6,4);

				//busco les imatges i arxius per eliminar-los
				$result = mysql_query("SELECT * FROM NOTICIES_NEWSLETTER WHERE ID='$n'");
				$row = mysql_fetch_array($result);

				$img1 = $row['IMATGE1'];
				$imgname1 = $CONFIG_PATHUPLOADIM.$img1;
				$pimgname1 = $CONFIG_PATHUPLOADIM."p".$img1;
				//echo $imgname1."<br/>";
				if ((file_exists($imgname1)) AND ($img1 != "")) {
				  unlink($imgname1);
				  unlink($pimgname1);
				}
/*
				$img2 = $row['IMATGE2'];
				$imgname2 = $CONFIG_PATHUPLOADIM."$img2";
				$pimgname2 = $CONFIG_PATHUPLOADIM."p$img2";
				if ((file_exists($imgname2)) AND ($img2 != "")) {
				  unlink($imgname2);
				  unlink($pimgname2);
				}

				$img3 = $row['IMATGE3'];
				$imgname3 = $CONFIG_PATHUPLOADIM."$img3";
				$pimgname3 = $CONFIG_PATHUPLOADIM."p$img3";
				if ((file_exists($imgname3)) AND ($img3 != "")) {
				  unlink($imgname3);
				  unlink($pimgname3);
				}
*/
				$adjunt1 = $row['ADJUNT1'];
				$filename1 = $CONFIG_PATHUPLOADAD."$adjunt1";
				//echo $filename1."<br/>";
				if ((file_exists($filename1)) AND ($adjunt1 != "")) {
				  unlink($filename1);
				}

				$adjunt2 = $row['ADJUNT2'];
				$filename2 = $CONFIG_PATHUPLOADAD."$adjunt2";
				if ((file_exists($filename2)) AND ($adjunt2 != "")) {
				  unlink($filename2);
				}

				$adjunt3 = $row['ADJUNT3'];
				$filename3 = $CONFIG_PATHUPLOADAD."$adjunt3";
				if ((file_exists($filename3)) AND ($adjunt3 != "")) {
				  unlink($filename3);
				}

				$adjunt4 = $row['ADJUNT4'];
				$filename4 = $CONFIG_PATHUPLOADAD."$adjunt4";
				if ((file_exists($filename4)) AND ($adjunt4 != "")) {
				  unlink($filename4);
				}

				$adjunt5 = $row['ADJUNT5'];
				$filename5 = $CONFIG_PATHUPLOADAD."$adjunt5";
				if ((file_exists($filename5)) AND ($adjunt5 != "")) {
				  unlink($filename5);
				}

				mysql_close();
				//fi eliminar imatges i arxius associats

				//elimino la noticia
                $dbCards->deleteCard($n);
			    echo t("noticiaeliminada")."<br>";
           }
       } // end while

   } // end else
?>

		<b><a href="list.php" class="vinclenoticia"><?php echo t("continuar"); ?></a></b>

	</td>
</tr>
</table>

</body>
</html>
