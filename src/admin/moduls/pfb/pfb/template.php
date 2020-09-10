<?php

class template {

  function template() {


  }


  function assign($values) {
    foreach ($values as $key => $value) {
      $this->vars[$key] = $value;
    }
  }

  function assign_by_ref($name, $ref) {
    $this->vars[$name] = &$ref;
  }

  function fetch($file) {
    foreach($this->vars as $key => $value) {
      $$key = $value;
    }
    ob_start();
    require('tpl/'.$file);
    $content = ob_get_contents();
    ob_clean();
    return $content;
  }

}



?>