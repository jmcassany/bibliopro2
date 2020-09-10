<?php
   include("config.php");
   
   $ID = $_GET['ID'];
   $IdCam = $_GET['IdCam'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title><?php echo t("website"); ?></title>
	<link rel="STYLESHEET" type="text/css" href="../../../../../public/media/css/estils.css">
	<meta http-equiv="refresh" content="2;url=edita.php?id=<?php echo $IdCam ?>">
</head>

<body>

<table align="center" cellpadding="0" cellspacing="0" style="border:solid #0A2082 1px;padding-left:20px;padding-right:20px;padding-bottom:5px;" width="50%">
	<tr>
		<td class="text" align="left" width="80%">
			<b>
			<?php $TIPOARXIU = t("imatge"); ?>
			 </b>
			 <br>
		</td>
		
	</tr>
	<tr>
		<td colspan="2" class="text">

<?php 
	$result = mysql_query("SELECT * FROM NEWSLETTERS WHERE ID='$ID'");
	$row = mysql_fetch_array($result);
	
    $img = $row['IMATGE_ANUNCI'];
	$imgname = $CONFIG_PATHUPLOADANUNCI.$img;
	if ((file_exists($imgname)) AND ($img != "")) {
	  unlink($imgname);
	}

   //$text = htmlspecialchars(stripslashes($text));
   $data="";
   $sql = "UPDATE NEWSLETTERS SET IMATGE_ANUNCI='$data' where ID='$ID'";
   $result = mysql_query($sql);
   
   if($result) {
   		echo ("&#149;&nbsp;".$TIPOARXIU." ".t("eliminatda")."<br><br>");
   } else {
		echo ("<a href='javascript:history.back()'>".t("tornar")."</a>");
		echo mysql_errno().":".mysql_error()."";
   }
?> 	

			<table align='center' border="0" cellspacing="1" cellpadding="0" width="250">
			<tr>
				<td >
					<table width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr>
							<td width="100%" align="center" >
								<?php echo t("esperiredirec"); ?><br><br>
								(<a href="edita.php?id=<?php echo $IdCam ?>"><?php echo t("premisinovolesperar"); ?></a>)
							</td>
						</tr>
					</table>
				</td>
			</tr>
		    </table>
			<br>
			
		</td>
	</tr>
</table>	


</body>
</html>
