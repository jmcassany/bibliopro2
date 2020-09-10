<?php

include_once("database/database.inc");

class dbCards {
	function dbCards($table = 'CARDS')
	{
		$this->Error = '';
		$this->Ok = true;
		$this->Table = $table;
	}
	function listCards($number = 0, $category1 = '', $category2 = '')
	{
		global $ECLASS, $LANG;
		global $db_url;
		global $CARDS_LISTLENGTH, $CARDS_LISTFILTER, $CARDS_LISTSORTBY;
		$self = "listCards($number, $category1, $category2)";
		$page = array();
		if ($category1 != '') {
			$category1 = (int)$category1;
		}
		if ($category2 != '') {
			$category2 = (int)$category2;
		}
		if ($number == 0) {
			$off = 0;
			$max = 9999;
		} else {
			$off = ($number-1) * $CARDS_LISTLENGTH;
			$max = $CARDS_LISTLENGTH;
		}
		if (isset($ECLASS)) {
		  $filter = " ECLASS='$ECLASS'";
		}
		else {
		  $filter = " 1=1";
		}
		if ($category1 != '') {
			$filter .= " and CATEGORY1='$category1'";
		}
		if ($category2 != '') {
			$filter .= " and CATEGORY2='$category2'";
		}
		if (!empty($CARDS_LISTFILTER)) {
		   $filter .= " and $CARDS_LISTFILTER";
        }
		$TABLE = $this->Table;
		$query = "select * from $TABLE where $filter order by $CARDS_LISTSORTBY";
//		db_query($query);
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query_range($query, $off, $max);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		} while ($hash = @db_fetch_array($idq)) {
//			foreach($hash as $key => $value) {
//				$hash[$key] = stripslashes($value);
//			}
			$page[] = $hash;
		}
		return($page);
	}
	function readCard($id)
	{
		global $ECLASS, $LANG;
		global $db_url;
		$self = "readCard($id)";
		$id = (int)$id;
		$TABLE = $this->Table;
		$query = "select * from $TABLE where ID='$id'";
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		}
		$hash = @db_fetch_array($idq);
//		foreach($hash as $key => $value) {
//			$hash[$key] = stripslashes($value);
//		}
		return($hash);
	}
	function randomCard($category1 = '', $category2 = '')
	{
		global $ECLASS, $LANG;
		global $db_url;
		global $CARDS_LISTFILTER;
		$self = "randomCard($category1, $category2)";
		$list = array();
		if ($category1 != '') {
			$category1 = (int)$category1;
		}
		if ($category2 != '') {
			$category2 = (int)$category2;
		}
		$filter = " ECLASS='$ECLASS'";
		if ($category1 != '') {
			$filter .= " and CATEGORY1='$category1'";
		}
		if ($category2 != '') {
			$filter .= " and CATEGORY2='$category2'";
		}
		if (!empty($CARDS_LISTFILTER)) {
		   $filter .= " and $CARDS_LISTFILTER";
        }
		$TABLE = $this->Table;
		$query = "select ID from $TABLE where $filter";
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		} while ($hash = @db_fetch_array($idq)) {
			$list[] = $hash['ID'];
		}
		srand((double)microtime() * 1000000);
		$winner = $list[rand(0, count($list)-1)];
		return($this->readCard($winner));
	}
	function newCard($data)
	{
		global $CARDS_FIELDS;
		global $db_url;
		$self = "newCard()";
		$names = '';
		$values = '';
		foreach($data as $name => $value) {
			if (!isset($CARDS_FIELDS[$name])) {
				continue;
			}
			$type = $CARDS_FIELDS[$name][1];
			if ($type == 'NUMBER' || $type == 'ITEM') {
				$values .= ", " . (int)$value;
			}
			if ($type == 'FLAG' || $type == 'CHAR' || $type == 'TEXT' || $type == 'DATE') {
				$values .= ", '" . addslashes($value) . "'";
			}
			$names .= ", $name";
		}
		$names = substr($names, 2);
		$values = substr($values, 2);
		$TABLE = $this->Table;
		$query = "insert into $TABLE ($names) VALUES ($values)";
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		}
//		$id = @db_insert_id();
        $idq = @db_query("select max(ID) as MAXID from ".$TABLE);
        $row = @db_fetch_array($idq);
		return($row['MAXID']);
	}
	function updateCard($id, $data)
	{
		global $CARDS_FIELDS;
		global $db_url;
		$self = "updateCard($id)";
		$id = (int)$id;
		$pairs = '';
		$names = '';
		foreach($data as $name => $value) {
			if (!isset($CARDS_FIELDS[$name])) {
				continue;
			}
			$type = $CARDS_FIELDS[$name][1];
			if ($type == 'NUMBER' || $type == 'ITEM') {
				$pairs .= ", $name=" . (int)$value;
			}
			if ($type == 'FLAG' || $type == 'CHAR' || $type == 'TEXT' || $type == 'DATE') {
				$pairs .= ", $name='" . addslashes($value) . "'";
			}
			$names .= ", $name";
		}
		$pairs = substr($pairs, 2);
		$TABLE = $this->Table;
		$query = "update $TABLE SET $pairs where ID=$id";
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		}
	}
	function deleteCard($id)
	{
		global $CARDS_FIELDS, $CONFIG_PATHUPLOAD;
		global $db_url;
		$self = "deleteCard($id)";
		foreach($CARDS_FIELDS as $name => $values) {
			$type = $CARDS_FIELDS[$name][1];
			if ($type == 'IMAGE' || $type == 'FILE') {
				system("rm " . $CONFIG_PATHUPLOAD . $this->UploadPath($id, $name, '*'));
			}
		}
		$id = (int)$id;
		$TABLE = $this->Table;
		$query = "delete from $TABLE where ID=$id";
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		}
	}
	function readFile($id, $field)
	{
		global $ECLASS, $LANG;
		global $db_url;
		$self = "readImage($id,$field)";
		$id = (int)$id;
		$FIELD = strtoupper($field);
		$TABLE = $this->Table;
		$query = "select $FIELD from $TABLE where ID='$id'";
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		}
		$hash = @db_fetch_array($idq);
//		foreach($hash as $key => $value) {
//			$hash[$key] = stripslashes($value);
//		}
		return($hash);
	}
	function deleteFile($id, $field)
	{
		global $CARDS_FIELDS, $CONFIG_PATHUPLOAD;
		global $db_url;
		$self = "deleteFile($id,$field)";
		$id = (int)$id;
		$field = strtoupper($field);
		if (!isset($CARDS_FIELDS[$field])) {
			$this->error($self . ' 0: Invalid Fieldname.');
			return;
		}
		system("rm " . $CONFIG_PATHUPLOAD . $this->UploadPath($id, $field, '*'));
		$TABLE = $this->Table;
		$query = "update $TABLE SET $field='' where ID=$id";
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		}
	}
	function updateFile($id, $field, $path)
	{
		global $CARDS_FIELDS;
		global $db_url;
		$self = "updateFile($id,$field,$path)";
		$id = (int)$id;
		$field = strtoupper($field);
		if (!isset($CARDS_FIELDS[$field])) {
			$this->error($self . ' 0: Invalid Fieldname.');
			return;
		}
		if (!file_exists($path)) {
			$this->error($self . ' 0: Inexistent File.');
			return;
		}
		$type = $CARDS_FIELDS[$field][1];
		if ($type == 'IMAGE') {
			list($width, $height, $type, $html) = GetImageSize($path);
			$bits = explode(".", $path);
			$nbits = count($bits);
			$ext = strtolower($bits[$nbits-1]);
			$bytes = sprintf("%08d", filesize($path));
			$width = sprintf("%04d", $width);
			$height = sprintf("%04d", $height);
			$filename = sprintf("%04d%s", $id, strtolower($field));
			$value = "$bytes.$width.$height.$filename.$ext";
		}
		if ($type == 'FILE') {
			$bits = explode(".", $path);
			$nbits = count($bits);
			$ext = strtolower($bits[$nbits-1]);
			$downs = sprintf("%08d", 0);
			$bytes = sprintf("%08d", filesize($path));
			$filename = sprintf("%04d%s", $id, strtolower($field));
			$value = "$downs.$bytes.$filename.$ext";
		}
		$TABLE = $this->Table;
		$query = "update $TABLE SET $field='$value' where ID=$id";
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		}
	}
	function countCards($category1 = '', $category2 = '')
	{
		global $ECLASS;
		global $db_url;
		global $CARDS_LISTFILTER;
		$self = "countCards($category1, $category2)";
		$category1 = (int)$category1;
		$category2 = (int)$category2;
		if (isset($ECLASS)) {
		  $filter = " ECLASS='$ECLASS'";
		}
		else {
		  $filter = " 1=1";
		}

		if ($category1 != '') {
			$filter .= " and CATEGORY1='$category1'";
		}
		if ($category2 != '') {
			$filter .= " and CATEGORY2='$category2'";
		}
		if (!empty($CARDS_LISTFILTER)) {
		   $filter .= " and $CARDS_LISTFILTER";
        }
		$TABLE = $this->Table;
		$query = "select count(*) as COUNT from $TABLE where $filter";
		$idc = @db_connect($db_url);
		if (!$idc) {
			$this->error($self . ' 1: Could not connect to the database server.');
			return;
		}
		$idq = @db_query($query);
		if (!$idq) {
			$this->error($self . ' 3: Unable to perform query: ' . $query);
			return;
		}
		$data = @db_fetch_array($idq);
		return($data['COUNT']);
	}
	function countCardPages($category1 = '', $category2 = '')
	{
		global $ECLASS;
		global $CARDS_LISTLENGTH;
		$self = "countCardPages($category1,$category2)";
		$total = $this->countCards($category1, $category2);
		$total = ceil($total / $CARDS_LISTLENGTH);
		if ($total < 1) {
			$total = 1;
		}
		return($total);
	}
	function GenerateData($stock, $name, $value)
	{
		global $LANG, $CARDS_FIELDS, $CARDS_IMAGESTYLE, $CARDS_IMAGETYPES, $CARDS_FILETYPES, $CONFIG_URLUPLOAD;
		$scope = $CARDS_FIELDS[$name][0];
		$type = $CARDS_FIELDS[$name][1];
		$style = $CARDS_FIELDS[$name][2];
		$stock[$name] = $value;
		switch ($type) {
			case 'NUMBER':$value = $value / pow(10, (int)$style);
				$stock[$name . '_X'] = number_format($value, (int)$style, '', '.');
				$stock[$name . '_D0'] = number_format($value, 0, '', '.');
				$stock[$name . '_D1'] = number_format($value, 1, '', '.');
				$stock[$name . '_D2'] = number_format($value, 2, '', '.');
				break;
			case 'DATE':$stock[$name . '_YEAR'] = TOOLS_TimestampToYear($value);
				$stock[$name . '_MONTH'] = TOOLS_TimestampToMonth($value);
				$stock[$name . '_DAY'] = TOOLS_TimestampToDay($value);
				$stock[$name . '_HOUR'] = TOOLS_TimestampToHour($value);
				$stock[$name . '_MIN'] = TOOLS_TimestampToMin($value);
				$stock[$name . '_SEC'] = TOOLS_TimestampToSec($value);
				$stock[$name . '_WEEKDAY'] = TOOLS_TimestampToWeekday($value);
				break;
			case 'FLAG':for($i = 0;$i < strlen($value);$i++) {
					$stock[$name . '_' . $i] = substr($value, $i, 1);
					$stock[$name . '_' . $i . '_CHK'] = ($stock[$name . '_' . $i] == '1')?'checked':'';
				}
				break;
			case 'ITEM':$stock[$name . '_X'] = ITEMS_GetValue($style, $value, $LANG);
				$stock[$name . '_U'] = strtoupper($stock[$name . '_X']);
				$stock[$name . '_L'] = strtolower($stock[$name . '_X']);
				$stock[$name . '_C'] = ucwords($stock[$name . '_X']);
				$stock[$name . '_P'] = strip_tags($stock[$name . '_X']);
				$stock['SELECT_' . $name] = ITEMS_HTMLSelect($name, $style, $value, $LANG);
				$stock['RADIO_' . $name . '_' . $value] = 'CHECKED';
				break;
			case 'CHAR':$stock[$name . '_X'] = $this->MakeupHTML($value, 'CHAR');
				$stock[$name . '_U'] = strtoupper($stock[$name . '_X']);
				$stock[$name . '_L'] = strtolower($stock[$name . '_X']);
				$stock[$name . '_C'] = ucwords($stock[$name . '_X']);
				$stock[$name . '_P'] = strip_tags($stock[$name . '_X']);
				break;
			case 'TEXT':$stock[$name . '_X'] = $this->MakeupHTML($value, 'TEXT');
				$stock[$name . '_P'] = strip_tags($value);
				$length = strlen($value);
				$stock[$name . '_CHARS'] = number_format($length, 0, '', '.');
				break;
			case 'FILE':list($downs, $bytes, $filename, $ext) = explode(".", $value);
				$stock[$name . '_DOWNS'] = number_format($downs, 0, '.', '');
				$stock[$name . '_BYTES'] = $bytes;
				$stock[$name . '_NAME'] = strtolower($filename);
				$stock[$name . '_EXT'] = strtolower($ext);
				$stock[$name . '_EXT_U'] = strtoupper($ext);
				$stock[$name . '_EXT_L'] = strtolower($ext);
				if ($bytes == 0) {
					$stock[$name . '_URL'] = '';
					$stock[$name . '_DOWNLOAD'] = '';
				} else {
					$url = strtolower($CONFIG_URLUPLOAD . ($this->Table) . "/$filename.$ext");
					$stock[$name . '_URL'] = $url;
					$stock[$name . '_DOWNLOAD'] = '...';
				}
				break;
			case 'IMAGE':list($bytes, $width, $height, $filename, $ext) = explode(".", $value);
				$stock[$name . '_BYTES'] = $bytes;
				$stock[$name . '_WIDTH'] = (int)$width;
				$stock[$name . '_HEIGHT'] = (int)$height;
				$stock[$name . '_NAME'] = strtolower($filename);
				$stock[$name . '_EXT'] = strtolower($ext);
				$stock[$name . '_EXT_U'] = strtoupper($ext);
				$stock[$name . '_EXT_L'] = strtolower($ext);
				if ($bytes == 0) {
					$ext = explode("|", $CARDS_IMAGETYPES);
					$ext = $ext[0];
					$url = strtolower($CONFIG_URLUPLOAD . ($this->Table) . "/$name.$ext");
					$tag = "<img src='$url' $CARDS_IMAGESTYLE>";
				} else {
					$url = strtolower($CONFIG_URLUPLOAD . ($this->Table) . "/$filename.$ext");
					$tag = "<img src='$url' width='$width' height='$height' $CARDS_IMAGESTYLE>";
				}
				$stock[$name . '_URL'] = $url;
				$stock[$name . '_TAG'] = $tag;
				break;
		}
		return($stock);
	}
	function MakeupHTML($text, $style)
	{
		if (empty($text))return("&nbsp;");
		$output = htmlspecialchars(stripslashes($text));
		$output = nl2br($output);
		return($output);
	}
	function UploadPath($id, $field, $ext)
	{
		global $CONFIG_PATHUPLOAD, $TABLE;
		global $CARDS_FIELDS;
		$path = '';
		if (isset($CARDS_FIELDS[$field])) {
			$fullname = sprintf("%04d%s.%s", $id, strtolower($field), strtolower($ext));
			$path = ($this->Table) . '/' . $fullname;
		}
		return strtolower($path);
	}
	function error($message)
	{
		$this->Ok = false;
		$this->Error = $message . ": " . db_error();
		echo $this->Error;
	}
}
?>
