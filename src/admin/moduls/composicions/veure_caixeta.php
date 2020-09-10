<?php


require ('../../config_admin.inc');
accessGroupPermCheck('composition');


include("variables.php");

list($id, $sufix) = split('_', $ID);
foreach($fonts_caixetes as $value) {
  if ($value['sufix'] == $sufix) {
    $taula = $value['taula'];
    $path = $value['path'];
  }
}
if (isset($taula)) {
  $resultat = db_query('SELECT * FROM '.$taula.' WHERE ID='.$id);
  $row = db_fetch_array ($resultat);
  if (!empty($row['NOM'])) {
    $targetfilename = $path.'/'.$row['NOM'].'.inc';
    if (file_exists($targetfilename)) {
      echo '<html><head>';
      echo '<link rel="STYLESHEET" type="text/css" href="../../css/estils.css">';
      echo '<link rel="STYLESHEET" type="text/css" href="'.$CONFIG_URLCSS.'/estils.css">';
      echo '<base href="'.urlHost($CONFIG_URLBASE).'">';
      echo '</head><body>';
      include($targetfilename);
      echo ('</body></html>');
    }
  }

}

?>

