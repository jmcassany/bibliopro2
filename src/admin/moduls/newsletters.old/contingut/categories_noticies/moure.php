<?php 
include("config.php"); 

$TAULA = "CATEGORIES_NOTICIES";
$ID=$_GET['ID'];
$accio=$_GET['accio'];
$opcio=$_GET['opcio'];

//va al reves pq s'ordena a l'inreves
////////////MOURE AVALL//////////////////////////////
if ($accio=="up"){
	  //selecciono el camp  q ha de pujar
	 $result = mysql_query("select * from $TAULA where ID = '$ID'");
	 $row = mysql_fetch_array($result);
	 $ORDREACTUALPUJA=$row['ORDRECAT'];
	 $IDPUJA=$ID;
	
	 if($result){
		 //selecciono el camp seguent de la base de dades q ha de baixar
		 $result=mysql_query("select * from $TAULA where ORDRECAT >'$ORDREACTUALPUJA' ORDER BY ORDRECAT ASC");

		 $totalresultats=mysql_num_rows($result);
		 $row2 = mysql_fetch_array($result);
		 $ORDREACTUALBAIXA=$row2['ORDRECAT'];		
		 $IDBAIXA=$row2['ID'];					 
		 if ($totalresultats>0){

				 //ACTUALITZO EL CAMP SELECCIONAT Q HA DE PUJAR 
				$sql = "UPDATE $TAULA SET ORDRECAT='$ORDREACTUALBAIXA' where ID = '$IDPUJA'";
				$result = mysql_query($sql);
				if($result){
					//ACTUALITZO EL  CAMP Q HA DE BAIXA
					$sql = "UPDATE $TAULA SET ORDRECAT='$ORDREACTUALPUJA' where ID = '$IDBAIXA'";
					$result = mysql_query($sql);
				}
		 }
	 }	
	mysql_close();   
}
////////////MOURE AMUNT //////////////////////////////
if ($accio=="down"){
	  //selecciono el camp  q ha de pujar
	 $result=mysql_query("select * from $TAULA where ID = '$ID'");
	 $row = mysql_fetch_array($result);
	 $ORDREACTUALPUJA=$row['ORDRECAT'];
	 $IDPUJA=$ID;
	 if($result){

		 //selecciono el camp seguent de la base de dades q ha de baixar
		 $result=mysql_query("select * from $TAULA where ORDRECAT <'$ORDREACTUALPUJA' ORDER BY ORDRECAT DESC");

		 $totalresultats=mysql_num_rows($result);
		 $row2 = mysql_fetch_array($result);
		 $ORDREACTUALBAIXA=$row2['ORDRECAT'];
		 $IDBAIXA=$row2['ID'];	
		 if ($totalresultats>0){

				 //ACTUALITZO EL CAMP SELECCIONAT Q HA DE PUJAR 
				$sql = "UPDATE $TAULA SET ORDRECAT='$ORDREACTUALBAIXA' where ID = '$IDPUJA'";
				$result = mysql_query($sql);
				if($result){
					//ACTUALITZO EL  CAMP Q HA DE BAIXA
					$sql = "UPDATE $TAULA SET ORDRECAT='$ORDREACTUALPUJA' where ID = '$IDBAIXA'";
					$result = mysql_query($sql);
				}
		 }
	 }	
	mysql_close();   
}




if($opcio == "cercador"){
	header("Location: busca.php");
}else{
	header("Location: list.php");
}
?> 
