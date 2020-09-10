<?php
include_once '../../selconfig.php';
include_once 'config.php';

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
accessCheckLevel(2, $CONFIG_PRE_NOMCARPETA.'/admin/');


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


if(isset($cerca)){
    $CARDS_LISTFILTER = "TITOL LIKE '%$cerca%' OR LINK1 LIKE '%$cerca%'";
}
$CARDS_LISTFILTER = "STATUS=1";



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
$Tpl->scanFile("index0.tpl");

// Si hi ha cap problema -> Error
if (!$Tpl->Ok) { echo "<B>Error: No se ha encontrado la plantilla 'index0.tpl'.</B><br>\n"; exit; }

// ------------------
// CONTENT MERGING
// ------------------

unset($data);

// NAVEGATION DATA ==================================================

function getPageLink($page)
{
    global $CATEGORY1, $CATEGORY2, $MODE, $SKIN, $PAGE;
    return "index.php?CATEGORY1=$CATEGORY1&CATEGORY2=$CATEGORY2&MODE=$MODE&SKIN=$SKIN&PAGE=$page";
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
setCurrent('contingut');
include ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
$cards = $dbCards->listCards();//llegim el total de registres sense paginar

$total = count($cards);
$data['TOTAL'] = $total;

///variables de text idioma
$data['LANGETSA'] = $messages["youarein"];
$data['LANGTITOL'] = "Gesti� RSS de Not�cies";//$messages["dinamicstitle"];
$data['LANGHOME'] = $messages["home"];
$data['LANGCREATEPAGE'] = $messages["staticpagesoptionscreate"];
$data['LANGLISTPAGES'] = $messages["staticpageslist"];
$data['LANGCREATEREGISTRY'] = $messages["createregistry"];
$data['LANGEDIT'] = $messages["edit"];
$data['LANGDELETE'] = $messages["delete"];
$data['LANGVIEW'] = $messages["view"];
$data['LANGDUPLICATE'] = $messages["duplicate"];
$data['LANGCERCA'] = $messages["search"];
$data['LANGCREATION'] = $messages["creationdate"];

$data['LANGLIST'] = $messages["list"];
$data['LANGLISTTITOL'] = $messages["title"];
$data['LANGLISTCREATION'] = $messages["creationdate"];
$data['LANGLISTSTATUS'] = $messages["status"];
$data['LANGLISTORDER'] =  $messages["order"];

$data['DESCRIPCIOCARPETA'] =  "Selector Not�cies RSS";
$data['LANGCREATER'] = "Crear Enquesta";
echo $Tpl->mergeBlock('HEAD',$data);

if(isset($_GET['updated']) && $_GET['updated'] == true)
{
    echo $Tpl->mergeBlock('RSS_UPDATE',$data);
}

// READ DATA =======================================================
$cards = $dbCards->listCards($PAGE,$CATEGORY1,$CATEGORY2);
$data['N']=0;

$total = count($cards);
$item_RSS = 1;
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

    $data['RSS_RESOURCE_NAME'] = $data['TITOL'];

    // OUTPUT ROW =====================================================
    echo $Tpl->mergeBlock('ORIGEN_RSS',$data);


    require_once($CONFIG_PATHBASE."/lib/lastRSS.inc");

    /************* LLEGIR RSS ******************/
    // Try to load and parse RSS file
    $url=$data['LINK1'];
    $maxim = $data['MAX_ITEMS'];
     
    $rss = new lastRSS;
    $rss->items_limit = $maxim;
    $rss->CDATA = 'content';
    $rss->cp = 'utf-8';
    $rss->stripHTML = False;
     
    if ($rs = $rss->get($url)) {
         
        $trad = get_html_translation_table(HTML_SPECIALCHARS);
        $trad = array_flip($trad);
        $rs['title'] = strtr($rs['title'],$trad);
        //   $rs['description'] = strtr($rs['description'],$trad);
        //   $rs['image_title'] = strtr($rs['image_title'],$trad);
         
        foreach($rs['items'] as $item) {
             
            $item['title'] = strtr($item['title'],$trad);
            $data['RSS_TITLE'] = str_replace('"','&quot;',$item['title']);
            $data['RSS_ITEM_ID'] = $item_RSS;
            $data['RSS_DESCRIPTION'] = '';
            $data['RSS_PUBDATE'] = '';
            $data['RSS_LINK'] = '';
            if (!empty($item['description'])) {
                $data['RSS_DESCRIPTION'] = strip_tags($item['description']);
            }
            if (!empty($item['pubDate'])) {
                $data['RSS_PUBDATE'] = $item['pubDate'];
            }
            if (!empty($item['link'])) {
                $data['RSS_LINK'] = $item['link'];
            }
             
            /**** comprovem si ja est� introduit a la taula de noticies i el marquem com a seleccionat ****/
            $data['CHECKED'] = '';
            $result_rss = db_query("SELECT * FROM $EDITORA_NOTICIES WHERE ORIGEN_RSS=".$data['ID']." AND TITOL='".addslashes($data['RSS_TITLE'])."' ");
            if( db_num_rows($result_rss) == 1 )
            {
                $data['CHECKED'] = 'checked';
            }
            // OUTPUT ROW =====================================================
            echo $Tpl->mergeBlock('ROW1',$data);
             
            $item_RSS ++;
        }

    }
    else {
        echo "Error: It's not possible to reach RSS file...\n";
    }

    /************* FI LLEGIR RSS ******************/

}

$data['CATEGORY1'] = $CATEGORY1;
$data['CATEGORY1_X'] = ITEMS_GetValue( 'CARDS_CATEGORY1', $CATEGORY1, $LANG );

$data['CATEGORY2'] = $CATEGORY2;
$data['CATEGORY2_X'] = ITEMS_GetValue( 'CARDS_CATEGORY2', $CATEGORY2, $LANG );

$data['LANGCONFIRMDELETE']=$messages["confirmdelete"];
$data['TOTAL_ITEMS']=$item_RSS;

echo $Tpl->mergeBlock('FOOT',$data);
include ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');

?>
