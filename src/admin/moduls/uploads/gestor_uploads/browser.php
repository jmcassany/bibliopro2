<?php
require ('../../../config_admin.inc');
accessGroupPermCheck('upload_files');
?>
<!--
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2005 Frederico Caldeira Knabben
 *
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 *
 * For further information visit:
 * 		http://www.fckeditor.net/
 *
 * File Name: browser.html
 * 	This page compose the File Browser dialog frameset.
 *
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<link href="browser.css" type="text/css" rel="stylesheet">
	</head>
	<frameset cols="150,*" framespacing="0" bordercolor="#f1f1e3" frameborder="no" class="Frame_none">
		<frameset rows="108,*" framespacing="0"  class="Frame_r">
			<frame src="frmresourcetype.html" scrolling="no" frameborder="no">
			<frame name="frmFolders" id="frmFolders" src="frmfolders.html" scrolling="auto" frameborder="no">
		</frameset>
		<frameset rows="50,*,50" framespacing="0" class="Frame_none">
			<frame name="frmActualFolder" src="frmactualfolder.html" scrolling="no" frameborder="no">
			<frame name="frmResourcesList" id="mainWindow" src="frmresourceslist.html" scrolling="auto" frameborder="no">
			<frameset cols="150,*,0" framespacing="0" frameborder="no" class="Frame_t">
				<frame name="frmCreateFolder" id="frmCreateFolder" src="frmcreatefolder.html" scrolling="no" frameborder="no">
				<frame name="frmUpload" id="frmUpload" src="frmupload.html" scrolling="no" frameborder="no">
				<frame name="frmUploadWorker" src="" scrolling="no" frameborder="no">
			</frameset>
		</frameset>
	</frameset>
</html>
