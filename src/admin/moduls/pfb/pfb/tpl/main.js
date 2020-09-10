function showHide( what )
{
   var loginDiv  = '';
   var uploadDiv = '';
   var mkdirDiv  = '';
   var pasteDiv  = '';

   var f = document.getElementById( 'addField' );

   if( f.style.visibility == 'hidden' )
   {
      f.style.visibility = 'visible';
   }
   else
   {
      f.style.visibility = 'hidden';
   }

   var old = f.innerHTML;

   uploadDiv += '<form action="<?php echo $_SERVER['PHP_SELF'] ?>?d=<?php echo $d ?>&amp;a=upload" method="post" enctype="multipart/form-data">';
   uploadDiv += '   &bull; <?php echo $lng[19] ?> (max <?php echo $maxUplSize ?>MB):<br/>';
   uploadDiv += '   <input type="file" name="uploadFile" size="15" maxlength="255"/> <input type="submit" name="upload" value="<?php echo $lng[29] ?>"/>';
   uploadDiv += '</form>';

   mkdirDiv += '<form action="<?php echo $_SERVER['PHP_SELF'] ?>?d=<?php echo $d ?>&amp;a=mkdir" method="post">';
   mkdirDiv += '   &bull; <?php echo $lng[20] ?>:<br/>';
   mkdirDiv += '   <input type="text" name="dirName" size="15" maxlength="50"/> <input type="submit" name="create" value="<?php echo $lng[21] ?>"/>';
   mkdirDiv += '</form>';

   pasteDiv += '<form action="<?php echo $_SERVER['PHP_SELF'] ?>?d=<?php echo $d ?>&amp;a=paste" method="post">';
   pasteDiv += '   &bull; <?php echo $lng[22] ?>:<br/>';
   pasteDiv += '   <input type="text" name="pasteName" value="<?php if(isset($_SESSION['cutedFile'])) { echo basename($_SESSION['cutedFile']); } ?>" size="15" maxlength="255"/> <input type="submit" name="paste" value="<?php echo $lng[23] ?>"/>';
   pasteDiv += '</form>';

   switch( what )
   {
      case 'upload':
         f.innerHTML = uploadDiv;
         break;
      case 'mkdir':
         f.innerHTML = mkdirDiv;
         break;
      case 'paste':
         f.innerHTML = pasteDiv;
         break;
   }

   if( old != f.innerHTML )
   {
      f.style.visibility = 'visible';
   }
}
function del( n, t, f )
{
   var msg;

   if( t == 'd' )
   {
      msg = '<?php echo $lng[24] ?>: "' + n + '" <?php echo $lng[25] ?>';
   }
   else
   {
      msg = '<?php echo $lng[28] ?>: "' + n + '"';
   }

   if( confirm( '<?php echo $lng[26] ?> ' + msg + '?') )
   {
      window.top.location.href = '<?php echo $_SERVER['PHP_SELF'] ?>?d=<?php echo $d ?>&a=delete&f=' + f;
   }
}