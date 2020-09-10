<?php 
    echo $datafile_name;
    copy($_FILES['datafile']['tmp_name'], $_FILES['datafile']['name']) or 
        die("Error while copying file");
        
    $_SESSION['source']->source_file = $_FILES['datafile']['name'];
    $_SESSION['source']->import();
    
?>
