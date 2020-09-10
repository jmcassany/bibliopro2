<?php


$users = new dbUsers();
$trozos = $users->getComments(accessGetLogin());
if (!in_array($DIN, $trozos)) {
  goto_url('../login.php');
}

$result = db_query("select * from CARPETES where ID=".$DIN);
$row = db_fetch_array($result);
$nomcarpeta = $row['NOMCARPETA'];
$tipuseditora=$row['SKIN'];
$idiomaEditora=$row['IDIOMA'];
$ruta = folderPath($DIN);
$descripciocarpeta = db_select_text('CARPETES', 'DESCRIPCIO', 'ID = '.$DIN);

//FI COMPROVEM SI TE ACCES A AQUEST MODUL

?>
