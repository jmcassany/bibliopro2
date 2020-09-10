<?php

require ('../../../config_admin.inc');
accessGroupPermCheck('menu_entrys');


   foreach($_POST as $key => $value) {
     $_POST[$key] = addslashes($value);
   }

  //MIRO L´ultim ordre entrat
  $result=db_query("select MAX(ORDRE) as ORDRE from MENUITEMSSUB where MENUITEM='".$_POST['MENUITEM']."'");
		 $totalresultats=db_num_rows($result);
		 $row2 = db_fetch_array($result);
		 if ($totalresultats>0){
		 	$ORDRE=$row2['ORDRE']+1;
		}else{
			$ORDRE=1;
		}

  $sql = "insert into MENUITEMSSUB (TEXT,LINKPAGE,FINESTRA,`SEPARATOR`,ORDRE,MENUITEM,CSSCLASS) values ('".$_POST['TEXT']."','".$_POST['LINKPAGE']."','".$_POST['FINESTRA']."','".$_POST['SEPARATOR']."','$ORDRE','".$_POST['MENUITEM']."', '".$_POST['CSSCLASS']."')";
  $result = db_query($sql);
   if($result) {
    $result2=db_query("select max(ID) as ID from MENUITEMSSUB");
    $row2 = db_fetch_array($result2);
	//////////////////////////////////////
	goto_url('index_desp.php?ID='.$_POST['MENUITEM']);

   } else {
	echo ("<a href='javascript:history.back()'>".t("back")."</a>");
	echo db_error();
   }

?>
