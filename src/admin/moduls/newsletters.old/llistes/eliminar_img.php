<?php
require ('../../../config_admin.inc');
//accessGroupPermCheck('dinamic_read');

//include_once("dinamiques.php");
//include_once('categories/funcions.inc');

$file=$_GET['file'];
$categoria=$_GET['categoria'];
$ID=$_GET['ID'];
$IDSUB=$_GET['IDSUB'];
$camptaula=$_GET['camptaula'];

//COMPROVEM SI TE ACCES A AQUEST MODUL
//include("check_moduls.php");
//FI COMPROVEM SI TE ACCES A AQUEST MODUL
?>
<html>
<head>
<?php echo htmlMetas(); ?>
<meta http-equiv="refresh" content="2;url=subscriptor.php?id=<?php echo $ID; ?>&amp;sub=<?php echo $IDSUB; ?>">
</head>
<body>


<table align="center" cellpadding="0" cellspacing="0" style="border:solid #0A2082 1px;padding-left:20px;padding-right:20px;padding-bottom:5px;" width="50%">
	<tr>
		<td width="132" ><img src="../../../comu/logo.gif" alt="" width="132" height="52" vspace="5" border="0"></td>
		<td class="text" align="left" width="80%">
		<b>
		 <?php
			if ($categoria == 0){
				$TIPOARXIU=t("image");
				echo t("delete")." ".t("images");
			}
			if ($categoria == 1){
				$TIPOARXIU=t("file");
				echo t("delete")." ".t("files");
			}

		 ?>

		</b><br>
		</td>

	</tr>
	<tr>
		<td colspan="2" class="text">
			<?php
			$data="";
			$sql = "UPDATE news_SUBSCRIPTORS SET $camptaula='$data' where IdSub='$IDSUB'";
			$result = db_query($sql);
			if($result) {
				if ($categoria == 1) {

					$tall = explode("/", $file);
					//var_dump($tall);
					$targetfilename = $CONFIG_PATHUPLOADAD.'/'.$tall[7];

					if (file_exists($targetfilename)) {
						unlink($targetfilename);

						if(file_exists($thumbtargetfilename)) unlink($thumbtargetfilename);
						echo ("&#149;&nbsp;$TIPOARXIU $file ".t("staticpagesdeletefilesmessage1").".<br><br>");
		
					}else{
						echo ("&#149;&nbsp;$TIPOARXIU $file ".t("staticpagesdeletefilesmessage2").".<br><br>");
					}
		
				}
				else {
		
					$imageSizes = $dinamiques_imageSizes;
					if (isset($tipusdinamiques[$tipuseditora]['imageSizes'])) {
						$imageSizes = $tipusdinamiques[$tipuseditora]['imageSizes'];
					}
		
					foreach ($imageSizes as $value) {
						$prefix = '';
						if (isset($value['prefix'])) {
							$prefix = trim($value['prefix']);
						}
						if(file_exists($CONFIG_PATHUPLOADIM.'/'.$prefix.$file)) {
							unlink($CONFIG_PATHUPLOADIM.'/'.$prefix.$file);
						}
						echo ("&#149;&nbsp;$TIPOARXIU $prefix$file ".t("staticpagesdeletefilesmessage1").".<br><br>");
					}
		
				}
			
			} else {
				echo ("<a href='javascript:history.back()'>".t("back")."</a>");
				echo db_error();
			}
			?>


			<table align='center' border="0" cellspacing="1" cellpadding="0" width="250">
			<tr>
				<td >
					<table width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr>
							<td width="100%" align="center" >
			
								<?php echo t("redirect"); ?><br><br>
								(<a href="subscriptor.php?id=<?php echo $ID; ?>&amp;sub=<?php echo $IDSUB; ?>"><?php echo t("notwait"); ?></a>)
							</td>
						</tr>
					</table>
				</td>
			</tr>
			</table>
			<br>

		</td>
	</tr>
</table>


</body>
</html>
