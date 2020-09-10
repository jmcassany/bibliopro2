<?php
$sql_model = "SELECT * FROM " . TAULA_NEWSLETTERS . " WHERE IdCam=".$_GET['id'];
$result_model = db_query($sql_model);
$row_model = db_fetch_array($result_model);
$model = $row_model['SKIN'];
if($MODELS[$model]['destacats']){
    $estilsCaixa = "var boxClasses = { ";
    $estilsCaixa2 = "\t\t\tvar sortedBoxClasses = [";
    if(is_array($CONFIG_estilsCaixa)){
        foreach ($CONFIG_estilsCaixa as $key => $value) {
            $elementsCaixa .= $value['nom'].": '".$value['valor']."',";
            $elementsCaixa2 .= "'".$value['nom']."',";
        }
        $elementsCaixa = substr ($elementsCaixa, 0, strlen($elementsCaixa) - 1);
        $elementsCaixa2 = substr ($elementsCaixa2, 0, strlen($elementsCaixa2) - 1);
    }
    $estilsCaixa .= $elementsCaixa." };\n";
    $estilsCaixa2 .= $elementsCaixa2."];\n";
} else {
    $elementsCaixa = '';
    $elementsCaixa2 = '';
    $estilsCaixa = "var boxClasses = null;\n\t\t";
    $estilsCaixa2 = "var sortedBoxClasses = null;\n";
}

if($MODELS[$model]['filescolumnes']){
    

    $estilsLlistat = "var listingClasses = { ";
    $estilsLlistat2 = "\t\t\tvar sortedListingClasses = [";
    if(is_array($CONFIG_estilsLlistat)){
        foreach ($CONFIG_estilsLlistat as $key => $value) {
            $elementsLlistat .= $value['nom'].": '".$value['valor']."',";
            $elementsLlistat2 .= "'".$value['nom']."',";
        }
    }
    $elementsLlistat = substr ($elementsLlistat, 0, strlen($elementsLlistat) - 1);
    $elementsLlistat2 = substr ($elementsLlistat2, 0, strlen($elementsLlistat2) - 1);
    $estilsLlistat .= $elementsLlistat." };\n";
    $estilsLlistat2 .= $elementsLlistat2."];\n";
} else {
    $elementsLlistat = '';
    $elementsLlistat2 = '';
    $estilsLlistat = "var listingClasses = null;\n";
    $estilsLlistat2 = "\t\tvar sortedListingClasses = null;\n";
}


if($MODELS[$model]['destacats']){
    $estilsElement = "var elementClasses = { ";
    $estilsElement2 = "\t\t\tvar sortedElementClasses = [";
    if(is_array($CONFIG_estilsElement)){
        foreach ($CONFIG_estilsElement as $key => $value) {
            $elementsElement .= $value['nom'].": '".$value['valor']."',";
            $elementsElement2 .= "'".$value['nom']."',";
        }
    }
    $elementsElement = substr ($elementsElement, 0, strlen($elementsElement) - 1);
    $elementsElement2 = substr ($elementsElement2, 0, strlen($elementsElement2) - 1);
    $estilsElement .= $elementsElement." };\n";
    $estilsElement2 .= $elementsElement2."];\n";
} else {
    $elementsElement = '';
    $elementsElement2 = '';
    $estilsElement = "var elementClasses = null; \t\t\n";
    $estilsElement2 = "var sortedElementClasses = null;";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<meta name="author" content="Can Antaviana" />
<meta name="description" content="Houdini 3.0" />
<meta name="keywords" content="houdini" />

<title>Houdini-Newsletter 3.0</title>

<link rel="shortcut icon" href="../../media/css/img/favicon.ico"
	type="image/x-icon" />
<link rel="stylesheet" href="../../media/css/style-admin.css"
	type="text/css" media="screen" />
<link rel="stylesheet" href="../../media/css/nifty.css" type="text/css"
	media="screen" />
<link rel="stylesheet" href="../../media/css/jforms.css" type="text/css"
	media="screen" />
<link rel="stylesheet" href="../../media/css/print.css" type="text/css"
	media="print" />
<link rel="stylesheet" href="../../media/css/estils-newsletter.css"
	type="text/css" media="screen" />
<link rel="stylesheet" href="../../media/css/style-contingut.css"
	type="text/css" media="screen" />

<script type="text/javascript">
			var urlBase = '';
			var campaignID = <?php if (isset($_GET['id'])) { echo $_GET['id']; } else { echo $_GET['IdCam']; } ?>;
		</script>

<!-- jquery ui (sortables) + jquery form + newsletter functionalities -->
<script type="text/javascript" src="../../media/js/jquery.js"></script>
<script type="text/javascript" src="../../media/js/base.js"></script>
<script type="text/javascript"
	src="../../media/js/jquery-ui-sortables.min.js"></script>
<script type="text/javascript" src="../../media/js/jquery.boxes.js"></script>
<script type="text/javascript" src="../../media/js/jquery.form.js"></script>
<script type="text/javascript" src="../../media/js/frontpage.js"></script>
<script type="text/javascript">
			// estils caixes (classe: 'Nom pestanya')
			<?php echo $estilsCaixa;echo $estilsCaixa2; ?>
			// estils llistats (classe: 'Nom pestanya')
			<?php echo $estilsLlistat;echo $estilsLlistat2; ?>
			// estils elements llistats (classe: 'Nom pestanya')
			<?php echo $estilsElement;echo $estilsElement2; ?>
		</script>

<script language="javascript">
		/* <![CDATA[ */
			//Testeig camps de text
			function dades(){
				if (checkit_ins(document.env_dades)==0)
					return;

				document.env_dades.submit();
			}

			function checkit_ins(form){
				if(form.TITOL.value == ""){
					alert("<?php echo t("titolobligatori"); ?>");
					return (0);
				}else if(form.SKIN.value == ""){
					alert("<?php echo t("modelobligatori"); ?>");
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
    					ot1.src = "../../../../../public/media/plantilles/model" + SKIN + "/model" + SKIN + ".jpg"
    				}
				}
			}
			function doTemplate2(myForm) {
				CAP = myForm.CAP.value
				ot1 = document.getElementById("t2")
				if (CAP == "") {
					ot1.src = ""
				} else {
					ot1.src = "../../../../../public/media/upload/caps/capsal_newsletter" + CAP + ".jpg"
				}
			}
		/* ]]> */
		</script>

<!-- thickbox -->
<link href="../../media/css/thickbox.css" rel="stylesheet"
	media="screen" type="text/css" />
<script type="text/javascript"
	src="../../media/js/thickbox-compressed.js"></script>

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

<div id="top" class="clearfix"><img
	src="../../media/img/minilogo_houdini.png" alt="Houdini v3.0" /> <span>admin</span>
<span class="user"><?php echo $_SESSION['access']['login']; ?></span>
<ul>
	<!-- <li><a href="http://some-site.com/">Ves al web</a></li> -->
	<li><a href="../../../../login.php?action=logout" id="logout">Surt de
	la sessió</a></li>
</ul>
</div>
<!-- /top -->


<div id="header" class="clearfix">
<h1><img src="../../../../comu/logo.png" alt="" /></h1>
<ul id="menu">
	<li class="current"><a href="../../campanyes/index.php" id="uti">Butlletins</a></li>
	<li><a href="../../contingut/index.php" id="con">Contingut</a></li>
	<li><a href="../../llistes/index.php" id="car">Subscriptors</a></li>
	<li><a href="../../informes/index.php" id="for">Informes</a></li>
</ul>
</div>
<!-- /header -->