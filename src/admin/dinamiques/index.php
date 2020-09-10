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
accessGroupPermCheck('dinamic_read');

include_once("dinamiques.php");
include_once('categories/funcions.inc');


   //COMPROVEM SI TE ACCES A AQUEST MODUL
   include("check_moduls.php");
   //FI COMPROVEM SI TE ACCES A AQUEST MODUL

   if (isset($_POST["cerca"]))
   {
      $cerca=$_POST['cerca'];
   }
   elseif (isset($_GET["cerca"]))
   {
      $cerca = $_GET["cerca"];
   }
   else {
      $cerca = "";
   }

   $CARDS_LISTFILTER = "";
   if (!empty($cerca)) {
       $cerca = addslashes($cerca);
       $CARDS_LISTFILTER = "TITOL LIKE '%$cerca%' OR  DESCRIPCIO LIKE '%$cerca%' OR CREATION LIKE '%$cerca%'";
   }


// --------------------
// PARAMETERS FILTERING
// --------------------

   if (empty($LANG))  { $LANG=$DEFAULT_LANG; }
   if (empty($ECLASS)) { $ECLASS=$DEFAULT_ECLASS; }

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

   //comprovar si existeix el tpl si no agafem el base
   $Tpl->scanFile("index0.tpl");

   // Si hi ha cap problema -> Error
   if (!$Tpl->Ok) {
     htmlPageBasicError(t("plantillanotrobada")." index0.tpl");
   }

// ------------------
// CONTENT MERGING
// ------------------

   unset($data);




   // NAVEGATION DATA ==================================================

   function getPageLink($page)
   {
      global $ordenar,$ordre,$DIN,$cerca,$PAGE;
      $textcerca = '';
      if (!empty($cerca)) {
        $textcerca = '&cerca='.$cerca;
      }

      return "index.php?DIN=".$DIN."&ordenar=$ordenar&ordre=$ordre&PAGE=$page".$textcerca;
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
}
$ordre = 'ASC';
if (isset($_GET['ordre'])) {
  $ordre = $_GET['ordre'];
}
if($ordenar == ""){
  $CARDS_LISTSORTBY = 'ORDRE DESC,ID DESC';
}
else if($ordenar == 'titol'){
	$CARDS_LISTSORTBY = 'TITOL '.$ordre;
	$data['COLOR1']="#DEDEDE";
	$data['ICO1']="<img src=\"../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
	if($ordre == "DESC"){
		$ordre = "ASC";
	}else{
		$ordre = "DESC";
	}
}
else if($ordenar == "data"){
	$CARDS_LISTSORTBY = 'CREATION '.$ordre;
	$data['COLOR2']="#DEDEDE";
	$data['ICO2']="<img src=\"../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
	if($ordre == "DESC"){
		$ordre = "ASC";
	}else{
		$ordre = "DESC";
	}
}
else if($ordenar == "estat"){
	$CARDS_LISTSORTBY = 'STATUS '.$ordre;
	$data['COLOR3']="#DEDEDE";
	$data['ICO3']="<img src=\"../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
	if($ordre == "DESC"){
		$ordre = "ASC";
	}else{
		$ordre = "DESC";
	}
}
else if($ordenar == "ordre"){
	$CARDS_LISTSORTBY = 'ORDRE '.$ordre;
	$data['COLOR4']="#DEDEDE";
	$data['ICO4']="<img src=\"../comu/$ordre.gif\" width=\"10\" height=\"10\" alt=\"Ascendent\" border=\"0\" align=\"absmiddle\" hspace=\"5\">";
	if($ordre == "DESC"){
		$ordre = "ASC";
	}else{
		$ordre = "DESC";
	}
}
///fi ordenar dades
  if (!empty($cerca)) {
     	$data['CERCA']=$cerca;
  }

	$data['METAS'] = htmlMetas();

   // GENERAL DATA HEAD =================================================

   $data['LANG'] = $LANG;

   $data['ECLASS'] = $ECLASS;
   $data['ECLASS_X'] = ITEMS_GetValue( 'CARDS_ECLASS', $ECLASS, $LANG );

   $data['MODE'] = $MODE;

  $ITEMS['CARDS_CATEGORY2']['ESP'] =cat2items($DIN);
  if (count($ITEMS['CARDS_CATEGORY2']['ESP']) == 0){
    $ITEMS['CARDS_CATEGORY2']['ESP'] =array('0_'.t("notcategoriesdefined"));
  }


   $data['CATEGORY1'] = $CATEGORY1;
   $data['CATEGORY1_X'] = ITEMS_GetValue( 'CARDS_CATEGORY1', $CATEGORY1, $LANG );

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

   if (accessGroupPerm('dinamic_category')) {
     $data['EDITACATEGORIA'] = '<a href="categories/index.php?DINAMICA='.$DIN.'" class="vermell10b"><img src="../comu/ico_categoria.gif" border="0" align="absmiddle" style="margin-right:8px;">'.t('dincategoryedit').'</a>';
   }

   // OUTPUT HEAD =====================================================

   $data['ORDRE'] = $ordre;
   $data['TAULA']=$TAULA;
   $data['DIN']=$DIN;
   $data['USUARI']=accessGetLogin();

   $data['DESCRIPCIOCARPETA']= $descripciocarpeta;

   $data['NOMCARPETA']= $nomcarpeta;
   if ($tipuseditora == 0){
      $data['TIPOENTRADA']="";
   }else{
   	 $data['TIPOENTRADA']=$tipuseditora;
   }

   //saber ruta on es la la carpeta
    $data['LINK'] = $CONFIG_URLBASE."/".$ruta;
	$data['RUTAWEB']= "<a href=$CONFIG_URLBASE/".$ruta." target=\"_blank\">".t("dinamicsviewinweb")."</a>";

	//fi capçelera de situacio





   if (accessGroupPerm('dinamic_create')) {
     $data['NEW'] = '
<form action="nou'.$data['TIPOENTRADA'].'.php" method="post" name="FormCrearpagina"  style="display:inline">
<input type="hidden" name="DIN" value="'.$DIN.'">
<button type="submit" class="vermell10b" style="background-color:transparent;cursor:pointer;border:none;text-decoration: none;">
  <img src="../comu/icon_afegir_plana.gif" alt="'.t("createregistry").'" align="absmiddle" style="margin-right:5px;" />'.t("createregistry").'
</button>
</form>
';
      $data['CLONE_LEGEND'] = '
<img src="../comu/icon_duplica.gif" alt="'.t("duplicate").'" width="20" height="16" border="0" align="absmiddle" >'.t("duplicate").'&nbsp;&nbsp;&nbsp;
';
   }
   if (accessGroupPerm('dinamic_delete')) {
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
   if (accessGroupPerm('dinamic_edit')) {
      $data['EDIT_LEGEND'] = '
<img src="../comu/icon_modifica.gif" alt="'.t("edit").'" width="23" height="16" border="0" align="absmiddle" >'.t("edit").'&nbsp;&nbsp;&nbsp;
';
      $data['MOVE_LEGEND'] = '
<img src="../comu/icon_moure.gif" alt="'.t("move").'" width="24" height="16" border="0" align="absmiddle">'.t("move").'&nbsp;&nbsp;&nbsp;
';
   }









  //CODI HTML CAPCELERA
$data['CAPCELERA'] = htmlHeader();


  $data['N']=0;
  $data['TOTAL'] = $dbCards->countCards();//llegim el total de registres sense paginar

  if (!empty($cerca)) {
	if ($data['TOTAL'] == 0){
   		$data['RESULTAT']="<tr><td class=\"text10\" colspan=\"2\" style=\"padding-left:10px;\"><br>Recerca: <b>$cerca</b></td></tr>\n<tr><td class=\"grana\" colspan=\"2\" style=\"padding-left:20px;\"><br><img src=\"../../comu/houdini_alerta.gif\" width=\"19\" height=\"31\" alt=\"Error\" border=\"0\" align=\"absmiddle\">&nbsp;<b>No s'ha trobat cap coincidència</b><br><br><a href=\"javascript:history.back();\" ><b><< Tornar</b></a></td></tr>";
	}else{
		$data['RESULTAT']="<tr><td class=\"text10\" colspan=\"2\">Recerca: <b>$cerca</b><br>".t("searchresults").": <b>".$data['TOTAL']."</b></td></tr>";

	}
  }



   ///variables de text idioma
   $data['LANGETSA'] = t("youarein");
   $data['LANGTITOL'] = t("dinamicstitle");
   $data['LANGHOME'] = t("home");
   $data['LANGCREATEPAGE'] = t("staticpagesoptionscreate");
   $data['LANGLISTPAGES'] = t("staticpageslist");
   $data['LANGCREATEREGISTRY'] = t("createregistry");
   $data['LANGEDIT'] = t("edit");
   $data['LANGDELETE'] = t("delete");
   $data['LANGVIEW'] = t("view");
   $data['LANGDUPLICATE'] = t("duplicate");
   $data['LANGCERCA'] = t("search");
   $data['LANGCREATION'] = t("creationdate");

   $data['LANGLIST'] = t("list");
   $data['LANGLISTTITOL'] = t("title");
   $data['LANGLISTCREATION'] = t("creationdate");
   $data['LANGLISTSTATUS'] = t("status");
   $data['LANGLISTORDER'] =  t("order");

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
       {          // Les dades en brut de tots els camps
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
          else if ($type=='FILE')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='IMAGE')  { $data = $dbCards->GenerateData($data, $name, $value); }
       }
       $data['TAULA']=$TAULA;
       $data['DIN']=$DIN;
	   $data['TIPOENTRADA']=$tipuseditora;




   if (accessGroupPerm('dinamic_create')) {
      $data['CLONE_OPTION'] = '
<a href="duplicar.php?ID='.$data['ID'].'&DIN='.$DIN.'&amp;PAGE='.$pagina.'"><img src="../comu/icon_duplica.gif" alt="Duplicar" width="20" height="16" border="0" align="absmiddle" ></a>
';
   }
   if (accessGroupPerm('dinamic_delete')) {
      $data['DELETE_OPTION'] = '
&#149;&nbsp;
<img src="../comu/icon_borrar.gif" alt="'.t("delete").'" width="22" height="16" border="0" align="absmiddle"><input type="checkbox" name="CHECK['.$data['ID'].']" value="TRUE" >
';
   }
   if (accessGroupPerm('dinamic_edit')) {
      $data['EDIT_OPTION'] = '
<a href="view.php?ID='.$data['ID'].'&DIN='.$DIN.'&amp;PAGE='.$pagina.'" ><img src="../comu/icon_modifica.gif" alt="Editar" width="23" height="16" border="0" align="absmiddle" ></a>
';
      $data['INFO'] = '
<td class="gris11" width="35%" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="view.php?ID='.$data['ID'].'&DIN='.$DIN.'&amp;PAGE='.$pagina.'" class="gris11">'.$data['TITOL'].'</a></td>
<td class="gris11" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="view.php?ID='.$data['ID'].'&DIN='.$DIN.'&amp;PAGE='.$pagina.'" class="gris11">'.$data['CREATION_DAY'].'-'.$data['CREATION_MONTH'].'-'.$data['CREATION_YEAR'].' '.$data['CREATION_HOUR'].':'.$data['CREATION_MIN'].':'.$data['CREATION_SEC'].'</a></td>
<td class="gris11" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;"><a href="view.php?ID='.$data['ID'].'&DIN='.$DIN.'&amp;PAGE='.$pagina.'" class="gris11">'.$data['STATUS_X'].'</a></td>
<td class="gris11" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;" align="center"><a href="view.php?ID='.$data['ID'].'&DIN='.$DIN.'&amp;PAGE='.$pagina.'" class="gris11">'.$data['ORDRE'].'</a></td>
      ';
   }
   else {
      $data['INFO'] = '
<td class="gris11" width="35%" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">'.$data['TITOL'].'</td>
<td class="gris11" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">'.$data['CREATION_DAY'].'-'.$data['CREATION_MONTH'].'-'.$data['CREATION_YEAR'].' '.$data['CREATION_HOUR'].':'.$data['CREATION_MIN'].':'.$data['CREATION_SEC'].'</td>
<td class="gris11" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;">'.$data['STATUS_X'].'</td>
<td class="gris11" valign="top" style="border-bottom:solid #cccccc 1px;padding-left:10px;padding-top:5px;padding-bottom:5px;" align="center">'.$data['ORDRE'].'</td>
      ';
   }









       // OUTPUT ROW =====================================================
       echo $Tpl->mergeBlock('ROW',$data);
   }

   $data['CATEGORY1'] = $CATEGORY1;
   $data['CATEGORY1_X'] = ITEMS_GetValue( 'CARDS_CATEGORY1', $CATEGORY1, $LANG );

   $data['CATEGORY2'] = $CATEGORY2;
   $data['CATEGORY2_X'] = ITEMS_GetValue( 'CARDS_CATEGORY2', $CATEGORY2, $LANG );

   // OUTPUT FOOT =====================================================
   //CODI HTML PEU
   $data['PEU'] = htmlFoot();
   $data['LANGCONFIRMDELETE']=t("confirmdelete");
   echo $Tpl->mergeBlock('FOOT',$data);

?>
