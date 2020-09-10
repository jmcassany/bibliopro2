<?php

/*busca la ip real de l'usuari*/
function checkIP()
{
  $tmp = array();
  if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) &&
      strpos($_SERVER['HTTP_X_FORWARDED_FOR'],',')) 
  {
    $tmp += explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
  }
  elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
  {
    $tmp[] = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  $tmp[] = $_SERVER['REMOTE_ADDR'];

  $ipusuari = $tmp['0'];
  return $ipusuari;
}

?>
