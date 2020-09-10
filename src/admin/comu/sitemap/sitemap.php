<?php
/* Sitemap version 2.0 (C) copyright Metalhead 2003
Sitemap home: http://www.metalhead.ws/phpbin/
This script is released under the terms of the GNU General Public License. A copy of the GPL is included with this script. */

/* User configuration */
$showsize = 1; /* Show size of each file, 1 for yes, 0 for no. */

/* Array with file types to display and the pictures to use.
Syntax: $display[filetype] = "picture"; */
$display[php] = "php.gif";
$display[html] = "html.gif";
$display[htm] = "html.gif";
$display[shtml] = "html.gif";

/* Array with directories to exclude.
Syntax: $excludedir[] = "directory"; */
$excludedir[] = "temp";
$excludedir[] = "tmp";

/* Array with files to exclude. */
$excludefile[] = "index.php";

?>

<html>
<head>
<title>Sitemap</title>
</head>

<body>

<b>Sitemap</b><p>

<?php

$stime = gettimeofday();

/* some preliminaries... */
$root = getcwd();

$pre = explode("/", $REQUEST_URI);
array_pop($pre);
$prefix = join("/", $pre);


/* Uncomment the 2 lines below to create a tree of all files and directories on your webserver if the script
 * is in a subdirectory */
//$root = str_replace($prefix, "", $root);
//$root="/home/o/obrador/share/Feines/html/houdini";
//$prefix = "";

$root .= "/";

/* Display server name and directory */
echo "<table cellspacing=0 cellpadding=0 border=0>\n";
echo "<tr><td><img align=absmiddle src=server.gif> http://$SERVER_NAME";
echo "$prefix/";
echo "</td></tr><tr><td><img align=absmiddle src=vertical.gif></td></tr>\n";

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
	$count = substr_count($dir1, "/") + substr_count($dir1, "\\");
		  	  
	/* display directory names and recursively list all of them */
	if(is_array($sdirs)) {
		sort($sdirs);
		reset($sdirs);
			 
		for($y=0; $y<sizeof($sdirs); $y++) {
			echo "<tr><td>";
			for($z=1; $z<=$count; $z++)
		  	{ echo "<img align=absmiddle src=vertical.gif>&nbsp;&nbsp;&nbsp;"; }
			if(is_array($sfiles))
			{ echo "<img align=absmiddle src=verhor.gif>"; }
			else
			{ echo "<img align=absmiddle src=verhor1.gif>"; }
			echo "<img align=absmiddle src=folder.gif> <a href=\"http://$SERVER_NAME$prefix/$dir1$sdirs[$y]\">$sdirs[$y]</a>";
			list_dir($dir."/".$sdirs[$y]);
		}
	}
		 		  
	chdir($chdir);
		  
	/* iterate through the array of files and display them */
	if(is_array($sfiles)) {
		sort($sfiles);
		reset($sfiles);
				 
		$sizeof = sizeof($sfiles);
			 
		/* what file types shall be displayed? */
		for($y=0; $y<$sizeof; $y++) {
			echo "<tr><td>";
			for($z=1; $z<=$count; $z++)
			{ echo "<img align=absmiddle src=vertical.gif>&nbsp;&nbsp;&nbsp;"; }
			if($y == ($sizeof -1))
			{ echo "<img align=absmiddle src=verhor1.gif>"; }
			else
			{ echo "<img align=absmiddle src=verhor.gif>"; }
			echo "<img align=absmiddle src=\"";
			echo $display[get_extension($sfiles[$y])];
			echo "\"> ";
			echo "<a href=\"http://$SERVER_NAME$prefix/$dir1$sfiles[$y]\">$sfiles[$y]</a>";
			if($showsize) {
				$fsize = @filesize($sfiles[$y])/1024;
				printf(" (%.2f kB)", $fsize);
			}
			echo "</td></tr>";

			echo "<tr><td>";
			
		}
		echo "<tr><td>";
		for($z=1; $z<=$count; $z++)
		{ echo "<img align=absmiddle src=vertical.gif>&nbsp;&nbsp;&nbsp;"; }
		echo "</td></tr>\n"; 
	}
}

list_dir($root);

echo "</table>\n";

/* How long did that need..? */
$ftime = gettimeofday();
$time = round(($ftime[sec] + $ftime[usec] / 1000000) - ($stime[sec] + $stime[usec] / 1000000), 5);
echo "<center>This page was generated in $time seconds.</center>\n";

?>

</body>
</html>
