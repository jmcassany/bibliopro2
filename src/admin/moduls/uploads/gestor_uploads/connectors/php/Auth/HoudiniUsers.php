<?php 
/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2005 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * File Name: Default.php
 * 	Im not very clued up on authentication but even i can see that anyone 
 * 	who can spoof an IP could perform a replay attack on this, but its 
 * 	better than nothing. 
 * 	There is a 1 hour time out on tokens to help this slightly.
 * 
 * File Authors:
 * 		Grant French (grant@mcpuk.net)
 */
 
  $path = substr (__FILE__,0,-(strlen('Auth/HoudiniUsers.php')));
  require_once($path.'config.php');
  require_once($path.'funcions.php');

//////////// la funci� scandir nom�s est� dispnible a PHP 5
//////////// la creem per a que sigui utilitzable en altres versions on no estigui disponible

	if(!function_exists('scandir')) {
	   function scandir($dir, $sortorder = 0) {
	       if(is_dir($dir))        {
	           $dirlist = opendir($dir);
	           while( ($file = readdir($dirlist)) !== false) {
	               if(!is_dir($file)) {
	                   $files[] = $file;
	               }
	           }
	           ($sortorder == 0) ? asort($files) : rsort($files); // arsort was replaced with rsort
	           return $files;
	       } else {
	       return FALSE;
	       break;
	       }
	   }
	}    

//////////// 


class Auth {
	
	function authenticate($data,$fckphp_config) {
	
		//Hold relevant$fckphp_config vars locally
		$key=$fckphp_config['auth']['Handler']['SharedKey'];
		$fckphp_config['authSuccess']=false;

		
		// agafem la info de l'usuari : Login, grups i carpetes de cada grup
		$USERLOGIN = accessGetLogin();
		$USERGROUPS = getUserGroup($USERLOGIN);	// array de grups
		$GROUPFOLDERS = array();
		foreach( $USERGROUPS as $grup)
		{
			array_unshift($GROUPFOLDERS, getGroupFolder($grup) );
		}

		
		// carpeta base d'uploads
		$base_folder = str_replace("//","/",$fckphp_config['basedir'].'/'.$fckphp_config['UserFilesPath']."/");
		
		
		//filtrat usuaris 
		if($USERLOGIN == 'admin' ){ 					// usuaris amb acc�s total
			$fckphp_config['authSuccess']=true;
			
			//Create resource area subfolders if they dont exist
			$GROUPFOLDERS = $this->getGroupFolders();
			foreach($GROUPFOLDERS as $folder)
			{
				foreach ($fckphp_config['ResourceTypes'] as $value) {
					$group_folder = str_replace("//","/",$fckphp_config['basedir'].'/'.$fckphp_config['UserFilesPath']."/".$value."/".$folder);
					if (!file_exists("$group_folder")) {
						mkdir("$group_folder",0777) or die("$group_folder folder in UserFilesPath does not exist and could not be created.");
						chmod("$group_folder",0777); //Just for good measure
					}
				}
			}			
		}
		else if($USERGROUPS != false && (! in_array(0,$USERGROUPS) ) ){									// tenim un usuari amb grup
			$fckphp_config['authSuccess']=true;
			//Create resource area subfolders if they dont exist

			foreach($GROUPFOLDERS as $folder)
			{
				foreach ($fckphp_config['ResourceTypes'] as $value) {
					$group_folder = str_replace("//","/",$fckphp_config['basedir'].'/'.$fckphp_config['UserFilesPath']."/".$value."/".$folder);
					if (!file_exists("$group_folder")) {
						mkdir("$group_folder",0777) or die("$group_folder folder in UserFilesPath does not exist and could not be created.");
						chmod("$group_folder",0777); //Just for good measure
					}
				}
			}

			
			// fem que nom�s pugui veure les seves carpetes en cadascun dels recursos i els generals
			foreach ($fckphp_config['ResourceTypes'] as $value) {
				$exclude_folders = $this->exclusionFolders($base_folder.$value,$GROUPFOLDERS);
				$fckphp_config['ResourceAreas'][$value]['HideFolders'] = array_merge($fckphp_config['ResourceAreas'][$value]['HideFolders'],$exclude_folders);
			}					
			
		}
		else{															// l'usuari no t� grup
			// l'usuari no t� grup -> el validem i li treiem l'acc�s a totes les carpetes de grup menys la general
			$fckphp_config['authSuccess']=true;

			// fem que nom�s pugui veure els recursos generals
			foreach ($fckphp_config['ResourceTypes'] as $value) {
				$exclude_folders = $this->exclusionFolders($base_folder.$value);
				$fckphp_config['ResourceAreas'][$value]['HideFolders'] = array_merge($fckphp_config['ResourceAreas'][$value]['HideFolders'],$exclude_folders);
			}			
			
		}
		return $fckphp_config;
	}
	

	// busca directoris de grup exclosos d'acc�s
	function exclusionFolders($base_folder, $exception_folder =''){
		
		$folders_list = $this->getGroupFolders();

		$exclude_folders = array();
		for($i=0; $i<count($folders_list); $i++){
			if( (is_array($exception_folder) && !in_array($folders_list[$i],$exception_folder)) || (!is_array($exception_folder) && $folders_list[$i] != $exception_folder ) ){
				array_unshift($exclude_folders, $folders_list[$i]);
			}
		}
		return $exclude_folders;
	}
	
	/** retorna array amb les carpetes definides en la taula de grups **/
	function getGroupFolders(){
		global $db_url;
		$TABLE = 'GRUPS_UPLOAD';
	
		db_connect($db_url);
		$res = db_query("select NOM_CARPETA from $TABLE");
		$ret = array();
		while($row = db_fetch_array($res)){
			array_unshift($ret,$row['NOM_CARPETA']);
		}
		return $ret;
	}	
}
?>