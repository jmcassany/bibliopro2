<?php

require_once ('checkip.inc');


/*afegeix una entrada al registre*/
function register_add($accio, $missatge = '', $login = '') {
  global $CONFIG_registre_days;

  /*eliminar entrades velles*/
  if (isset($CONFIG_registre_days) && $CONFIG_registre_days > 0) {
    db_query("delete from REGISTRE where DATA < DATE_SUB(sysdate(), INTERVAL ".$CONFIG_registre_days." DAY)");
  }

  $ip=checkIP();
  if ($login == '') {
    $login = accessGetLogin();
  }
  $login = addslashes($login);
  $accio = addslashes($accio);
  $missatge = addslashes($missatge);
  db_query("INSERT INTO REGISTRE (DATA, LOGIN,ACTION,DESCRIPTION,IP) VALUES (sysdate(),'".$login."','".$accio."','".$missatge."','".$ip."')");
  return (db_affected_rows()>0);
}

/*obté la última entrada del registre*/
function register_last($number = 1, $user = '') {

  if (!empty($user)) {
    $user = addslashes($user);
    $user = "LOGIN = '".$user."' AND";
  }
  $result=db_query_range("select * from REGISTRE where ".$user." ACTION NOT LIKE '".t('registrylogin')."' ORDER BY DATA DESC",0,$number);
  $return = array();
  while($row = db_fetch_array($result)) {
    $login = $row['LOGIN'];
    $action = $row['ACTION'];
    $description = $row['DESCRIPTION'];
    array_push($return, array('action' => $action, 'description' => $description, 'date' => $row['DATA'], 'user' => $login, 'ip' => $row['IP']));
  }
  return $return;
}

/*retorna l'html amb l'últim registre*/
function register_last_print($number = 1, $user = '') {

  $result = register_last($number, $user);

  $text =  '<table border="0" cellpadding="0"   cellspacing="0" width="760" style="margin:10px;" bgcolor="#CECECE">';
  $text .= '  <tr>';
  $text .= '    <td class="gris10" style="padding:10px;">';
  $text .= '      <b>'.t('lastaction').':</b>';

  foreach ($result as $value) {
    $text .= ('      <br>'.$value['action'].': '.$value['description'].' - '.$value['date']);
  }
  $text .= '    </td>';
  $text .= '  </tr>';
  $text .= '</table>';

  return ($text);
}

/*obté una llista d'entrades de registre*/
function register_list($user = '', $ini_time, $end_time, $order = 'DATA DESC') {
  if (!empty($user)) {
    $user = addslashes($user);
    $user = "LOGIN = '".$user."' AND";
  }
  $result=db_query("select * from REGISTRE WHERE $user ((DATA >='$ini_time') AND (DATA <= '$end_time')) ORDER BY $order");
  $return = array();
  while($row = db_fetch_array($result)) {
    $login = $row['LOGIN'];
    $action = $row['ACTION'];
    $description = $row['DESCRIPTION'];
    array_push($return, array('action' => $action, 'description' => $description, 'date' => $row['DATA'], 'user' => $login, 'ip' => $row['IP']));
  }
  return $return;
}

/*retorna l'html amb una llista d'entrades de registre*/
function register_list_print($user = '', $ini_time, $end_time, $order = 'DATA DESC') {

  echo ('
  <tr>
');
  if (empty($user)) {
    echo ('
    <td class="text10" style="border-bottom:solid #000000 1px;padding:3px;padding-top:10px;font-weight:bold;">'.t('user').'</td>
    ');
  }
  echo ('
    <td class="text10" style="border-bottom:solid #000000 1px;padding:3px;padding-top:10px;font-weight:bold;">'.t("action").'</td>
    <td class="text10" style="border-bottom:solid #000000 1px;padding:3px;padding-top:10px;font-weight:bold;">'.t("date").'</td>
    <td class="text10" style="border-bottom:solid #000000 1px;padding:3px;padding-top:10px;font-weight:bold;">IP</td>
  </tr>
');

  $result = register_list($user, $ini_time, $end_time, $order);

  foreach ($result as $value) {
    $data=explode(" ",$value['date']);
    $data1=explode("-",$data['0']);

    echo ('
  <tr>
');
    if (empty($user)) {
      echo ('
    <td class="blau10" style="padding:3px;" valign="top">'.$value['user'].'</td>
');
    }
    echo ('
    <td class="text10" style="padding:3px;" valign="top">'.$value['action'].': '.$value['description'].'</td>
    <td class="text10" style="padding:3px;" valign="top">'.$data1['2'].'-'.$data1['1'].'-'.$data1['0'].' '.$data['1'].'</td>
    <td class="text10" style="padding:3px;" valign="top">'.$value['ip'].'</td>
    </tr>
');
  }
}

?>
