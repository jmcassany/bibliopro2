<?php
    require_once('importer.php');

    if (! isset($_SESSION['source'])) {
        $_SESSION['source'] = new db_importer;
        $_SESSION['source']->db_connect();
    }

    if (!$_GET['go']) {
        include('imp_step1.php');   
    } else {
        if (file_exists('./' . $_GET[go] . '.php')) {
            include('./' . $_GET[go] . '.php');   
        } else {
            print('File does not exist');   
        }
    }
?> 
