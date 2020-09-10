<?php

function comments_pages($content) {
	$comment = "@\|!--.*?--\|@is";
	$content = preg_replace($comment, '', $content);
	return $content;
}
?>
