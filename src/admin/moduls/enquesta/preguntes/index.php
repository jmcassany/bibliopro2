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

require ('../../../config_admin.inc');
accessGroupPermCheck('poll');

require('enquesta_preg.php');


   $CARDS_LISTFILTER = "";
   if (!empty($cerca)) {
     $cerca = addslashes($cerca);
     $CARDS_LISTFILTER = 'ENQUESTA = '.$_GET['ENQUESTA']."NOM LIKE '%$cerca%' OR  DESCRIPCIO LIKE '%$cerca%'";
   }
   else {
     $CARDS_LISTFILTER = 'ENQUESTA = '.$_GET['ENQUESTA'];
   }


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
   if (!$dbCards->Ok) { echo "<B>Error: No se ha podido crear dbCards.</B><br>\n"; exit; }

// -----------------
// TEMPLATE SCANNING
// -----------------

   // Create and define Template
   $Tpl = new awTemplate();
   $Tpl->scanFile("index.tpl");

   // Si hi ha cap problema -> Error
   if (!$Tpl->Ok) { echo "<B>Error: No se ha encontrado la plantilla 'list.tpl'.</B><br>\n"; exit; }

// ------------------
// CONTENT MERGING
// ------------------

   unset($data);
   $data['ENQUESTA']=$_GET['ENQUESTA'];

   $data['METAS'] = htmlMetas();

   // NAVEGATION DATA ==================================================

   function getPageLink($page)
   {
      global $ordenar,$cerca,$PAGE;
      $textcerca = '';
      if (!empty($cerca)) {
        $textcerca = '&cerca='.$cerca;
      }
      return "index.php?ordenar=$ordenar&PAGE=$page".$textcerca;
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
if($ordenar == ""){
	$CARDS_LISTSORTBY = 'ID DESC';
}
if($ordenar == "nom"){
	$CARDS_LISTSORTBY = 'DESCRIPCIO ASC';
}
if($ordenar == "data"){
	$CARDS_LISTSORTBY = 'CREATION DESC';
}

///fi ordenar dades
  if (!empty($cerca)) {
     	$data['CERCA']=$cerca;
  }


   // GENERAL DATA HEAD =================================================

   $data['LANG'] = $LANG;

   $data['ECLASS'] = $ECLASS;
   $data['ECLASS_X'] = ITEMS_GetValue( 'CARDS_ECLASS', $ECLASS, $LANG );

   $data['MODE'] = $MODE;

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


   // OUTPUT HEAD =====================================================
    $cards = $dbCards->listCards();//llegim el total de registres sense paginar
	$data['N']=0;
    $total = count($cards);
	$data['TOTAL'] = $total;

   $result = db_query('SELECT DESCRIPCIO FROM ENQUESTA WHERE ID='.$_GET['ENQUESTA']);
   $row = db_fetch_array($result);
   $data['DESC_ENQ']=$row['DESCRIPCIO'];


	//CODI HTML CAPCELERA
 $data['CAPCELERA'] = htmlHeader();

  if (!empty($cerca)) {
	if ($total == 0){
   		$data['RESULTAT']="<tr><td class=\"text10\" colspan=\"2\" style=\"padding-left:10px;\"><br>Recerca: <b>$cerca</b></td></tr>\n<tr><td class=\"grana\" colspan=\"2\" style=\"padding-left:20px;\"><br><img src=\"../../comu/houdini_alerta.gif\" width=\"19\" height=\"31\" alt=\"Error\" border=\"0\" align=\"absmiddle\">&nbsp;<b>No s'ha trobat cap coincidència</b><br><br><a href=\"javascript:history.back();\" ><b><< Tornar</b></a></td></tr>";
	}else{
		$data['RESULTAT']="<tr><td class=\"text10\" colspan=\"2\">Recerca: <b>$cerca</b><br>".t("searchresults").": <b>$total</b></td></tr>";

	}
  }

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
          else if ($type=='FILE')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='IMAGE')  { $data = $dbCards->GenerateData($data, $name, $value); }
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
   echo $Tpl->mergeBlock('FOOT',$data);

?>
