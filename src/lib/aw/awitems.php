<?php
function ITEMS_GetValue($listname, $code, $lang)
{
	global $ITEMS;
	$list = $ITEMS[strtoupper($listname)][strtoupper($lang)];
	if (empty($list)) {
		echo "<b>Warning $listname, $code, $lang</b><br>";
	}
	foreach($list as $element) {
		list($c, $v) = explode("_", $element, 2);
		if ($c == $code) {
			return $v;
		}
	}
	return(false);
}
function ITEMS_GetCode($listname, $value, $lang)
{
	global $ITEMS;
	$list = $ITEMS[strtoupper($listname)][strtoupper($lang)];
	foreach($list as $element) {
		list($c, $v) = explode("_", $element, 2);
		if ($v == $value) {
			return $c;
		}
	}
	return(false);
}
function ITEMS_ListValues($listname, $lang)
{
	global $ITEMS;
	$list = array();
	foreach($ITEMS[strtoupper($listname)][strtoupper($lang)]as $element) {
		list($c, $v) = explode("_", $element, 2);
		$list[] = $v;
	}
	return($list);
}
function ITEMS_ListCodes($listname, $lang)
{
	global $ITEMS;
	$list = array();
	foreach($ITEMS[strtoupper($listname)][strtoupper($lang)]as $element) {
		list($c, $v) = explode("_", $element, 2);
		$list[] = $c;
	}
	return($list);
}
function ITEMS_HTMLSelect($varname, $listname, $select, $lang)
{
	global $ITEMS;
	$select = strtoupper($select);
	$list = $ITEMS[strtoupper($listname)][strtoupper($lang)];
	$html = "<select name='$varname'>\n";
	foreach($list as $element) {
		list($code, $value) = explode("_", $element, 2);
		if ($code == $select) {
			$html .= "<option value='$code' selected>$value</option>\n";
		} else {
			$html .= "<option value='$code'>$value</option>\n";
		}
	}
	$html .= "</select>\n";
	return($html);
}
?>