<?php
include_once('|CONFIG_PATHBASE|/media/php/config.php');
include_once('lastRSS.inc');


// Try to load and parse RSS file
$url='|LINKRSS|';
$maxim = |MAXRSS|;


$rss = new lastRSS;
$rss->items_limit = $maxim;
$rss->CDATA = 'content';
$rss->cp = 'utf-8';
$rss->stripHTML = False;

if ($rs = $rss->get($url)) {

   $trad = get_html_translation_table(HTML_SPECIALCHARS);
   $trad = array_flip($trad);

/*capçelera*/

   $rs['title'] = strtr($rs['title'],$trad);
   $rs['description'] = strtr($rs['description'],$trad);
   $rs['image_title'] = strtr($rs['image_title'],$trad);

   // Show website logo (if presented)
   $logo = '';
   if (!empty($rs['image_url'])) {
      if (empty($rs['image_link'])) {
         $rs['image_link'] = $rs['link'];
      }
      if (empty($rs['image_title'])) {
         $rs['image_title'] = $rs['title'];
      }
      $logo = '<a href="'.$rs['image_link'].'"><img src="'.$rs['image_url'].'" alt="'.$rs['image_title'].'" border="0" align="absmiddle" /></a>';
   }

   echo '<h3>'.$logo.'<a href="'.$rs['link'].'">'.$rs['title'].'</a></h3>'.$rs['description'].'<br />';
/*fi capçelera*/

/*cos*/
   echo "<ul>\n";
   foreach($rs['items'] as $item) {

       $item['title'] = strtr($item['title'],$trad);
       $item['description'] = strtr($item['description'],$trad);
       $item['image_title'] = strtr($item['image_title'],$trad);

       $imatge = '';
       if (!empty($item['image_url'])) {
          $imatge = '<img src="'.$item['image_url'].'" alt="'.$item['title'].'" />';
       }
       $description = '';
       if (!empty($item['description'])) {
          $description = '<br />'.$item['description'];
       }
       $author = '';
       if (!empty($item['author'])) {
          $author = '<br />'.$item['author'];
       }
       $date = '';
       if (!empty($item['pubDate'])) {
          $date = '<br />'.$item['pubDate'];
       }
       if (!empty($item['link'])) {
         $title = '<a href="'.$item['link'].'">'.$item['title'].'</a>';
       }
       else {
         $title = $item['title'];
       }
       echo "\t<li>".$imatge.$title.$description.$author.$date."</li>\n";
   }
   echo "</ul>\n";
/*fi cos*/

}
else {
   echo "Error: It's not possible to reach RSS file...\n";
}
?>