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
	

$TITOL = addslashes($TITOL);

$sql = "update BANNERS_NEWSLETTER set STATUS='$STATUS',CATEGORY1='$CATEGORY1',CATEGORY2='$CATEGORY2',TITOL='$TITOL',LINK='$LINK',USUARI_HOUDINI='$USUARI_HOUDINI' where ID='$ID'";
$result = mysql_query($sql);

if($result) {
		
		///////////////////////Pujar imatge al servidor
		
		$abpath = $CONFIG_PATHUPLOADBANNER; //ruta absoluta on es puja la imatge
		$sizelim = "yes"; //limita tamany si/no
		$size = "500000"; //tamany imatge
		$campbbdd = "IMATGE";
		
		//all image types to upload
		$cert1 = "image/png"; //Png type
		$cert2 = "image/jpeg"; //Jpeg type 2
		$cert3 = "image/gif"; //Gif type
		$cert4 = "image/pjpeg"; //Jpeg tipo 1
		
		$log = "";
		
		$extensio = explode (".", $img_name[0]);
		
		//checks if file exists
		if ($img_name[0] == "") {
			
			$log .= "1";
		}
		
		if ($img_name[0] != "") {	
				
			//mira pes de la imatge
			if (($sizelim == "yes") && ($img_size[0] > $size)) {
				
				$log .= "2";
				
			} else {
				
				//mirem si es imatge
				if (($img_type[0] == $cert1) or ($img_type[0] == $cert2) or ($img_type[0] == $cert3)  or ($img_type[0] == $cert4)) {
					
					if($NOMIMATGEEXIS==""){
						
						$rand1 = (microtime()*1234567);//fer un random per generar codi aleatori
						$md1 = md5($rand1);
						$posanom = $campbbdd."_$md1$ID.$extensio[1]";
						$posanom = str_replace("$", "_", $posanom);
						
					}else{
						
						$posanom = $NOMIMATGEEXIS;
						$posanom = str_replace("$", "_", $posanom);
					}
					
					@copy($img[0], "$abpath/$posanom"); //or $log = "3";
					
					if (file_exists("$abpath/$posanom")) {
						
						$filex = "$abpath/$posanom";
						chmod ($filex, 0666);
						
						$sql = "UPDATE BANNERS_NEWSLETTER SET IMATGE='$posanom'  where ID='$ID'";
					    $result = mysql_query($sql);
						
					    //copio l'imatge amb tamany petit
						$ruta = $abpath."/".$posanom;
						$mides=getimagesize($ruta);
						if ($mides['0'] > 135) {
					      $tn_image = new Thumbnail($ruta, 135, 0, 0);
					      $tn_image->save($ruta);
					      if ($tn_image->error) {
					        echo "error!";
					      }
					    }
					    
						$log .= "4";
						
					}else{
						
						$log .= "3";
					}
					
				} else {
					
					$log .= "5";
				}
			}
		}
		
		mysql_close();
		header("Location: preview.php?ID=$ID&log=$log");
   
}else{
	echo ("<a href='javascript:history.back()'>".$messages["tornar"]."</a>");
	echo mysql_errno().":".mysql_error()."";
}

?>