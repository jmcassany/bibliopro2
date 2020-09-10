<?php

require ("config_admin.inc");
accessGroupPermCheck('houdinibasic');


/* Sitemap version 2.0 (C) copyright Metalhead 2003
Sitemap home: http://www.metalhead.ws/phpbin/
This script is released under the terms of the GNU General Public License. A copy of the GPL is included with this script. */

/* User configuration */
$showsize = 0; /* Show size of each file, 1 for yes, 0 for no. */

/* Array with file types to display and the pictures to use.
Syntax: $display[filetype] = "picture"; */
$display['php']   = "php.gif";
$display['html']  = "html.gif";
$display['htm']   = "html.gif";
$display['shtml'] = "html.gif";
$display['pdf']   = "gen.gif";
$display['zip']   = "gen.gif";
$display['doc']   = "gen.gif";
$display['xls']   = "gen.gif";
$display['ppt']   = "gen.gif";
$display['pps']   = "gen.gif";
$display['jpg']   = "gen.gif";
$display['jpeg']  = "gen.gif";

/* Array with directories to exclude.
Syntax: $excludedir[] = "directory"; */
$excludedir[] = "sitemap";
$excludedir[] = "documentacio";
$excludedir[] = "pdf";
$excludedir[] = "php";
$excludedir[] = "admin";
$excludedir[] = "lib";
$excludedir[] = "config";
$excludedir[] = "comu";
$excludedir[] = "css";
$excludedir[] = "gif";
$excludedir[] = "menus";
$excludedir[] = "plantilles";
$excludedir[] = "js";
$excludedir[] = "working";
$excludedir[] = "fotos_prova";
$excludedir[] = ".svn";

/* Array with files to exclude. */
$excludefile[] = "config.inc";
$excludefile[] = "view.php";

?>

<html>
<head>
<?php echo htmlMetas(); ?>
<script type="text/javascript">
function CopyClipboard(element)
{
  obj = document.getElementById(element);
  if (obj) {
    window.clipboardData.setData('Text', obj.value);
  }
}

function OpenFile( fileUrl )
{
	//fileUrl=unescape(fileUrl);
	window.top.opener.SetUrl( fileUrl ) ;
	window.top.close() ;
	window.top.opener.focus() ;
}
</script>
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">



<!-- PART CENTRAL -->
<table border="0" cellpadding="0" cellspacing="0" width="95%" style="border:solid #0E449A 5px;margin:10px;margin-bottom:0px;">

	<!-- situacio Sou a -->
	<tr>
		<td  class="text" bgcolor="#C0CEE4" style="padding:6px;"><img src="comu/kland_blanc.gif" width="22" height="7" border="0" align="absmiddle"><b>Mapa del web</b></td>
	</tr>
	<!-- /situacio Sou a -->


	<tr>

		<!-- ENTRADA -->
		<td colspan="2" style="padding:10px;" valign="top">
			<TABLE width="100%" cellpadding="5" cellspacing="0">
<?php

$stime = gettimeofday();

/* some preliminaries... */
//$root = getcwd();
//$pre = explode("/", $REQUEST_URI);
//array_pop($pre);
//$prefix = join("/", $pre);

/* Uncomment the 2 lines below to create a tree of all files and directories on your webserver if the script
 * is in a subdirectory */
//$root = str_replace($prefix, "", $root);
//$prefix = "";
$root=$CONFIG_PATHBASE;//dir-li la ruta directa
$prefix = $CONFIG_NOMCARPETA;
/* Display server name and directory */
echo "<table cellspacing=0 cellpadding=0 border=0>\n";
echo "<tr><td><img align=absmiddle src=comu/sitemap/server.gif> ";
//echo "http://$SERVER_NAME $prefix/";
echo "</td></tr><tr><td><img align=absmiddle src=comu/sitemap/vertical.gif></td></tr>\n";

function get_extension($name) {
	$array = explode(".", $name);
	$retval = strtolower(array_pop($array));
	return $retval;
}

/* Recursion, here we go.. */
function list_dir($chdir) {
	/* some globals, some cleaning */
	global $root, $prefix, $PHP_SELF, $SERVER_NAME, $showsize, $display, $excludedir, $excludefile;
	unset($sdirs);
	unset($sfiles);
	chdir($chdir);
	$self = basename($PHP_SELF);

	/* open current directory */
	$handle = opendir('.');
	/* read directory. If the item is a directory, place it in $sdirs, if it's a filetype we want
	 * and not this file, put it in $sfiles */
	while ($file = readdir($handle))
	{
		if(is_dir($file) && $file != "." && $file != ".." && !in_array($file, $excludedir))
		{ $sdirs[] = $file; }
		elseif(is_file($file) && $file != "$self" && array_key_exists(get_extension($file), $display)
			&& !in_array($file, $excludefile))
		{ $sfiles[] = $file; }
	}

	/* count the slashes to determine how deep we're in the directory tree and how many
	 * nice bars we need to add */
	$dir = getcwd();
	$dir1 = str_replace($root, "", $dir."/");
	$count = substr_count($dir1, "/") + substr_count($dir1, "\\") - (substr_count($root, "/")-1);

	/* display directory names and recursively list all of them */
	if(isset($sdirs) && is_array($sdirs)) {
		sort($sdirs);
		reset($sdirs);

		for($y=0; $y<sizeof($sdirs); $y++) {
			echo "<tr><td>";
			for($z=1; $z<=$count; $z++)
		  	{ echo "<img align=absmiddle src=comu/sitemap/vertical.gif>&nbsp;&nbsp;&nbsp;"; }
			if((isset($sfiles) && is_array($sfiles)) || $y<sizeof($sdirs)-1)
			{ echo "<img align=absmiddle src=comu/sitemap/verhor.gif>"; }
			else
			{ echo "<img align=absmiddle src=comu/sitemap/verhor1.gif>"; }
			echo "<img align=absmiddle src=comu/sitemap/folder.gif> <a href=\"http://$SERVER_NAME$prefix/$dir1$sdirs[$y]\"  target=\"_blank\" class=\"blau10b\">$sdirs[$y]</a>";
			list_dir($dir."/".$sdirs[$y]);
		}
	}

	chdir($chdir);

	/* iterate through the array of files and display them */
	if(isset($sfiles) && is_array($sfiles)) {
		sort($sfiles);
		reset($sfiles);

		$sizeof = sizeof($sfiles);

		/* what file types shall be displayed? */
		for($y=0; $y<$sizeof; $y++) {
			echo "<tr><td>";
			for($z=1; $z<=$count; $z++)
			{ echo "<img align=absmiddle src=comu/sitemap/vertical.gif>&nbsp;&nbsp;&nbsp;"; }
			if($y == ($sizeof -1))
			{ echo "<img align=absmiddle src=comu/sitemap/verhor1.gif>"; }
			else
			{ echo "<img align=absmiddle src=comu/sitemap/verhor.gif>"; }
			echo "<img align=absmiddle src=comu/sitemap/";
			echo $display[get_extension($sfiles[$y])];
			echo "> ";


				$valorlink="$prefix/$dir1$sfiles[$y]";
				//echo "<a href=\"$valorlink\" class=\"blau10\" target=\"_blank\">$sfiles[$y]</a>";
				echo '<a href="#" class="blau10" onclick="OpenFile(\''.$valorlink.'\');return false;">'.$sfiles[$y].'</a>';

			/*if (!isset($_GET['nocopy'])) {
				//per copiar link
				echo "<input type=hidden name=\"$dir1$sfiles[$y]\" id=\"$dir1$sfiles[$y]\" value=\"$valorlink\">";
				echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:CopyClipboard('$dir1$sfiles[$y]')\" title=\"copiar el vincle al portapapers\">copiar vincle</a>";
				//fi
			}*/

			if($showsize) {
				$fsize = @filesize($sfiles[$y])/1024;
				printf(" (%.2f kB)", $fsize);
			}
			echo "</td></tr>";



		}
		echo "<tr><td>";
		for($z=1; $z<=$count; $z++)
		{ echo "<img align=absmiddle src=comu/sitemap/vertical.gif>&nbsp;&nbsp;&nbsp;"; }
		echo "</td></tr>\n";
	}
}

list_dir($root);

echo "</table>\n";

/* How long did that need..? */
//$ftime = gettimeofday();
//$time = round(($ftime['sec'] + $ftime['usec'] / 1000000) - ($stime['sec'] + $stime['usec'] / 1000000), 5);
//echo "<center>This page was generated in $time seconds.</center>\n";

?>

			</TABLE>
		</td>
		<!-- /ENTRADA -->

	</tr>


</table>
<!-- /PART CENTRAL -->

</body>
</html>
