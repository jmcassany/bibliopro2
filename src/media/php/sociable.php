<?php
/*basat en el plugin de wordpress Sociable escrit per Joost de Valk*/

$active_sites = array(
	'Facebook',
	'del.icio.us',
	'Technorati',
	'latafanera',
	'Meneame',
	'MySpace'
);


$sociable_known_sites = Array(

	'BarraPunto' => Array(
		'favicon' => 'barrapunto.png',
		'url' => 'http://barrapunto.com/submit.pl?subj=TITLE&amp;story=PERMALINK',
	),

	'Bitacoras.com' => Array(
		'favicon' => 'bitacoras.png',
		'url' => 'http://bitacoras.com/anotaciones/PERMALINK',
	),

	'blinkbits' => Array(
		'favicon' => 'blinkbits.png',
		'url' => 'http://www.blinkbits.com/bookmarklets/save.php?v=1&amp;source_url=PERMALINK&amp;title=TITLE&amp;body=TITLE',
	),

	'BlinkList' => Array(
		'favicon' => 'blinklist.png',
		'url' => 'http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Url=PERMALINK&amp;Title=TITLE',
	),

	'BlogMemes' => Array(
		'favicon' => 'blogmemes.png',
		'url' => 'http://www.blogmemes.net/post.php?url=PERMALINK&amp;title=TITLE',
	),

	'BlogMemes Fr' => Array(
		'favicon' => 'blogmemes.png',
		'url' => 'http://www.blogmemes.fr/post.php?url=PERMALINK&amp;title=TITLE',
	),

	'BlogMemes Sp' => Array(
		'favicon' => 'blogmemes.png',
		'url' => 'http://www.blogmemes.com/post.php?url=PERMALINK&amp;title=TITLE',
	),

	'BlogMemes Cn' => Array(
		'favicon' => 'blogmemes.png',
		'url' => 'http://www.blogmemes.cn/post.php?url=PERMALINK&amp;title=TITLE',
	),

	'BlogMemes Jp' => Array(
		'favicon' => 'blogmemes.png',
		'url' => 'http://www.blogmemes.jp/post.php?url=PERMALINK&amp;title=TITLE',
	),

	'blogmarks' => Array(
		'favicon' => 'blogmarks.png',
		'url' => 'http://blogmarks.net/my/new.php?mini=1&amp;simple=1&amp;url=PERMALINK&amp;title=TITLE',
	),

	'Blogosphere News' => Array(
		'favicon' => 'blogospherenews.png',
		'url' => 'http://www.blogospherenews.com/submit.php?url=PERMALINK&amp;title=TITLE',
	),

	'Blogsvine' => Array(
		'favicon' => 'blogsvine.png',
		'url' => 'http://blogsvine.com/submit.php?url=PERMALINK',
	),

	'blogtercimlap' => Array(
		'favicon' => 'blogter.png',
		'url' => 'http://cimlap.blogter.hu/index.php?action=suggest_link&amp;title=TITLE&amp;url=PERMALINK',
	),

	'Faves' => Array(
		'favicon' => 'bluedot.png',
		'url' => 'http://faves.com/Authoring.aspx?u=PERMALINK&amp;title=TITLE',
	),

	'Book.mark.hu' => Array(
		'favicon' => 'bookmarkhu.png',
		'url' => 'http://book.mark.hu/bookmarks.php/?action=add&amp;address=PERMALINK%2F&amp;title=TITLE',
	),

	'Bumpzee' => Array(
		'favicon' => 'bumpzee.png',
		'url' => 'http://www.bumpzee.com/bump.php?u=PERMALINK',
	),

	'co.mments' => Array(
		'favicon' => 'co.mments.png',
		'url' => 'http://co.mments.com/track?url=PERMALINK&amp;title=TITLE',
	),

	'connotea' => Array(
		'favicon' => 'connotea.png',
		'url' => 'http://www.connotea.org/addpopup?continue=confirm&amp;uri=PERMALINK&amp;title=TITLE',
	),


	'del.icio.us' => Array(
		'favicon' => 'delicious.png',
		'url' => 'http://del.icio.us/post?url=PERMALINK&amp;title=TITLE',
	),

	'De.lirio.us' => Array(
		'favicon' => 'delirious.png',
		'url' => 'http://de.lirio.us/rubric/post?uri=PERMALINK;title=TITLE;when_done=go_back',
	),

	'Design Float' => Array(
		'favicon' => 'designfloat.png',
		'url' => 'http://www.designfloat.com/submit.php?url=PERMALINK&amp;title=TITLE',
	),

	'Digg' => Array(
		'favicon' => 'digg.png',
		'url' => 'http://digg.com/submit?phase=2&amp;url=PERMALINK&amp;title=TITLE',
		'description' => 'Digg',
	),

	'DotNetKicks' => Array(
		'favicon' => 'dotnetkicks.png',
		'url' => 'http://www.dotnetkicks.com/kick/?url=PERMALINK&amp;title=TITLE',
	),

	'DZone' => Array(
		'favicon' => 'dzone.png',
		'url' => 'http://www.dzone.com/links/add.html?url=PERMALINK&amp;title=TITLE',
	),

	'eKudos' => Array(
		'favicon' => 'ekudos.png',
		'url' => 'http://www.ekudos.nl/artikel/nieuw?url=PERMALINK&amp;title=TITLE',
	),

//	'email' => Array(
//		'favicon' => 'email_link.png',
//		'url' => 'mailto:?subject=TITLE&amp;body=PERMALINK',
//		'description' => __('E-mail this story to a friend!','sociable'),
//	),

	'Facebook' => Array(
		'favicon' => 'facebook.png',
		'url' => 'http://www.facebook.com/share.php?u=PERMALINK&amp;t=TITLE',
	),

	'Fark' => Array(
		'favicon' => 'fark.png',
		'url' => 'http://cgi.fark.com/cgi/fark/farkit.pl?h=TITLE&amp;u=PERMALINK',
	),

	'feedmelinks' => Array(
		'favicon' => 'feedmelinks.png',
		'url' => 'http://feedmelinks.com/categorize?from=toolbar&amp;op=submit&amp;url=PERMALINK&amp;name=TITLE',
	),

	'Furl' => Array(
		'favicon' => 'furl.png',
		'url' => 'http://www.furl.net/storeIt.jsp?u=PERMALINK&amp;t=TITLE',
	),

	'Fleck' => Array(
		'favicon' => 'fleck.png',
		'url' => 'http://extension.fleck.com/?v=b.0.804&amp;url=PERMALINK',
	),

	'GeenRedactie' => array(
		'favicon' => 'geenredactie.png',
		'url'=> 'http://www.geenredactie.nl/submit?url=PERMALINK&amp;title=TITLE'
	),

	'Global Grind' => Array (
		'favicon' => 'globalgrind.png',
		'url' => 'http://globalgrind.com/submission/submit.aspx?url=PERMALINK&amp;type=Article&amp;title=TITLE'
	),

	'Google' => Array (
		'favicon' => 'googlebookmark.png',
		'url' => 'http://www.google.com/bookmarks/mark?op=edit&amp;bkmk=PERMALINK&amp;title=TITLE'
	),

	'Gwar' => Array(
		'favicon' => 'gwar.png',
		'url' => 'http://www.gwar.pl/DodajGwar.html?u=PERMALINK',
	),

	'Haohao' => Array(
		'favicon' => 'haohao.png',
		'url' => 'http://www.haohaoreport.com/submit.php?url=PERMALINK&amp;title=TITLE',
	),

	'HealthRanker' => Array(
		'favicon' => 'healthranker.png',
		'url' => 'http://healthranker.com/submit.php?url=PERMALINK&amp;title=TITLE',
	),

	'Hemidemi' => Array(
		'favicon' => 'hemidemi.png',
		'url' => 'http://www.hemidemi.com/user_bookmark/new?title=TITLE&amp;url=PERMALINK',
	),

	'Identi.ca' => Array(
		'favicon' => 'identica.png',
		'url' => 'http://identi.ca/notice/new?status_textarea=PERMALINK',
	),

	'IndianPad' => Array(
		'favicon' => 'indianpad.png',
		'url' => 'http://www.indianpad.com/submit.php?url=PERMALINK',
	),

	'Internetmedia' => Array(
		'favicon' => 'im.png',
		'url' => 'http://internetmedia.hu/submit.php?url=PERMALINK'
	),

	'kick.ie' => Array(
		'favicon' => 'kickit.png',
		'url' => 'http://kick.ie/submit/?url=PERMALINK&amp;title=TITLE',
	),

	'Kirtsy' => Array(
		'favicon' => 'kirtsy.png',
		'url' => 'http://www.kirtsy.com/submit.php?url=PERMALINK&amp;title=TITLE',
	),

	'laaik.it' => Array(
		'favicon' => 'laaikit.png',
		'url' => 'http://laaik.it/NewStoryCompact.aspx?uri=PERMALINK&amp;headline=TITLE&amp;cat=5e082fcc-8a3b-47e2-acec-fdf64ff19d12',
	),

	'latafanera' => array(
		'favicon' => 'latafanera.gif',
		'url' => 'http://latafanera.cat/submit.php?url=PERMALINK',
	),

	'Leonaut' => Array(
		'favicon' => 'leonaut.png',
		'url' => 'http://www.leonaut.com/submit.php?url=PERMALINK&amp;title=TITLE'
	),

	'LinkArena' => Array(
		'favicon' => 'linkarena.png',
		'url' => 'http://linkarena.com/bookmarks/addlink/?url=PERMALINK&amp;title=TITLE',
	),

	'LinkaGoGo' => Array(
		'favicon' => 'linkagogo.png',
		'url' => 'http://www.linkagogo.com/go/AddNoPopup?url=PERMALINK&amp;title=TITLE',
	),

	'LinkedIn' => Array(
		'favicon' => 'linkedin.png',
		'url' => 'http://www.linkedin.com/shareArticle?mini=true&amp;url=PERMALINK&amp;title=TITLE&amp;source=BLOGNAME&amp;summary=EXCERPT',
	),

	'Linkter' => Array(
		'favicon' => 'linkter.png',
		'url' => 'http://www.linkter.hu/index.php?action=suggest_link&amp;url=PERMALINK&amp;title=TITLE',
	),

	'Live' => Array(
		'favicon' => 'live.png',
		'url' => 'https://favorites.live.com/quickadd.aspx?marklet=1&amp;url=PERMALINK&amp;title=TITLE',
	),

	'Ma.gnolia' => Array(
		'favicon' => 'magnolia.png',
		'url' => 'http://ma.gnolia.com/bookmarklet/add?url=PERMALINK&amp;title=TITLE',
	),

	'Meneame' => Array(
		'favicon' => 'meneame.png',
		'url' => 'http://meneame.net/submit.php?url=PERMALINK',
	),

	'MisterWong' => Array(
		'favicon' => 'misterwong.png',
		'url' => 'http://www.mister-wong.com/addurl/?bm_url=PERMALINK&amp;bm_description=TITLE&amp;plugin=soc',
	),

	'MisterWong.DE' => Array(
		'favicon' => 'misterwong.png',
		'url' => 'http://www.mister-wong.de/addurl/?bm_url=PERMALINK&amp;bm_description=TITLE&amp;plugin=soc',
	),

	'Mixx' => Array(
		'favicon' => 'mixx.png',
		'url' => 'http://www.mixx.com/submit?page_url=PERMALINK&amp;title=TITLE',
	),

	'muti' => Array(
		'favicon' => 'muti.png',
		'url' => 'http://www.muti.co.za/submit?url=PERMALINK&amp;title=TITLE',
	),

	'MyShare' => Array(
		'favicon' => 'myshare.png',
		'url' => 'http://myshare.url.com.tw/index.php?func=newurl&amp;url=PERMALINK&amp;desc=TITLE',
	),

	'MySpace' => Array(
		'favicon' => 'myspace.png',
		'url' => 'http://www.myspace.com/Modules/PostTo/Pages/?u=PERMALINK&amp;t=TITLE',
	),

	'N4G' => Array(
		'favicon' => 'n4g.png',
		'url' => 'http://www.n4g.com/tips.aspx?url=PERMALINK&amp;title=TITLE',
	),

	'Netvibes' => Array(
		'favicon' => 'netvibes.png',
		'url' =>	'http://www.netvibes.com/share?title=TITLE&amp;url=PERMALINK',
	),

	'NewsVine' => Array(
		'favicon' => 'newsvine.png',
		'url' => 'http://www.newsvine.com/_tools/seed&amp;save?u=PERMALINK&amp;h=TITLE',
	),

	'Netvouz' => Array(
		'favicon' => 'netvouz.png',
		'url' => 'http://www.netvouz.com/action/submitBookmark?url=PERMALINK&amp;title=TITLE&amp;popup=no',
	),

	'NuJIJ' => Array(
		'favicon' => 'nujij.png',
		'url' => 'http://nujij.nl/jij.lynkx?t=TITLE&amp;u=PERMALINK',
	),

	'Ping.fm' => Array(
		'favicon' => 'ping.png',
		'url' => 'http://ping.fm/ref/?link=PERMALINK&amp;title=TITLE',
	),

	'PlugIM' => Array(
		'favicon' => 'plugim.png',
		'url' => 'http://www.plugim.com/submit?url=PERMALINK&amp;title=TITLE',
	),

	'Pownce' => Array(
		'favicon' => 'pownce.png',
		'url' => 'http://pownce.com/send/link/?url=PERMALINK&amp;note_body=TITLE&amp;note_to=all'
	),

	'ppnow' => Array(
		'favicon' => 'ppnow.png',
		'url' => 'http://www.ppnow.net/submit.php?url=PERMALINK',
	),

//	'Print' => Array(
//		'favicon' => 'printer.png',
//		'url' => 'javascript:window.print();',
//		'description' => __('Print this article!', 'sociable'),
//	),

	'Propeller' => Array(
		'favicon' => 'propeller.png',
		'url' => 'http://www.propeller.com/submit/?url=PERMALINK',
	),

	'Ratimarks' => Array(
		'favicon' => 'ratimarks.png',
		'url' => 'http://ratimarks.org/bookmarks.php/?action=add&address=PERMALINK&amp;title=TITLE',
	),

	'Rec6' => Array(
		'favicon' => 'rec6.png',
		'url' => 'http://www.syxt.com.br/rec6/link.php?url=PERMALINK&amp;=TITLE',
	),

	'Reddit' => Array(
		'favicon' => 'reddit.png',
		'url' => 'http://reddit.com/submit?url=PERMALINK&amp;title=TITLE',
	),

	'SalesMarks' => Array(
		'favicon' => 'salesmarks.png',
		'url' => 'http://salesmarks.com/submit?edit[url]=PERMALINK&amp;edit[title]=TITLE',
	),

	'Scoopeo' => Array(
		'favicon' => 'scoopeo.png',
		'url' => 'http://www.scoopeo.com/scoop/new?newurl=PERMALINK&amp;title=TITLE',
	),

	'scuttle' => Array(
		'favicon' => 'scuttle.png',
		'url' => 'http://www.scuttle.org/bookmarks.php/maxpower?action=add&amp;address=PERMALINK&amp;title=TITLE',
		'description' => 'description',
	),

	'Segnalo' => Array(
		'favicon' => 'segnalo.png',
		'url' => 'http://segnalo.alice.it/post.html.php?url=PERMALINK&amp;title=TITLE',
	),

	'Shadows' => Array(
		'favicon' => 'shadows.png',
		'url' => 'http://www.shadows.com/features/tcr.htm?url=PERMALINK&amp;title=TITLE',
	),

	'Simpy' => Array(
		'favicon' => 'simpy.png',
		'url' => 'http://www.simpy.com/simpy/LinkAdd.do?href=PERMALINK&amp;title=TITLE',
	),

	'Slashdot' => Array(
		'favicon' => 'slashdot.png',
		'url' => 'http://slashdot.org/bookmark.pl?title=TITLE&amp;url=PERMALINK',
	),

	'Smarking' => Array(
		'favicon' => 'smarking.png',
		'url' => 'http://smarking.com/editbookmark/?url=PERMALINK&amp;title=TITLE',
	),

	'Socialogs' => Array(
		'favicon' => 'socialogs.png',
		'url' => 'http://socialogs.com/add_story.php?story_url=PERMALINK&amp;story_title=TITLE',
	),

	'Spurl' => Array(
		'favicon' => 'spurl.png',
		'url' => 'http://www.spurl.net/spurl.php?url=PERMALINK&amp;title=TITLE',
	),

	'SphereIt' => Array(
		'favicon' => 'sphere.png',
		'url' => 'http://www.sphere.com/search?q=sphereit:PERMALINK&amp;title=TITLE',
	),

	'Sphinn' => Array(
		'favicon' => 'sphinn.png',
		'url' => 'http://sphinn.com/submit.php?url=PERMALINK&amp;title=TITLE',
	),

	'StumbleUpon' => Array(
		'favicon' => 'stumbleupon.png',
		'url' => 'http://www.stumbleupon.com/submit?url=PERMALINK&amp;title=TITLE',
	),

	'Symbaloo' => Array(
		'favicon' => 'symbaloo.png',
		'url' => 'http://www.symbaloo.com/nl/add/url=PERMALINK&amp;title=TITLE&amp;icon=http%3A//static01.symbaloo.com/_img/favicon.png',
	),

	'Taggly' => Array(
		'favicon' => 'taggly.png',
		'url' => 'http://taggly.com/bookmarks.php/pass?action=add&amp;address=',
	),

	'Technorati' => Array(
		'favicon' => 'technorati.png',
		'url' => 'http://technorati.com/faves?add=PERMALINK',
	),

	'TailRank' => Array(
		'favicon' => 'tailrank.png',
		'url' => 'http://tailrank.com/share/?text=&amp;link_href=PERMALINK&amp;title=TITLE',
	),

	'ThisNext' => Array(
		'favicon' => 'thisnext.png',
		'url' => 'http://www.thisnext.com/pick/new/submit/sociable/?url=PERMALINK&amp;name=TITLE',
	),

	'Tipd' => Array(
		'favicon' => 'tipd.png',
		'url' => 'http://tipd.com/submit.php?url=PERMALINK',
	),

	'Tumblr' => Array(
		'favicon' => 'tumblr.png',
		'url' => 'http://www.tumblr.com/share?v=3&amp;u=PERMALINK&amp;t=TITLE&amp;s=',
	),

	'TwitThis' => Array(
		'favicon' => 'twitter.png',
		'url' => 'http://twitter.com/home?status=PERMALINK',
	),

	'Upnews' => Array(
			'favicon' => 'upnews.png',
			'url' => 'http://www.upnews.it/submit?url=PERMALINK&amp;title=TITLE',
	),

	'Webnews.de' => Array(
		'favicon' => 'webnews.png',
		'url' => 'http://www.webnews.de/einstellen?url=PERMALINK&amp;title=TITLE',
	),

	'Webride' => Array(
		'favicon' => 'webride.png',
		'url' => 'http://webride.org/discuss/split.php?uri=PERMALINK&amp;title=TITLE',
	),

	'Wikio' => Array(
		'favicon' => 'wikio.png',
		'url' => 'http://www.wikio.com/vote?url=PERMALINK',
	),

	'Wikio FR' => Array(
		'favicon' => 'wikio.png',
		'url' => 'http://www.wikio.fr/vote?url=PERMALINK',
	),

	'Wikio IT' => Array(
		'favicon' => 'wikio.png',
		'url' => 'http://www.wikio.it/vote?url=PERMALINK',
	),

	'Wists' => Array(
		'favicon' => 'wists.png',
		'url' => 'http://wists.com/s.php?c=&amp;r=PERMALINK&amp;title=TITLE',
		'class' => 'wists',
	),

	'Wykop' => Array(
		'favicon' => 'wykop.png',
		'url' => 'http://www.wykop.pl/dodaj?url=PERMALINK',
	),

	'Xerpi' => Array(
		'favicon' => 'xerpi.png',
		'url' => 'http://www.xerpi.com/block/add_link_from_extension?url=PERMALINK&amp;title=TITLE',
	),

	'YahooBuzz' => Array(
		'favicon' => 'yahoobuzz.png',
		'url' => 'http://buzz.yahoo.com/submit/?submitUrl=PERMALINK&amp;submitHeadline=TITLE&amp;submitSummary=EXCERPT&amp;submitCategory=science&amp;submitAssetType=text',
		'description' => 'Yahoo! Buzz',
	),

	'YahooMyWeb' => Array(
		'favicon' => 'yahoomyweb.png',
		'url' => 'http://myweb2.search.yahoo.com/myresults/bookmarklet?u=PERMALINK&amp;=TITLE',
	),

	'Yigg' => Array(
		'favicon' => 'yiggit.png',
		'url' => 'http://yigg.de/neu?exturl=PERMALINK&amp;exttitle=TITLE',
	 ),
);

function sociable($url, $title = '', $sitename = '', $rss = '', $sumary = '', $blank = true) {
	global $CONFIG_NOMCARPETA, $active_sites, $sociable_known_sites;

	$imagepath = $CONFIG_NOMCARPETA.'/media/comu/sociable/';
	$html = '';

	// Load the post's data
	$blogname = urlencode($sitename);

	$excerpt = urlencode(strip_tags($sumary));
	$excerpt = str_replace('+','%20',$excerpt);

	$permalink = urlencode($url);

	$title = urlencode($title);
	$title = str_replace('+','%20',$title);

	$rss = urlencode($rss);

	$html .= "\n<div class=\"sociable\">\n";

	$html .= "\n<ul>\n";

	foreach($active_sites as $sitename) {
		// if they specify an unknown or inactive site, ignore it

		if (!isset($sociable_known_sites[$sitename])) {
			continue;
		}

		$site = $sociable_known_sites[$sitename];

		$url = $site['url'];
		$url = str_replace('PERMALINK', $permalink, $url);
		$url = str_replace('TITLE', $title, $url);
		$url = str_replace('RSS', $rss, $url);
		$url = str_replace('BLOGNAME', $blogname, $url);
		$url = str_replace('EXCERPT', $excerpt, $url);

		if (isset($site['description']) && $site['description'] != "") {
			$description = $site['description'];
		} else {
			$description = $sitename;
		}
		$link = "<li>";
		$link .= "<a rel=\"nofollow\"";
		if ($blank) {
			$link .= " target=\"_blank\"";
		}
		$link .= " href=\"$url\" title=\"$description\">";
		$link .= "<img src=\"".$imagepath.$site['favicon']."\" title=\"$description\" alt=\"$description\" class=\"sociable-hovers";
		if (isset($site['class']) && $site['class'])
			$link .= " sociable_{$site['class']}";
		$link .= "\" />";
		$link .= "</a></li>";

		$html .= $link;

	}

	$html .= "</ul>\n</div>\n";

	return $html;
}


?>
