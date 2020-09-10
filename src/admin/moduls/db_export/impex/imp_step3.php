<?php 
    $_SESSION['source']->import_source = $_POST['import_source'];
?>
<form action="?go=imp_step4" enctype="multipart/form-data" method="POST">
<table width="780" cellpadding="5" cellspacing="5" border="0">
    <tr>
        <td align="center">
           <b>Seleccione el fichero de datos: <br /></b>
        </td>   
    </tr>
    <tr>
        <td align="center">
            <input type="file" name="datafile">
        </td>
    </tr>
    <tr>
        <td align="center">
            <input type="submit" value="Continuar">
        </td>
    </tr>
</table>
</form>