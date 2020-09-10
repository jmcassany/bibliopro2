<?php
require_once($CONFIG_PATHBASE."/media/php/config.php");
require_once($CONFIG_PATHBASE."/lib/database/database.inc");



/***********************************************************************/
// funcio que monta el formulari d'enquesta
/***********************************************************************/

function montar_enquesta($enquesta) {
  global $db_url_web;
  global $CONFIG_URLVOTA, $CONFIG_NOMCARPETA;

  $desti = $CONFIG_URLVOTA.'?ENQUESTA='.$enquesta;

  db_connect($db_url_web);

  $result = @db_query("SELECT TITOL, END_TIME, VISIBILITY FROM ENQUESTA WHERE ID=".$enquesta." AND (STATUS='1') and ((VISIBILITY='1') or (VISIBILITY='2' and START_TIME < NOW()))");

  if (db_num_rows($result) != 1) {
    return;
  }
  $fila = db_fetch_array($result);
  $titol = $fila['TITOL'];
  $actiu = true;
  if ($fila['END_TIME']<date('Y-m-d H:i:s') && $fila['VISIBILITY'] == 2) {
    $actiu = false;
  }
  
  return $actiu;
}





/***********************************************************************/
// actualitzem dades de la votacio rebuda
/***********************************************************************/

db_connect($db_url_web);

$enquesta = '';
if (isset($_POST['action'])) {
  if (isset($_POST['ENQUESTA']) && isset($_POST['PREGUNTA'.$_POST['ENQUESTA']])) {
    $enquesta = $_POST['ENQUESTA'];
    @db_query('UPDATE ENQUESTA_PREG SET VOTS = VOTS+1 WHERE ID='.$_POST['PREGUNTA'.$_POST['ENQUESTA']].' AND ENQUESTA='.$enquesta);
  }
}
else if (isset($_GET['ENQUESTA'])){
  $enquesta = $_GET['ENQUESTA'];
}





/***********************************************************************/
// mostrem resultats enquesta seleccionada
/***********************************************************************/

if (!empty($enquesta)) {

  $result = @db_query('SELECT TITOL, CREATION, VISIBILITY, START_TIME FROM ENQUESTA WHERE ID='.$enquesta);
  $fila = db_fetch_array($result);
  $titol = $fila['TITOL'];
  $result = @db_query('SELECT sum(VOTS) as TOTALVOTS FROM ENQUESTA_PREG WHERE ENQUESTA='.$enquesta.' GROUP BY ENQUESTA');
  $fila1 = db_fetch_array($result);
  $votstotal = $fila1['TOTALVOTS'];

  $trossos = explode('?',$_SERVER['REQUEST_URI']);

  $result = @db_query('SELECT DESCRIPCIO, VOTS FROM ENQUESTA_PREG WHERE ENQUESTA='.$enquesta);


?>
<div class="enquesta clearfix">
	<p class="inici">Inici de l'enquesta:
	<?php
		$data_inici = '';
		if($fila['VISIBILITY'] == 2)
			$data_inici = $fila['START_TIME'];
		else
			$data_inici = $fila['CREATION'];
		setlocale(LC_TIME,'ca_ES');
		echo strftime("%d-%m-%Y" , strtotime($data_inici));
	?>
	</p>

<?php  echo '<h4>'.$fila['TITOL'].'</h4>';?>


<?php
  while($fila = db_fetch_array($result))
  {
    if ($votstotal == 0) {
      $resultat = 0;
    }
    else {
      $resultat=round($fila['VOTS']*100/$votstotal);
    }
    $res = $resultat * 205 /100;
    $no_res = 205 - $res;
?>


  <p><strong><?php echo $fila['DESCRIPCIO']; ?>
  <!--<img style="vertical-align:middle;" src="<?php echo $CONFIG_NOMCARPETA ?>/media/comu/bg_enquesta_inici.gif" width="3" height="20" alt="" /><img style="vertical-align:middle;" src="<?php echo $CONFIG_NOMCARPETA ?>/media/comu/bg_enquesta_ple.gif" width="<?php echo $res; ?>" height="20" alt="" /><img style="vertical-align:middle;" src="<?php echo $CONFIG_NOMCARPETA ?>/media/comu/bg_enquesta_buit.gif" width="<?php echo $no_res; ?>" height="20" alt="" /><img style="vertical-align:middle;" src="<?php echo $CONFIG_NOMCARPETA ?>/media/comu/bg_enquesta_fi.gif" width="3" height="20" alt="" />-->
  <img align="middle" src="<?php echo $CONFIG_NOMCARPETA ?>/media/comu/franja_enq_1.jpg" width="2" height="21" alt="" /><img align="middle" src="<?php echo $CONFIG_NOMCARPETA ?>/media/comu/franja_enq_2.jpg" width="<?php echo $res; ?>" height="21" alt="" /><img align="middle" src="<?php echo $CONFIG_NOMCARPETA ?>/media/comu/franja_enq_4.jpg" width="<?php echo $no_res; ?>" height="21" alt="" /><img align="middle" src="<?php echo $CONFIG_NOMCARPETA ?>/media/comu/franja_enq_3.jpg" width="2" height="21" alt="" />
  &nbsp;<?php echo $resultat.'%';?>
  </strong></p>


<?php
  }
?>



<?php
if (!isset($num_opcions) || $num_opcions == '') {
  echo '<p>Nombre de vots: ';
}
else {
  echo $num_opcions;
}
?>
<strong><?php echo $votstotal ?></strong></p>



<!--
<div class="anteriors-enquesta">
<a href="<?php echo $trossos[0] ?>">
<?php
if (!isset($veure_anteiors) || $veure_anteiors == '') {
  echo 'Veure les enquestes anteriors';
}
else {
  echo $veure_anteiors;
}
?>
</a>
</div>
-->


</div>

<?php
}
else {

/***********************************************************************/
// llistem enquestes actives
/***********************************************************************/

$result = @db_query("SELECT * FROM ENQUESTA WHERE (STATUS='1') and ((VISIBILITY='1') or (VISIBILITY='2' and START_TIME < NOW() and END_TIME > NOW()))");
?>

<?php
  while($fila = db_fetch_array($result)) {
?>
<div class="enquesta clearfix">
	<p class="inici">
		Inici de l'enquesta:
		<?php
			$data_inici = '';
			if($fila['VISIBILITY'] == 2)
				$data_inici = $fila['START_TIME'];
			else
				$data_inici = $fila['CREATION'];
			setlocale(LC_TIME,'ca_ES');
			echo strftime("%d-%m-%Y" , strtotime($data_inici));
		?>
	</p>
	<h4><?php echo $fila['TITOL'] ?></h4>
	<?php $actiu = montar_enquesta($fila['ID']); ?>
	
	<script type="text/javascript">
	//<![CDATA[
	function desactivarBoto<?php echo $fila['ID'];?>() {
	  oBoto = document.getElementById('boto<?php echo $fila['ID'] ?>');
	  oBoto.setAttribute('disabled', 'disabled');
	}
	function activarBoto<?php echo $fila['ID'];?>() {
	  oElements = document.getElementsByName('PREGUNTA<?php echo $fila['ID'];?>');
	  oBoto = document.getElementById('boto<?php echo $fila['ID'] ?>');
	  marcat = false;
	  for (i=0;i<oElements.length;i++) {
	    if(oElements[i].checked==true) {
	      marcat= true;
	    }
	  }
	  if( marcat ) {
	    oBoto.removeAttribute('disabled');
	  }
	  else {
	    oBoto.setAttribute('disabled', 'disabled');
	  }
	}
	//]]>
	</script>
	<noscript>Seleccioni una resposta abans de votar</noscript>

	<form action="enquesta_vota.php" method="post">
	<fieldset>
  	<?php
	if ($actiu) {
	    $i = 0;
		$result2 = @db_query('SELECT DESCRIPCIO, ID FROM ENQUESTA_PREG WHERE ENQUESTA='.$fila['ID']);
	    while ($row = db_fetch_array($result2)) {
	?>
	    	<label for="PREGUNTA<?php echo $fila['ID'].'-'.$i;?>"><input type="radio" name="PREGUNTA<?php echo $fila['ID'];?>" id="PREGUNTA<?php echo $fila['ID'].'-'.$i;?>" value="<?php echo $row['ID'] ?>" onclick="activarBoto<?php echo $fila['ID'];?>()" onchange="activarBoto<?php echo $fila['ID'];?>()" /><?php echo $row['DESCRIPCIO'] ?></label>
	<?php
	     	$i++;
		}
	?>
	</fieldset>	
	<input type="hidden" name="ENQUESTA" value="<?php echo $fila['ID'] ?>" />
	
	<span class="resultats"><a href="?ENQUESTA=<?php echo $fila['ID']; ?>">Resultats</a></span>
	<p><input type="submit" name="action" id="boto<?php echo $fila['ID'] ?>" value="Votar" class="enviar" /></p>
	
	<script type="text/javascript">
	//<![CDATA[
			activarBoto<?php echo $fila['ID'];?>();
	//]]>
	</script>
	<?php
	}
	?>
	</form>

	<!--<a class="resultats" href="?ENQUESTA=<?php echo $fila['ID'];?>">Veure resultats</a>-->

</div>
<?php
  }


/***********************************************************************/
// llistem enquestes anteriors
/***********************************************************************/


$result = @db_query("SELECT * FROM ENQUESTA WHERE (STATUS='1') and ((VISIBILITY='1') or (VISIBILITY='2' and START_TIME < NOW() and END_TIME < NOW()))");
?>

<h4 class="enquestes">
Enquestes anteriors
</h4>

<table summary="Enquestes anteriors" class="enquestes">
<?php
  while($fila = db_fetch_array($result)) {
?>
<tr>
	<td class="dates">
		<span>Inici:
		<?php
			$data_inici = '';
			if($fila['VISIBILITY'] == 2)
				$data_inici = $fila['START_TIME'];
			else
				$data_inici = $fila['CREATION'];
			setlocale(LC_TIME,'ca_ES');
			echo strftime("%d-%m-%Y" , strtotime($data_inici));
		?>
		</span>
		<span>Final: DD-MM-YYYY</span>
	</td>
	<td><strong><?php echo $fila['TITOL'] ?></strong></td>
	<td class="noborder">
		<span class="resultats"><a href="<?php echo $_SERVER['REQUEST_URI'] ?>?ENQUESTA=<?php echo $fila['ID'] ?>">Resultats</a></span>
	</td>
</tr>
<?php
  }
?>  
</table>
<?php
}
?>