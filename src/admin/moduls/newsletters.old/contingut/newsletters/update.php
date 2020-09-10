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

	

	
// --------------------
// PARAMETERS DEFAULT  
// --------------------

   if (empty($ID))     { echo "<B>".$messages["error1"].".</B><br>\n"; exit; }
   
   if (empty($LANG))       { $LANG=$DEFAULT_LANG; }
   if (empty($CLASS))      { $CLASS=$DEFAULT_CLASS; }
   
// ------------------
// CARDS INSTANTATION
// ------------------

   $dbCards = new dbCards($CARDS_TABLE);
   if (!$dbCards->Ok) { echo "<B>".$messages["error2"].".</B><br>\n"; exit; }
   
// -------------
// DATA UPDATING
// -------------
   
   // DATA PREPARATION
   unset($data);
   
   // Passem llista als camps i mirem quins em rebut per POST METHOD
   foreach ($CARDS_FIELDS as $name=>$field)
   {
     list ($scope, $type, $style) = $field;
     if (isset($_POST[$name]) || isset($_POST[$name.'_DAY']))
     {
         if ($type=='NUMBER' || $type=='ITEM' )
         { $data[$name]=(int)trim($$name); }
         if ($type=='CHAR' || $type=='TEXT' || $type=='LIST')
         { 
         	//$data[$name]= trim($$name); 
         	$data[$name]= $_POST[$name]; 
         }
         if ($type=='FLAG')
         {
            $data[$name]='';
            for ($i=0; $i<strlen($$name); $i++)
            {
                if (isset(${$name.'_'.$i}))
                { $data[$name].='1'; }                else
                { $data[$name].='0'; }
            }
         }
         if ($type=='DATE')
         {
           $year  = trim(${$name.'_YEAR'});
           $month = trim(${$name.'_MONTH'});
           $day   = trim(${$name.'_DAY'});
           $hour  = trim(${$name.'_HOUR'});
           $min   = trim(${$name.'_MIN'});
           $sec   = trim(${$name.'_SEC'});
           $data[$name]="$year-$month-$day $hour:$min:$sec";
         }
     } // end if
   } // end foreach


   // actualitzem les dades
   $dbCards->updateCard( $ID, $data );
   if (!$dbCards->Ok) { echo "<B>".$messages["error5"].".</B><br>".$Cards->Error."\n"; exit; }


// ### gestio imatge anunci ###
   	$abpath = $CONFIG_PATHUPLOADANUNCI; //ruta absoluta on es puja la imatge
	$sizelim = "yes"; //limita tamany si/no
	$size = "500000"; //tamany imatge
	$campbbdd = "IMATGE";
	$number_of_uploads = 1;  //Nombre d'uploads
	
	//all image types to upload
	$cert1 = "image/png"; //Png type
	$cert2 = "image/jpeg"; //Jpeg type 2
	$cert3 = "image/gif"; //Gif type
	$cert4 = "image/pjpeg"; //Jpeg tipo 1
	
	$log = "";
	
	for ($i=0; $i<$number_of_uploads; $i++) {
		
		$extensio = explode (".", $img_name[$i]);
		
		//checks if file exists
		if ($img_name[$i] == "") {
			
			$log .= "1";
		}
		
		if ($img_name[$i] != "") {	
				
			//mira pes de la imatge
			if (($sizelim == "yes") && ($img_size[$i] > $size)) {
				
				$log .= "2";
				
			} else {
				
				//mirem si es imatge
				if (($img_type[$i] == $cert1) or ($img_type[$i] == $cert2) or ($img_type[$i] == $cert3)  or ($img_type[$i] == $cert4)) {
					
					if($NOMIMATGEEXIS==""){
						
						$rand1 = (microtime()*1234567);//fer un random per generar codi aleatori
						$md1 = md5($rand1);
						$posanom = $campbbdd."_$md1$ID.$extensio[1]";
						$posanom = str_replace("$", "_", $posanom);
						
					}else{
						
						$posanom = $NOMIMATGEEXIS;
						$posanom = str_replace("$", "_", $posanom);
					}
					
					@copy($img[$i], "$abpath/$posanom"); //or $log = "3";
					
					if (file_exists("$abpath/$posanom")) {
						
						$filex = "$abpath/$posanom";
						chmod ($filex, 0666);
						
						$sql = "UPDATE NEWSLETTERS SET IMATGE_ANUNCI='$posanom'  where ID='$ID'";
					    $result = mysql_query($sql);
						
						$log .= "4";
						
					}else{
						
						$log .= "3";
					}
					
				} else {
					
					$log .= "5";
				}
			}
		}
	}
/// ### fi gestio imatge anunci ###


   // -----------
   // REDIRECTION
   // -----------
   // Return URL
   eval("\$url= \"$CARDS_URLUPDATE\";");
   //echo header("Location: $url");
   
   
   if($ACCIO == 1){	
   		header("Location: ../../campanyes/pas2c.php?id=".$_POST['IdCam']);
   }
   
   if($ACCIO == 2){
	   	header("Location: edita.php?ID=".$ID."&ACCIO=".$ACCIO."&IdCam=".$_POST['IdCam']);
   }

?>