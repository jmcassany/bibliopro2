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
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
				$result = mysql_query("SELECT * FROM CAPS_NEWSLETTER WHERE ID='$n'");
				$row = mysql_fetch_array($result);
				
				$img = $row['IMATGE'];
				$imgname = $CONFIG_PATHBASE."public/media/upload/caps/$img";
				//echo $imgname;
				if ((file_exists($imgname)) AND ($img != "")) {
					unlink($imgname);
				}
				
				mysql_close();
				//fi eliminar imatges i arxius associats
				
				//elimino la noticia
				$dbCards->deleteCard($n);
				echo "Capçalera eliminada<br>";
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