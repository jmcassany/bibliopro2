<?php 

define('FROM_XML', 0);
define('FROM_CSV', 2);
define('FROM_SQL', 3);


require_once('imp.config.inc.php');

class db_importer {
    
    var $connection_id = 0;
    var $source_file;
    var $import_source;
    var $target_source;
    var $target_table;
    
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
    
    function import() {
        switch($this->import_source) {
            case FROM_XML:
                $this->import_from_xml();
                break;
            case FROM_CSV:
                $this->import_from_csv();
                break;
            case FROM_SQL:
                $this->import_from_sql();
                break;   
        }   
    }
    
    function import_from_xml() {
        if (!$this->connection_id) {
            $this->db_connect();   
        }  
        $fp = fopen($this->source_file, 'r');
        $data = fread($fp, filesize($this->source_file));
        preg_match_all("/<record>(.*?)<\/record>/", $data, $records);
        foreach($records[1] AS $rec) {
            preg_match_all("/<field>(.*?)<\/field>/", $rec, $fields);
            foreach($fields[1] AS $field) {
                preg_match_all("/<key>(.*?)<\/key>/", $field, $key);
                preg_match_all("/<value>(.*?)<\/value>/", $field, $value);
                $keys[] = $key[1][0];
                $values[] = $value[1][0];
            }
            mysql_query("INSERT INTO " . $this->target_table . " (" . implode(',', $keys) . ") VALUES ('" . implode('\',\'', $values) . "')") or 
                die(mysql_error());
            unset($keys);
            unset($values);
        }
        echo "Los datos han sido importados";
        mysql_close($this->connection_id);
        fclose($fp);
    }
    
    function import_from_csv() {
        if (!$this->connection_id) {
              $this->db_connect();   
        }
        $fp = fopen($this->source_file, 'r');
        $fields = trim(fgets($fp));
        $fields = str_replace('";"', ', ', $fields);
        $fields = str_replace('"', '', $fields);
        $fields = substr($fields, 0, -1);
        while(!feof($fp)) {
            $values = trim(fgets($fp));
            if(strlen($values)>0) {
                $values = str_replace('";"', '\', \'', $values);
                $values = preg_replace('/([^\\\]|^)"/', "\\1'", $values);
                $values = stripslashes($values);
                $values = substr($values, 0, -1);
                mysql_query("INSERT INTO " . $this->target_table . " (" . $fields . ") VALUES (" . $values . ")") or
                    die(mysql_error());
            }
        }
        echo "Los datos han sido importados";
        mysql_close($this->connection_id);
        fclose($fp);
    }
    
    function import_from_sql() {
        if (!$this->connection_id) {
              $this->db_connect();   
        }   
        $fp = fopen($this->source_file, 'r'); 
        while(!feof($fp)) {
            mysql_query(trim(fgets($fp)))
                or die(mysql_errno());   
        }
        echo "Los datos han sido importados";
        mysql_close($this->connection_id);
        fclose($fp);
    }

}
?>