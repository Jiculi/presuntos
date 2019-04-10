<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$rec= valorSeguro($_REQUEST['rec']);
//-------------------------- SQL VERIFICA DEVOLUCIONES -------------------------

$sql = $conexion->update("UPDATE medio_historial SET tiempo = 1  WHERE id_actor =  $rec ", false);
mysql_free_result($sql);

?>
