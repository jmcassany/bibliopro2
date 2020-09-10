<?php
require_once ('/../config.php');
require_once ('graphic-title.inc');

if(isset($_GET['title'])) {
  graphic_title_show($_GET['title']);
}

?>