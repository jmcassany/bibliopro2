<?php

/*This code is based on drupal database wrapper*/

function db_url_parser($db_url, $port = 0) {
  $url = parse_url($db_url);
  if ($port == 1 && isset($url['port'])) {
    $db['port'] = $url['port'];
  }
  else if (isset($url['port'])) {
     $url['host'] = $url['host'] .':'. $url['port'];
  }
  $db['name'] = substr($url['path'], 1);
  $db['host']   = $url['host'];
  $db['user']    = $url['user'];
  $db['passwd']   = $url['pass'];
  return ($db);
}


/**
 * Append a database prefix to all tables in a query.
 *
 * @param $sql
 *   A string containing a partial or entire SQL query.
 * @return
 *   The properly-prefixed string.
 */
function db_prefix_tables($sql) {
  global $db_prefix;

  //return strtr($sql, array('{' => $db_prefix, '}' => ''));
  return $sql;
}


/**
 * Runs a basic query in the active database.
 *
 * User-supplied arguments to the query should be passed in as separate parameters
 * so that they can be properly escaped to avoid SQL injection attacks.
 *
 * @param $query
 *   A string containing an SQL query.
 * @param ...
 *   A variable number of arguments which are substituted into the query using
 *   printf() syntax. Instead of a variable number of query arguments, you may
 *   also pass a single array containing the query arguments.
 * @return
 *   A database query result resource, or FALSE if the query was not executed
 *   correctly.
 */
function db_query($query) {
  $args = func_get_args();
  $query = db_prefix_tables($query);
  if (count($args) > 1) {
    if (is_array($args[1])) {
      $args = array_merge(array($query), $args[1]);
    }
    $args = array_map('db_escape_string', $args);
    $args[0] = $query;
    $query = call_user_func_array('sprintf', $args);
  }
  return _db_query($query);
}

/**
 * Debugging version of db_query().
 *
 * Echoes the query to the browser.
 */
function db_queryd($query) {
  $args = func_get_args();
  $query = db_prefix_tables($query);
  if (count($args) > 1) {
    if (is_array($args[1])) {
      $args = array_merge(array($query), $args[1]);
    }
    $args = array_map('db_escape_string', $args);
    $args[0] = $query;
    $query = call_user_func_array('sprintf', $args);
  }
  return _db_query($query, 1);
}


/* Initialize the default database. */
$db_type = substr($db_url, 0, strpos($db_url, '://'));

if ($db_type == 'mysql') {
   include_once ('database/database.mysql.inc');
}
else if ($db_type == 'mysqli') {
   include_once ('database/database.mysqli.inc');
}
else if ($db_type == 'pgsql') {
   include_once ('database/database.pgsql.inc');
}
else {
   include_once ('database/database.pear.inc');
}


?>
