<?php

require ('../../config_admin.inc');






/*falta arreglar*/
db_query("alter table ESTATICA add column PLANTILLAID int(11) default null");

$result = db_query('select ID, PLANTILLA, NOMPAG from ESTATICA');

while ($row = db_fetch_array($result)) {
  $plantilla = db_query("select ID, NOM from PLANTILLA where NOM='".$row['PLANTILLA']."'");
  if (db_num_rows($plantilla) == 0) {
    echo '<h4>la pagina '.$row['NOMPAG'].' no te plantilla</h4>';
    /*plantilla no trobada, posar null*/
    db_query('update ESTATICA set PLANTILLAID=null where ID='.$row['ID']);
  }
  else {
    $idplantilla = db_fetch_array($plantilla);
    echo '<h4>la pagina '.$row['NOMPAG'].' te la plantilla '.$idplantilla['NOM'].' </h4>';

    db_query('update ESTATICA set PLANTILLAID='.$idplantilla['ID'].' where ID='.$row['ID']);
  }
}




echo '<h2>Comprova que la conversió ha estat correcte</h2>';
echo '<h2>Elimina la columna PLANTILLA de la taula estatica</h2>';






?>
