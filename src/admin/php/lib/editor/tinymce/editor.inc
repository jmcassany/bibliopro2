<?php

function editor_head() {
  global $CONFIG_URLEDITOR;

  return '
<!-- tinyMCE -->

<script language="javascript" type="text/javascript" src="'.$CONFIG_URLEDITOR.'/tinymce/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
  tinyMCE.init({
    mode : "textareas",
    theme : "advanced"
  });
</script>
<!-- /tinyMCE -->
';

}

/*tipus Antavianabasic, Antaviana*/
function editor_entry($name, $value = '', $type = 'Antaviana') {
  return '
<textarea name="'.$name.'" id="'.$name.'" rows="20" cols="53">
'.$value.'
</textarea>
  ';
}

function editor_filter($value) {
  return $value;
}

?>