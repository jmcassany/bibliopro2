<?php
   include("config.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title><?php echo t("website"); ?></title>
	<link rel="STYLESHEET" type="text/css" href="../../../../../public/media/css/estils.css">
	<meta http-equiv="refresh" content="2;url=view.php?ID=<?php echo $ID ?>">
</head>

<body>

<table align="center" cellpadding="0" cellspacing="0" style="border:solid #0A2082 1px;padding-left:20px;padding-right:20px;padding-bottom:5px;" width="50%">
	<tr>
		<td class="text" align="left" width="80%">
			<b>
			<?php
				if ($categoria == 0){
					$TIPOARXIU = t("imatge");
				}
				if ($categoria == 1){
					$TIPOARXIU = t("adjunt");
				}
				
			 ?>
			 </b>
			 <br>
		</td>
		
	</tr>
	<tr>
		<td colspan="2" class="text">

<?php 
   //$text = htmlspecialchars(stripslashes($text));
   $file=$_GET['file'];
   $data="";
   $sql = "UPDATE NOTICIES_NEWSLETTER SET $camptaula='$data' where ID='$ID'";
   $result = mysql_query($sql);
   
   if($result) {
   				//agafo l'imatge
   				$targetfilename = $CONFIG_PATHUPLOADIM."$file";
				$targetfilename2 = $CONFIG_PATHUPLOADIM."p$file";
				
				
				
				//agafo l'arxiu
				if ($categoria == 1)$targetfilename = $CONFIG_PATHUPLOADAD."$file";
				
				//elimino
				if (file_exists("$targetfilename")) {
					  unlink($targetfilename);
					  if(file_exists("$targetfilename2")){
					  	unlink($targetfilename2);
					  }
					  echo ("&#149;&nbsp;".$TIPOARXIU." ".t("eliminatda")."<br><br>");
					  
				}else{
					 echo ("&#149;&nbsp;".$TIPOARXIU." ".t("jahasiguteliminatda")."<br><br>");
				}
				
				mysql_close();
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
								(<a href="view.php?ID=<?php echo $ID ?>"><?php echo t("premisinovolesperar"); ?></a>)</td>
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
