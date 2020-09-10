<?php

function getGroupSelect($user_login =''){

	$result = db_query("SELECT ID,NOM_GRUP FROM GRUPS_UPLOAD ORDER BY NOM_GRUP asc");
	$options = '';
	$array_grup = array();
	if($user_login != ''){
		$result_grup = db_query("SELECT ID_GRUP FROM USERS_GRUPS_UPLOAD WHERE USERLOGIN = '".$user_login."' ");
		if($result_grup){
			$row_grup = db_fetch_array($result_grup);
			$array_grup = explode(',',$row_grup['ID_GRUP']);
		}
	}
	
	while($row = db_fetch_array($result) )
	{	
		$selected = '';
		if( in_array( $row['ID'], $array_grup) ){
			$selected = ' selected';
		}
		$options .= '<option value="'.$row['ID'].'" '.$selected.'>'.$row['NOM_GRUP'].'</option>';
	}
	
	if( empty($array_grup) ||  in_array( 0, $array_grup)){
		$options = '<option value="0" selected>Cap</option>'.$options;
	}
	else{
		$options = '<option value="0">Cap</option>'.$options;
					
	}
	$options = '<select name="GRUP[]" multiple class="formulari" style="width:150px;">
					'.$options.'
				</select>';
	
	return $options;
}



?>