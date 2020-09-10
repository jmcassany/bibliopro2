<?php 
    $_SESSION['db_exporter']->selected_table = $_POST['sel_table'];
    $fields = $_SESSION['db_exporter']->get_fields();
?>

<table cellpadding='0' cellspacing='0' border='0' width='100%'>
<tr>
	<td width='36' rowspan='2' valign='top'>
		<img src='../../comu/ico_copia1.gif' width='36' height='18' alt='Fer una copia de seguretat' border='0' vspace='2'>
	</td>
	<td bgcolor='#0E449A' style='padding:5px;' class="blanc11b">
		Exportar dades (2/3)
	</td>
</tr>
<tr>
	<td bgcolor='#E6E6E6'>

		<form action="?go=ex_step3" method="POST">
		<table width="100%" cellpadding="5" cellspacing="5" border="0">
		    <tr>
		        <td>
		           Seleccioneu els camps de la taula a exportar:<br />
		        </td>   
		    </tr>
		    <tr>
		        <td>
		            <select name="sel_fields[]" multiple="yes">
		                <?php
		                    foreach($fields as $key=>$value) {
		                        print("<option value=\"$value\" selected>$value</option>");   
		                    }
		                ?>
		            </select>
		        </td>
		    </tr>
		    <tr>
		        <td>
		            <input type="submit" value="Continuar">
		        </td>
		    </tr>
		</table>
		</form>

	</td>
</tr>
</table>
