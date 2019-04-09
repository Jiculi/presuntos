<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$nombre= $_REQUEST["term"];
$acciones = $_REQUEST["acciones"];
$accion = str_replace("|","",$acciones);
$tipo = $_REQUEST["tipo"];

$cont = 0;

$sql=$conexion->select("select * from actores_recurso where actor like '%$nombre%'");

while ($r=mysql_fetch_array ($sql))
{
	$results[] = array("idact"=>$r["actor"],"acc"=>$r["num_accion"],"dependencia"=>$r["entidad"], "estado"=>$r["detalle_edo_tramite"], "procedimiento"=>$r["recurso_reconsideracion"], "value"=>$r["actor"]." - ".$r["num_accion"]);
}

echo json_encode($results);

?>