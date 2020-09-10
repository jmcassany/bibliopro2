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
accessGroupPermCheck('backup_make');
include_once("lib/main.inc");
include_once("lib/export.inc");
include_once("../../../config.php");

// set the timelimit
set_time_limit($CONF['time_limit']);

if(isset($argv[1])) {
    $mode="shell";
    $_POST['db']=$argv[1];
    $_POST['data']="on";
    $_POST['tables']="on";
} else {
    $mode="web";
}

$phpMyBackup=new phpMyBackup;
if($mode=="web") {
    $phpMyBackup->printHeader();
}

if(isset($_POST['db'])) {
    delOldBackups();
    $exportLib=new dropTable;
    $phpMyBackup->sqlConnect($CONF['sql_host'],$CONF['sql_usr'],$CONF['sql_pass']);
    if($mode=="web") {
        if($_POST['db']=="multiple") {
            $db_list=explode(",", $_POST['db_list']);
        } elseif($_POST['db']=="all") {
	    $db_list=getDbList();
		} else {
            $db_list[]=$_POST['db'];
        }
    } else {
         if($_POST['db']=="all") {
		     $db_list=getDbList();
		 } else {
             $db_list=explode(",",$_POST['db']);
		}
    }
    foreach($db_list as $export_db) {
    if(!mysql_select_db($export_db,$con)) {
        echo"ERROR: Could not select db $export_db<br><br>\n\n";
    } else {
    $exportLib->dbName=$export_db;
    $fileData=$exportLib->structure();
    $time=time();

    // see if zlib is installed
    if (function_exists('gzopen')) {
        // open file for writing with maximum compression
        $zp = gzopen("./export/".$exportLib->dbName.".".$time.".sql.gz", "w9");
        gzwrite($zp, $fileData);
        gzclose($zp);
        $BackupFileName=$exportLib->dbName.".".$time.".sql.gz";
        $BackupIsGziped=1;
    } else {
        // write file old fasion way :(
        $fp=fopen("./export/".$exportLib->dbName.".".$time.".sql", "w");
        fwrite($fp,$exportLib->structure());
        fclose($fp);
        $BackupIsGziped=0;
        $BackupFileName=$exportLib->dbName.".".$time.".sql";
    }

    //$fp=fopen("./export/".$exportLib->dbName.".".$time.".sql", "w");
    //fwrite($fp,$exportLib->structure());
    //fclose($fp);

    $backup_size=strlen($fileData);

    if(isset($_POST['data']) && $_POST['data']=="on") {
        $store_data="yes";
    } else {
        $store_data="no";
    }

    if(isset($_POST['tables']) && $_POST['tables']=="on") {
        $store_tables="yes";
    } else {
        $store_tables="no";
    }

    $fp=fopen("./export/".$exportLib->dbName.".".$time.".info", "w");
    $comments=str_replace("|","l",$_POST['comments']);
    fwrite($fp,"$time|$export_db|$backup_size|$store_tables|$store_data|$BackupIsGziped|$comments");
    fclose($fp);

    chmod("./export/".$BackupFileName,0777);
    chmod("./export/".$exportLib->dbName.".".$time.".info",0777);


    if($CONF['ftp_use']==1 && function_exists('ftp_connect')) {
        $ftp=ftp_store($BackupFileName);
        $ftp .= ftp_store($exportLib->dbName.".".$time.".info");
    }

    if($mode=="web") {
        echo"L'arxiu ha estat guardat amb èxit com: ".$BackupFileName."<br>\n<br><a href=\"export/$BackupFileName\" target=\"_blank\">Descarregar</a>\n";
        if(isset($ftp)) {
            echo $ftp;
        }
        echo"<br><br>\n\n";
    }
    }
    }


}elseif(!isset($_POST['db']) && $mode=='web') {
    echo '<form action="export.php" method="post">
    ';
	echo '<input type="hidden" name="db" value="'.$CONF['sql_dbname'].'">
    ';
    /*
	echo"<b>Select database to export:</b><br>\n";
    echo"<select name='db'>\n";
    echo"<option value='multiple'>From list</option>";
    echo "<option value='all'>all available</option>\n";
	echo "<option value='houdini'>houdini</option>\n";
    $phpMyBackup->sqlConnect($CONF['sql_host'],$CONF['sql_usr'],$CONF['sql_pass']);
    $db_list = mysql_list_dbs();
    while ($row = mysql_fetch_object($db_list)) {
        if(@mysql_select_db($row->Database)) {
            echo "<option value='".$row->Database . "'>".$row->Database."</option>\n";
        }
    }

    echo"</select>\n";

    echo"<br>\n";

    echo"<b>Or enter several databases seperated with commas(,).</b><br><input type='text' name='db_list'><br>\n";
	*/
	 echo"<table cellpadding='0' cellspacing='0' border='0' width='350'>
	 	<tr>
			<td width='36' rowspan='2' valign='top'><img src='../../../comu/ico_copia1.gif' width='36' height='18' alt='Fer una copia de seguretat' border='0' vspace='2'></td>
			<td bgcolor='#0E449A' style='padding:5px;font-weight:bold;font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 11px;color:#FFFFFF'>Fer una copia de seguretat</td>
		</tr><tr><td bgcolor='#E6E6E6' style='padding-left:15px;'>
	 ";
    echo"<br>\n<font style='font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 11px;color:#0E449A'>Notes</font><br>\n";
    echo"<textarea name='comments' rows='5' cols='30' style='margin-top:2px;'></textarea>\n";
    //echo"<br>\n<input type='checkbox' name='tables' checked><b>Guardar taules</b>";
    //echo"<br>\n<input type='checkbox' name='data' checked><b>Guardar dades</b>";
	echo "<input type='hidden' name='tables' value='on'><input type='hidden' name='data' value='on'>";
    echo"<br>\n<br>\n<input type='submit' value='Guardar'>\n";
    echo"</form></td></tr></table>";
}

@mysql_close($con);

if($mode=="web") {
    //$phpMyBackup->printFooter();
}

?>