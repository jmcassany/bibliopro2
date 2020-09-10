<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// mySQL connection information

$dades_db = db_url_parser($db_url);

$CONFIG_DBSERVER   = $dades_db['host'];
$CONFIG_DBNAME     = $dades_db['name'];
$CONFIG_DBUSER     = $dades_db['user'];
$CONFIG_DBPASSWORD = $dades_db['passwd'];

function connexio_blog()
{
    if (getenv('testserver')) {
        $DBhost = "localhost";
        $DBuser = "root";
        $DBpass = "dae.woo";
        $DBname = "wordpress";
    }
    else {
        $DBhost = "localhost";
        $DBuser = "deploy";
        $DBpass = "VeptOmriga";
        $DBname = "bibliopro";
    }

    $link = mysql_connect($DBhost,$DBuser,$DBpass) or die("Error NL-BBDD BLOG");
    mysql_set_charset('utf8', $link);
    mysql_select_db ($DBname, $link) or htmlNewsletterError("Error NL-BBDD BLOG");

    return $link;
}

function connexio_houdini()
{
    // => lib
    if (getenv('testserver')) {
        $DBhost = "localhost";
        $DBuser = "root";
        $DBpass = "dae.woo";
        $DBname = "imim_bibliopro";
    }
    else {
        $DBhost = "localhost";
        $DBuser = "deploy";
        $DBpass = "VeptOmriga";
        $DBname = "bibliopro";
    }

    $link = mysql_connect($DBhost,$DBuser,$DBpass) or die("Error NL-BBDD HOUDINI");
    mysql_set_charset('utf8', $link);
    mysql_select_db ($DBname) or htmlNewsletterError("Error NL-BBDD HOUDINI");
    return $link;
}

function connexio_newsletter()
{
    // => lib
    if (getenv('testserver')) {
        $DBhost = "localhost";
        $DBuser = "root";
        $DBpass = "dae.woo";
        $DBname = "imim_bibliopro";
    }
    else {
        $DBhost = "localhost";
        $DBuser = "deploy";
        $DBpass = "VeptOmriga";
        $DBname = "bibliopro";
    }

    $link = mysql_connect($DBhost,$DBuser,$DBpass) or die("Error NL-BBDD NEWSLETTER");
    mysql_select_db ($DBname) or htmlNewsletterError("Error NL-BBDD NEWSLETTER");

    return $link;
}

function desconnexio($result, $link) {
    mysql_free_result($result);
    mysql_close($link);
}
//require_once(dirname(__FILE__).'/../../config.php');

?>
