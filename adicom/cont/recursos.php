<?php
require_once("includes/clases.php");
require_once("includes/configuracion.php");
require_once("includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------

//-------------------------------------------------------------------------------
?>
<div style="padding:10px">
<table width="100%">
    <tr>
                <form action="reportes/recupera_recursos.excel.php" method = "POST" >
                    <input type="hidden" name="export" value= <?php //echo urlencode($data) ?> />
                    <input type="hidden" name="nombre_archivo" value="Reporte Recuperaciones"/>
                    <input type = "submit" class="submit_line" value = "Descargar en Excel" class="links">
				</form>

        <td>
        <iframe width="100%" height="400" frameborder="0" src="reportes/recursos_1.pdf.php"></iframe>
        </td>
        
                </table>
        </td>
    </tr>
</table>
</div>