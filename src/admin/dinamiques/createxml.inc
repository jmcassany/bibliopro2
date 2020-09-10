<?php

include ($CONFIG_PATHADMIN.'/php/lib/writerss.inc');
include_once ($CONFIG_PATHBASE.'/config.php');
// include_once ('funcions_cat.inc');


function createrss($id) {
  global $CONFIG_URLBASE, $CONFIG_PATHBASE, $CONFIG_URLUPLOADIM;
  global $CONFIG_SITENAME;

  $result = db_query("SELECT * FROM CARPETES WHERE CATEGORY1=1 AND ID=".$id);

  if (!db_num_rows($result)) {
    return false;
  }
  $row = db_fetch_array($result);

  $rutaguardarxml = folderPath($row['PARE']).'/'.$row['NOMCARPETA'];

  if ($row['RSS']>0) {
    $rss = new writerss($CONFIG_SITENAME.' - '.$row['TITOL'], $CONFIG_URLBASE.'/'.$rutaguardarxml, $row['DESCRIPCIO']);

    $result = db_query_range ("select * from ".staticFolderTableName($id)." Where (STATUS='1') and ((VISIBILITY='1') or (VISIBILITY='2' and START_TIME<sysdate() and END_TIME>sysdate())) order by ORDRE desc", 0,$row['RSS']) or die (db_error());
    while ($row = db_fetch_array($result)) {
      $row['DESCRIPCIO'] = db_select_text(staticFolderTableName($id), 'DESCRIPCIO', 'ID = '.$row['ID']);
      $row['RESUM'] = db_select_text(staticFolderTableName($id), 'RESUM', 'ID = '.$row['ID']);
      $imatge = array();
      if (!empty($row['IMATGE1'])) {
        $imatge['url'] = $CONFIG_URLUPLOADIM.'/'.$row['IMATGE1'];
      }
      $url = '';
      if (!empty($row['DESCRIPCIO'])) {
        $url = $CONFIG_URLBASE.'/'.$rutaguardarxml.'/view.php?ID='.$row['ID'];
      }
      $categoria = '';
      if($row['CATEGORY2'] != 0)
      {
      	$categoria = '<a href="'.$CONFIG_URLBASE.'/'.$rutaguardarxml.'/index.php?CATEGORY2='.$row['CATEGORY2'].'">'.getNomCategoria($row['CATEGORY2']).'</a>';
      }
      $rss->setitem($row['TITOL'], $url, $row['RESUM'], $row['CREATION'], $imatge, $categoria);
    }
    $rss->generate();
    $rss->save($CONFIG_PATHBASE.'/'.$rutaguardarxml.'/index.xml');
  }
  else {
    @unlink($CONFIG_PATHBASE.'/'.$rutaguardarxml.'/index.xml');
  }
}


?>
