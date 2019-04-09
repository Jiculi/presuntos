<?php
require_once("includes/clases.php");
require_once("includes/configuracion.php");
require_once("includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
if($_SESSION['direccion'] != "DG")
	$sql = $conexion->insert("INSERT INTO rep_visitas SET user = '".$_SESSION['usuario']."', fechaHora = '".date("Y-m-d")." ".date("h:i:s")."', hora='".date("h:i:s")."' ",false);
//echo $sql;
//$r = mysql_fetch_array($sql);
//-------------------------------------------------------------------------------
?>
<div style="padding:10px">
<table width="100%">
    <tr>
        <td <?php if($_SESSION['direccion'] == "DG") echo 'width="60%"'; 
		else  echo 'width="100%"';  ?> >
        <iframe width="100%" height="400" frameborder="0" src="reportes/po_asistidos.pdf.php"></iframe>
        </td>
        
                </table>
        </td>
    </tr>
</table>
</div>