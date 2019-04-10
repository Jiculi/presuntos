<?php
require_once("includes/clases.php");
require_once("includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$accion = valorSeguro($_REQUEST['numAccion']);
$direccion = $_REQUEST['direccion'];
?>
<div style="padding:0 10px">
	<iframe frameborder="0" width="100%" height="550" src="reportes2/principalReportes.php"></iframe>
</div>
