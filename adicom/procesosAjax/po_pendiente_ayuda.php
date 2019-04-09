<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$id = valorSeguro($_REQUEST['id']);
$usuario = valorSeguro($_REQUEST['usuario']);
$cometnarios= valorSeguro($_REQUEST['comentarios']);
//-------------------------- SQL VERIFICA DEVOLUCIONES -------------------------

$sql = $conexion->update("UPDATE solicitud_ayuda SET atendidopor='".$usuario."',fechaHora='".date("Y-m-d H:i:s")."',status = 1,comentarios='".$cometnarios."' WHERE id = $id ", false);

mysql_free_result($sql);
//mysql_close($conexion);

?>
