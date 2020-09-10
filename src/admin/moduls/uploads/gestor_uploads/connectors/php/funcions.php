<?php 

$GROUPS_TABLE = 'GRUPS_UPLOAD';

function getUserGroup($login){
	global $db_url;

	db_connect($db_url);
	$res = db_query("select * from USERS_GRUPS_UPLOAD where USERLOGIN='$login'");
	if(db_num_rows($res) == 0)
		return array();
	else{
		$row = db_fetch_array($res);
		$array_grups = explode(',',$row['ID_GRUP']);
		return $array_grups;
	}
	return array();
}

function getGroupData($id_grup){
	global $db_url, $GROUPS_TABLE;

	db_connect($db_url);
	$res = db_query("select ID, NOM_GRUP, NOM_CARPETA from $GROUPS_TABLE where ID=$id_grup");
	if(db_num_rows($res) == 0)
		return false;
	else{
		$row = db_fetch_array($res);
		return $row;
	}
	return false;	
}

function getGroupFolder($id_grup){
	$group_data = getGroupData($id_grup);
	return $group_data['NOM_CARPETA'];
}



/*
$GROUPS_TABLE = 'GRUPS_UPLOAD';

function getUserGroup($login){
	global $db_url;

	db_connect($db_url);
	$res = db_query("select * from USERS where LOGIN='$login'");
	if(db_num_rows($res) == 0)
		return false;
	else{
		$row = db_fetch_array($res);
		return $row['GRUP'];
	}
	return false;
}

function getGroupData($id_grup){
	global $db_url, $GROUPS_TABLE;

	db_connect($db_url);
	$res = db_query("select ID, NOM_GRUP, NOM_CARPETA from $GROUPS_TABLE where ID=$id_grup");
	if(db_num_rows($res) == 0)
		return false;
	else{
		$row = db_fetch_array($res);
		return $row;
	}
	return false;	
}

function getGroupFolder($id_grup){
	$group_data = getGroupData($id_grup);
	return $group_data['NOM_CARPETA'];
}
*/

?>