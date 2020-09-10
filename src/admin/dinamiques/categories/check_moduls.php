<?php
//COMPROVEM SI TE ACCES A AQUEST MODUL
  $entrada = false;

  $users = new dbUsers();
  $trozos = $users->getComments(accessGetLogin());

  $entrada = in_array($DINAMICA, $trozos);


if (!$entrada){
  goto_url('../../login.php');
  exit;
}

//FI COMPROVEM SI TE ACCES A AQUEST MODUL

?>
