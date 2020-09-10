<?php
/**
 * @file
 * Database interface code for PEAR database servers.
 */

/**
 * @ingroup database
 * @{
 */

require_once 'DB.php';

/**
 * Initialize a database connection.
 *
 */
function db_connect($url) {
  global $active_db;
  if(isset($active_db) && $active_db) {
    return $active_db;
  }

  $db_handle = DB::connect($url);

  if (DB::isError($db_handle)) {
    return false;
  }

  $db_handle->setFetchMode(DB_FETCHMODE_ASSOC);
  $active_db = $db_handle;

  return $db_handle;
}

/**
 * Helper function for db_query().
 */
function _db_query($query, $debug = 0) {
  global $active_db;
  global $queries, $dev_query;

  if (isset($dev_query) && $dev_query) {
    list($usec, $sec) = explode(' ', microtime());
    $timer = (float)$usec + (float)$sec;
  }

  $result = $active_db->query($query);

  if (isset($dev_query) && $dev_query) {
    list($usec, $sec) = explode(' ', microtime());
    $stop = (float)$usec + (float)$sec;
    $diff = $stop - $timer;
    $queries[] = array($query, $diff);
  }

  if ($debug) {
    print '<p>query: '. $query .'<br />error:'. db_error($active_db) .'</p>';
  }

  if (DB::isError($result)) {
    return false;
  }
  else {
    return $result;
  }
}

/**
 * Fetch one result row from the previous query as an object.
 *
 * @param $result
 *   A database query result resource, as returned from db_query().
 * @return
 *   An object representing the next row of the result. The attributes of this
 *   object are the table fields selected by the query.
 */
function db_fetch_object($result) {
  if ($result) {
    return $result->fetchRow(DB_FETCHMODE_OBJECT);
  }
}

/**
 * Fetch one result row from the previous query as an array.
 *
 * @param $result
 *   A database query result resource, as returned from db_query().
 * @return
 *   An associative array representing the next row of the result. The keys of
 *   this object are the names of the table fields selected by the query, and
 *   the values are the field values for this result row.
 */
function db_fetch_array($result) {
  if ($result) {
    return $result->fetchRow(DB_FETCHMODE_ASSOC);
  }
}

/**
 * Retorna el contingut d'un camp de text
 *
 * @param $table
 *   Nom de la taula en la que fer el select
 * @param $col
 *   Nom de la columna que es del tipus text
 * @param $where
 *   Condicions per obtenir la fila, la condició només ha de fer retornar una fila
 * @return
 *   Valor que conté el camp de text
 *
*/
function db_select_text($table, $col, $where) {

  $last_result = db_query('select '.$col.' from '.$table.' where '.$where);
  if ($last_result == false || db_num_rows($last_result) != 1) {
    /*error*/
    return (null);
  }
  /*correcte, retornar el valor*/
  $ret = db_fetch_array($last_result);
  return ($ret[$col]);
}

/**
 * Modifica el contingut d'un camp de text
 *
 * @param $table
 *   Nom de la taula en la que fer el select
 * @param $col
 *   Nom de la columna que es del tipus text
 * @param $value
 *   Valor a afegir dins del camp de text
 * @param $where
 *   Condicions per obtenir la fila, la condició només ha de fer retornar una fila
 * @return
 *   fals en cas d'error
 *
*/
function db_update_text($table, $col, $value, $where) {

  $last_result = db_query('update '.$table.' set '.$col.'=\'%s\' where '.$where, $value);

  if($last_result == false) {
    return (false);
  }
  return (true);
}

/**
 * Determine how many result rows were found by the preceding query.
 *
 * @param $result
 *   A database query result resource, as returned from db_query().
 * @return
 *   The number of result rows.
 */
function db_num_rows($result) {
  if ($result) {
    return $result->numRows($result);
  }
}

/**
 * Return an individual result field from the previous query.
 *
 * Only use this function if exactly one field is being selected; otherwise,
 * use db_fetch_object() or db_fetch_array().
 *
 * @param $result
 *   A database query result resource, as returned from db_query().
 * @param $row
 *   The index of the row whose result is needed.
 * @return
 *   The resulting field.
 */
function db_result($result, $row = 0) {
  if ($result && $result->numRows($result) > $row) {
    $tmp = $result->fetchRow(DB_FETCHMODE_ORDERED);
    return $tmp[$row];
  }
}

/**
 * Determine whether the previous query caused an error.
 */
function db_error() {
  global $active_db;

  return DB::isError($active_db);
}

/**
 * Determine the number of rows changed by the preceding query.
 */
function db_affected_rows() {
  global $active_db;

  return $active_db->affectedRows();
}

/**
 * Runs a limited-range query in the active database.
 *
 * Use this as a substitute for db_query() when a subset of the query is to be
 * returned.
 * User-supplied arguments to the query should be passed in as separate parameters
 * so that they can be properly escaped to avoid SQL injection attacks.
 *
 * @param $query
 *   A string containing an SQL query.
 * @param ...
 *   A variable number of arguments which are substituted into the query using
 *   printf() syntax. Instead of a variable number of query arguments, you may
 *   also pass a single array containing the query arguments.
 * @param $from
 *   The first result row to return.
 * @param $count
 *   The maximum number of result rows to return.
 * @return
 *   A database query result resource, or FALSE if the query was not executed
 *   correctly.
 */
function db_query_range($query) {
  global $active_db, $queries, $dev_query;

  if (isset($dev_query) && $dev_query) {
    list($usec, $sec) = explode(' ', microtime());
    $timer = (float)$usec + (float)$sec;
  }

  $args = func_get_args();
  $count = array_pop($args);
  $from = array_pop($args);
  if (count(func_get_args()) > 3) {
    $args = array_map('check_query', $args);
    $query = db_prefix_tables($query);
    $args[0] = $query;
    $result = $active_db->limitQuery(call_user_func_array('sprintf', $args), $from, $count);
  }
  else {
    $query = func_get_arg(0);
    $query = db_prefix_tables($query);
    $result = $active_db->limitQuery( $query, $from, $count);
  }

  if (isset($dev_query) && $dev_query) {
    list($usec, $sec) = explode(' ', microtime());
    $stop = (float)$usec + (float)$sec;
    $diff = $stop - $timer;
    $queries[] = array($query. ' [LIMIT '. $from .', '. $count .']', $diff);
  }

  if (DB::isError($result)) {
    return false;
  }
  else {
    return $result;
  }
}

/**
 * Returns a properly formatted Binary Large OBject value.
 *
 * @param $data
 *   Data to encode.
 * @return
 *  Encoded data.
 */
function db_encode_blob($data) {
  return $data;
}

/**
 * Returns text from a Binary Large OBject value.
 *
 * @param $data
 *   Data to decode.
 * @return
 *  Decoded data.
 */
function db_decode_blob($data) {
  return $data;
}

/**
 * Prepare user input for use in a database query, preventing SQL injection attacks.
 */
function db_escape_string($text) {
  global $active_db;
  return $active_db->escapeSimple($text);
}

function db_free_result($result) {
  $result->free();
}

function db_close() {
  global $active_db;
  $active_db->disconnect();
  $active_db = null;
}


/**
 * @} End of "ingroup database".
 */

?>