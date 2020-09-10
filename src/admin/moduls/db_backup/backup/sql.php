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


switch($do) {
    case "empty_db":
    if(isset($_GET['db'])) {
        $phpMyBackup->sqlConnect($CONF['sql_host'],$CONF['sql_usr'],$CONF['sql_pass']);
        $db=mysql_select_db($_GET['db']);
        $res=mysql_list_tables($_GET['db']);
        $nt=mysql_num_rows($res);
        for ($a=0;$a<$nt;$a++) {
            $row=mysql_fetch_row($res);
            $tablename=$row[0];
            if (in_array($tablename, $CONF['exclude_tables'])) {
              continue;
            }
            $q=mysql_query("drop table `".$tablename."`");

        }
        $phpMyBackup->redirect($_SERVER['HTTP_REFERER'],"Base de dades buida");
        echo mysql_error();
        @mysql_close($con);
    } else {
        echo"Cap taula seleccionada.";
    }
    break;

    case "del_file":
    if(isset($_GET['file'])) {
        if(unlink("./export/".$_GET['file'].".info")) {
            if(!@unlink("./export/".$_GET['file'].".sql.gz")) {
                unlink("./export/".$_GET['file'].".sql");
            }
            $phpMyBackup->redirect($_SERVER['HTTP_REFERER'],"Arxiu eliminat");
        }
    }
    break;
}


?>
