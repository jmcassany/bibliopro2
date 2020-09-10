<?php 
    $tables = $_SESSION['source']->get_tables();
?>
<form action="?go=imp_step2" method="POST">
<table width="780" cellpadding="5" cellspacing="5" border="0">
    <tr>
        <td align="center">
           <b>Seleccione la tabla a la cual los datos ser&aacute;n importados (ign&oacute;rese si la importaci&oacute;n se realiza desde ficheros SQL)<br /></b>
        </td>   
    </tr>
    <tr>
       <td align="center">
           <select name="sel_table">
               <?php
                    foreach($tables as $key=>$value) {
                        print("<option value=\"$value\">$value</option>");   
                    }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td align="center"><br><br>
            <input type="submit" value="Continuar">
        </td>
    </tr>
</table>
</form>
