<?php

function block_pages($content, $id = null, $taula = null, $preview = false)
{
	global $CONFIG_PATHTEMPLATEBLOCK;

	if ($id != null) {
		$result = db_query("select IDIOMA from " . $taula . " where id=" . $id);
		$row = db_fetch_array($result);
		$idioma = $row['IDIOMA'];
	}

	preg_match_all("/\|(block-static-[A-Za-z0-9_]+?)\|/", $content, $values);
	$values = array_unique($values[1]);

	foreach($values as $value) {
		$elements = explode('-', $value);
		$name = $elements[2];
		$block = '';
		$ok = false;

		if (isset($idioma)) {
			$file_name = $CONFIG_PATHTEMPLATEBLOCK . '/' . $idioma . '-' . $name . '.html';

			if (file_exists($file_name) && is_file($file_name)) {

				if ($file = @fopen($file_name, 'r')) {
					$block = @fread($file, filesize($file_name));
					fclose($file);
					$ok = true;
				} else {
					$block = '';
				}
			}
		}

		if (!$ok) {
			$file_name = $CONFIG_PATHTEMPLATEBLOCK . '/' . $name . '.html';

			if (file_exists($file_name) && is_file($file_name)) {

				if ($file = @fopen($file_name, 'r')) {
					$block = @fread($file, filesize($file_name));
					fclose($file);
				} else {
					$block = '';
				}
			}
		}

		if ($block != '') {
			$block = block_pages($block);
		}
		$content = str_replace('|' . $value . '|', $block, $content);
	}
	return $content;
}
?>
