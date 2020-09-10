<?php 
    $_SESSION['db_exporter']->export_target = $_POST['export_target'];
    $_SESSION['db_exporter']->export();
?>