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


$avui = date('Y-m-d H:i:s', time());

$any = date('Y');
$mes = date('m');
$dia = date('d');
$anymes = $any + 1;

$start = $any."-".$mes."-".$dia." 00:00:00";
$end = $anymes."-".$mes."-".$dia." 00:00:00";

$TITOL=addslashes($_POST['TITOL']);
$SUBTITOL=addslashes($_POST['SUBTITOL']);
$LLOC=addslashes($_POST['LLOC']);
$DATA_LLOC=addslashes($_POST['DATA_LLOC']);
$RESUM=addslashes($_POST['RESUM']);
$DESCRIPCIO=addslashes($_POST['DESCRIPCIO']);
$NOM=addslashes($_POST['NOM']);
$CARREC=addslashes($_POST['CARREC']);
$NOMAD1=addslashes($_POST['NOMAD1']);
$NOMAD2=addslashes($_POST['NOMAD2']);
$NOMAD3=addslashes($_POST['NOMAD3']);
$NOMAD4=addslashes($_POST['NOMAD4']);
$PIXELS_IMG=$_POST['IMATGE2'];
$IMATGE3=addslashes($_POST['IMATGE3']);
$NOMAD5=addslashes($_POST['NOMAD5']);


$sql = "insert into NOTICIES_NEWSLETTER (CLASS,SKIN,CATEGORY1,CATEGORY2,STATUS,VISIBILITY,CREATION,START,END,TITOL,RESUM,DESCRIPCIO,NOMAD1,NOMAD2,NOMAD3,NOMAD4,NOMAD5,MESINFO,LINK1,LINK2,NOM,CARREC,LLOC,DATA_LLOC,SUBTITOL,MODEL,USUARI_HOUDINI,IMATGE2,IMATGE3) values ('1','0','$CATEGORY1','$CATEGORY2','$STATUS','1','$avui','$start','$end','$TITOL','$RESUM','$DESCRIPCIO','$NOMAD1','$NOMAD2','$NOMAD3','$NOMAD4','$NOMAD5','$MESINFO','$LINK1','$LINK2','$NOM','$CARREC','$LLOC','$DATA_LLOC','$SUBTITOL','$MODEL','$USUARI_HOUDINI','$PIXELS_IMG','$IMATGE3')";

//echo $sql;

$result = mysql_query($sql);

if($result) {
	
	$result = mysql_query("SELECT ID FROM NOTICIES_NEWSLETTER ORDER BY ID DESC LIMIT 1");
	$row = mysql_fetch_array($result);
	$ID = $row['ID'];
    
    if($result) {
     	
		///////Pujar arxius al servidor		
		
		$abpath = $CONFIG_PATHUPLOADAD; //ruta absoluta on es puja l'arxiu
		$sizelim = "yes"; //Limit de tamany si/no
		$size = "5000000"; //tamant limit
		$campbbdd = "ADJUNT";
		$number_of_uploads = 5;  //Nombre d'uploads
		$imatgeinicial = 1;
		
		//tipus d'arxius
		$cert1 = "application/pdf";
		$cert2 = "application/x-mspowerpoint";
		$cert3 = "application/msword";
		$cert4 = "application/x-zip-compressed";
		$cert5 = "application/x-msexcel";
		$cert6 = "application/excel";
		$cert7 = "application/x-excel";
		$cert8 = "application/vnd.ms-excel";
		$cert9 = "application/mspowerpoint";
		$cert10 = "application/powerpoint";
		$cert11 = "application/vnd.ms-powerpoint";
		
		$log20 = "";
		$log21 = "";
		$log22 = "";
		$log23 = "";
		$log24 = "";
		
		for ($i=0; $i<$number_of_uploads; $i++) {
			
			$extensio = explode (".", $_FILES['file'.$i]['name']);
			
			//mirem si existeix
			if ($_FILES['file'.$i]['name'] == "") {
				
				switch($i){
					case '0': $log20 .= "1";break;
					case '1': $log21 .= "1";break;
					case '2': $log22 .= "1";break;
					case '3': $log23 .= "1";break;
					case '4': $log24 .= "1";break;
				}
				$imatgeinicial++;
			}
			
			if ($_FILES['file'.$i]['name'] != "") {
				
				//mirem tamany de l'arxiu
				if (($sizelim == "yes") && ($_FILES['file'.$i]['size'] > $size)) {
					
					switch($i){
						case '0': $log20 .= "2";break;
						case '1': $log21 .= "2";break;
						case '2': $log22 .= "2";break;
						case '3': $log23 .= "2";break;
						case '4': $log24 .= "2";break;
					}
					$imatgeinicial++;
					
				} else {
					
					//mirem si es un arxiu valid
					//if (($file_type[$i] == $cert1) or ($file_type[$i] == $cert2) or ($file_type[$i] == $cert3) or ($file_type[$i] == $cert4) or ($file_type[$i] == $cert5) or ($file_type[$i] == $cert6) or ($file_type[$i] == $cert7) or ($file_type[$i] == $cert8) or ($file_type[$i] == $cert9) or ($file_type[$i] == $cert10) or ($file_type[$i] == $cert11)) {
						
						$rand1 = (microtime()*1234567);//fer un random per generar codi aleatori
						$md1 = md5($rand1);
						$posanom= $extensio[0]."_$md1$ID.$extensio[1]";	
						
						//@copy($file[$i], "$abpath/$posanom");// or $log2[$i] .= "3";
						@move_uploaded_file($_FILES['file'.$i]['tmp_name'], $abpath.'/'.$posanom);
						
						if (file_exists("$abpath/$posanom")) {
							
							$filex ="$abpath/$posanom";
							chmod ($filex, 0666);
							
							$sql = "UPDATE NOTICIES_NEWSLETTER SET ADJUNT$imatgeinicial='$posanom' where ID='$ID'";
						    $result = mysql_query($sql);
							
							switch($i){
								case '0': $log20 .= "4";break;
								case '1': $log21 .= "4";break;
								case '2': $log22 .= "4";break;
								case '3': $log23 .= "4";break;
								case '4': $log24 .= "4";break;
							}
							$imatgeinicial++;
							
						}else{
							
							switch($i){
								case '0': $log20 .= "3";break;
								case '1': $log21 .= "3";break;
								case '2': $log22 .= "3";break;
								case '3': $log23 .= "3";break;
								case '4': $log24 .= "3";break;
							}
						}
						
					/*} else {
						
						switch($i){
							case '0': $log20 .= "5";break;
							case '1': $log21 .= "5";break;
							case '2': $log22 .= "5";break;
							case '3': $log23 .= "5";break;
							case '4': $log24 .= "5";break;
						}
						$imatgeinicial++;
					}*/
				}
			}
		}
		
		///////////////////////Pujar imatge al servidor
		
		$abpath = $CONFIG_PATHUPLOADIM; //ruta absoluta on es puja la imatge
		$sizelim = "yes"; //limita tamany si/no
		$size = "500000"; //tamany imatge
		$campbbdd = "IMATGE";
		$number_of_uploads = 1;  //Nombre d'uploads
		$imatgeinicial = 1;
		
		//all image types to upload
		$cert1 = "image/png"; //Png type
		$cert2 = "image/jpeg"; //Jpeg type 2
		$cert3 = "image/gif"; //Gif type
		$cert4 = "image/pjpeg"; //Jpeg tipo 1
		
		$log10 = "";
		$log11 = "";
		$log12 = "";
		
		for ($i=0; $i<$number_of_uploads; $i++) {
			
			$extensio = explode (".", $img_name[$i]);
			
			//checks if file exists
			if ($img_name[$i] == "") {
				
				switch($i){
					case '0': $log10 .= "1";break;
					case '1': $log11 .= "1";break;
					case '2': $log12 .= "1";break;
				}
				$imatgeinicial++;
			}
			
			if ($img_name[$i] != "") {	
					
				//mira pes de la imatge
				if (($sizelim == "yes") && ($img_size[$i] > $size)) {
					
					switch($i){
						case '0': $log10 .= "2";break;
						case '1': $log11 .= "2";break;
						case '2': $log12 .= "2";break;
					}
					$imatgeinicial++;
					
				} else {
					
					//mirem si es imatge
					if (($img_type[$i] == $cert1) or ($img_type[$i] == $cert2) or ($img_type[$i] == $cert3)  or ($img_type[$i] == $cert4)) {
						
						$rand1 = (microtime()*1234567);//fer un random per generar codi aleatori
						$md1 = md5($rand1);
						$posanom = $campbbdd."_$md1$ID.$extensio[1]";
						$posanom = str_replace("$", "_", $posanom);	
						
						@copy($img[$i], "$abpath/$posanom"); //or $log = "3";
						
						if (file_exists("$abpath/$posanom")) {
							
							$filex = "$abpath/$posanom";
							chmod ($filex, 0666);
							
							$sql = "UPDATE NOTICIES_NEWSLETTER SET IMATGE$imatgeinicial='$posanom'  where ID='$ID'";
						    $result = mysql_query($sql);
							
							//copio l'imatge amb tamany petit
							$ruta = $abpath."/".$posanom;
							$ruta2 = $abpath."/p".$posanom;
							$mides=getimagesize($ruta);
							if ($mides['0'] > $PIXELS_IMG) {
						      $tn_image = new Thumbnail($ruta, $PIXELS_IMG, 0, 0);
						      $tn_image->save($ruta2);
						      if ($tn_image->error) {
						        echo "error!";
						      }
						    }
							
							switch($i){
								case '0': $log10 .= "4";break;
								case '1': $log11 .= "4";break;
								case '2': $log12 .= "4";break;
							}
							$imatgeinicial++;
							
						}else{
							
							switch($i){
								case '0': $log10 .= "3";break;
								case '1': $log11 .= "3";break;
								case '2': $log12 .= "3";break;
							}
						}
						
					} else {
						
						switch($i){
							case '0': $log10 .= "5";break;
							case '1': $log11 .= "5";break;
							case '2': $log12 .= "5";break;
						}
						$imatgeinicial++;
					}
				}
			}
		}
		
		mysql_close();
		//header("Location: preview.php?ID=$ID&log10=$log10&log11=$log11&log12=$log12&log20=$log20&log21=$log21&log22=$log22&log23=$log23&log24=$log24");
		echo header("Location: view.php?ID=$ID");
		
   } else {
		
		echo ("<a href='javascript:history.back()'>".$messages["tornar"]."</a>");
		echo mysql_errno().":".mysql_error()."";
   }
   
}else{
	
	echo ("<a href='javascript:history.back()'>".$messages["tornar"]."</a>");
	echo mysql_errno().":".mysql_error()."";
} 

?>