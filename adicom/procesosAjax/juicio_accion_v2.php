<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/funciones.php");
// ----------------------- cvariables ---------------------------------------------------------------
$procedimiento= $_REQUEST["term"];
// ----------------------- conexion principal ---------------------------------------------------------------
require_once("../includes/clases.php");
$conexion = new conexion;
$conexion->conectar();

$sql=$conexion->select("SELECT pfrr.num_accion, pfrr.num_procedimiento, pfrr.cp, pfrr.entidad, pfrr.direccion, pfrr_presuntos_audiencias.importe_frr, pfrr_presuntos_audiencias.nombre FROM pfrr INNER JOIN pfrr_presuntos_audiencias ON pfrr.num_accion=pfrr_presuntos_audiencias.num_accion WHERE num_procedimiento like '%$procedimiento%' AND responsabilidad LIKE 'Si' AND status = '1' AND detalle_edo_tramite = 24");

while ($r=mysql_fetch_array ($sql))
{
	
	$results[] = array("value"=>$r["num_procedimiento"]."-".$r["nombre"], "accion"=>$r["num_accion"], "enti"=>$r["entidad"], "da"=>$r["direccion"], "cuepub"=>$r["cp"], "actor"=>$r["nombre"] , "monto"=>$r["importe_frr"] );
}
echo json_encode($results);

?>

