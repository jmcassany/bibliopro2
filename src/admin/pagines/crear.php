<?php

require ('../config_admin.inc');
accessGroupPermCheck('page_create');

include_once("estatiques.php");

$carpeta = $_POST['PARE'];
   include("check_moduls.php");

   //comprovar q hagi seleccionat una plantilla i un nom de pagina amb extensio correcta

   $PLANTILLA=$_POST['PLANTILLA'];
   $NOMPAG=normalizeFile($_POST['NOMPAG']);
   $PARE=$_POST['PARE'];

   if ($PLANTILLA == ""){
     htmlPageError(t("staticpageerrornotemplate"));
   }

   if ($NOMPAG == ""){
     htmlPageError(t("staticpageerrornoname"));
   }

   $trozos = explode (".", $NOMPAG);
//   $teextensio=$trozos['1'];
   //li poso extensio .html si no posa extensio

   if (!isset($trozos['1']) || $trozos['1'] == ''){
		$NOMPAG = $NOMPAG.".html";
   }
   //fi comprovacio


   foreach($_POST as $key => $value) {
     $_POST[$key] = addslashes($value);
   }

    $data = date('Y-m-d H:i:s', time());
	$trozos = explode ("_", $CONFIG_idiomes[$CONFIG_IDIOMA]['0']);
	$numerocategoria=$trozos['0'];
	$idioma=$trozos['1'];
	$codiidioma=$trozos['2'];
    $sql = "insert into ESTATICA (ECLASS,STATUS,CREATION,USUARICREAR,NOMPAG,IDIOMA,REFERENCIA,PARE,PLANTILLAID) values ('1','1','$data','".accessGetLogin()."','$NOMPAG','$codiidioma','0','$PARE','$PLANTILLA')";


  $result = db_query($sql);



   if($result) {
     //insertar registre d'accions
    register_add(t("staticpagescreateok"), $NOMPAG);
	//fi

	//trobar id del principal
	$resultprincipal = db_query_range("SELECT ID FROM ESTATICA Where NOMPAG='$NOMPAG' AND PARE='$PARE' ORDER BY ID DESC",0,1);
	$rowprincipal = db_fetch_array($resultprincipal);
	$IDPRINCIPAL=$rowprincipal['ID'];
	//fi ID

	//crear les pàgines per els altres idiomes si n'hi ha definits
	if((count($CONFIG_idiomes[$CONFIG_IDIOMA])) > 1){

		for($i=1;$i<count($CONFIG_idiomes[$CONFIG_IDIOMA]);$i++){
			$trozos = explode ("_", $CONFIG_idiomes[$CONFIG_IDIOMA][$i]);
			$numerocategoria=$trozos['0'];
			$idioma=$trozos['1'];
			$codiidioma=$trozos['2'];
			//inserta la nova plana
			$NOMPAGIDIOMA=$codiidioma."_".$NOMPAG;
			$sql = "insert into ESTATICA (ECLASS,CATEGORY1,CREATION,USUARICREAR,NOMPAG,IDIOMA,REFERENCIA,PARE,PLANTILLAID) values ('1','$numerocategoria','$data','".accessGetLogin()."','$NOMPAGIDIOMA','$codiidioma','$IDPRINCIPAL','$PARE','$PLANTILLA')";
	 	    $result = db_query($sql);
		}

	}

	//fi

	/////
	if (accessGroupPerm('page_edit')) {
     goto_url('edita.php?ID='.$IDPRINCIPAL.'&carpeta='.$PARE.'&accio=1');
    }
    else {
      goto_url('index.php?path='.$path);
    }
   } else {
	echo db_error();
	echo ("<a href='javascript:history.back()'>".t("back")."</a>");
   }

?>
