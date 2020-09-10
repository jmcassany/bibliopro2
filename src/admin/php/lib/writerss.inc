<?php

class writerss {
    var $head = array();
    var $image = array();
    var $items = array();
    var $content = '';

    function writerss($title = '', $link = '', $description = '') {
        if (!empty($title)) { $this->head['title'] = htmlspecialchars($title); };
        if (!empty($link)) { $this->head['link'] = $link; };
        if (!empty($description)) { $this->head['description'] = "<![CDATA[\n".htmlspecialchars($description)."\n]]>"; };
    }
    function setimage ($url = '', $title = '', $link = '') {
        if (!empty($url)) { $this->image['url'] = $url; };
        if (!empty($title)) { $this->image['title'] = $title; };
        if (!empty($link)) { $this->image['link'] = $link; };
    }
    function setitem ($title = '', $link = '', $description = '', $pubDate, $image = array(), $category = '') {
        $item = array();
        $img = array();
        if (!empty($title)) { $item['title'] = htmlspecialchars($title); };
        if (!empty($link)) { $item['link'] = $link; };
        if (!empty($description)) { $item['description'] = "<![CDATA[\n".htmlspecialchars($description)."\n]]>"; };
        if (!empty($author)) { $item['author'] = $author; };
        if (!empty($category)) { $item['category'] = $category; };
        if (!empty($pubDate)) { $item['pubDate'] = $pubDate; };
        if (isset($image['url'])) {
          if (!empty($image['url'])) { $img['url'] = $image['url']; };
          if (!empty($image['title'])) { $img['title'] = $image['title']; };
          if (!empty($image['link'])) { $img['link'] = $image['link']; };
          $item['image'] = $img;
        }

        array_push($this->items, $item);
    }

    function generate() {
        $headertext = '';
        foreach ($this->head as $key => $value) {
           $headertext .= "<".$key.">".$value."</".$key.">\n";
        }
        $imagetext = '';
        foreach ($this->image as $key => $value) {
           $imagetext .= "\t<".$key.">".$value."</".$key.">\n";
        }
        if (!empty($imagetext)) {
           $headertext .= "<image>\n".$imagetext."</image>\n";
        }
//        if (!empty($headertext)) {
//           $headertext = "<channel>\n".$headertext."</channel>\n";
//        }
        $itemstext = '';
        foreach ($this->items as $item) {
           $itemtext = '';
           foreach ($item as $key => $value) {
              if ($key == 'image') {
                $imagetext = '';
                foreach ($value as $key2 => $value2) {
                  $imagetext .= "\t<".$key2.">".$value2."</".$key2.">\n";
                }
                if (!empty($imagetext)) {
                  $itemtext .= "<image>\n".$imagetext."</image>\n";
                }

              }
              else {
                $itemtext .= "\t<".$key.">".$value."</".$key.">\n";
              }
           }

           if (!empty($itemtext)) {
              $itemstext .= "<item>\n".$itemtext."</item>\n";
           }
        }

        $this->content = '<?xml version="1.0" encoding="utf-8" ?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	>
<channel>
  '.$headertext.'
  '.$itemstext.'
</channel>
</rss>';
    }
    function content() {
        return $this->content;
    }
    function printrss() {
        header("Content-type: text/xml");
        echo $this->content;
    }
    function save($filename) {
        global $CONFIG_PERMFILES;
        if (!$file = @fopen($filename,'w+')) {
           return FALSE;
        }
        fwrite($file, $this->content);
        fclose($file);
        if (!empty($CONFIG_PERMFILES)) {
          chmod($filename, $CONFIG_PERMFILES);
        }
        return TRUE;
    }
}


?>
