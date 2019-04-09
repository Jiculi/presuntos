<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/funciones.php");
// ----------------------- cvariables ---------------------------------------------------------------
$accion= $_REQUEST["term"];
// ----------------------- conexion principal ---------------------------------------------------------------
require_once("../includes/clases.php");
$conexion = new conexion;
$conexion->conectar();

$sql=$conexion->select("select * FROM pfrr where num_accion like '%$accion%'");

while ($r=mysql_fetch_array ($sql))
{
	
	$results[] = array("value"=>$r["num_accion"], "proce"=>$r["num_procedimiento"], "enti"=>$r["entidad"]);
}
echo json_encode($results);

?>