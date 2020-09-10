<?php

function editor_head() {
  return '';
}

function editor_entry($name, $value = '') {
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