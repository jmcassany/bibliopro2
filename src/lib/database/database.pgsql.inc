<?php
/**
 * @file
 * Database interface code for PostgreSQL database servers.
 */

/**
 * @ingroup database
 * @{
 */

/**
 * Initialize a database connection.
 *
 */
function db_connect($url) {
  global $active_db;
  if(isset($active_db) && $active_db) {
    return $active_db;
  }
  $url = parse_url($url);

  $conn_string = ' user='. $url['user'] .' dbname='. substr($url['path'], 1) .' password='. $url['pass'] . ' host=' . $url['host'];
  if (isset($url['port'])) {
    $conn_string .= ' port=' . $url['port'];
  }
  $connection = @pg_connect($conn_string);
  $active_db = $connection;
  if (!$connection) {
    return false;
  }

  return $connection;

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

  $result = pg_query($active_db, $query);

  if (isset($dev_query) && $dev_query) {
    list($usec, $sec) = explode(' ', microtime());
    $stop = (float)$usec + (float)$sec;
    $diff = $stop - $timer;
    $queries[] = array($query, $diff);
  }

  if ($debug) {
    print '<p>query: '. $query .'<br />error:'. pg_last_error() .'</p>';
  }

  if ($last_result !== FALSE) {
    return $result;
  }
  else {
    //trigger_error(mysql_error($active_db) ."\nquery: ". htmlspecialchars($query), E_USER_ERROR);
    //return (mysql_error($active_db));
    return false;
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
    return pg_fetch_object($result);
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
    $ret = pg_fetch_assoc($result);
    $upper = array();
    foreach ($ret as $key => $value) {
      $upper[strtoupper($key)] = $value;
    }
    return $upper;
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
  return ($ret[strtolower($col)]);
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
    return pg_num_rows($result);
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
  if ($result && pg_num_rows($result) > $row) {
    $res = pg_fetch_row($result, $row);

    return $res[0];
  }
}

/**
 * Determine whether the previous query caused an error.
 */
function db_error() {
  return pg_last_error();
}

/**
 * Determine the number of rows changed by the preceding query.
 */
function db_affected_rows() {
  global $active_db;
  return pg_affected_rows($active_db);
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
  $args = func_get_args();
  $count = array_pop($args);
  $from = array_pop($args);

  $query = db_prefix_tables($query);
  if (count(func_get_args()) > 3) {
    // Check for array (alternative syntax).
    if (is_array($args[1])) {
      $args = array_merge(array($query), $args[1]);
    }
    $args = array_map('db_escape_string', $args);
    $args[0] = $query;
    $query = call_user_func_array('sprintf', $args);
  }
  $query .= ' LIMIT '. $count .' OFFSET '. $from;
  return _db_query($query);
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
  return addcslashes($data, "\0..\37\\");
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
  return stripcslashes($data);
}

/**
 * Prepare user input for use in a database query, preventing SQL injection attacks.
 */
function db_escape_string($text) {
  return pg_escape_string($text);
}

function db_free_result($result) {
  pg_free_result($result);
}

function db_close() {
  global $active_db;
  pg_close($active_db);
  $active_db = null;
}


/**
 * @} End of "ingroup database".
 */

?>