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

class phpMyBackup {
    function printHeader() {
        global $CONF;
        echo <<< end
<html>
<head>
<style type="text/css">
pre          {color: #333333; font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 11px; text-decoration: none;}
td          {color: #333333; font-family: Verdana, Helvetica, Geneva, sans-serif; font-size: 11px; text-decoration: none;}
.textinput      {font-size: 9px; font-family: verdana;vertical-align:middle; color: #666666; background-color: #dfdfdf; border: 1px solid #666666;}
.checkbox      {font-size: 9px; font-family: verdana;vertical-align:middle; color: #666666; background-color: #dfdfdf; border: 0px;}
.codebuttons    {font-size: 9px; font-family: verdana; vertical-align:middle; color: #666666; background-color: #dfdfdf; border: 1px solid #bbbbbb;}
a {  color: #333333;text-decoration: none}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" language="javascript">
var confirmMsg  = '';
function confirmLink(theLink, theaction)
{


    var is_confirmed = confirm(confirmMsg + ' ' + theaction);
    if (is_confirmed) {
        theLink.href += '&is_js_confirmed=1';
    }

    return is_confirmed;
} // end of the 'confirmLink()' function
</script>
<script language="JavaScript">
<!-- Begin
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=400,height=400');");
}
// End -->
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000" vlink="blue">
<table width="100%" border="0" cellspacing="1" cellpadding="3" align="center" >

  <tr>
    <td >
    <font face="Verdana, Arial, Helvetica, sans-serif" size="1">
end;
    }

    function addLogEntry($time, $text) {

    }


    function redirect($url, $text) {
echo <<< end
<html>
<head>
<title>Please stand by...</title>
<meta http-equiv='refresh' content='2; url=$url'>
<style type='text/css'>
#mainbg  { background-color: #FFFFFF  }
#alt1   { background-color: #EEF2F7  }
TABLE, TR, TD                { font-family:Verdana, Tahoma, Arial;font-size: 10px; color:#000000}
</style
</head>

<body id='mainbg'>
<table width='95%' height='85%'>
<tr>
	<td valign='middle'>
		<table align='center' border="0" cellspacing="1" cellpadding="0" bgcolor="#999999">
		<tr>
			<td id='mainbg'>
				<table width="100%" border="0" cellspacing="1" cellpadding="12">
					<tr>
						<td width="100%" align="center" id='alt1'>
							$text<br><br>
							Esperi un moment, redireccionant la pàgina...<br><br>
							(<a href="$url">O premi aquí si no vol esperar</a>)</td>
					</tr>
				</table>
			</td>
		</tr>
	  </table>
	</td>
</tr>
</table>
</body>
</html>
end;
    }


    function printFooter() {
        echo <<< end
</font>
</td>
  </tr>
  <tr>
    <td bgcolor="#AEBDC9">
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Powered
        by <a href="http://sourceforge.net/projects/pmbackup/">phpMyBackup</a></font></div>
    </td>
  </tr>
</table>
</body>
</html>
end;
    }

    function sqlConnect($host, $uid, $pwd) {
        global $con, $CONF;
        $con=mysql_pconnect($host,$uid, $pwd);
    }

    function confirm_link($url, $msg, $link){
        $html="<a href='$url' onclick=\"return confirmLink(this, '$msg')\">$link</a>";
        return $html;
    }
}

function ftp_store($file) {
    global $CONF;
    $out="";
    // set up basic connection
    $conn_id = ftp_connect($CONF['ftp_server']);

    // login with username and password
    $login_result = ftp_login($conn_id, $CONF['ftp_user'], $CONF['ftp_pass']);

    // check connection
    if ((!$conn_id) || (!$login_result)) {
        $out .= "FTP connection has failed!";
        $out .= "Attempted to connect to $CONF[ftp_server] for user $CONF[ftp_user]";
    }
    if($CONF['ftp_pasv']=="1") {
	    ftp_pasv ($conn_id, 'TRUE');
	}
    // upload the file
    $destination_file = $CONF['ftp_path']."/".$file;
    $source_file = "./export/".$file;
    $upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY);

    // check upload status
    if (!$upload) {
        $out .= "FTP upload has failed!<br>\n";
    } else {
        $out .= "File uploaded to $CONF[ftp_server] as $destination_file<br>\n";
    }

    // close the FTP stream
    if(@function_exists("ftp_close")) {
        ftp_close($conn_id);
    }
    return $out;
}

function delOldBackups() {
    global $CONF;
// remove old backups from ftp server
if(($CONF['del_after_days_ftp'] > 0) && ($CONF['ftp_use'] == 1) && (function_exists('ftp_connect'))) {
    #echo "Attemting to connect!\n";
    $ftp_connection=@ftp_connect($CONF['ftp_server']);
    $ftp_login_result=@ftp_login($ftp_connection, $CONF['ftp_user'], $CONF['ftp_pass']);
    if(!$ftp_login_result || !$ftp_connection) {
        // connection failed
        echo"ERROR: Could not connect to the FTP server!<br>\n";
    } else {
        // yey! connected to the FTP server, lets remove the old backups
        if($CONF['ftp_pasv']=="1") {
	        ftp_pasv($ftp_connection, 'TRUE');

     	}
        // find the time to remove ftp backups backups
        $remove_backups_older_than=time()-($CONF['del_after_days_ftp']*86400);

        // get the file list
        $ftp_files_array=ftp_nlist($ftp_connection, $CONF['ftp_path']);
        if($ftp_files_array != 'FALSE') {

        while(list($file_id,$file_name)=each($ftp_files_array)) {
            $tmp_file=explode("/", $file_name);
            $ftp_file=$tmp_file[sizeof($tmp_file)-1];
            $file_info_arr=explode(".",$ftp_file);

            $filtype=$file_info_arr[2];
            if($filtype=="sql") {
                if(($file_info_arr[1]<$remove_backups_older_than) && ($CONF['del_after_days_ftp'] != 0)) {
                    if(!@ftp_delete ($ftp_connection,$CONF['ftp_path']."/".$file_info_arr[0].".".$file_info_arr[1].".sql")) {
                        ftp_delete ($ftp_connection,$CONF['ftp_path']."/".$file_info_arr[0].".".$file_info_arr[1].".sql.gz");
                    }
                   ftp_delete ($ftp_connection,$CONF['ftp_path']."/".$file_info_arr[0].".".$file_info_arr[1].".info");
                }
            }
        }
        }
        // close the FTP stream
        if(function_exists('ftp_close')) {
            ftp_close($ftp_connection);
        }
    }
}
$handle=opendir('./export');
$remove_backups_older_than=time()-($CONF['del_after_days_local']*86400);
while (false !== ($file = readdir($handle))) {
    if ($file != "." && $file != ".." && !is_dir($file)) {
        //check if it is a sql file, and it is in the correct format
        $file_info_arr=explode(".",$file);
        $filtype=$file_info_arr[2];
        if($filtype=="sql") {
            if(($file_info_arr[1]<$remove_backups_older_than) && ($CONF['del_after_days_local'] != 0)) {
                if(!@unlink("./export/".$file_info_arr[0].".".$file_info_arr[1].".sql")) {
                    unlink("./export/".$file_info_arr[0].".".$file_info_arr[1].".sql.gz");
                }
                unlink("./export/".$file_info_arr[0].".".$file_info_arr[1].".info");
            }
       }
    }
}

}

function getDbList() {

    $db_list = mysql_list_dbs();

    while ($row = mysql_fetch_object($db_list)) {

        if(@mysql_select_db($row->Database)) {

            $list[]=$row->Database;

        }

    }

	return $list;

}

?>
