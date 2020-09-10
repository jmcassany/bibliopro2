<?php
// ============================================================================
// ============================================================================
// USERS ADMIN: INDEX.PHP
// - Shows users in a table
// by Asterisc.web
// Version: beta 1.0
// Start: May 2002 - Last: June 2002
// ============================================================================
// ============================================================================

require ('../config_admin.inc');
accessGroupPermCheck('users_read');


    // lists definitions
    $USERS_SORTINDEXPAGEBY = 'USERLEVEL desc, STATUS desc, LOGIN asc';
    $USERS_INDEXPAGELENGTH = '25';
    $USERS_INDEXLISTSKIP = '10';

// ------------------
// USERS INSTANTATION
// ------------------

   $Users = new dbUsers();
   if (!$Users->Ok) {
     htmlPageBasicError(t("errordbusers"));
   }

// --------------------
// PARAMETERS FILTERING
// --------------------
   if (empty($P)) { $P = 1; }
   if (!isset($L)) { $L=''; }  // Si no especifica Level -> els mostra tots
   if (!isset($cerca)) { $cerca=''; }  // Si no especifica filtre -> els mostra tots

// -----------------
// TEMPLATE SCANNING
// -----------------

   // Create and define Template
   $Tpl = new awTemplate();
   $Tpl->scanFile("index.tpl");

   // Si hi ha cap problema -> Error
   if (!$Tpl->Ok) {
     htmlPageBasicError(t("plantillanotrobada"));
   }

// ------------------
// CONTENT MERGING
// ------------------

   unset($data);

   if (accessGroupPerm('users_create')) {
     if ($ldap_active) {
       $data['NEWUSER'] = '<a href="nou_ldapsearch.php" class="vermell10b"><img src="../comu/icon_afegir_plana.gif" alt="Crear usuari" width="18" height="19" border="0" align="absmiddle"> '.t("create").' '.t("user").'</a>';
     }
     else {
       $data['NEWUSER'] = '<a href="nou.php" class="vermell10b"><img src="../comu/icon_afegir_plana.gif" alt="Crear usuari" width="18" height="19" border="0" align="absmiddle"> '.t("create").' '.t("user").'</a>';
     }
   }

   if (accessGroupPerm('users_edit')) {
     $data['EDIT_LEGEND'] = '
<img src="../comu/icon_modifica.gif" alt="'.t("edit").'" width="23" height="16" border="0" align="absmiddle" >'.t("edit").'&nbsp;&nbsp;&nbsp;
';
   }


   if (accessGroupPerm('users_delete')) {
     $data['DELETE_LEGEND'] = '
<img src="../comu/icon_borrar.gif" alt="'.t("delete").'" width="22" height="16" border="0" align="absmiddle">'.t("delete").'
';

     $data['DELETE_CONFIRM'] = '
<!-- CONFIRMACIO BORRAR -->
<table border="0" cellspacing="4" cellpadding="4" width="100%" bgcolor="#ECECEC" height="33" style="border-top:solid #000000 1px;">
  <tr>
    <td  class="text">&nbsp;'.t("confirmdelete").'&nbsp;<img src="../comu/icon_borrar.gif" alt="Eliminar" width="22" height="16" border="0" align="absmiddle"><input type="checkbox" name="CONFIRM" value="TRUE"><input type="image" src="../comu/confirma_elimina.gif" name="accio" value="Borrar" class="text10" align="absmiddle"></td>
  </tr>
</table>
<!-- /CONFIRMACIO BORRAR -->
';
   }

$data['METAS'] = htmlMetas();

   // NAVEGATION DATA ==================================================

   function getPageLink($page)
   {
      global $ordenar,$ordre, $MODE, $SKIN, $PAGE;
      return "index.php?ordenar=$ordenar&ordre=$ordre&P=$page";
   }

   // Acotem $P
   $pagemin=1;
   if ($P<$pagemin){ $P=$pagemin; }

   $pagemax=$Users->countUsersPages($L);
   if ($P>$pagemax) { $P=$pagemax; }

   $data['P']=$P;
   $data['PMAX']=$pagemax;

   // Next page link
   $pagenext=$P+1;
   if ($pagenext>$pagemax) { $data['PAGENEXT']=t("next"); }
   else { $data['PAGENEXT']="<A HREF='".getPageLink($pagenext)."'>".t("next")."</A>"; }

   // Previous page link
   $pageprev=$P-1;
   if ($pageprev<$pagemin) { $data['PAGEPREV']=t("previous"); }
   else { $data['PAGEPREV']="<A HREF='".getPageLink($pageprev)."'>".t("previous")."</A>"; }

   // List Page links
   $PAGE=$P;
   $data['PAGE']=$PAGE;
   $dec=floor(($PAGE-1)/$USERS_INDEXLISTSKIP);
   $decmax=floor(($pagemax-1)/$USERS_INDEXLISTSKIP);
   $min=1+($dec*$USERS_INDEXLISTSKIP);
   $max=$min+$USERS_INDEXLISTSKIP-1;      if ($max>$pagemax)       { $max=$pagemax; }
   $skipright=$PAGE+$USERS_INDEXLISTSKIP; if ($skipright>$pagemax) { $skipright=$pagemax; }
   $skipleft=$PAGE-$USERS_INDEXLISTSKIP;  if ($skipleft<1)         { $skipleft=1; }

   $pagelist=' ';

   if ($dec>0) { $pagelist.="<A HREF='".getPageLink($skipleft)."'>...</A> "; }
   for ($i=$min; $i<=$max; $i++)
   {
       if ($i==$PAGE) { $pagelist.=" <b>$i</b>"; }
       else           { $pagelist.=" <A HREF='".getPageLink($i)."'>$i</A>"; }
   }
   if ($dec<$decmax) { $pagelist.=" <A HREF='".getPageLink($skipright)."'>...</A>"; }

   $data['PAGELIST']=$pagelist.' ';

   //ORDENAR LES DADES
$ordenar = '';
if (isset($_GET['ordenar'])) {
  $ordenar = $_GET['ordenar'];
}
$ordre = 'ASC';
if (isset($_GET['ordre'])) {
  $ordre = $_GET['ordre'];
}
if($ordenar == ""){
	$USERS_SORTINDEXPAGEBY = 'LOGIN DESC';
	}
if($ordenar == "titol"){
	$USERS_SORTINDEXPAGEBY = 'LOGIN '.$ordre;
	$data['COLOR1']="#DEDEDE";
	$data['ICO1']="<img src=\"../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
	if($ordre == "DESC"){
		$ordre = "ASC";
	}else{
		$ordre = "DESC";
	}

}
if($ordenar == "nivell"){
	$USERS_SORTINDEXPAGEBY = 'USERLEVEL '.$ordre;
	$data['COLOR2']="#DEDEDE";
	$data['ICO2']="<img src=\"../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
	if($ordre == "DESC"){
		$ordre = "ASC";
	}else{
		$ordre = "DESC";
	}

}
if($ordenar == "estat"){
	$USERS_SORTINDEXPAGEBY = 'STATUS '.$ordre;
	$data['COLOR3']="#DEDEDE";
	$data['ICO3']="<img src=\"../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
	if($ordre == "DESC"){
		$ordre = "ASC";
	}else{
		$ordre = "DESC";
	}

}
///fi ordenar dades



   // HEAD =====================================================
   $data['USUARI']=accessGetLogin();
   $data['ORDRE'] = $ordre;
   //CODI HTML CAPCELERA
 $data['CAPCELERA'] = htmlHeader();
   ///variables de text idioma
   $data['LANGUSUARI'] = t("user");
   $data['LANGUSERLEVEL'] = t("userformlevel");
   $data['LANGSTATUS'] = t("userformstat");
   $data['ETSA'] = t("youarein");
   $data['USERSTITOL'] = t("userstitle");
   $data['HOME'] = t("home");
   $data['USERSLIST']=t("userslist");
   $data['EDIT'] = t("edit");
   $data['DELETE'] = t("delete");
   $data['CREATE'] = t("create");
   // fi
   echo $Tpl->mergeBlock('HEAD',$data);

   if ($L=='' && $cerca =='') { $users = $Users->listUsers($P); }
   elseif ($L=='' && $cerca !='') { $users = $Users->listUsers($P,$cerca); }
   else  { $users = $Users->listUsers($P, $cerca, $L); }


   if (!accessGroupPerm('users_all')) {
     $limit_permissos = $Users->getComments(accessGetLogin());
     foreach($users as $key => $value) {
       $permissos = explode(',',$value['COMMENTS']);
       $trobat = false;
       foreach ($limit_permissos as $perm) {
         if (in_array($perm, $permissos)) {
           $trobat = true;
         }
       }
       if (!$trobat) {
         unset($users[$key]);
       }
     }
     $users = array_values($users);
   }







   // USER1 + USER2 ======================================

   $total = count($users);
   for ($i=0; $i<$total; $i++)
   {

       $data['N']               = 1 + $i + ($P-1)*$USERS_INDEXPAGELENGTH;
       $data['LOGIN']          = strip_tags($users[$i]['LOGIN']);
       $data['PASSWD']         = strip_tags($users[$i]['PASSWD']);
       $data['USERLEVEL']          = strip_tags($users[$i]['USERLEVEL']);
       $data['USERLEVEL_X']         = accessGetGroupName($users[$i]['USERLEVEL']);
       $data['STATUS']         = strip_tags($users[$i]['STATUS']);

       $data['ERROR'] = '';
       if ($ldap_active && isset($users[$i]['ldap_error'])) {
         $data['ERROR'] = '<strong style="color:#ff0000;padding-left:10px">Usuari no present al ldap</strong>';
       }


        if ($data['STATUS'] == '0') {
          $data['STATUS_X'] = t("active");
        }
        elseif ($data['STATUS'] == '1') {
          $data['STATUS_X'] = t("inactive");
        }



       $data['EXPIRATION']     = strip_tags($users[$i]['EXPIRATION']);
       list($t1,$t2)= explode (" ", $data['EXPIRATION']);
       list($data['EXP_YEAR'],$data['EXP_MONTH'],$data['EXP_DAY']) = explode("-",$t1);
       $data['EMAIL']          = strip_tags($users[$i]['EMAIL']);
       $data['REALNAME']      = strip_tags($users[$i]['REALNAME']);
       $data['TELEPHONE']      = strip_tags($users[$i]['TELEPHONE']);
       $data['COMMENTS']       = strip_tags($users[$i]['COMMENTS']);

       if (accessGroupPerm('users_delete')) {
         $data['DELETE_OPTION'] = '
&#149;&nbsp;
<img src="../comu/icon_borrar.gif" alt="'.t("delete").'" width="22" height="16" border="0" align="absmiddle"><input type="checkbox" name="CHECK['.$data['LOGIN'].']" value="TRUE" >
';
       }

       if (accessGroupPerm('users_edit')) {
         $data['EDIT_OPTION'] = '
<a href="edita.php?LOGIN='.$data['LOGIN'].'"><img src="../comu/icon_modifica.gif" alt="'.t("edit").'" width="23" height="16" border="0" align="absmiddle" ></a>
';
         $data['USER_INFO'] = '
<td class="gris11" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="edita.php?LOGIN='.$data['LOGIN'].'" class="nompagina"><img src="../comu/icon_user.gif" alt="Usuari" width="18" height="13" border="0" align="absmiddle"> '.$data['LOGIN'].'</a> '.$data['ERROR'].'</td>
<td class="gris10"  valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="edita.php?LOGIN='.$data['LOGIN'].'" class="gris10">'.$data['USERLEVEL_X'].'</a></td>
<td class="gris10"  valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="edita.php?LOGIN='.$data['LOGIN'].'" class="gris10">'.$data['STATUS_X'].'</a></td>
';
       }
       else {
         $data['USER_INFO'] = '
<td class="gris11" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><img src="../comu/icon_user.gif" alt="Usuari" width="18" height="13" border="0" align="absmiddle">'.$data['LOGIN'].' '.$data['ERROR'].'</td>
<td class="gris10"  valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">'.$data['USERLEVEL_X'].'</td>
<td class="gris10"  valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">'.$data['STATUS_X'].'</td>
';
       }


       // bloc segons si la fila es senar o parella
       echo $Tpl->mergeBlock('USER',$data);
   }

   // FOOT =====================================================
   //CODI HTML PEU
   $data['PEU'] = htmlFoot();
   echo $Tpl->mergeBlock('FOOT',$data);

?>
