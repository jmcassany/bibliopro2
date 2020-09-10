<?php
if (isset($_POST['carpeta'])) {
  $carpeta=$_POST['carpeta'];
}
else if (isset($_GET['carpeta'])) {
  $carpeta=$_GET['carpeta'];
}
else if (!isset($carpeta)){
  /*no hi ha identificador de carpeta, anar a index*/
  goto_url('../index.php');
}

$result=db_query("select * from CARPETES where CATEGORY1='0' and ID=".$carpeta);
if (db_num_rows($result) != 1) {
  /*carpeta no trobadam, anar a index*/
  goto_url('../index.php');
}
$row = db_fetch_array($result);

$descripciocarpeta= $row['DESCRIPCIO'];
$nomcarpeta= $row['NOMCARPETA'];

/*comprovar permissos*/
$users = new dbUsers();
$trozos = $users->getComments(accessGetLogin());
if (!in_array($carpeta, $trozos)) {
  goto_url('../login.php');
}

?>
