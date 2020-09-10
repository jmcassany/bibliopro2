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
accessGroupPermCheck('backup_restore');
include_once("lib/main.inc");
include_once("lib/export.inc");

$phpMyBackup=new phpMyBackup;
$phpMyBackup->printHeader();

$handle=opendir('./export');
$all_files=array();

// remove old backups
delOldBackups();

// find the time to remove local backups
while (false !== ($file = readdir($handle))) {
    if ($file != "." && $file != ".." && !is_dir($file)) {
        //check if it is a sql file, and it is in the correct format
        $file_info_arr=explode(".",$file);
        $filtype=$file_info_arr[2];
        if($filtype=="sql") {
            $all_files[]=$file;
        }
    }
}

echo"<br><img src='../../../comu/ico_copia2.gif' width='36' height='18' alt='Restaura unar copia de seguretat anterior' border='0' align='left'><table bgcolor='#FFFFFF' cellspacing='1' cellpadding='2' width='90%'>";

$printed_titles=array();

//natsort($all_files);
arsort($all_files);
foreach($all_files as $file) {
    $file_info1=explode(".", $file);
    $db   = $file_info1[0];
    $time = $file_info1[1];
    if(!isset($printed_titles[$db])) {
        $printed_titles[$db]=1;
        echo"<tr><td colspan='6' bgcolor='#0E449A' height='25'>&nbsp;<b><font  style='font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 11px;color:#FFFFFF'>$db ".$phpMyBackup->confirm_link("sql.php?do=empty_db&db=$db", "Buidar base de dades $db?","<img src='pics/trashcan.gif' border='0' alt='Buidar Base de dades $db' align='absmiddle'>")."</font></b></td></tr>\n";
    }
    $filesize_b=filesize("./export/".$file);
    $filesize=round($filesize_b/1024,0);
    $date=date("j m Y H:i",$time);
    echo "<tr bgcolor='#E5E5E5'><td  bgcolor='#C0CEE4' style='padding:5px;'>$time</td><td style='padding:5px;'>".$date."</td><td style='padding:5px;'>".$filesize." kb</td><td style='padding:5px;'>".$phpMyBackup->confirm_link("import.php?db=$db&file=$db.$time", "Estàs segur que vols restaurar l´arxiu a la base de dades: $db?","restaurar")."</td><td><A HREF='javascript:popUp(\"file_info.php?file=".$db.".".$time.".info\")'>detalls</A></td><td style='padding:5px;border:solid #CCCCCC 1px;' bgcolor='#FFFFFF' align='center'>".$phpMyBackup->confirm_link("sql.php?do=del_file&file=$db.$time", "Estàs segur que vols eliminar l´arxiu guardat: $file ?","<img src='pics/trashcan.gif' border='0' alt='Eliminar'>")."</td></tr>\n";
}

echo"</table>\n<br><br>";
//$phpMyBackup->printFooter();

?>