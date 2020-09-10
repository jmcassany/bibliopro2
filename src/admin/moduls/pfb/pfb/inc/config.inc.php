<?php

$cfg = array();

// pfb version, don't change it
$cfg[ 'version' ]    = '3.27';

// pfb language
$cfg[ 'lang' ]       = 'ca';

// date format
$cfg[ 'dateFormat' ] = '%d.%m.%Y %H:%M';

// auto-logoff (in seconds)
//$cfg[ 'autoLogoff' ] = 600;

// access only with password
//$cfg[ 'usePass' ]    = false;

// guests password
//$cfg[ 'guestPass' ]  = 'pass';

// admin password
//$cfg[ 'adminPass' ]  = 'adminpass';

// 'hidden' dirs/files
$cfg[ 'dontShow' ]   = array( 'img', 'smarty' );

// list of files with source display option
$cfg[ 'source' ]     = array(); //array('html', 'php', 'css');

$cfg['wrong'] = array(); //array( 'php', 'php4', 'php5', 'htm', 'html', 'pl' );

ini_set( 'arg_separator.output', '&amp;' );

?>