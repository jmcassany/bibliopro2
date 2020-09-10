<?php

require ('../../../config_admin.inc');
accessGroupPermCheck('menu_entrys');


   if($_POST){
   	$ID=$_POST['ID'];
   }else{
   	$ID=$_GET['ID'];
   }
   $sql = "UPDATE MENUITEMS SET IMATGE='' where ID='$ID'";
   $result = db_query($sql);
   if($result) {
   				$targetfilename = $CONFIG_PATHUPLOADIM."/menu/$file";
				if (file_exists($targetfilename)) {
					  unlink($targetfilename);
					  //echo ("&#149;&nbsp;La imatge $file ha estat eliminada.<br><br>");

				}
				goto_url('edita.php?ID='.$ID);

   } else {
	echo db_error();
   }
?>
