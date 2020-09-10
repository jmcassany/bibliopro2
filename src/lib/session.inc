<?php

require_once ('checkip.inc');

//session_set_save_handler("sess_open", "sess_close", "sess_read", "sess_write", "sess_destroy", "sess_gc");
//session_name($CONFIG_SESSIONNAME.'_SESSID');
if (!isset($_SESSION)) { session_start(); }
header("Cache-control: private");  //pq no es perdin les dades dels formularis al tornar enrera!

/*** Session functions *****************************************************/

function sess_open($save_path, $session_name) {
  return 1;
}

function sess_close() {
  return 1;
}

function sess_read($key) {
  if (strlen($key) != 32) {
    return '';
  }
  $result = db_query("SELECT session FROM sessions WHERE sid = '%s'", $key);

  if (!db_num_rows($result)) {
    db_query("INSERT INTO sessions (sid, hostname, timestamp) VALUES ('%s', '%s', %d)", $key, $_SERVER["REMOTE_ADDR"], time());
    $session = '';
  }
  else {
    $session = db_fetch_array($result);
    $session = $session['session'];
  }
  return $session;
}

function sess_write($key, $value) {
  db_query("UPDATE sessions SET hostname = '%s', session = '%s', timestamp = %d WHERE sid = '%s'", $_SERVER["REMOTE_ADDR"], $value, time(), $key);
  return '';
}

function sess_destroy($key) {
  db_query("DELETE FROM sessions WHERE sid = '%s'", $key);
}

function sess_gc($lifetime) {

  /*
  **  Be sure to adjust 'php_value session.gc_maxlifetime' to a large enough
  **   value.  For example, if you want user sessions to stay in your database
  **   for three weeks before deleting them, you need to set gc_maxlifetime
  **   to '1814400'.  At that value, only after a user doesn't log in after
  **   three weeks (1814400 seconds) will his/her session be removed.
  */
  db_query("DELETE FROM sessions WHERE timestamp < %d", time() - $lifetime);
  return 1;
}

?>