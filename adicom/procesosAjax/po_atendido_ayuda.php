<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$id = valorSeguro($_REQUEST['id']);
//-------------------------- SQL VERIFICA DEVOLUCIONES -------------------------

$sql = $conexion->update("UPDATE solicitud_ayuda SET status = 2 WHERE id = $id ", false);

mysql_free_result($sql);
//mysql_close($conexion);

?>
