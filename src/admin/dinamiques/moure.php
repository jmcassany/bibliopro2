<?php

require ('../config_admin.inc');
accessGroupPermCheck('dinamic_read');

include_once("dinamiques.php");
include_once('categories/funcions.inc');

$ID=$_GET['ID'];
$accio=$_GET['accio'];
//COMPROVEM SI TE ACCES A AQUEST MODUL
 include("check_moduls.php");
 //FI COMPROVEM SI TE ACCES A AQUEST MODUL

//va al reves pq s'ordena a l'inreves
////////////MOURE AVALL//////////////////////////////
if ($accio=="up"){
	  //selecciono el camp  q ha de pujar
	 $result=db_query("select * from $TAULA where ID = '$ID'");
	 $row = db_fetch_array($result);
	 $ORDREACTUALPUJA=$row['ORDRE'];
	 $IDPUJA=$ID;

	 if($result){
		 //selecciono el camp seguent de la base de dades q ha de baixar
		 $result=db_query("select * from $TAULA where ORDRE >'$ORDREACTUALPUJA' ORDER BY ORDRE ASC");

		 $totalresultats=db_num_rows($result);
		 $row2 = db_fetch_array($result);
		 $ORDREACTUALBAIXA=$row2['ORDRE'];
		 $IDBAIXA=$row2['ID'];
		 if ($totalresultats>0){

				 //ACTUALITZO EL CAMP SELECCIONAT Q HA DE PUJAR
				$sql = "UPDATE $TAULA SET ORDRE='$ORDREACTUALBAIXA' where ID = '$IDPUJA'";
				$result = db_query($sql);
				if($result){
					//ACTUALITZO EL  CAMP Q HA DE BAIXA
					$sql = "UPDATE $TAULA SET ORDRE='$ORDREACTUALPUJA' where ID = '$IDBAIXA'";
					$result = db_query($sql);
				}
		 }
	 }
}
////////////MOURE AMUNT //////////////////////////////
if ($accio=="down"){
	  //selecciono el camp  q ha de pujar
	 $result=db_query("select * from $TAULA where ID = '$ID'");
	 $row = db_fetch_array($result);
	 $ORDREACTUALPUJA=$row['ORDRE'];
	 $IDPUJA=$ID;
	 if($result){

		 //selecciono el camp seguent de la base de dades q ha de baixar
		 $result=db_query("select * from $TAULA where ORDRE <'$ORDREACTUALPUJA' ORDER BY ORDRE DESC");

		 $totalresultats=db_num_rows($result);
		 $row2 = db_fetch_array($result);
		 $ORDREACTUALBAIXA=$row2['ORDRE'];
		 $IDBAIXA=$row2['ID'];
		 if ($totalresultats>0){

				 //ACTUALITZO EL CAMP SELECCIONAT Q HA DE PUJAR
				$sql = "UPDATE $TAULA SET ORDRE='$ORDREACTUALBAIXA' where ID = '$IDPUJA'";
				$result = db_query($sql);
				if($result){
					//ACTUALITZO EL  CAMP Q HA DE BAIXA
					$sql = "UPDATE $TAULA SET ORDRE='$ORDREACTUALPUJA' where ID = '$IDBAIXA'";
					$result = db_query($sql);
				}
		 }
	 }
}

include("createxml.inc");
createrss($DIN);

goto_url('index.php?DIN='.$DIN.'&PAGE='.$pagina);
?>
