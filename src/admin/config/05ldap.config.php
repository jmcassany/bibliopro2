<?php

	if (getenv('testserver')) {

		$ldap_active = false;

		/*configuració houdini servidor local*/
		$ldap_server = 'esgolfa.antaviana.info'; //url del servidor ldap
		$ldap_dn = 'ou=intern,dc=antaviana,dc=com'; //directori a partir del qual es fara la cerca d'usuaris

		/*dades per validar-se al ldap*/
// 		$ldap_user = 'cn=admin,dc=antaviana,dc=com';
// 		$ldap_password = 'xxxxx';
		$ldap_user = '';
		$ldap_password = '';
		$ldap_uid_label = 'uid'; //samaccountname

		$ldap_fields = array("objectClass","dn","uid","displayName","givenName","sn","mail");

	}
	else {

		$ldap_active = false;

		/*configuració houdini servidor local*/
		$ldap_server = ''; // url del servidor
		$ldap_dn = ''; // directori a partir del qual es fara la cerca d'usuaris

		/*dades per validar-se al ldap*/
		$ldap_user = '';
		$ldap_password = '';

		$ldap_uid_label = 'uid'; //samaccountname

		$ldap_fields = array("objectClass","dn","uid","displayName","givenName","sn","mail");

	}

?>
