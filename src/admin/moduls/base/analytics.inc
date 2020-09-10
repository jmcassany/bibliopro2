<?php

function analytics_pages($content, $preview = false) {
	global $ANALYTICS_params, $ANALYTICS_automatic, $ANALYTICS_type;

	$codes = array(
		'google-analytics' => array(1,'
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%%3E%%3C/script%%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("%s");
pageTracker._initData();
pageTracker._trackPageview();
</script>
'),
		'piwik' => array(2,'
<!-- Piwik -->
<script language="javascript" src="%2$s/piwik.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
piwik_action_name = \'\';
piwik_idsite = %1$s;
piwik_url = \'%2$s/piwik.php\';
piwik_log(piwik_action_name, piwik_idsite, piwik_url);
//-->
</script>
<!-- /Piwik -->
')
);


	if($preview) {
		return $content;
	}
	if (isset($codes[$ANALYTICS_type]) && is_array($ANALYTICS_params) && count($ANALYTICS_params) == $codes[$ANALYTICS_type][0]) {
		$codi = vsprintf($codes[$ANALYTICS_type][1], $ANALYTICS_params);
	}
	else {
		return $content;
	}

	if ($ANALYTICS_automatic) {
		$content = str_replace('</body>', $codi.'</body>', $content);
	}
	else {
		$content = str_replace('|ANALYTICS|', $codi, $content);
	}

	return $content;
}
?>
