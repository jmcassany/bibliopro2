<?php

define('TO_XML', 0);
define('TO_HTML', 1);
define('TO_CSV', 2);
define('TO_SQL', 3);


class db_exporter {

    var $connection_id = 0;
    var $selected_table;
    var $selected_fields;
    var $export_target;

    function db_connect() {
        global $CFG;
        if ($this->connection_id = mysql_connect($CFG['dbhost'] . ':' . $CFG['dbport'], $CFG['dbuser'], $CFG['dbpass'])) {
            if(!mysql_select_db($CFG['dbname'])) {
                print("<b>Error while selecting database</b><br />");
                return FALSE;
                exit;
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_tables() {
        if (!$this->connection_id) {
            $this->db_connect();
        }
        if ($result = mysql_query("SHOW TABLES")) {
            for($x=0; $x<mysql_num_rows($result); $x++) {
                $row = mysql_fetch_row($result);
                $tables[] = $row[0];
            }
            return $tables;
        } else {
            return FALSE;
        }
    }

    function get_fields() {
         if (!$this->connection_id) {
            $this->db_connect();
        }
        if ($result = mysql_query("DESC $this->selected_table")) {
            for($x=0; $x<mysql_num_rows($result); $x++) {
                $row = mysql_fetch_row($result);
                $fields[] = $row[0];
            }
            return $fields;
        } else {
            return FALSE;
        }
    }

    function export() {
        switch ($this->export_target) {
            case TO_XML:
                $this->exp_to_xml();
                break;
            case TO_HTML:
                $this->exp_to_html();
                break;
            case TO_SQL:
                $this->exp_to_sql();
                break;
            case TO_CSV:
                $this->exp_to_csv();
                break;
        }
    }

    function exp_to_xml() {
        ob_start();
        if (!$this->connection_id) {
            $this->db_connect();
        }
        $data = '<?xml version="1.0" encoding="utf-8" ?>';
        $data .= "<database>";
        $result = mysql_query("SELECT " . implode(",", $this->selected_fields) . " FROM " . $this->selected_table);
        if ($result) {
            for($x=0; $x<mysql_num_rows($result); $x++) {
                $data .= '<record>';
                $row = mysql_fetch_assoc($result);
                foreach($row AS $key => $value) {
                    $data .= '<field>';
                    $data .= '<key>' . $key . '</key>';
                    $data .= '<value>' . htmlspecialchars($value) . '</value>';
                    $data .= '</field>';
                }
                $data .= '</record>';
            }
        }
        $data .= "</database>";
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=export.xml");
        header("Pragma: no-cache");
        header("Expires: 0");
        print($data);
        ob_end_flush();
    }

    function exp_to_html() {
        ob_start();
        if (!$this->connection_id) {
            $this->db_connect();
        }
        $data = '<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=utf-8">';
        $data .= '<caption align="top">Table: ' . $this->selected_table . '</caption>';
        $data .= '<table width="100%" cellpadding="1" cellspacing="0" border="1">';
        $data .= '<tr>';
        foreach($this->selected_fields AS $value) {
            $data .= '<td><b>' . htmlspecialchars($value) . '</b></td>';
        }
        $data .= '</tr>';
        $result = mysql_query("SELECT " . implode(",", $this->selected_fields) . " FROM " . $this->selected_table);
        if($result) {
            for($x=0; $x<mysql_num_rows($result); $x++) {
                $row = mysql_fetch_assoc($result);
                $data .= '<tr>';
                foreach($row AS $value) {
                    $data .= '<td>' . htmlspecialchars($value) . '</td>';
                }
                $data .= '</tr>';
            }
        }
        $data .= '</table>';
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=export.html");
        header("Pragma: no-cache");
        header("Expires: 0");
        print($data);
        ob_end_flush();
    }

    function exp_to_csv() {
        ob_start();
        if (!$this->connection_id) {
            $this->db_connect();
        }
        $data = '"' . implode('";"', $this->selected_fields) . "\";\n";
        $result = mysql_query("SELECT " . implode(",", $this->selected_fields) . " FROM " . $this->selected_table);
        if($result) {
            for($x=0; $x<mysql_num_rows($result); $x++) {
                $row = mysql_fetch_assoc($result);
                foreach($row AS $value) {
                    $data .= '"' .addslashes($value) . '";';
                }
                $data .= "\n";
            }
        }
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=export.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        print($data);
        ob_end_flush();
    }

    function exp_to_sql() {
        ob_start();
        if (!$this->connection_id) {
                $this->db_connect();
        }
        $result = mysql_query("SELECT " . implode(",", $this->selected_fields) . " FROM " . $this->selected_table);
        if($result) {
            for($x=0; $x<mysql_num_rows($result); $x++) {
                $row = mysql_fetch_assoc($result);
                $keys = array_keys($row);
                $values = array_values($row);
                foreach($values AS $key=>$value) {
                    $vals[] = str_replace($value, "'$value'", $value);
                }
                $data .= 'INSERT INTO ' . $this->selected_table . ' (' . implode(",", $keys) . ') VALUES (' . implode(",", $vals) . ');';
                $data .= "\n";
                unset($vals);
            }
        }
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=export.sql");
        header("Pragma: no-cache");
        header("Expires: 0");
        print($data);
        ob_end_flush();
    }
}

?>