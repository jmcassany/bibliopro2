<?php

require ('../../config_admin.inc');
accessGroupPermCheck('dinamic_category');

//include_once('categories/funcions.inc');

$ID=$_GET['ID'];
$accio=$_GET['accio'];
$DINAMICA =$_GET['DINAMICA'];
//COMPROVEM SI TE ACCES A AQUEST MODUL
 include("check_moduls.php");
 //FI COMPROVEM SI TE ACCES A AQUEST MODUL

//va al reves pq s'ordena a l'inreves
////////////MOURE AVALL//////////////////////////////
if ($accio=="up"){
	  //selecciono el camp  q ha de pujar
	 $result=db_query("select * from DIN_CATEGORIES where ID = '$ID'");
	 $row = db_fetch_array($result);
	 $ORDREACTUALPUJA=$row['ORDRE'];
	 $PARE = $row['PARE'];
	 $IDPUJA=$ID;

	 if($result){
	 	
		 //selecciono el camp seguent de la base de dades q ha de baixar
		 if($PARE == null)
		 {
		 	$result=db_query("select * from DIN_CATEGORIES where DINAMICA = $DINAMICA AND PARE IS NULL AND ORDRE >'$ORDREACTUALPUJA' ORDER BY ORDRE ASC");
		 }
		 else 
		 {
		 	$result=db_query("select * from DIN_CATEGORIES where DINAMICA = $DINAMICA AND PARE=$PARE AND ORDRE >'$ORDREACTUALPUJA' ORDER BY ORDRE ASC");
		 }
		 $totalresultats=db_num_rows($result);
		 $row2 = db_fetch_array($result);
		 $ORDREACTUALBAIXA=$row2['ORDRE'];
		 $IDBAIXA=$row2['ID'];
		 if ($totalresultats>0){

				 //ACTUALITZO EL CAMP SELECCIONAT Q HA DE PUJAR
				$sql = "UPDATE DIN_CATEGORIES SET ORDRE='$ORDREACTUALBAIXA' where ID = '$IDPUJA'";
				$result = db_query($sql);
				if($result){
					//ACTUALITZO EL  CAMP Q HA DE BAIXA
					$sql = "UPDATE DIN_CATEGORIES SET ORDRE='$ORDREACTUALPUJA' where ID = '$IDBAIXA'";
					$result = db_query($sql);
				}
		 }
	 }
}
////////////MOURE AMUNT //////////////////////////////
if ($accio=="down"){
	  //selecciono el camp  q ha de pujar
	 $result=db_query("select * from DIN_CATEGORIES where ID = '$ID'");
	 $row = db_fetch_array($result);
	 $ORDREACTUALPUJA=$row['ORDRE'];
	 $PARE = $row['PARE'];
	 $IDPUJA=$ID;
	 if($result){

		 //selecciono el camp seguent de la base de dades q ha de baixar
		 if($PARE == null)
		 {
		 	$result=db_query("select * from DIN_CATEGORIES where DINAMICA = $DINAMICA AND PARE IS NULL AND ORDRE <'$ORDREACTUALPUJA' ORDER BY ORDRE DESC");
		 }
		 else 
		 {
		 	$result=db_query("select * from DIN_CATEGORIES where DINAMICA = $DINAMICA AND PARE=$PARE AND ORDRE <'$ORDREACTUALPUJA' ORDER BY ORDRE DESC");
		 }
		 $totalresultats=db_num_rows($result);
		 $row2 = db_fetch_array($result);
		 $ORDREACTUALBAIXA=$row2['ORDRE'];
		 $IDBAIXA=$row2['ID'];
		 if ($totalresultats>0){

				 //ACTUALITZO EL CAMP SELECCIONAT Q HA DE PUJAR
				$sql = "UPDATE DIN_CATEGORIES SET ORDRE='$ORDREACTUALBAIXA' where ID = '$IDPUJA'";
				$result = db_query($sql);
				if($result){
					//ACTUALITZO EL  CAMP Q HA DE BAIXA
					$sql = "UPDATE DIN_CATEGORIES SET ORDRE='$ORDREACTUALPUJA' where ID = '$IDBAIXA'";
					$result = db_query($sql);
				}
		 }
	 }
}


$id_params = ($PARE != null) ? '&ID='.$PARE : '';
goto_url('index.php?DINAMICA='.$DINAMICA.$id_params);

?>
