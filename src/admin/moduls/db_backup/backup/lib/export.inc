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

class dropTable{
    var $dbName;
    function structure() {
        global $con, $CONF;
        $out="";
        $res=mysql_list_tables($this->dbName);
        $nt=mysql_num_rows($res);
        for ($a=0;$a<$nt;$a++) {
            $row=mysql_fetch_row($res);
            $tablename=$row[0];
            if (in_array($tablename, $CONF['exclude_tables'])) {
              continue;
            }
            $res2=mysql_query('SHOW CREATE TABLE ' . $this->dbName . '.' . $tablename);
            $tmpres        = mysql_fetch_array($res2);
            if(isset($_POST['tables']) && $_POST['tables'] == "on") {
                $out .= $tmpres[1];
                $out .= "\n\n";
            }
            if(isset($_POST['data']) && $_POST['data'] == "on") {
                $res2=mysql_query("select * from `$tablename`");
                $nf=mysql_num_fields($res2);
                $nr=mysql_num_rows($res2);
                for ($c=0;$c<$nr;$c++){
                    $out .= "insert into `$tablename` values (";
                    $row=mysql_fetch_row($res2);
                    for ($d=0;$d<$nf;$d++) {
                        $data=strval($row[$d]);
                        $out .="'".mysql_escape_string($data)."'";
                        if ($d<($nf-1)) {
                            $out .=", ";
                        }
                    }
                $out .=");\n";
                }
            }
        }
    $out .= "";
    echo mysql_error();
    return $out;
    }
}

?>
