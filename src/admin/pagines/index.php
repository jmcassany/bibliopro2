<?php

// ============================================================================
// ============================================================================
// USERS ADMIN: LIST.PHP
// - Shows a Page List of cards: PAGE, MODE, CATEGORY1 and CATEGORY2 ($ECLASS and $LANG)
// by Asterisc.web
// Version: beta 1.2
// Start: May 2002 - Last: November 2002
// ============================================================================
// ============================================================================

require ('../config_admin.inc');
accessGroupPermCheck('page_read');

include_once("estatiques.php");

include("check_moduls.php");

   $CARDS_LISTFILTER = "PARE='$carpeta' AND REFERENCIA='0'";
   if (isset ($cerca)) {
      $cerca = addslashes($cerca);
      $CARDS_LISTFILTER = "PARE='$carpeta' AND (NOMPAG LIKE '%$cerca%' OR  DESCRIPCIO LIKE '%$cerca%') AND REFERENCIA='0'";
   }

$rutacarpetes = folderPath($carpeta);

// --------------------
// PARAMETERS FILTERING
// --------------------

   if (empty($LANG))  { $LANG=$DEFAULT_LANG; }
   if (empty($ECLASS)) { $ECLASS=$DEFAULT_ECLASS; }
   if (empty($SKIN))  { $SKIN=$DEFAULT_SKIN; }

   if (empty($PAGE))      { $PAGE = '1'; } // Primera pagina
   if (empty($MODE))      { $MODE = '0'; } // Mode[0]='Zebra', Mode[1]='Skin'
   if (empty($CATEGORY1)) { $CATEGORY1 = ''; } // No filtre CATEGORY1
   if (empty($CATEGORY2)) { $CATEGORY2 = ''; } // No filtre CATEGORY2

// ------------------
// CARDS INSTANTATION
// ------------------

   $dbCards = new dbCards($CARDS_TABLE);
   if (!$dbCards->Ok) {
     htmlPageBasicError(t("errordbcards"));
   }

// -----------------
// TEMPLATE SCANNING
// -----------------

   // Create and define Template
   $Tpl = new awTemplate();
   $Tpl->scanFile("index.tpl");

   // Si hi ha cap problema -> Error
   if (!$Tpl->Ok) {
     htmlPageBasicError(t("plantillanotrobada")." index.tpl");
   }

// ------------------
// CONTENT MERGING
// ------------------

   unset($data);

   if (accessGroupPerm('page_create')) {
     $data['NEWPAGE'] = '
<form action="selec_plantilla.php" method="post" name="FormCrearpagina" style="display:inline">
<input type="hidden" name="carpeta" value="'.$carpeta.'">
<button type="submit" class="vermell10b" style="background-color:transparent;cursor:pointer;border:none;text-decoration: none;">
  <img src="../comu/icon_afegir_plana.gif" alt="'.t("staticpagesoptionscreate").'" align="absmiddle" style="margin-right:5px;" />'.t("staticpagesoptionscreate").'
</button>
</form>


';
      $data['CLONE_LEGEND'] = '
<img src="../comu/icon_duplica.gif" alt="'.t("duplicate").'" width="20" height="16" border="0" align="absmiddle" >'.t("duplicate").'&nbsp;&nbsp;&nbsp;
';
   }
   if (accessGroupPerm('page_delete')) {
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
   if (accessGroupPerm('page_edit')) {
      $data['EDIT_LEGEND'] = '
<img src="../comu/icon_modifica.gif" alt="'.t("edit").'" width="23" height="16" border="0" align="absmiddle" >'.t("edit").'&nbsp;&nbsp;&nbsp;
';
      $data['MOVE_LEGEND'] = '
<img src="../comu/icon_moure.gif" alt="'.t("move").'" width="24" height="16" border="0" align="absmiddle">'.t("move").'&nbsp;&nbsp;&nbsp;
';
   }


$data['METAS'] = htmlMetas();
$data['CARPETA'] = $carpeta;


   // NAVEGATION DATA ==================================================

   function getPageLink($page)
   {
      global $ordenar,$ordre,$cerca,$carpeta,$PAGE;
      $textcerca = '';
      if (!empty($cerca)) {
        $textcerca = '&cerca='.$cerca;
      }
      return "index.php?ordenar=$ordenar&ordre=$ordre&carpeta=$carpeta&PAGE=$page".$textcerca;
   }

   // Acotem $PAGE
   $pagemin=1;
   if ($PAGE<$pagemin){ $PAGE=$pagemin; }

   $pagemax=$dbCards->countCardPages($CATEGORY1,$CATEGORY2);
   if ($PAGE>$pagemax) { $PAGE=$pagemax; }

   $data['PAGE']=$PAGE;
   $data['PMAX']=$pagemax;

   // Next page link
   $pagenext=$PAGE+1;
   if ($pagenext>$pagemax) { $data['PAGENEXT']=$CARDS_LISTPAGENEXT; }
   else { $data['PAGENEXT']="<A HREF='".getPageLink($pagenext)."'>$CARDS_LISTPAGENEXT</A>"; }

   // Previous page link
   $pageprev=$PAGE-1;
   if ($pageprev<$pagemin) { $data['PAGEPREV']=$CARDS_LISTPAGEPREV; }
   else { $data['PAGEPREV']="<A HREF='".getPageLink($pageprev)."'>$CARDS_LISTPAGEPREV</A>"; }

   // List Page links
   $dec=floor(($PAGE-1)/$CARDS_LISTSKIP);
   $decmax=floor(($pagemax-1)/$CARDS_LISTSKIP);
   $min=1+($dec*$CARDS_LISTSKIP);
   $max=$min+$CARDS_LISTSKIP-1;      if ($max>$pagemax)       { $max=$pagemax; }
   $skipright=$PAGE+$CARDS_LISTSKIP; if ($skipright>$pagemax) { $skipright=$pagemax; }
   $skipleft=$PAGE-$CARDS_LISTSKIP;  if ($skipleft<1)         { $skipleft=1; }

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
  $ordre = 'ASC';
  if (isset($_GET['ordre'])) {
    $ordre = $_GET['ordre'];
  }
}
if($ordenar == ""){
	$CARDS_LISTSORTBY = 'ID DESC';

	}

if($ordenar == "nom"){
	$CARDS_LISTSORTBY = 'NOMPAG '.$ordre;
}
if($ordenar == "data"){
	$CARDS_LISTSORTBY = 'CREATION '.$ordre;
}
if($ordenar == "datamodi"){
	$CARDS_LISTSORTBY = 'MODIFICAT '.$ordre;
}

///fi ordenar dades


   // GENERAL DATA HEAD =================================================

   $data['LANG'] = $LANG;

   $data['ECLASS'] = $ECLASS;
   $data['ECLASS_X'] = ITEMS_GetValue( 'CARDS_ECLASS', $ECLASS, $LANG );

   $data['MODE'] = $MODE;

   $data['CATEGORY1'] = $CATEGORY1;
//   $data['CATEGORY1_X'] = ITEMS_GetValue( 'CARDS_CATEGORY1', $CATEGORY1, $LANG );

   $data['CATEGORY2'] = $CATEGORY2;
   $data['CATEGORY2_X'] = ITEMS_GetValue( 'CARDS_CATEGORY2', $CATEGORY2, $LANG );

   $data['CATEGORY'] = ''; $data['CATEGORY_X'] = '';
   if (($CATEGORY1=='') && ($CATEGORY2!=''))
   {    $data['CATEGORY']   = $data['CATEGORY2'];
        $data['CATEGORY_X'] = $data['CATEGORY2_X'];
   }
   if (($CATEGORY1!='') && ($CATEGORY2==''))
   {    $data['CATEGORY']   = $data['CATEGORY1'];
        $data['CATEGORY_X'] = $data['CATEGORY1_X'];
   }


   // OUTPUT HEAD =====================================================
    $cards = $dbCards->listCards();//llegim el total de registres sense paginar
	$data['N']=0;
    $total = count($cards);
	$data['TOTAL'] = $total;
	$data['USUARI']=accessGetLogin();
	if ($descripciocarpeta == '') {
      $data['DESCRIPCIOCARPETA']= $nomcarpeta;
    }
    else {
      $data['DESCRIPCIOCARPETA']= $descripciocarpeta;
    }
    $data['NOMCARPETA']= $nomcarpeta;
	//capçelera de situacio
	//CODI HTML CAPCELERA
 $data['CAPCELERA'] = htmlHeader();


  if (!empty($cerca)) {
	if ($total == 0){
   		$data['RESULTAT']="<tr><td class=\"text10\" colspan=\"2\" style=\"padding-left:10px;\"><br>".t("search").": <b>$cerca</b></td></tr>\n<tr><td class=\"grana\" colspan=\"2\" style=\"padding-left:20px;\"><br><img src=\"../comu/houdini_alerta.gif\" width=\"19\" height=\"31\" alt=\"Error\" border=\"0\" align=\"absmiddle\">&nbsp;&nbsp;<b>".t("searchnotfound")."</b><br><br><a href=\"javascript:history.back();\" ><b>".t("back")."</b></a></td></tr>";
	}else{
		$data['RESULTAT']="<tr><td class=\"text10\" colspan=\"2\">".t("search").": <b>$cerca</b><br>".t("searchresults").": <b>$total</b></td></tr>";

	}
  }



   ///variables de text idioma
   $data['LANGETSA'] = t("youarein");
   $data['LANGTITOL'] = t("staticpagestitle");
   $data['LANGHOME'] = t("home");
   $data['LANGLISTPAGES'] = t("staticpageslist");
   $data['LANGEDIT'] = t("edit");
   $data['LANGDELETE'] = t("delete");
   $data['LANGVIEW'] = t("view");
   $data['LANGMOVE'] = t("move");
   $data['LANGDUPLICATE'] = t("duplicate");
   $data['LANGGENERATE'] = t("generate");
   $data['LANGORDERBY'] = t("orderby");
   $data['LANGCERCA'] = t("search");
   $data['LANGNAME'] = t("name");
   $data['LANGCREATION'] = t("creationdate");
   $data['LANGMODIFY'] = t("modifydate");

   // fi


    echo $Tpl->mergeBlock('HEAD',$data);



   // READ DATA =======================================================
   $cards = $dbCards->listCards($PAGE,$CATEGORY1,$CATEGORY2);

   $data['N']=0;

   $total = count($cards);


   for ($i=0; $i<$total; $i++)
   {
       $data['N'] = 1 + $i + ($PAGE-1)*$CARDS_LISTLENGTH;

       foreach ($cards[$i] as $name=>$value)
       {
          // Les dades en brut de tots els camps
          $data[$name] = strip_tags($value);

          // Filtrem només els camps definits
          if (!isset($CARDS_FIELDS[$name])) { continue; }
          $type = $CARDS_FIELDS[$name][1];

          // Generem les ampliades dels tipus necesaris
               if ($type=='NUMBER') { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='DATE')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='FLAG')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='ITEM')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='CHAR')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='TEXT')   { $data = $dbCards->GenerateData($data, $name, $value); }
//          else if ($type=='FILE')   { $data = $dbCards->GenerateData($data, $name, $value); }
//          else if ($type=='IMAGE')  { $data = $dbCards->GenerateData($data, $name, $value); }
       }

			//comprova si esta generada
			$pagina=$data['NOMPAG'];
            $data['LINK'] = $rutacarpetes.'/'.$pagina;;
			$targetfilename = $CONFIG_PATHBASE.'/'.$rutacarpetes.'/'.$pagina;
			if (file_exists("$targetfilename")) {
				$data['ICONAGENERAR']="ico_generar_ok.gif";
			}else{
				$data['ICONAGENERAR']="ico_generar_off.gif";
			}
			//fi comprova si esta generada

			//icona si descripcio hi ha alguna cosa
			$descrip=$data['DESCRIPCIO'];
	   		if ($descrip!=""){
				$data['DESCRIPCIO']="<img src=\"../comu/ico_descripcio.gif\" width=\"9\" height=\"9\" alt=\"Descripció\" border=\"0\" align=\"absmiddle\"> $descrip";
			}
			//fi icona si descripcio hi ha alguna cosa
			if($data['STATUS']==1){
				$generada= "_genera";
			}else{
				$generada= "_pendent";
			}

			if (accessGroupPerm('page_edit')) {
		$ICONESIDIOMA="<a href=\"edita.php?ID=".$data['ID']."&carpeta=".$carpeta."\"><img src=\"../comu/paisos/".$data['IDIOMA']."".$generada.".gif\" width=\"21\" height=\"13\" border=\"0\" alt=\"".$data['IDIOMA']."\"  style=\"margin-left:10px;\"></a>";
            }
            else {
              $ICONESIDIOMA="<img src=\"../comu/paisos/".$data['IDIOMA']."".$generada.".gif\" width=\"21\" height=\"13\" border=\"0\" alt=\"".$data['IDIOMA']."\"  style=\"margin-left:10px;\">";
            }
			$resultidioma=db_query("select ID,STATUS,IDIOMA,PARE from ESTATICA where REFERENCIA = '".$data['ID']."' ORDER BY ID ASC");
			while($rowidioma = db_fetch_array($resultidioma)) {
				if($rowidioma['STATUS']==1){
					$generada= "_genera";
				}else{
					$generada= "_pendent";
				}
			    if (accessGroupPerm('page_edit')) {
				  $ICONESIDIOMA.="<a href=\"edita.php?ID=".$rowidioma['ID']."&carpeta=".$rowidioma['PARE']."\"><img src=\"../comu/paisos/".$rowidioma['IDIOMA'].$generada.".gif\" width=\"21\" height=\"13\" border=\"0\" alt=\"".$rowidioma['IDIOMA']."\" style=\"margin-left:10px;\"></a>";
				}
                else {
				  $ICONESIDIOMA.="<img src=\"../comu/paisos/".$rowidioma['IDIOMA'].$generada.".gif\" width=\"21\" height=\"13\" border=\"0\" alt=\"".$rowidioma['IDIOMA']."\" style=\"margin-left:10px;\">";
                }

			}
			$data['ICONESIDIOMA']= $ICONESIDIOMA;



   if (accessGroupPerm('page_create')) {
      $data['CLONE_OPTION'] = '
<a href="duplicar.php?ID='.$data['ID'].'&carpeta='.$carpeta.'"><img src="../comu/icon_duplica.gif" alt="Duplicar la pàgina" width="20" height="16" border="0" align="absmiddle" ></a>
';
   }
   if (accessGroupPerm('page_delete')) {
      $data['DELETE_OPTION'] = '
&#149;&nbsp;
<img src="../comu/icon_borrar.gif" alt="'.t("delete").'" width="22" height="16" border="0" align="absmiddle"><input type="checkbox" name="CHECK['.$data['ID'].']" value="TRUE" >
';
   }
   if (accessGroupPerm('page_edit')) {
      $data['EDIT_OPTION'] = '
<a href="edita.php?ID='.$data['ID'].'&carpeta='.$carpeta.'"><img src="../comu/icon_modifica.gif" alt="Editar la pàgina" width="23" height="16" border="0" align="absmiddle" ></a>
';
      $data['MOVE_OPTION'] = '
<a href="canvi_carpeta1.php?ID='.$data['ID'].'&carpeta='.$carpeta.'"><img src="../comu/icon_moure.gif" alt="Moure la pàgina a una altra carpeta" width="24" height="16" border="0" align="absmiddle"></a>
';
      $data['PAGE_INFO'] = '
<td class="gris10" width="29" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="edita.php?ID='.$data['ID'].'&carpeta='.$carpeta.'"><img src="../comu/icon_html.gif" width="29" height="17" alt="Creada: '.$data['CREATION'].' Modificada: '.$data['MODIFICAT'].'" border="0" align="absmiddle"></a></td>
<td class="gris10" width="28%" valign="top" style="border-bottom:solid #cccccc 1px;padding-top:5px;padding-bottom:5px;"><a href="edita.php?ID='.$data['ID'].'&carpeta='.$carpeta.'" class="nompagina" title="Creada: '.$data['CREATION'].' Modificada: '.$data['MODIFICAT'].'">'.$data['NOMPAG'].'</a></td>
      ';
   }
   else {
      $data['PAGE_INFO'] = '
<td class="gris10" width="29" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><img src="../comu/icon_html.gif" width="29" height="17" alt="Creada: '.$data['CREATION'].' Modificada: '.$data['MODIFICAT'].'" border="0" align="absmiddle"></td>
<td class="gris10" width="28%" valign="top" style="border-bottom:solid #cccccc 1px;padding-top:5px;padding-bottom:5px;">'.$data['NOMPAG'].'</td>
      ';
   }





       // OUTPUT ROW =====================================================

       echo $Tpl->mergeBlock('ROW',$data);
   }

   $data['CATEGORY1'] = $CATEGORY1;
//   $data['CATEGORY1_X'] = ITEMS_GetValue( 'CARDS_CATEGORY1', $CATEGORY1, $LANG );

   $data['CATEGORY2'] = $CATEGORY2;
   $data['CATEGORY2_X'] = ITEMS_GetValue( 'CARDS_CATEGORY2', $CATEGORY2, $LANG );

   // OUTPUT FOOT =====================================================
   //CODI HTML PEU
   $data['PEU'] = htmlFoot();
   $data['LANGCONFIRMDELETE']=t("confirmdelete");
   echo $Tpl->mergeBlock('FOOT',$data);

?>
