<?php

require ('../../config_admin.inc');
accessGroupPermCheck('form_entrys');


$accio=$_GET['accio'];
$ID=$_GET['ID'];
////////////MOURE AVALL//////////////////////////////
if ($accio=="down"){
	  //selecciono el camp  q ha de pujar
	 $result=db_query("select * from FORMULARISITEMS where ID = '$ID'");
	 $row = db_fetch_array($result);
	 $form = $row['FORMULARI'];
	 $ORDREACTUALPUJA=$row['ORDRE'];
	 $IDPUJA=$ID;
	 if($result){
		 //selecciono el camp seguent de la base de dades q ha de baixar
		 $result=db_query_range("select * from FORMULARISITEMS where ORDRE >'$ORDREACTUALPUJA' and FORMULARI='$form' ORDER BY ORDRE ASC",0,1);
		 $totalresultats=db_num_rows($result);
		 $row2 = db_fetch_array($result);
		 $ORDREACTUALBAIXA=$row2['ORDRE'];
		 $IDBAIXA=$row2['ID'];
		 if ($totalresultats>0){
				 //ACTUALITZO EL CAMP SELECCIONAT Q HA DE PUJAR
				$sql = "UPDATE FORMULARISITEMS SET ORDRE='$ORDREACTUALBAIXA' where ID = '$IDPUJA'";
				$result = db_query($sql);
				if($result){
					//ACTUALITZO EL  CAMP Q HA DE BAIXA
					$sql = "UPDATE FORMULARISITEMS SET ORDRE='$ORDREACTUALPUJA' where ID = '$IDBAIXA'";
					$result = db_query($sql);
				}
		 }
	 }
}
////////////MOURE AMUNT //////////////////////////////
if ($accio=="up"){
	  //selecciono el camp  q ha de pujar
	 $result=db_query("select * from FORMULARISITEMS where ID = '$ID'");
	 $row = db_fetch_array($result);
	 $form = $row['FORMULARI'];
	 $ORDREACTUALPUJA=$row['ORDRE'];
	 $IDPUJA=$ID;
	 if($result){
		 //selecciono el camp seguent de la base de dades q ha de baixar
		 $result=db_query_range("select * from FORMULARISITEMS where ORDRE <'$ORDREACTUALPUJA' and FORMULARI='$form' ORDER BY ORDRE DESC",0,1);
		 $totalresultats=db_num_rows($result);
		 $row2 = db_fetch_array($result);
		 $ORDREACTUALBAIXA=$row2['ORDRE'];
		 $IDBAIXA=$row2['ID'];
		 if ($totalresultats>0){
				 //ACTUALITZO EL CAMP SELECCIONAT Q HA DE PUJAR
				$sql = "UPDATE FORMULARISITEMS SET ORDRE='$ORDREACTUALBAIXA' where ID = '$IDPUJA'";
				$result = db_query($sql);
				if($result){
					//ACTUALITZO EL  CAMP Q HA DE BAIXA
					$sql = "UPDATE FORMULARISITEMS SET ORDRE='$ORDREACTUALPUJA' where ID = '$IDBAIXA'";
					$result = db_query($sql);
				}
		 }
	 }
}



goto_url($_SERVER['HTTP_REFERER']);
?>
