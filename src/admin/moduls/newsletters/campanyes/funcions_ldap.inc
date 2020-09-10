<?php

// connexió amb LDAP
function openLDAPConnection(){
		global $ldap_server,$ldap_port,$ldap_protocol,$ldap_referral;
		$conn=ldap_connect($ldap_server,$ldap_port);
		ldap_set_option($conn,LDAP_OPT_PROTOCOL_VERSION,$ldap_protocol);
		ldap_set_option($conn,LDAP_OPT_REFERRALS,$ldap_referral);
		return $conn;

}
// autenticació a LDAP
function bindLDAP($conn){
	global $ldap_user, $ldap_password;
	return ldap_bind($conn, $ldap_user, $ldap_password);
	//return ldap_bind($conn); 	// Autentificacio anonima, habitual per accessos de només lectura
}
// tancar connexió LDAP
function closeLDAPConnection($conn){
	ldap_close($conn);
}

//consulta per un sol camp
function consultaLDAP($camp,$valor,$opcions){
	global $ldap_dn,$ldap_fields;
	$ldap_filter=$camp;
	switch($opcions){
		case 1: $ldap_busqueda=$valor;break;
		case 2: $ldap_busqueda=$valor."*";break;
		case 3: $ldap_busqueda="*".$valor."*";break;
		default:$ldap_busqueda=$valor;break;
	}


	$conn=openLDAPConnection();
	if ($conn) {
	   $ldapbind = bindLDAP($conn);
	   if($ldapbind){
	   		$query='(&('.$ldap_filter.'='.$ldap_busqueda.'))';
	   		//echo $query;
 		 	$sr = ldap_search($conn, $ldap_dn, $query, $ldap_fields);
			$entries = ldap_get_entries($conn, $sr);
			return $entries;
	   	}
	   	closeLDAPConnection($conn);

	} else {
	   echo "<h4>No ha sido posible conectarse al servidor LDAP</h4>";
	}

}

//llistat
function llistatLDAP(){
	global $ldap_dn,$ldap_fields;

	$conn=openLDAPConnection();
	if ($conn) {
	   $ldapbind = bindLDAP($conn);
	   if($ldapbind){
	   		$query='(&(givenname=*))';
 		 	$sr = ldap_search($conn, $ldap_dn, $query, $ldap_fields);
			$entries = ldap_get_entries($conn, $sr);
			return $entries;
	   	}
	   	closeLDAPConnection($conn);

	} else {
	   echo "<h4>No ha sido posible conectarse al servidor LDAP</h4>";
	}

}

//llistat arees de treball
function llistat_areesLDAP($area){
	global $ldap_dn,$ldap_fields;

	$conn=openLDAPConnection();
	if ($conn) {
	   $ldapbind = bindLDAP($conn);
	   if($ldapbind){
	   		$query='(&(description=*'.$area.'*))';
 		 	$sr = ldap_search($conn, $ldap_dn, $query, $ldap_fields);
			$entries = ldap_get_entries($conn, $sr);
			return $entries;
	   	}
	   	closeLDAPConnection($conn);

	} else {
	   echo "<h4>No ha sido posible conectarse al servidor LDAP</h4>";
	}

}

//consulta per varios camps
//	filter �s un array d'arrays amb 3 camps (tipo, campo y valor)
//	tipo: �s el tipus de filtre (�s igual, comen�a per, cont�, no es igual, no comen�a per, no cont�)
//	campo: es el nom del camp
//	valor: el valor del camp

function consultaLDAPMultiplesCamps($filters){
	global $ldap_dn,$ldap_fields;

	$query="(|";
	foreach($filters as $filter){

		$query.="(";

		switch($filter["tipo"]){
			case 1: $query.=$filter["campo"]."=".$filter["valor"];break; //es igual
			case 2: $query.=$filter["campo"]."=".$filter["valor"]."*";break; //comen�a per
			case 3: $query.=$filter["campo"]."="."*".$filter["valor"]."*";break; //cont�
			case 4: $query.="!".$filter["campo"]."=".$filter["valor"];break; //no es igual
			case 5: $query.="!".$filter["campo"]."=".$filter["valor"]."*";break; //no comen�a per
			case 6: $query.="!".$filter["campo"]."=*".$filter["valor"]."*";break; //no cont�
			default: $query.=$filter["valor"];break;
		}
		$query.=")";
	}
	$query.=")";

	$conn=openLDAPConnection();
	if ($conn) {
		   $ldapbind = bindLDAP($conn);
		   if($ldapbind){
		   		$sr = ldap_search($conn, $ldap_dn,$query,$ldap_fields);

					$entries = ldap_get_entries($conn, $sr);
					$j=0;
//							foreach($entries as $entry){
//								$entries[$j]=getParentData($conn,$entry);
//								$j++;
//							}

					return $entries;
		   	}
		   	closeLDAPConnection($conn);

		} else {
		   echo "<h4>No ha sido posible conectarse al servidor LDAP</h4>";
		}

}

/*
function getParentData($conn,$entry){
 	global $ldap_base,$ldap_fields;
 	if($entry["dn"]!=""){
	 	$parent_fields=array("street","st","l");
	 	$tmp=Array();
		$i=0;
		foreach($ldap_fields as $field){
			$tmp[$field]=$entry[$field];
			//echo $tmp[$field]."<br>";
			$i++;
		}

//			  $tmp["parent_dn"]=substr($entry["dn"],strpos($entry["dn"],",")+1,strlen($entry["dn"]));
//			  $query="(&(distinguishedname=".$tmp["parent_dn"]."))";
//			  $sr = ldap_search($conn, $ldap_base,$query,$parent_fields);
//				$parent_entries = ldap_get_entries($conn, $sr);
//				$parent_entry=$parent_entries[0];
//					$tmp["street"]=$parent_entry["street"];//carrer
//					$tmp["st"]=$parent_entry["st"];//telefon
//					$tmp["l"]=$parent_entry["l"];//planta

		return $tmp;
	}else{
		 return $entry;
	}
}
*/

function printConsultaLDAP( $results, $columns, $first_item = 0, $last_item = -1, $style_class = '', $style_id = ''){
	global $ldap_fields,$ldap_friendly_names;

	$table_id = ($style_id != '') ? ' id="'.$style_id.'"' : '' ;
	$table_class = ($style_class != '') ? ' class="'.$style_class.'"' : '' ;

	if(count($columns)>0 && count($results)>1){

		$return="<table $table_id $table_class summary=\"\" width=\"100%\">\n";

		$return.="\t<thead><tr>\n";

		$k=0;
		foreach($ldap_fields as $field){
				$return.= $columns[$field]?"<th scope=\"col\" align=\"left\">".$ldap_friendly_names[$k]."</th>":"";
				$k++;
		}

		$return.="\t</tr></thead><tbody>\n";

		$init = (isset($results['count'])) ? $first_item : $first_item+1;
		if($last_item == -1) {
			$ends = (isset($results['count'])) ? count($results)-1 : count($results);
		}
		else {
			$ends = (isset($results['count'])) ? $last_item : $last_item+1;
		}


		for($i=$init; $i<$ends; $i++){
			$entry=$results[$i];
			$class=(($i%2==0)?"class=odd":"");
			$return.="\t<tr>\n";
			$k=0;
			foreach($ldap_fields as $field){
				if($columns[$field]){
					$return.= "<td $class width=\"20%\" align=\"left\" style=\"padding:8px 8px 8px 0;\">";
					switch($field){
						case "samaccountname": $return.="<b>". $entry[$field][0] ."</b>";break;
						case "mail": $return.= "<a href=\"mailto:".$entry[$field][0]."\">". $entry[$field][0] ."</a>";break;
						case "dn":
						case "parent_dn": $return.= $entry[$field]; break;
						case "objectclass":
							 for($j=0;$j<count($entry[$field])-1;$j++){
					       	$tmp=$entry[$field][$j];
					       	$return.= "<li> ". $tmp."</li>";

					      }

					      break;
					   case "memberof":
							 for($j=0;$j<count($entry[$field])-1;$j++){
					       	$tmp=$entry[$field][$j];
					       	$return.= "<li> ". nice_name($tmp)."</li>";
					      }

					      break;
					   default: $return.= $entry[$field][0];break;
					}

					$return.= "</td>";
				}
				$k++;
			}
			$return.="\t</tr>\n";
		}
	$return.="</tbody></table>\n";

	return $return;

	}
}

function nice_name($line){
	$tmp=explode(",",ldap_dn2ufn($line));
	return $tmp[0];
}



/**
 * *
 * FUNCIONS D'ORDENACIO DELS RESULTATS
 */

/*Scoped global*/
$LDAPSortOrder;

/*$array is the return from ldap_get_entries
   $sortBy is an array of values to sort by in the order in
   which to sort them
   $reverse will sort in reverse order if true
*/
function LDAPSort(&$array,$sortBy,$reverse=FALSE){
        global $LDAPSortOrder;
        $LDAPSortOrder = $sortBy;
        if($reverse){
                usort($array,'ldapcomparereverse');
        } else {
                usort($array,'ldapcompare');
        }
}

/* The compare functions always check case insensitive*/
function ldapcompare($x,$y){
        global $LDAPSortOrder;
/*
Loops through the items in order until a difference is found
*/
        foreach($LDAPSortOrder as $ele){
                if(strtolower($x[$ele][0]) == strtolower($y[$ele][0]))
                        continue;
                elseif(strtolower($x[$ele][0]) < strtolower($y[$ele][0]))
                        return -1;
                else
                        return 1;
        }
        return 0;
}

/*Just like above but in reverse order*/
function ldapcomparereverse($x,$y){
        global $LDAPSortOrder;
        foreach($LDAPSortOrder as $ele){
                if(strtolower($x[$ele][0]) == strtolower($y[$ele][0]))
                        continue;
                elseif(strtolower($x[$ele][0]) < strtolower($y[$ele][0]))
                        return 1;
                else
                        return -1;
        }
        return 0;
}


?>