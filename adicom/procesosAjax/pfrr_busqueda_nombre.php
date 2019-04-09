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

$sql=$conexion->select("select * from pfrr_nombres where nombre like '%$nombre%'");

while ($r=mysql_fetch_array ($sql))
{
	$results[] = array("id"=>$r["id"],"value"=>$r["nombre"], "cargo"=>$r["cargo"], "dependencia"=>$r["dependencia"]);
}

echo json_encode($results);

?>




