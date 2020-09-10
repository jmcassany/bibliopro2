<?php

function menu_generate ($id, $tipus, $orientacio ,$estil, $preview = false) {
  global $CONFIG_URLMENU, $CONFIG_PATHADMIN, $CONFIG_NOMCARPETA;
  if ($preview) {
    $urlmenu = $CONFIG_URLMENU;
  }
  else {
    $urlmenu = urlDir($CONFIG_URLMENU);
  }

  $result=db_query("select * from MENUITEMS Where MENU = '".$id."' ORDER BY ORDRE ASC,ID DESC");

  $elements = array();
  while ($row = db_fetch_array($result)) {
    $value = array();
    $value['external'] = $row['FINESTRA'];
    if (!empty($row['IMATGE'])) {
      $value['image'] = $urlmenu.'/img/'.$row['IMATGE'];
    }
    $value['title'] = str_replace('&', '&amp;', $row['TEXT']);
    $value['separator'] = $row['SEPARATOR'];
    $value['link'] = trim(str_replace('&', '&amp;', $row['LINKPAGE']));
    $value['liclass'] = $row['CSSCLASS'];
    $value['directori'] = $row['DIRECTORI'];
		$value['editora'] = $row['EDITORA'];
		$value['limit'] = 10; /*$row['LIMIT'];*/


		// si el submenú ha de ser una editora, creem el submenú amb les entrades corresponents
		if($value['editora'] != '-1') {

			$result2 = db_query("SELECT * FROM editora_$value[editora]
			WHERE (STATUS='1') AND ((VISIBILITY='1') OR (VISIBILITY='2' AND START_TIME < NOW() AND NOW() < END_TIME))
			ORDER BY ORDRE DESC, ID DESC LIMIT $value[limit]");
			$subelements = array();
			while($row2 = db_fetch_array($result2)) {
				$value2 = array();
				$value2['external'] = 0;
				$value2['title'] = str_replace('&', '&amp;', $row2['TITOL']);
				$value2['separator'] = 0;
				$value2['link'] = trim(str_replace('&', '&amp;', $CONFIG_NOMCARPETA.'/'.folderPath($value['editora']).'/view.php?ID='.$row2['ID']));

				$subelements[] = $value2;
			}


		}
		else {
			$result2=db_query("select * from MENUITEMSSUB Where MENUITEM = '".$row['ID']."' ORDER BY ORDRE ASC,ID DESC");
			$subelements = array();
			while ($row2 = db_fetch_array($result2)) {
				$value2 = array();
				$value2['external'] = $row2['FINESTRA'];
				if (!empty($row2['IMATGE'])) {
					$value2['image'] = $urlmenu.'/img/'.$row2['IMATGE'];
				}
				$value2['title'] = str_replace('&', '&amp;', $row2['TEXT']);
				$value2['separator'] = $row2['SEPARATOR'];
				$value2['link'] = trim(str_replace('&', '&amp;', $row2['LINKPAGE']));
				$value2['liclass'] = $row2['CSSCLASS'];

				$subelements[] = $value2;
			}
		}

    $value['submenu'] = $subelements;


    $elements[] = $value;
  }


  $class = array('menu');
  if ($orientacio == 0 ) {
    $class[] = 'menu_vertical';
  }
  else {
    $class[] = 'menu_horitzontal';
  }
  if ($estil != '') {
    $class[] = $estil;
  }
  if ($tipus != '') {
    $class[] = $tipus;
  }

  $content = menu_generate_submenu(array('class' => $class, 'submenu' => $elements));

  /*afegir urls houdini*/
  if (file_exists($CONFIG_PATHADMIN.'/moduls/base/url_page.inc')) {
    require_once($CONFIG_PATHADMIN.'/moduls/base/url_page.inc');
    $content = url_filter($content);
  }

  return $content;

}



function menu_generate_element ($value) {
  $external = '';
  if (isset($value['external']) && $value['external']) {
    $external = ' rel="external"';
  }

  if (isset($value['image']) && $value['image'] != '') {
    $title = '<img src="'.$value['image'].'" alt="'.$value['title'].'" />';
  }
  else {
    $title = $value['title'];
  }

  $entry = '';
  if ($value['separator']) {
    $entry = '<hr />';
  }
  elseif (isset($value['link']) && $value['link'] != '') {
    $entry = '<a href="'.$value['link'].'"'.$external.'>'.$title.'</a>';
  }
  else {
    $entry = '<span>'.$title.'</span>';
  }

  $class = '';
  $phpMenuObert='';
  if (isset($value['liclass']) && $value['liclass'] != '') {
      if (isset($value['directori']) && $value['directori'] != -1) {
        $phpMenuObert = '<?php
        if (isset($directori) && in_array("'.$value['directori'].'", $directoris)) {
        ?> current<?php
        }
        ?>';
      } elseif (isset($value['editora']) && $value['editora'] != -1) {
        $phpMenuObert = '<?php
        if (isset($directori) && in_array("'.$value['editora'].'", $directoris)) {
        ?> current<?php
        }
        ?>';
      }else{
          $phpMenuObert = '<?php
          if("'.$value['link'].'" == $rutaplana or "'.$value['link'].'" == $_SERVER["REQUEST_URI"]) {
            ?> current<?php
            }
        ?>';
      }
    $class = ' class="'.$value['liclass'].$phpMenuObert.'"';
  }else{
      if (isset($value['directori']) && $value['directori'] != -1) {
        $phpMenuObert = '<?php
        if (isset($directori) && in_array("'.$value['directori'].'", $directoris)) {
        ?>current<?php
        }
        ?>';

      } elseif(isset($value['editora']) && $value['editora'] != -1) {
        $phpMenuObert = '<?php
        if (isset($directori) && in_array("'.$value['editora'].'", $directoris)) {
        ?> current<?php
        }
        ?>';
      }else{
          $phpMenuObert = '<?php
          if("'.$value['link'].'"== $rutaplana or "'.$value['link'].'" == $_SERVER["REQUEST_URI"]){
            ?>current<?php
            }
        ?>';
      }

      $class = $phpMenuObert != '' ? ' class="'.$phpMenuObert.'"' : '';
  }



  $submenu = menu_generate_submenu($value);

  $phpMenuIni = '';
  $phpMenuFi = '';
  if($submenu != '' && ($value['directori'] != -1 || $value['editora'] != -1)) {
    if($value['editora'] != -1) $value['directori'] = $value['editora'];

    $phpMenuIni = '<?php
if (isset($directori) && in_array("'.$value['directori'].'", $directoris)) {
?>';
    $phpMenuFi = '<?php
}
?>';
  }
  $submenu = $phpMenuIni.$submenu.$phpMenuFi;



  if ($entry != '') {
    return "<li".$class.">".$entry.$submenu."</li>\n";
  }
  else {
    return '';
  }
}

function menu_generate_submenu ($element) {
  if (!isset($element['submenu'])) {
    return '';
  }
  $menu = '';
  foreach ($element['submenu'] as $value) {
    $menu .= menu_generate_element ($value);
  }
  if ($menu != '') {
    $class = '';
    if (isset($element['class'])) {
      $class = implode (' ', $element['class']);
      $class = ' class="'.$class.'"';
    }

    return '
<ul'.$class.'>
'.$menu.'
</ul>
';
  }
  else {
    return '';
  }
}


?>
