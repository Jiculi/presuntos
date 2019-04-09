<?php
require_once("includes/clases.php");
require_once("includes/configuracion.php");
require_once("includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//$r = mysql_fetch_array($sql);
//-------------------------------------------------------------------------------
?>
<div style="padding:10px">
<table width="100%">
    <tr>
        <iframe width="100%" height="400" frameborder="0" src="reportes/informe_consejo.pdf.php"></iframe>
        </td>
        
    </tr>
</table>
</div>