<?php
$CONFIG_TIMEOFFSET = '+1';

function TOOLS_GetTimestamp()
{
	global $CONFIG_TIMEOFFSET;
	$off = 60 * 60 * $CONFIG_TIMEOFFSET;
	$stamp = date("Y-m-d H:i:s", time() + $off);
	return $stamp;
}
function TOOLS_TimestampToInt($timestamp)
{
	$hour = substr($timestamp, 11, 2);
	$minute = substr($timestamp, 14, 2);
	$second = substr($timestamp, 17, 2);
	$year = substr($timestamp, 0, 4);
	$month = substr($timestamp, 5, 2);
	$day = substr($timestamp, 8, 2);
	$int = mktime($hour, $minute, $second, $month, $day, $year);
	return $int;
}
function TOOLS_TimestampToYear($timestamp)
{
	return(substr($timestamp, 0, 4));
}
function TOOLS_TimestampToMonth($timestamp)
{
	return(substr($timestamp, 5, 2));
}
function TOOLS_TimestampToDay($timestamp)
{
	return(substr($timestamp, 8, 2));
}
function TOOLS_TimestampToHour($timestamp)
{
	return(substr($timestamp, 11, 2));
}
function TOOLS_TimestampToMin($timestamp)
{
	return(substr($timestamp, 14, 2));
}
function TOOLS_TimestampToSec($timestamp)
{
	return(substr($timestamp, 17, 2));
}
function TOOLS_TimestampToWeekday($timestamp)
{
	$year = TOOLS_TimestampToYear($timestamp);
	$month = TOOLS_TimestampToMonth($timestamp);
	$day = TOOLS_TimestampToDay($timestamp);
	$hour = TOOLS_TimestampToHour($timestamp);
	$minute = TOOLS_TimestampToMin($timestamp);
	$second = TOOLS_TimestampToSec($timestamp);
	$date = mktime($hour, $minute, $second, $month, $day, $year);
	$weekday = date("w", $date);
	return($weekday);
}
function TOOLS_TimestampToDate($timestamp, $lang)
{
	$year = TOOLS_TimestampToYear($timestamp);
	$month = TOOLS_TimestampToMonth($timestamp);
	$day = TOOLS_TimestampToDay($timestamp);
	switch (strtoupper($lang)) {
		case 'ESP':$date = $day . '/' . $month . '/' . $year;
			break;
		case 'ENG':$date = $month . '/' . $day . '/' . $year;
			break;
		default:$date = $year . '.' . $month . '.' . $day;
	}
	return $date;
}
function TOOLS_TimestampToTime($timestamp, $lang)
{
	$hour = TOOLS_TimestampToHour($timestamp);
	$minute = TOOLS_TimestampToMin($timestamp);
	$second = TOOLS_TimestampToSec($timestamp);
	switch (strtoupper($lang)) {
		case 'ESP':$time = $hour . ':' . $minute;
			break;
		case 'ENG':$time = $hour . ':' . $minute . ':' . $second;
			break;
		default:$time = $hour . ':' . $minute . ':' . $second;
	}
	return $time;
}


?>