<?php 
    $_SESSION['source']->target_table = $_POST['sel_table'];
?>
<form action="?go=imp_step3" method="POST">
<table width="780" cellpadding="5" cellspacing="5" border="0">
    <tr>
        <td align="center">
           <b>Seleccione el tipo de fichero del cual desea importar datos: <br /></b>
        </td>   
    </tr>
    <tr>
        <td align="center">
            <select name="import_source">
                <option value="<?php echo FROM_XML; ?>"> XML </option>
                <option value="<?php echo FROM_CSV; ?>"> CSV </option>
                <option value="<?php echo FROM_SQL; ?>"> SQL </option>
            </select>
        </td>
    </tr>
    <tr>
        <td align="center"><br><br><br>
            <input type="submit" value="Continuar">
        </td>
    </tr>
</table>
</form>