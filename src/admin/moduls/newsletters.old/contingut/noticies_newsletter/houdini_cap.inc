<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ca">
<head>
	<title>Houdini v2.0</title>
	<link rel="STYLESHEET" type="text/css" href="../../../../../public/media/css/estils.css">
	<link rel="STYLESHEET" type="text/css" href="../../../../css/estils.css">
	<link rel="STYLESHEET" type="text/css" href="../../media/css/estils-newsletter.css" />
	<!--[if IE]>
	<link rel="stylesheet" type="text/css" media="all" href="../../media/css/estils-newsletter-ie.css" />
	<![endif]-->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<script language="javascript">
	function veure(id){
		url= 'view.php?ID='+id+'&SKIN=2'
		result = window.open(url,"flotant","left=01,top=20,screenX=01,screenY=20,status=no,toolbar=no,width=559,height=460,directory=no,resize=no,scrollbars=yes");
	}
	</script>
	<script type="text/javascript" src="../../media/js/newsletters-tools.js"></script>
	<script language="javascript">
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

<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<table cellpadding="0" cellspacing="0" class="capadmin" summary="cap&ccedil;elera">
  <tr>
    <td rowspan="2" class="logo">
      <img src="../../../../../public/media/comu/admin/logo.gif" alt="" />
    </td>
    <td class="info">
      <img src="../../../../../public/media/comu/admin/icon_user_blanc.gif" alt="Usuari" border="0" align="absmiddle" /><?php echo $LOGIN; ?>
    </td>
    <td class="info" style="text-align: right">
    	<a href="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>" class="blanc10" target="_blank">Vés al web</a>
      	&nbsp;|&nbsp;
      	<a href="../../../../login.php?action=logout" class="blanc10" title="Continguts">Surt<img src="../../../../../public/media/comu/admin/icon_tanca.gif" alt="Surt de la sessi&oacute;" border="0" align="absmiddle" /></a>
    </td>
  </tr>
  <tr>
    <td class="links" colspan="2">
       
       	<a href="../../../../index.php" class="negre10b" title="Continguts"><img src="../../../../comu/icon_continguts.gif" alt="Continguts" align="absmiddle" />Continguts</a>
      	<?php if($_SESSION['access']['level'] == 5){ ?>
      		<a href="../../../../users/index.php" class="negre10b" title="Usuaris"><img src="../../../../../public/media/comu/admin/icon_gestio_usu.gif" alt="Usuaris" align="absmiddle" />Usuaris</a>
      		<a href="../../../../carpetes/index.php" class="negre10b" title="Carpetes"><img src="../../../../comu/icon_carpeta.gif"  alt="Carpetes" align="absmiddle" />Carpetes</a>
      		<a href="../../../../plantilles/index.php" class="negre10b" title="Plantilles"><img src="../../../../comu/icon_gest_plantilles.gif"  alt="Plantilles"  align="absmiddle" />Plantilles</a>
      		<a href="../../../../moduls/menus/index.php" class="negre10b"  title="Menus" ><img src="../../../../comu/icon_menus.gif" alt="Menu" align="absmiddle" />Menu</a>
      		<a href="../../../../formularis/index.php" class="negre10b" title="Formularis"><img src="../../../../comu/icon_formularis.gif" alt="Formularis" align="absmiddle" />Formularis</a>
      	<?php } ?>
        <a href="../../../../utilitats/index.php" class="negre10b"><img src="../../../../comu/icon_utilitats.gif" alt="Utilitats" align="absmiddle" />Utilitats</a>
        
    </td>
  </tr>
</table>
<a name="top"></a>