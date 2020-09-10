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
// set the timelimit
set_time_limit($CONF['time_limit']);
include_once("lib/export.inc");
$phpMyBackup=new phpMyBackup;
//$phpMyBackup->printHeader();

if(isset($_GET['file']) && isset($_GET['db'])) {
    $phpMyBackup->sqlConnect($CONF['sql_host'],$CONF['sql_usr'],$CONF['sql_pass']);
    $db=mysql_select_db($_GET['db']);
    $theInfoFile=file("export/".$file.".info");
    $theInfoFileArr=explode("|", $theInfoFile[0]);
    $totalBackupSize=$theInfoFileArr[2];

    // if the backup is gziped, uncrompress it
    if($theInfoFileArr[5]==1) {
        $zd = gzopen ("export/".$file.".sql.gz", "r");
        $theFileCont = gzread ($zd, $totalBackupSize);
        gzclose ($zd);
        $theFile=explode("\n",$theFileCont);
    } else {
        // this will do if it's not gziped :)
        $theFile=file("export/".$file.".sql");
    }

    $table_q=array();
    $data_q=array();
    $type="NONE";
    $tables_q=0;
    foreach($theFile as $line_in_file){
        $line_in_file=chop($line_in_file);
        if ($type=="NONE") {
            if(strtolower(substr($line_in_file,0,6))=="insert") {
                $data_q[]=substr($line_in_file,0,strlen($line_in_file)-1);
            } elseif(strtolower(substr($line_in_file,0,6))=="create") {
                $type="TABLE";
                $table_q[$tables_q]=$line_in_file."\n";
            }
        }elseif ($type=="TABLE") {
            if(strtolower(substr($line_in_file,0,1))==")") {
                $type="NONE";
                $table_q[$tables_q] .= $line_in_file."\n";
                $tables_q++;
            } else {
                $table_q[$tables_q] .= $line_in_file."\n";
            }
        }
    }

    $sql_error=0;
    foreach($table_q as $q_data) {
        $q=mysql_query($q_data);
        if($q == 0){
            $sql_error=1;
            //break;
        }
    }
    foreach($data_q as $q_data) {
        $q=mysql_query($q_data);
        if($q == 0){
          //  echo"$q_data\n<br>";
            $sql_error=1;
            //break;
        }
    }
    if($sql_error==1) {
        echo"
		<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\" >
			<tr>	
				<td style=\"padding:10px;\">
				<img  src=\"../../../comu/houdini_alerta.gif\" width=\"19\" height=\"31\" alt=\"Alerta\">
				</td>	
				<td style=\"padding:10px;color: #8B1F30; font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 11px;font-weight: bold;\">				
				No s'ha pogut restaurar la base de dades.<br>Comproveu que la base de dades estigui buida.
				<br><br>
				<a href=\"javascript:history.back();\" style=\"color: #0E449A; font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 10px;text-decoration:none;\"><b>&laquo; Tornar</b></a></font>		
				</td>
			</tr>
		</table>
		";
        //echo mysql_error();
    } else {
		echo"
		<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\" >
			<tr>				
				<td style=\"padding:10px;color: #333333; font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 11px;font-weight: bold;\">				
				La base de dades s'ha restaurat correctament.<br>S'ha importat <b>".sizeof($table_q)."</b> taules, i <b>".sizeof($data_q)."</b> camps.
				<br><br>
				<a href=\"../../../utilitats/index.php\" target=\"_top\" style=\"color: #0E449A; font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 10px;text-decoration:none;\"><b>Continuar &raquo;</b></a></font>
				</td>
			</tr>
		</table>
		";
    }
}

@mysql_close($con);
//$phpMyBackup->printFooter();
?>
