<?php

require ('../../../config_admin.inc');
accessGroupPermCheck('menu_entrys');


$ID=$_GET['ID'];
$accio=$_GET['accio'];
////////////MOURE AVALL//////////////////////////////
if ($accio=="down"){
	  //selecciono el camp  q ha de pujar
	 $result=db_query("select * from MENUITEMSSUB where ID = '$ID'");
	 $row = db_fetch_array($result);
	 $ORDREACTUALPUJA=$row['ORDRE'];
	 $IDPUJA=$ID;
	 if($result){
		 //selecciono el camp seguent de la base de dades q ha de baixar
		 $result2=db_query_range("select * from MENUITEMSSUB where (ORDRE > '$ORDREACTUALPUJA') AND MENUITEM='$row[MENUITEM]' ORDER BY ORDRE ASC",0,1);
		 $totalresultats=db_num_rows($result2);
		 $row2 = db_fetch_array($result2);
		 $ORDREACTUALBAIXA=$row2['ORDRE'];
		 $IDBAIXA=$row2['ID'];
		 if ($totalresultats>0){
				 //ACTUALITZO EL CAMP SELECCIONAT Q HA DE PUJAR
				$sql = "UPDATE MENUITEMSSUB SET ORDRE='$ORDREACTUALBAIXA' where ID = '$IDPUJA'";
				$result3 = db_query($sql);
				if($result3){
					//ACTUALITZO EL  CAMP Q HA DE BAIXA
					$sql = "UPDATE MENUITEMSSUB SET ORDRE='$ORDREACTUALPUJA' where ID = '$IDBAIXA'";
					$result4 = db_query($sql);
				}
		 }
	 }
}
////////////MOURE AMUNT //////////////////////////////
if ($accio=="up"){
	  //selecciono el camp  q ha de pujar
	 $result=db_query("select * from MENUITEMSSUB where ID = '$ID'");
	 $row = db_fetch_array($result);
	 $ORDREACTUALPUJA=$row['ORDRE'];
	 $IDPUJA=$ID;
	 if($result){
		 //selecciono el camp seguent de la base de dades q ha de baixar
		 $result2=db_query_range("select * from MENUITEMSSUB where (ORDRE <'$ORDREACTUALPUJA') AND MENUITEM='$row[MENUITEM]' ORDER BY ORDRE DESC",0,1);
		 $totalresultats=db_num_rows($result2);
		 $row2 = db_fetch_array($result2);
		 $ORDREACTUALBAIXA=$row2['ORDRE'];
		 $IDBAIXA=$row2['ID'];
		 if ($totalresultats>0){
				 //ACTUALITZO EL CAMP SELECCIONAT Q HA DE PUJAR
				$sql = "UPDATE MENUITEMSSUB SET ORDRE='$ORDREACTUALBAIXA' where ID = '$IDPUJA'";
				$result3 = db_query($sql);
				if($result3){
					//ACTUALITZO EL  CAMP Q HA DE BAIXA
					$sql = "UPDATE MENUITEMSSUB SET ORDRE='$ORDREACTUALPUJA' where ID = '$IDBAIXA'";
					$result4 = db_query($sql);
				}
		 }
	 }
}



goto_url($_SERVER['HTTP_REFERER']);
?>
