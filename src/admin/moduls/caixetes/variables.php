<?php

$tipus_caixetes = array(
  '0'=>array('nom'=>'Imatge','crear'=>'generar_imatge', 'defecte'=>1, 'mime'=>array('image/png','image/jpeg','image/gif','image/pjpeg')),
  '1'=>array('nom'=>'Flash','crear'=>'generar_flash', 'mime'=>array('application/x-shockwave-flash'), 'width'=>140),
  '2'=>array('nom'=>'Text','crear'=>'generar_text', 'width'=>140),
  '3'=>array('nom'=>'Lliure','crear'=>'generar_lliure', 'width'=>140),
  '4'=>array('nom'=>'PHP','crear'=>'generar_php', 'width'=>140)
);


function generar_imatge ($row, $preview = false) {
  global $CONFIG_PATHBOX, $CONFIG_URLBOX;
  global $CONFIG_BOXLOG;

  $rutaimatge = $CONFIG_PATHBOX.'/img/'.$row['IMATGE'];
  if ($preview) {
    $urlbox = $CONFIG_URLBOX;
  }
  else {
    $urlbox = urlDir($CONFIG_URLBOX);
  }
  $targeturl = $urlbox.'/img/'.$row['IMATGE'];


  $finestra = '';
  if($row['FINESTRA'] == 1) {
    $finestra=' rel="external"';
  }

  $text = '<img src="'.$targeturl.'" alt="'.$row['TITOL'].'" />';
  if (!empty($row['LINKC'])) {
    if ($CONFIG_BOXLOG) {
      //$text ='<a class="caixeta" href="'.$urlbox.'redireccionar.php?b=sup_'.$row['ID'].'&amp;url='.$row['LINKC'].'" '.$finestra.' onClick="javascript: _gaq.push([\'_trackPageview\', \'/banners/' . $row['ID'] . '/' . urlencode($row['NOM']) . '\']);">'.$text.'</a>';
      $text ='<a class="caixeta" href="'.$urlbox.'redireccionar.php?b=sup_'.$row['ID'].'&amp;url='.$row['LINKC'].'" '.$finestra.' onClick="_gaq.push([\'_trackEvent\', \'Banners\', \'' . $row['ID'] . '/' . urlencode($row['NOM']) . '\']);">'.$text.'</a>';

    }
    else {
      //$text ='<a href="'.$row['LINKC'].'" '.$finestra.' onClick="javascript: _gaq.push([\'_trackPageview\', \'/banners/' . $row['ID'] . '/' . urlencode($row['NOM']) . '\']);">'.$text.'</a>';
      $text ='<a href="'.$row['LINKC'].'" '.$finestra.' onClick="_gaq.push([\'_trackEvent\', \'Banners\', \'' . $row['ID'] . '/' . urlencode($row['NOM']) . '\']);">'.$text.'</a>';
    }
  }
  // Treiem la imatge en un paràgraf amb classe 'image'
  $text = "<p class=\"image\">".$text."</p>";
  return $text;
}

function generar_flash ($row, $preview = false) {
  global $CONFIG_PATHBOX, $CONFIG_URLBOX, $CONFIG_NOMCARPETA;

  if ($preview) {
    $urlbox = $CONFIG_URLBOX;
  }
  else {
    $urlbox = urlDir($CONFIG_URLBOX);
  }

  //rutes swf
  $ruta_flash = $CONFIG_PATHBOX.'/img/'.$row['IMATGE'];
  $targeturl_flash = $urlbox.'/img/'.$row['IMATGE'];
  if($row['IMATGE']!='' && file_exists($ruta_flash))
  {
	  //rutes imatge alternativa
	  $ruta_imatge_alternativa = $CONFIG_PATHBOX.'/img/'.$row['IMATGE_ALTERNATIVA'];
	  $targeturl_imatge_alternativa = $urlbox.'/img/'.$row['IMATGE_ALTERNATIVA'];
	  if ($row['IMATGE_ALTERNATIVA']!='' && file_exists($ruta_imatge_alternativa)) {
		$mides_imatge_alternativa = getimagesize($ruta_imatge_alternativa);
		$width = 'width="'.$mides_imatge_alternativa[0].'"';
		$height = 'height="'.$mides_imatge_alternativa[1].'"';
	  }
	  else {
	  	$targeturl_imatge_alternativa = $CONFIG_NOMCARPETA.'/media/comu/spacer.gif';
	    if ($row['HEIGHT']>0) {
	      $height = 'height="'.$row['HEIGHT'].'"';
	    }
	    if ($row['WIDTH']>0) {
	      $width = 'width="'.$row['WIDTH'].'"';
	    }
	  }
	   return '
	    <div id="flash_portada'.$row['ID'].'">
			<img src="'.$targeturl_imatge_alternativa.'" '.$height.' '.$width.' alt="'.$row['TITOL'].'" />
		</div>
		<script type="text/javascript">
			var fo = new SWFObject("'.$targeturl_flash.'", "flash_portada'.$row['ID'].'", "'.$row['WIDTH'].'", "'.$row['HEIGHT'].'", "6", "#ffffff");
			fo.addParam("menu", "false");
			fo.addParam("quality", "high");
			fo.addParam("wmode", "transparent")
			fo.write("flash_portada'.$row['ID'].'");
		</script>
		<!-- /flash -->';
  }
  return '';
}

function generar_text ($row, $preview = false) {
  global $CONFIG_URLBASE;
  global $CONFIG_BOXLOG, $CONFIG_URLBOX;
  global $CONFIG_URLCOMU;
  $text = '';

  if ($preview) {
    $urlbox = $CONFIG_URLBOX;
    $urlcomu = $CONFIG_URLCOMU;
  }
  else {
    $urlbox = urlDir($CONFIG_URLBOX);
    $urlcomu = urlDir($CONFIG_URLCOMU);
  }


  $finestra = '';
  if($row['FINESTRA'] == 1) {
    $finestra=' rel="external"';
  }

  if (!empty($row['LINKC'])) {
    if ($CONFIG_BOXLOG) {
      $text ='<p><a href="'.$urlbox."redireccionar.php?url=".$row['LINKC']."&amp;b=".$row['ID'].'" class="link-caixeta" '.$finestra.'>Més informació »</a></p>';
    }
    else {
      $text ='<p><a href="'.$row['LINKC'].'" class="link-caixeta" '.$finestra.'>Més informació »</a></p>';
    }
  }
  if (!empty($row['LINKC'])) {
    if ($CONFIG_BOXLOG) {
      $row["TITOL"] = '<h3><a href="'.$urlbox."redireccionar.php?url=".$row['LINKC']."&amp;b=".$row['ID'].'" title="Més informació sobre aquest tema" '.$finestra.'>'.$row['TITOL'].'</a></h3>';
    }
    else {
      $row["TITOL"] = '<h3><a href="'.$row['LINKC'].'" title="Més informació sobre aquest tema" '.$finestra.'>'.$row['TITOL'].'</a></h3>';
    }

  }
  else {
    $row["TITOL"] = '<h3>'.$row['TITOL'].'</h3>';
  }


  return '
<div class="caixeta">
  '.$row['TITOL'].'
  '.$row['TEXT'].'
  '.$text.'
</div>
';
}

function generar_lliure ($row, $preview = false) {
  return '
<div class="caixeta">
  '.$row['TEXT'].'
</div>
';
}

function generar_php ($row, $preview = false) {
  global $CONFIG_PATHPHP;
  $text = str_replace('|CONFIG_PATHPHP|', $CONFIG_PATHPHP, $row['TEXT']);
  return $text;
}

function caixeta_create($row, $preview = false) {
  global $CONFIG_BOXLOG, $CONFIG_URLBOX;
  global $tipus_caixetes;
  $contents = pageFilter(call_user_func($tipus_caixetes[$row['TIPO']]['crear'],$row));
  if ($CONFIG_BOXLOG) {
    $contents .= '<img src="'.urlDir($CONFIG_URLBOX).'redireccionar.php?b=sup_'.$row['ID'].'" width="0" height="0" style="display:none" />';
  }
  return $contents;
}

function caixeta_preview($row) {
  global $tipus_caixetes;
  return pageFilter((call_user_func($tipus_caixetes[$row['TIPO']]['crear'],$row, true)));
}

?>