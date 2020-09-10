<script type="text/javascript">
<!--
  <?php include('main.js'); ?>
//-->
</script>
   <center>
   <table class="topTable">
      <tr>
         <td class="left" style="padding-left: 5px; font-size: 11px;">
            <?php echo $common->showDate() ?>
         </td>
         <td style="text-align: right; padding-right: 5px; font-size: 11px;">
            php file browser v<?php echo $cfg['version'] ?> <span style="display:none">by <a href="mailto:crash@os.pl?subject=pfb%20v<?php echo $cfg['version'] ?>">crash</a></span>
         </td>
      </tr>
   </table>
   <table class="mainTable">
      <tr>
         <td class="header" style="height: 1px;" colspan="8"></td>
      </tr>
      <tr>
         <td class="header" style="width: 16px;">
         </td>
         <td class="header" style="" colspan="2">
            <?php echo $lng[0] ?>:
         </td>
         <td class="header" style="width: 80px;">
            <?php echo $lng[1] ?>:
         </td>
         <td class="header" style="width: 47px;" colspan="3">
            <?php echo $lng[2] ?>:
         </td>
         <td class="header" style="width: 100px;">
            <?php echo $lng[3] ?>:
         </td>
      </tr>
      <tr class="dark" onclick="window.location.href='<?php echo $_SERVER['PHP_SELF'].$dir->Common->dirUp() ?>';" onmouseover="className='hover';" onmouseout="className='dark';">
         <td class="center">
            <img src="./pfb/ico/cdup.gif" alt="CDUP"/>
         </td>
         <td colspan="2">
            <a href="<?php echo $dir->Common->dirUp() ?>"><img src="./pfb/ico/up.gif" alt="UP"/></a>
         </td>
         <td class="right">
            <b>&laquo;</b>
         </td>
         <td class="right" colspan="3">
            <b>&laquo;</b>
         </td>
         <td class="right">
            <b>&laquo;</b>
         </td>
      </tr>
<?php
foreach ($dir->readDirectory() as $n => $file) {
  if ($n % 2 == 0) {
    $style = "light";
  }
  else {
    $style = "dark";
  }
  if ($file['type'] == "dir") {
    $icon = 'cd';
  }
  else {
    $icon = $file['type'];
  }

  if ($file['type'] == "dir") {
    $href = $_SERVER['PHP_SELF'].$dir->Common->getURL($file);
  }
  else {
    $href = $baseUrl.'/'.$dir->Common->getURL($file);
  }



?>
      <tr class="<?php echo $style ?>" onmouseover="className='hover';" onmouseout="className='<?php echo $style ?>';">
         <td class="center">
            <img src="./pfb/ico/<?php echo $icon ?>.gif" alt="<?php echo $icon ?>"/>
         </td>
         <td class="left" style="width: 360px;" <?php if (!$file['issrc']) { ?> onclick="window.top.location.href='<?php echo $href ?>';" <?php } ?>>
            <?php if ($file['issrc']) { ?><div style="float: right;"><a href="./pfb/source.php?src=<?php echo $baseDir.'/'.$file['path'] ?>" target="_blank"><img src="./pfb/ico/iSource.png" alt="<?php echo $lng[30] ?>" title="<?php echo $lng[30] ?>"/></a></div><?php } ?>
            <a class="listLink" href="<?php echo $href ?>">
<?php
$text = substr($file['name'], 0, 45);
if ($text != $file['name']) {
  $text .='...';
}
echo $text;

?>
            </a>
         </td>
         <td style="text-align: center; width: 52px; vertical-align: middle;">
<?php
if (isset($_SESSION['cutedFile']) && basename($_SESSION['cutedFile']) == $file['name']) {
?>
<a href="<?php echo $_SERVER['PHP_SELF'] ?>?d=<?php echo $d ?>#paste"><img src="./pfb/ico/iPaste.png" title="<?php echo $lng[4] ?>" alt="<?php echo $lng[5] ?>"/></a>
<?php
}
else {
?>
<a href="<?php echo $_SERVER['PHP_SELF'] ?>?d=<?php echo $d ?>&amp;a=cut&amp;f=<?php echo $file['urle'] ?>" title="<?php echo  $lng[6] ?>"><img src="./pfb/ico/iCut.png" alt="<?php echo $lng[6] ?>"/></a>
<?php
}
?>
            <a href="javascript:del('<?php echo addslashes($file['name']) ?>','<?php echo ($file['type'] == "dir")?'d':'f' ?>','<?php echo $file['urle'] ?>');" title="<?php echo $lng[7] ?>"><img src="./pfb/ico/iDelete.png" alt="<?php echo $lng[7] ?>"/></a>
         </td>
         <td class="right" onclick="window.location.href='<?php echo $href ?>';">
            <?php echo ($file['type'] == "dir")?'<b>DIR</b>':$file['size'] ?>
         </td>
         <td class="perms" onclick="window.location.href='<?php echo $href ?>';">
            <?php echo $file['perms'][0] ?>
         </td>
         <td class="perms" onclick="window.location.href='<?php echo $href ?>';">
            <?php echo $file['perms'][1] ?>
         </td>
         <td class="perms" onclick="window.location.href='<?php echo $href ?>';">
            <?php echo $file['perms'][2] ?>
         </td>
         <td class="center" onclick="window.location.href='<?php echo $href ?>';">
           <?php echo strftime($cfg['dateFormat'], $file['time']) ?>
         </td>
      </tr>
<?php
}
?>
      <tr>
         <td class="header" style="height: 1px;" colspan="8"></td>
      </tr>
   </table>
   <table class="topTable">
      <tr>
         <td colspan="2" class="left" style="padding-left: 5px;">
            <?php echo $lng[8].': '.$common->getTime().' '.$lng[9] ?>
         </td>
         <td class="right" style="font-size: 11px; padding-right: 5px;">
            <a href="javascript:showHide('upload');" title="<?php echo $lng[12] ?>"><img src="./pfb/ico/iUpload.png" alt="<?php echo $lng[12] ?>"/></a>
<?php
if (isset($_SESSION['cutedFile']) && $_SESSION['cutedFile']) {
?>
<a href="javascript:showHide('paste');" title="<?php echo $lng[5] ?>"><img src="./pfb/ico/iPaste.png" alt="<?php echo $lng[5] ?>"/></a>
<?php
}
else {
?>
<img src="./pfb/ico/iPaste.png" title="<?php echo $lng[13] ?>" alt="<?php echo $lng[5] ?>"/>
<?php
}
?>
            <a href="javascript:showHide('mkdir');" title="<?php echo $lng[14] ?>"><img src="./pfb/ico/iNewDir.png" alt="<?php echo $lng[14] ?>"/></a>
         </td>
         <td class="center" style="font-size: 11px; padding-right: 5px; width: 130px; white-space: nowrap;">
            [ <?php echo $lng[16] ?>: <b><?php echo $dir->countItems('file') ?></b> | <?php echo $lng[17] ?>: <b><?php echo $dir->countItems('dir') ?></b> ]
         </td>
      </tr>
      <tr>
         <td style="padding-left: 10px;" colspan="3">
            <div id="addField" style="visibility: hidden;"></div>
         </td>
      </tr>
   </table>
   <br/>
   </center>