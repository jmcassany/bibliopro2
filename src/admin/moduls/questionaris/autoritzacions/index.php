<?php
require (dirname(dirname(dirname(dirname(__FILE__)))) . '/config_admin.inc');
accessGroupPermCheck('questionaris');

require('autoritzacions.php');

$Tpl = new awTemplate();
$Tpl->scanFile("index0.tpl");

// Si hi ha cap problema -> Error
if (!$Tpl->Ok) { echo "<B>Error: Plantilla no trobada 'index.tpl'.</B><br>\n"; exit; }

unset($data);

$data['AVUI'] = date('Y-m-d H:i:s', time());
$data['USUARI']=accessGetLogin();
$data['CAPCELERA'] = htmlHeader();
$data['PEU'] = htmlFoot();
$data['METAS'] = htmlMetas();
$data['CONFIG_URLADMIN'] = $CONFIG_URLADMIN;

$textDefecte = 
'<p>Estimado Dr. #doctor#</p>
<p>Gracias por revisar la información sobre el instrumento #instrumento# recogida en BiblioPRO. La pàgina web de BiblioPRO está preparada para dar acceso a los instrumentos y distribuir las licencias de uso según las preferencias de cada autor. Por ello le solicitamos <strong>su autorización</strong> para incluir la <strong>versión española del cuestionario</strong> #instrumento# en BiblioPRO.</p>
<p>Para autorizar la inclusión del cuestionario en BiblioPRO puede:
<ul>
	<li>Hacer clic en el siguiente enlace y completar el formulario de autorización:<br/>#linkAutoritzacion#</li>
	<li>Contestar directamente por correo electrónico <strong>indicando su autorización</strong></li>
	<li>Completar el documento que <strong>le enviamos</strong> donde el autor elige las opciones de distribución.</li>
</ul>
<p>Además, si es posible, le agradeceríamos que <strong>nos envíe una copia del instrumento</strong> #instrumento# para incluirla en los materiales a los que puede tener acceso el usuario. Le enviaremos información anualmente sobre las solicitudes gestionadas a traves de BiblioPRO para este instrumento.</p>
<p>La participación de los autores resulta de gran ayuda para que sea una plataforma realmente útil para los investigadores de esta área, permitiendo <strong>compartir y divulgar su trabajo científico.</strong></p>

<p>Muchas gracias por su atención,<br/>
Reciba un saludo cordial,
El equipo BiblioPRO</p>';

$data['editor_text'] = editor_entry('textCorreu', $textDefecte,'Antavianabasic'); 

$result = db_query('SELECT * FROM ' . TAULA_CUESTIONARIS . ' WHERE 1=1 AND NOM_ORIGINAL != "" ORDER BY ID_CUEST, NOM_ORIGINAL');
$data['OPTIONS_CUESTIONARIS'] = '';
while ($cuestionario = db_fetch_array($result)) {
	$data['OPTIONS_CUESTIONARIS'] .= '<option value="' . $cuestionario['ID_CUEST'] . '">' . $cuestionario['ID_CUEST'] . ': ' . $cuestionario['SIGLAS'] . ' / ' . $cuestionario['NOM_ORIGINAL'] . '</option>';
}

// OUTPUT ALL
echo $Tpl->mergeBlock('ALL',$data);

?>