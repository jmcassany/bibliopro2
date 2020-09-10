<?php
include_once (dirname(__FILE__) . '/fckeditor_264/fckeditor.php');
$editor_spellerLang = 'ca_ES';

function editor_head($lang = 'ca')
{
	global $editor_spellerLang;
	$langConvert = array(
		'ca' => 'ca_ES',
		'es' => 'es_ES',
		'fr' => 'fr_FR',
		'en' => 'en_GB'
	);
	$editor_spellerLang = $langConvert[$lang];
	return '';
}
/*tipus Antavianabasic, Antaviana*/

function editor_entry($name, $value = '', $type = 'Antaviana')
{
	global $CONFIG_URLADMIN;
	global $CONFIG_URLEDITOR;
	global $EDITOR_formats;
	global $CONFIG_URLCSS;
	global $editor_spellerLang;
	$fckpath = $CONFIG_URLEDITOR . '/fckeditor';

	$oFCKeditor = new FCKeditor($name);
	$oFCKeditor->BasePath = $fckpath . '/fckeditor_264/';
	$oFCKeditor->Value = $value;
	$oFCKeditor->ToolbarSet = $type;
	$oFCKeditor->Config['sLang'] = 'ca'; //idioma de l'interficie
	//toolbars personalitzats
	$oFCKeditor->Config['CustomConfigurationsPath'] = $fckpath . '/houdini.js';
	//fitxer amb estils
	$oFCKeditor->Config['EditorAreaCSS'] = $CONFIG_URLCSS . '/editor.css';
	//estils aplicables
	$oFCKeditor->Config['StylesXmlPath'] = $CONFIG_URLADMIN . '/config/fckstyles.xml';
	//directori de plugins
	$oFCKeditor->Config['PluginsPath'] = $fckpath . '/plugins/';
	/*corrector ortogràfic*/
	$oFCKeditor->Config['DefaultLanguage'] = 'ca';
	$oFCKeditor->Config['IncludeLatinEntities'] = false;
	$oFCKeditor->Config['SpellChecker'] = 'SpellerPages';
	$oFCKeditor->Config['SpellerLang'] = $editor_spellerLang;

	//browser
	$oFCKeditor->Config['ImageBrowserURL'] = $CONFIG_URLADMIN.'/moduls/uploads/gestor_uploads/browser_editor_visual_link.php?Type=imatges&Connector=connectors/php/connector.php';
	$oFCKeditor->Config['LinkBrowserURL'] = $CONFIG_URLADMIN.'/moduls/uploads/gestor_uploads/browser_editor_visual_link.php?Type=arxius&Connector=connectors/php/connector.php';
	//$oFCKeditor->Config['ImageBrowserURL'] = $CONFIG_URLADMIN . '/moduls/ajaxfilemanager/ajaxfilemanager.php?config=editor';
	//$oFCKeditor->Config['LinkBrowserURL'] = $CONFIG_URLADMIN . '/moduls/ajaxfilemanager/ajaxfilemanager.php?config=editor';
	$oFCKeditor->Config['FlashBrowserURL'] = $oFCKeditor->BasePath . 'editor/filemanager/browser/default/browser.html?Type=Flash&Connector=connectors/php/connector.php';
	$oFCKeditor->Config['LinkUploadURL'] = $oFCKeditor->BasePath . 'editor/filemanager/upload/php/upload.php';
	$oFCKeditor->Config['ImageUploadURL'] = $oFCKeditor->BasePath . 'editor/filemanager/upload/php/upload.php?Type=Image';
	$oFCKeditor->Config['FlashUploadURL'] = $oFCKeditor->BasePath . 'editor/filemanager/upload/php/upload.php?Type=Flash';

	$oFCKeditor->Config['EMailProtection'] = 'none';

	//mides del editor
	$oFCKeditor->Width = '558';
	$oFCKeditor->Height = '350';
	$oFCKeditor->Config['FontFormats'] = implode(';', $EDITOR_formats);
	$content = '<div style="position:relative;width:' . $oFCKeditor->Width . 'px;height:' . $oFCKeditor->Height . 'px;">';
	ob_start();
	$oFCKeditor->Create();
	$content.= ob_get_contents();
	ob_end_clean();
	$content.= '
</div>
';
	return $content;
}

function editor_filter($value)
{
	$value = str_replace('http://$link$/', '', $value);
	$value = str_replace('http://' . $_SERVER['SERVER_NAME'] . '/', '/', $value);
	return $value;
}
?>
