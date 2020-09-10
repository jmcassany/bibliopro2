<?php


/*funció que genera la imatge amb el titol*/
function graphic_title($title) {
  global $CONFIG_TITOLGRAFICCOLOR;
  global $CONFIG_TITOLGRAFICBGCOLOR;
  global $CONFIG_TITOLGRAFICFONT;
  global $CONFIG_TITOLGRAFICSIZE;

  /*calcular amplada del text*/

  $size = imagettfbbox( $CONFIG_TITOLGRAFICSIZE, 0, $CONFIG_TITOLGRAFICFONT, $title );

  /**
   * Obtenemos el ancho y alto final, aplicándole el desfase en píxeles asociado a la fuente definida en 'CONFIG_TITOLGRAFICFONT'
   * @see graphic_get_dip
   */

  $nImageWidth = abs( $size[ 2 ] - $size[ 0 ] ) + graphic_get_dip( $CONFIG_TITOLGRAFICFONT, $CONFIG_TITOLGRAFICSIZE );
  $nImageHeight = abs( $size[ 5 ] ) + graphic_get_dip( $CONFIG_TITOLGRAFICFONT, $CONFIG_TITOLGRAFICSIZE );

  $im = imagecreate( $nImageWidth, $nImageHeight );

  /*obtenir colors*/
  $fondo = imagecolorallocate($im, $CONFIG_TITOLGRAFICBGCOLOR['red'], $CONFIG_TITOLGRAFICBGCOLOR['green'], $CONFIG_TITOLGRAFICBGCOLOR['blue']);
  $color = imagecolorallocate($im, $CONFIG_TITOLGRAFICCOLOR['red'], $CONFIG_TITOLGRAFICCOLOR['green'], $CONFIG_TITOLGRAFICCOLOR['blue']);
  imagecolortransparent ($im ,$fondo);

  /*escriure text a la imatge*/
  imagettftext($im, $CONFIG_TITOLGRAFICSIZE, 0, - $size[ 0 ], abs( $size[5]- $size[3] )- $size[ 1 ], $color, $CONFIG_TITOLGRAFICFONT, $title);

  /*retorna les mides*/
  return array('image' => $im ,'width'=> $nImageWidth, 'height' => $nImageHeight );
}

/*funció que guarda la imatge en un fitxer*/
function graphic_title_save($title, $path) {

  $values = graphic_title($title);
  /*crea la imatge*/
  imagepng($values['image'], $path);
  imagedestroy($values['image']);

  /*retorna les mides*/
  return array('width'=>$values['width'],'height'=>$values['height']);
}

/*funció que guarda la imatge en un fitxer*/
function graphic_title_show($title) {
  $values = graphic_title($title);
  /*crea la imatge*/
  header("Content-type: image/png");
  echo imagepng($values['image']);
  imagedestroy($values['image']);
}



/*genera el titol i retorna el codi a insertar*/
function graphic_title_code($title, $name, $preview = false) {
  global $CONFIG_PATHTITLES;
  global $CONFIG_URLTITLES;
  global $CONFIG_URLADMIN;

  if (!$preview) {
    /*obté el la imatge desti*/
    $dest_path = $CONFIG_PATHTITLES.'/'.$name.'.png';
    $dest_url = urlDir($CONFIG_URLTITLES).'/'.$name.'.png';

    /*genera el titol grafic*/
    $size = graphic_title_save($title, $dest_path);

    /*genera el codi per la imatge*/
    $codiimatge='<img src="'.$dest_url.'"  alt="'.$title.'"  width="'.$size['width'].'" height="'.$size['height'].'" border="0" align="absmiddle" />';
  }
  else {
    $codiimatge='<img src="'.$CONFIG_URLADMIN.'/php/preview-graphic-title.php?title='.$title.'"  alt="'.$title.'" border="0" align="absmiddle" />';
  }

  return ($codiimatge);
}
/*inserta el titol gràfic en el contingut*/
function graphic_title_insert($title, $name, $var, $content, $preview = false) {

  $codiimatge = graphic_title_code($title, $name, $preview);

  /*substitueix la variable en el contingut*/
  return (str_replace($var, $codiimatge, $content));
}

/**
 * Try to determine the "dip" ( pixels dropped below baseline ) of this font for this size.
 *
 * @function graphic_get_dip
 * @param sFontFilePath ( string )
 * @param nFontSize ( int )
 * @return ( int )
 */

function graphic_get_dip($sFontFilePath,$nFontSize)
{
	$test_chars = 'abcdefghijklmnopqrstuvwxyz' .
			      'ABCDEFGHIJKLMNOPQRSTUVWXYZ' .
				  '1234567890' .
				  '!@#$%^&*()\'"\\/;.,`~<>[]{}-+_-=' ;
	$box = @imagettfbbox($nFontSize,0,$sFontFilePath, $test_chars );
	return $box[3] ;
}

?>