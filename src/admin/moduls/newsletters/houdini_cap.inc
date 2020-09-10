<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    
    <meta name="author" content="Can Antaviana" />
    <meta name="description" content="Houdini 3.0.1" />
    <meta name="keywords" content="houdini" />
    
    <title>Houdini-Newsletter 3.0.1</title>
    
    <link rel="shortcut icon" href="/admin/moduls/newsletters/media/css/img/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/admin/moduls/newsletters/media/css/style-admin.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/admin/moduls/newsletters/media/css/style-contingut.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/admin/moduls/newsletters/media/css/jforms.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="/admin/moduls/newsletters/media/css/thickbox.css" media="screen" type="text/css" />
   
    <script type="text/javascript">
            var urlBase = '';
            var campaignID = <?php echo isset($_GET['IdCam']) ? $_GET['IdCam'] : (isset($_POST['idCam']) ? $_POST['idCam'] : null); ?>;
            
            <?php
                echo $estilsCaixa . "\n"; ; 
                echo $estilsCaixa2 . "\n"; ; 
                echo $estilsLlistat . "\n"; 
                echo $estilsLlistat2  . "\n"; 
                echo $estilsElement . "\n"; ; 
                echo $estilsElement2 . "\n"; ; 
             ?>
    </script>
    
    <script type="text/javascript" src="/admin/moduls/newsletters/media/js/jquery.js"></script>
    <script type="text/javascript" src="/admin/moduls/newsletters/media/js/base.js"></script>
    <script type="text/javascript" src="/admin/moduls/newsletters/media/js/jquery-ui-sortables.min.js"></script>
    <script type="text/javascript" src="/admin/moduls/newsletters/media/js/jquery.boxes.js"></script>
    <script type="text/javascript" src="/admin/moduls/newsletters/media/js/jquery.form.js"></script>
    <script type="text/javascript" src="/admin/moduls/newsletters/media/js/frontpage.js"></script>
    <script type="text/javascript" src="/admin/moduls/newsletters/media/js/thickbox-compressed.js"></script>
    <script type="text/javascript" src="/admin/moduls/newsletters/media/js/newsletters-tools.js"></script>

    <script type="text/javascript">
    /* <![CDATA[ */
        //Testeig camps de text
        function dades(){
            if (checkit_ins(document.env_dades)==0)
                return;
    
            document.env_dades.submit();
        }

        function checkit_ins(form){
            if(form.TITOL.value == ""){
                alert("<?php echo _t("titolobligatori"); ?>");
                return (0);
            }else if(form.SKIN.value == ""){
                alert("<?php echo _t("modelobligatori"); ?>");
                return (0);
            }else if(form.CAP.value == ""){
                alert("No heu escollit cap capçalera!");
                return (0);
            }else{
                return (1);
            }
        }
    
        //Visualitzar plantilles
        function doTemplate(myForm) {
            SKIN = myForm.SKIN.value
            SKIN = $('#SKIN').val();
            if(SKIN != ''){
                ot1 = document.getElementById("t1")
                if (SKIN == "") {
                    ot1.src = ""
                } else {
                    ot1.src = "/public/media/plantilles/model" + SKIN + "/model" + SKIN + ".jpg"
                }
            }
        }
        function doTemplate2(myForm) {
            CAP = myForm.CAP.value
            ot1 = document.getElementById("t2")
            if (CAP == "") {
                ot1.src = ""
            } else {
                ot1.src = "/public/media/upload/caps/capsal_newsletter" + CAP + ".jpg"
            }
        }
    /* ]]> */
    </script>
    <script type="text/javascript" language="javascript">
            function veure(id){
                url= 'view.php?ID='+id+'&SKIN=2'
                result = window.open(url,"flotant","left=01,top=20,screenX=01,screenY=20,status=no,toolbar=no,width=559,height=460,directory=no,resize=no,scrollbars=yes");
            }
            function dades(){
                if(checkit_ins(document.env_dades)==0)
                    return;
                
                document.env_dades.submit();
            }
            function checkit_ins(form){
                if(form.TITOL.value == ""){
                    alert("El camp títol és obligatori.");
                    return (0);
                }else{
                    return (1);
                }
            }
    </script>
        
</head>

        
<body>

    <div id="page" class="clearfix">
    
        <div id="acc">
            <ul>
            	<li><a href="#menu">Accés directe al menú principal</a></li>
            	<li><a href="#content" accesskey="S">Accés directe al contingut</a></li>
            </ul>
        </div>
        <!-- /acc -->
        
        <div id="top" class="clearfix">
            <img src="/admin/moduls/newsletters/media/img/minilogo_houdini.png" alt="Houdini v3.0" />
            <span>admin</span> <span class="user"><?php echo $_SESSION['access']['login']; ?></span>
            <ul>
        	   <li><a href="/admin/login.php?action=logout" id="logout">Surt de la sessió</a></li>
            </ul>
        </div>
        <!-- /top -->
        
        <div id="header" class="clearfix">
            <h1><img src="/admin/comu/logo.gif" alt="" /></h1>
            <ul id="menu">
            	<li <?php echo $curbutlletins; ?>><a href="/admin/moduls/newsletters/campanyes/index.php" id="uti">Butlletins</a></li>
            	<li <?php echo $curcontingut; ?>><a href="/admin/moduls/newsletters/contingut/index.php" id="con">Contingut</a></li>
            	<li <?php echo $cursubscriptors; ?>><a href="/admin/moduls/newsletters/llistes/index.php" id="car">Subscriptors</a></li>
            	<li <?php echo $curinformes; ?>><a href="/admin/moduls/newsletters/informes/index.php" id="for">Informes</a></li>
            	<li <?php echo $curconfig; ?>><a href="/admin/moduls/newsletters/configuracio/index.php" id="pla">Configuració</a></li>
            </ul>
        </div>
        <!-- /header -->