<?php
$CONFIG_PATHPHP = '|CONFIG_PATHPHP|';
include_once($CONFIG_PATHPHP."/config.php");
//include_once($CONFIG_PATHPHP."/lib/database/database.inc");

function view_enquesta|ENQUESTA| () {
  global $db_url_web;
  global $CONFIG_URLVOTA, $CONFIG_URLBASE, $CONFIG_NOMCARPETA;

  $enquesta=|ENQUESTA|;

  $desti = $CONFIG_URLVOTA.'?ENQUESTA='.$enquesta;

  db_connect($db_url_web);

  $result = db_query("SELECT TITOL, END_TIME, VISIBILITY FROM ENQUESTA WHERE ID=".$enquesta." AND (STATUS='1') and ((VISIBILITY='1') or (VISIBILITY='2' and START_TIME < NOW()))");

  if (db_num_rows($result) != 1) {
    return;
  }
  $fila = db_fetch_array($result);
  $titol = $fila['TITOL'];
  $actiu = true;
  if ($fila['END_TIME']<date('Y-m-d H:i:s') && $fila['VISIBILITY'] == 2) {
    $actiu = false;
  }
  $result = @db_query('SELECT DESCRIPCIO, ID FROM ENQUESTA_PREG WHERE ENQUESTA='.$enquesta);
?>
<script type="text/javascript">
//<![CDATA[

function desactivarBoto<?php echo $enquesta;?>() {
  oBoto = document.getElementById('boto<?php echo $enquesta ?>');
  oBoto.setAttribute('disabled', 'disabled');
}

function activarBoto<?php echo $enquesta;?>() {
  oElements = document.getElementsByName('PREGUNTA<?php echo $enquesta;?>');
  oBoto = document.getElementById('boto<?php echo $enquesta ?>');
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


	<div class="enquesta clearfix">
		<p class="int"><?php echo $titol ?></p>
		<form action="<?php echo $CONFIG_NOMCARPETA; ?>/enquesta_vota.php" method="post">
		<fieldset>
		<?php
		if ($actiu) {
		    $i = 0;
		    while ($row = db_fetch_array($result)) {
		?>
		     	<label for="PREGUNTA<?php echo $enquesta.'-'.$i;?>"><input type="radio" name="PREGUNTA<?php echo $enquesta;?>" id="PREGUNTA<?php echo $enquesta.'-'.$i;?>" value="<?php echo $row['ID'] ?>" onclick="activarBoto<?php echo $enquesta;?>()" onchange="activarBoto<?php echo $enquesta;?>()" /><?php echo $row['DESCRIPCIO'] ?></label>
		<?php
		      	$i++;
		    }
		?>
		</fieldset>
		<span class="resultats"><a href="<?php echo $CONFIG_NOMCARPETA;?>/enquesta.html?ENQUESTA=<?php echo $enquesta; ?>">Resultats</a></span>
		<input type="hidden" name="ENQUESTA" value="<?php echo $enquesta ?>" />
		<p><input type="submit" id="boto<?php echo $enquesta ?>" value="Votar" name="action" class="enviar" /></p>
		<script type="text/javascript">
		//<![CDATA[
			activarBoto<?php echo $enquesta;?>();
		//]]>
		</script>
		<?php
		  }
		?>
      	</form>
	</div>

<?php
}
view_enquesta|ENQUESTA|();
?>
