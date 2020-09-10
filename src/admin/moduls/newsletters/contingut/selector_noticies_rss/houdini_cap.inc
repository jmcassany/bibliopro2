<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Script-Type" content="text/javascript" />
		<meta http-equiv="Content-Style-Type" content="text/css" />

		<meta name="author" content="Can Antaviana"/>
		<meta name="description" content="Houdini 3.0" />
		<meta name="keywords" content="houdini" />

		<title>Houdini-Newsletter 3.0</title>

		<link rel="shortcut icon" href="../../media/css/img/favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" href="../../media/css/style-admin.css" type="text/css" media="screen"/>
		<link rel="stylesheet" href="../../media/css/nifty.css" type="text/css" media="screen"/>
		<link rel="stylesheet" href="../../media/css/jforms.css" type="text/css" media="screen"/>
		<link rel="stylesheet" href="../../media/css/print.css" type="text/css" media="print"/>

		<script type="text/javascript">
			var urlBase = '/admin/moduls/newsletters';
		</script>

		<script type="text/javascript" src="../../media/js/jquery.js"></script>
		<script type="text/javascript" src="../../media/js/base.js"></script>
		
		<script language="javascript">
			function veure(id){
				url= 'view.php?ID='+id+'&SKIN=1'
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
				<img src="../../media/img/minilogo_houdini.png" alt="Houdini v3.0"/>
				<span>admin</span>
				<span class="user"><?php echo $_SESSION['access']['login']; ?></span>
				<ul>
					<!-- <li><a href="http://some-site.com/">Ves al web</a></li> -->
					<li><a href="../../../../login.php?action=logout" id="logout">Surt de la sessió</a></li>
				</ul>
			</div>
			<!-- /top -->

			<div id="header" class="clearfix">
				<h1><img src="../../../../comu/logo.png" alt=""/></h1>
				<ul id="menu">
					<li><a href="../../../../users/" id="usu">Usuaris</a></li>
					<li><a href="../../campanyes/index.php" id="uti">Butlletins</a></li>
					<li class="current"><a href="../../contingut/index.php" id="con">Contingut</a></li>
					<li><a href="../../llistes/index.php" id="car">Subscriptors</a></li>
					<li><a href="../../informes/index.php" id="for">Informes</a></li>
				</ul>
			</div>
			<!-- /header -->