<?php
$SETTINGS['settings_file'] = 'settings/settings.inc.php';
$SETTINGS['files_file'] = 'settings/files.inc.php';
$SETTINGS['script'] = '/devel-houdini/admin/moduls/sitemap/index.php';
$SETTINGS['debug'] = '';
$SETTINGS['state'] = 'getSettings';
$SETTINGS['executed']['getSettings'] = '1';
$SETTINGS['timeout_automatic'] = '';

$SETTINGS['website'] = $CONFIG_URLBASE.'/';
$SETTINGS['page_root'] = $CONFIG_PATHBASE.'/';
$SETTINGS['crawler_url'] = $SETTINGS['website'];



$SETTINGS['sitemap_file'] = '/sitemap.xml.gz';
$SETTINGS['txtsitemap_file'] = '/sitemap.txt';
$SETTINGS['sitemap_url'] = str_replace('//', '/', $CONFIG_NOMCARPETA.$SETTINGS['sitemap_file']);
$SETTINGS['txtsitemap_url'] = str_replace('//', '/', $CONFIG_NOMCARPETA.$SETTINGS['txtsitemap_file']);
$SETTINGS['timeout'] = 'timeout_force';
$SETTINGS['timeout_duration'] = '30';
$SETTINGS['scan_local'] = '1';
$SETTINGS['scan_website'] = '1';
$SETTINGS['ping_google'] = '1';
$SETTINGS['scan_website_level'] = '0';
$SETTINGS['edit_result'] = 'edit_result_TRUE';
$SETTINGS['store_filelist'] = 'TRUE';
$SETTINGS['lastmod'] = 'lastmod_filedate';
$SETTINGS['lastmod_format'] = 'long';
$SETTINGS['changefreq'] = 'changefreq_fixed';
$SETTINGS['changefreq_fixed'] = 'weekly';
$SETTINGS['priority'] = 'priority_fixed';
$SETTINGS['priority_fixed'] = '0.5';
$SETTINGS['disallow_dir'] = array('/admin/','/media/','/lib/');
$SETTINGS['disallow_file'] = array('.xml','.inc','.old','.bak','.save','.txt','.js','~','.LCK','.zip','.ZIP','.bmp','.BMP','.jpg','.jpeg','.JPG','.GIF','.PNG','.png','.gif','.CSV','.csv','.css','.class','.jar','.tpl');

$SETTINGS['disallow_key'] = array('PHPSESSID','sid');

$SETTINGS['compress_sitemap'] = '1';
$SETTINGS['temp_dir'] = '/home/share/Feines/devel-houdini/admin/moduls/phpSitemapNG/inc/functions/temp/';
$SETTINGS['public_url'] = '/home/share/Proves//phpsitemapng.php';
$SETTINGS['timeout_is'] = '';
$SETTINGS['timeout_time'] = '1199450811.72';
$SETTINGS['timeout_shutdown'] = '3';
$SETTINGS['timeout_deadline'] = '1199450838.72';
?>