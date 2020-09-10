<?php
/************************************************************************/
/* phpMyBakcup                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2002 by Audun Larsen                                   */
/* http://sourceforge.net/projects/pmbackup/                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the QPL License, included in this package.     */
/************************************************************************/

include_once("global_conf.php");

?>

<html>
<head>
<style type="text/css">
pre         {color: #333333; font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 11px; text-decoration: none;}
td          {color: #333333; font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 11px; text-decoration: none;}
body        {color: #333333; font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 11px; text-decoration: none;}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body text="#000000">

<br>
<?php

if(isset($_GET['file'])) {
    $file_info_tmp=implode("",file("export/".$_GET['file']));
    $fil_info=explode("|",$file_info_tmp);
    $date=date("j m Y H:i",$fil_info[0]);
    $database=$fil_info[1];
    $size=$fil_info[2];
    $tables=$fil_info[3];
    $data=$fil_info[4];
    $isGziped=$fil_info[5];
    $comments=str_replace("\r\n","<br>\n",$fil_info[6]);
    echo"<table>\n";
    echo"<tr><td><b>Data:</b></td><td>$date</td></tr>\n";
    echo"<tr><td><b>Base de dades:</b></td><td>$database</td></tr>\n";
    echo"<tr><td><b>Backup pes:</b></td><td>$size bytes</td></tr>\n";
	$tables = str_replace("yes", "Si", $tables);
    echo"<tr><td><b>Conté taules:</b></td><td>$tables</td></tr>\n";
	$data = str_replace("yes", "Si", $data);
    echo"<tr><td><b>Conté dades:</b></td><td>$data</td></tr>\n";
    //echo"<tr><td><b>Està comprimida:</b></td><td>$isGziped</td></tr>\n";
    echo"<tr><td colspan='2'>&nbsp;</td></tr>\n";
    echo"<tr><td colspan='2'><b>Comentaris:</b></td></tr>\n";
    echo"<tr><td colspan='2'>$comments</td></tr>\n";

    echo"</table>\n";
    echo"<br>\n[<a href=\"javascript:onClick= window.close()\">tancar</a>]";
} else{
    echo"<b>Cap arxiu seleccionat!</b>";
}
?>
</body>
</html>

