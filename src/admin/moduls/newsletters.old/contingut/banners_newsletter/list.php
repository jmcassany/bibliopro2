<?php

// ============================================================================
// ============================================================================
// USERS ADMIN: LIST.PHP
// - Shows a Page List of cards: PAGE, MODE, CATEGORY1 and CATEGORY2 ($CLASS and $LANG)
// by Asterisc.web
// Version: beta 1.2
// Start: May 2002 - Last: November 2002
// ============================================================================
// ============================================================================

   include("config.php");

   accessCheckLevel(2, $CONFIG_PRE_NOMCARPETA.'/admin/');
	function accessCheckLevel($level,$url){
		global $level_user;

		$level_user = $_SESSION['access']['level'];

		if($level_user >= $level){
			return true;
		}else{
			header("Location: $url");
			exit;
		}
	}


// --------------------
// PARAMETERS FILTERING
// --------------------

   if (empty($LANG))  { $LANG=$DEFAULT_LANG; }
   if (empty($CLASS)) { $CLASS=$DEFAULT_CLASS; }
   if (empty($SKIN))  { $SKIN=$DEFAULT_SKIN; }

   if (empty($PAGE))      { $PAGE = '1'; } // Primera pagina
   if (empty($MODE))      { $MODE = '0'; } // Mode[0]='Zebra', Mode[1]='Skin'
   if (empty($CATEGORY1)) { $CATEGORY1 = ''; } // No filtre CATEGORY1
   if (empty($CATEGORY2)) { $CATEGORY2 = ''; } // No filtre CATEGORY2

// ------------------
// CARDS INSTANTATION
// ------------------

   $dbCards = new dbCards($CARDS_TABLE);
   if (!$dbCards->Ok) { echo "<B>".$messages["error2"].".</B><br>\n"; exit; }

// -----------------
// TEMPLATE SCANNING
// -----------------

   // Create and define Template
   $Tpl = new awTemplate();
   $Tpl->scanFile("list$SKIN.tpl");

   // Si hi ha cap problema -> Error
   if (!$Tpl->Ok) { echo "<B>".$messages["error3"].".</B><br>\n"; exit; }

// ------------------
// CONTENT MERGING
// ------------------

   unset($data);

   // NAVEGATION DATA ==================================================

   function getPageLink($page)
   {
      global $CATEGORY1, $CATEGORY2, $MODE, $SKIN, $PAGE, $ordre, $ordenar;
      return "list.php?CATEGORY1=$CATEGORY1&CATEGORY2=$CATEGORY2&MODE=$MODE&SKIN=$SKIN&PAGE=$page&ordre=$ordre&ordenar=$ordenar";
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


    // ***************************************** ORDENAR LES DADES
	if ($ordre == "") {
		$ordre = "ASC";
	}

	if ($ordenar == "") {
		$CARDS_LISTSORTBY = 'CREATION DESC';
	}

	if ($ordenar == "titol") {
		$CARDS_LISTSORTBY = 'TITOL '.$ordre;
		$data['COLOR1']="#DEDEDE";
		$data['ICO1']="<img src=\"../../../../../public/media/comu/admin/$ordre.gif\" width=\"10\" height=\"10\"  border=\"0\" align=\"absmiddle\" hspace=\"5\">";
		if ($ordre == "DESC") {
			$ordre = "ASC";
		} else {
			$ordre = "DESC";
		}
	}

	if ($ordenar == "data") {
		$CARDS_LISTSORTBY = 'CREATION '.$ordre;
		$data['COLOR2']="#DEDEDE";
		$data['ICO2']="<img src=\"../../../../../public/media/comu/admin/$ordre.gif\" width=\"10\" height=\"10\"  border=\"0\" align=\"absmiddle\" hspace=\"5\">";
		if ($ordre == "DESC") {
			$ordre = "ASC";
		} else {
			$ordre = "DESC";
		}
	}

	if ($ordenar == "estat") {
		$CARDS_LISTSORTBY = 'STATUS '.$ordre;
		$data['COLOR3']="#DEDEDE";
		$data['ICO3']="<img src=\"../../../../../public/media/comu/admin/$ordre.gif\" width=\"10\" height=\"10\"  border=\"0\" align=\"absmiddle\" hspace=\"5\">";
		if ($ordre == "DESC") {
			$ordre = "ASC";
		} else {
			$ordre = "DESC";
		}
	}


	$data['ORDRE'] = $ordre;


   // GENERAL DATA HEAD =================================================

   $data['LANG'] = $LANG;
   $data['LANG_X'] = ITEMS_GetValue( 'LANG', $LANG, $LANG );

   $data['CLASS'] = $CLASS;
   $data['CLASS_X'] = ITEMS_GetValue( 'CARDS_CLASS', $CLASS, $LANG );

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
   include ('houdini_cap.inc');
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

          // Filtrem nom�s els camps definits
          if (!isset($CARDS_FIELDS[$name])) { continue; }
          $type = $CARDS_FIELDS[$name][1];

          // Generem les ampliades dels tipus necesaris
               if ($type=='NUMBER') { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='DATE')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='FLAG')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='ITEM')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='CHAR')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='TEXT')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='LIST')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='FILE')   { $data = $dbCards->GenerateData($data, $name, $value); }
          else if ($type=='IMAGE')  { $data = $dbCards->GenerateData($data, $name, $value); }
       }





       // OUTPUT ROW =====================================================
       if ($MODE=='0') {
           // bloc segons si la fila es senar o parella
           if (($i%2)==0)  echo $Tpl->mergeBlock('ROW1',$data);
           else            echo $Tpl->mergeBlock('ROW2',$data);
       }
       else
       {
           // bloc segons l'skin de la fitxa
           echo $Tpl->mergeBlock('ROW'.$cards[$i]['SKIN'], $data);
           // PER FER: Hauriem de comprovar que el bloc corresponent esta definit,
           // i en cas contrari utilitzar el bloc per defecte 'ROW0'
       }
   }

   $data['CATEGORY1'] = $CATEGORY1;
   $data['CATEGORY1_X'] = ITEMS_GetValue( 'CARDS_CATEGORY1', $CATEGORY1, $LANG );

   $data['CATEGORY2'] = $CATEGORY2;
   $data['CATEGORY2_X'] = ITEMS_GetValue( 'CARDS_CATEGORY2', $CATEGORY2, $LANG );


   // OUTPUT FOOT =====================================================
   echo $Tpl->mergeBlock('FOOT',$data);
   include ('houdini_peu.inc');
?>
