<?php

/*Activa el filtrat de text que s'introduex al fckeditor*/
$htmlFilter = true;

//s'utilitza abanç del filtrat dels tags
//el remplaçament es fa en l'ordre en que s'han posat a la variable
$htmlFilter_pre_replace = array(
"@<b([> ])@i" => "<strong\\1", // canvia els tacs obsolets b per strong
"@</b([> ])@i" => "</strong\\1", // canvia els tacs obsolets b per strong
"@<i([> ])@i" => "<em\\1", // canvia els tacs obsolets i per em
"@</i([> ])@i" => "</em\\1", // canvia els tacs obsolets i per em
"@class=\"(\s*?)\"@i" => "", // elimina classes buides
"@id=\"(\s*?)\"@i" => "", // elimina identificadors buits
"@\s+?class=\"(\s*?)([^\s>]+?)((\s*?[^\s>]+?)*?)(\s*?)\"@i" => " class=\"\\2\\3\"", //elimina espais al inici i al final del llistat de classes
"@\s+?id=\"(\s*?)([^\s>]+?)((\s*?[^\s]+?)*?)(\s*?)\"@i" => " id=\"\\2\\3\"", //elimina espais al inici i al final del llistat de ids
);

//s'utilitza despres del filtrat dels tags
//el remplaçament es fa en l'ordre en que s'han posat a la variable
$htmlFilter_post_replace = array(
"@<(p|span|li|ul|ol|div)([^>]*?)>&nbsp;</\\1>@i" => '', // elimina els tacs que només tenen un espai
"@<(p|span|li|ul|ol|div)([^>]*?)>\s*?</\\1>@i" => '', // elimina els tacs buits

"@<h([1-6])([^>]*?)>&nbsp;</h\\1>@i" => '',// elimina els h span que només tenen un espai
"@<h([1-6])([^>]*?)>\s*?</h\\1>@i" => '', // elimina els h span buits

"@class=\"(\s*?)\"@i" => '', // eliminar els atributs class que estan buits
"@<br([^>]*?)>([\s\n]*?)</(a|span|strong|em)>@si" => "</\\3>\\2<br\\1>", // arregla bug del fckeditor que posar el br dins d'un tac inline
"@<p>\s*<table([^>]*?)>(.*?)</table>\s*</p>@is" => '<table\\1>\\2</table>' //elimina els p que el fckeditor posa al voltant de les tauels
);


//configuració del kses
//atributs acceptats en tots els tacs
$standardAttributes = array('title' => 1, 'id' => 1, 'style' => 1, 'class' => 1, 'lang' => 1, 'xml:lang' => 1, 'dir' => 1, 'accesskey' => 1, 'tabindex' => 1);

//tacs permessos amb els parametres
$htmlFilter_allowed = array(
'a' => array_merge($standardAttributes, array('href' => 1, 'rel' => 1, 'name' => 1)),
'img' => array_merge($standardAttributes, array('src' => 1, 'alt' => 1, 'longdesc' => 1, 'height' => 1, 'width' => 1)),
'p' => $standardAttributes,
'span' => $standardAttributes,
'div' => $standardAttributes,
'ul' => $standardAttributes,
'li' => $standardAttributes,
'ol' => $standardAttributes,
'dt' => $standardAttributes,
'dd' => $standardAttributes,
'address' => $standardAttributes,
'cite' => $standardAttributes,
'code' => $standardAttributes,
'kbd' => $standardAttributes,
'strong' => $standardAttributes,
'em' => $standardAttributes,
'h1' => $standardAttributes,
'h2' => $standardAttributes,
'h3' => $standardAttributes,
'h4' => $standardAttributes,
'h5' => $standardAttributes,
'h6' => $standardAttributes,
'hr' => $standardAttributes,
'br' => $standardAttributes,
'sub' => $standardAttributes,
'sup' => $standardAttributes,
'iframe' => array_merge($standardAttributes, array('width' => 1, 'height' => 1, 'src' => 1, 'frameborder' => 1, 'allow' => 1, 'allowfullscreen' => 1)),
'table' => array_merge($standardAttributes, array('summary' => 1)),
'caption' => $standardAttributes,
'th' => array_merge($standardAttributes, array('colspan' => 1, 'headers' => 1, 'rowspan' => 1, 'scope' => 1)),
'tr' => $standardAttributes,
'td' => array_merge($standardAttributes, array('colspan' => 1, 'headers' => 1, 'rowspan' => 1, 'scope' => 1)),
'tbody' => $standardAttributes,
'tfoot' => $standardAttributes,

'form' => array_merge($standardAttributes, array('action' => 1, 'enctype' => 1, 'method' => 1, 'name' => 1)),
'input' => array_merge($standardAttributes, array('checked' => 1, 'alt' => 1, 'disabled' => 1, 'maxlength' => 1, 'name' => 1, 'readonly'   => 1, 'size' => 1, 'src' => 1, 'type' => 1, 'value' => 1)),
'select' => array_merge($standardAttributes, array('disabled' => 1, 'name' => 1, 'size'   => 1, 'multiple' => 1)),
'button' => array_merge($standardAttributes, array('disabled' => 1, 'name' => 1, 'size'   => 1, 'type' => 1)),
'fieldset' => $standardAttributes,
'legend' => $standardAttributes,
'textarea' => array_merge($standardAttributes, array('cols' => 1, 'rows' => 1, 'disabled' => 1, 'name' => 1, 'readonly' => 1))
);

//tacs simples on s'hi ha d'afegir el tancament
$htmlFilter_closed_tags = array(
'br', 'img', 'button', 'input', 'hr'
);




/*Activa el filtrat del contingut del textarea abanç de generar-la*/
$textareaFilter = true;

//el remplaçament es fa en l'ordre en que s'han posat a la variable
$textareaFilter_replace = array(
//modifica els elements de classe txtImg per adaptar-los al css
"@<(p|ul|ol)[^>]*?class=\"txtImgEsq\"[^>]*?>\s*(<(strong|span|em)[^>]*?>)?\s*(<img[^>]*>)(.*?)</(p|ul|ol)>((\s*<(p|ul|ol)[^>]*?class=\"txtImgEsqCont\"[^>]*?>.*?</(p|ul|ol)>)*)@is" =>
"<div class=\"txtImgEsq clearfix\">\\4<\\1>\\2\\5</\\6>\\7</div>",
"@<(p|ul|ol)[^>]*?class=\"txtImgEsq\"[^>]*?>\s*(<(strong|span|em)[^>]*?>)?\s*(<a.*?<img[^>]*></a>)(.*?)</(p|ul|ol)>((\s*<(p|ul|ol)[^>]*?class=\"txtImgEsqCont\"[^>]*?>.*?</(p|ul|ol)>)*)@is" =>
"<div class=\"txtImgEsq clearfix\">\\4<\\1>\\2\\5</\\6>\\7</div>",
"@<(p|ul|ol)[^>]*?class=\"txtImgDr\"[^>]*?>\s*(<(strong|span|em)[^>]*?>)?\s*(<img[^>]*>)(.*?)</(p|ul|ol)>((\s*<(p|ul|ol)[^>]*?class=\"txtImgDrCont\"[^>]*?>.*?</(p|ul|ol)>)*)@is" =>
"<div class=\"txtImgDr clearfix\">\\4<\\1>\\2\\5</\\6>\\7</div>",
"@<(p|ul|ol)[^>]*?class=\"txtImgDr\"[^>]*?>\s*(<(strong|span|em)[^>]*?>)?\s*(<a.*?<img[^>]*></a>)(.*?)</(p|ul|ol)>((\s*<(p|ul|ol)[^>]*?class=\"txtImgDrCont\"[^>]*?>.*?</(p|ul|ol)>)*)@is" =>
"<div class=\"txtImgDr clearfix\">\\4<\\1>\\2\\5</\\6>\\7</div>"
);


/*Activa el filtrat del contingut de la pàgina abanç de generar-la*/
$pageFilter = true;

//el remplaçament es fa en l'ordre en que s'han posat a la variable
$pageFilter_replace = array(
//filtrat antispam
"@<a(\s*?)href=\"mailto:(.*?)\@(.*?)\"(.*?)>(.*?)(\@(.*?))?</a>@is" =>
"<a \\1 href=\"mailto:\\2(ELIMINAR)@\\3\" \\4>\\5(ELIMINAR)\\6</a>"
);



?>
