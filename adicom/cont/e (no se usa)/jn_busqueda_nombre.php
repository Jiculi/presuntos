<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$nombre= $_REQUEST["term"];

$sql=$conexion->select("select DISTINCT destinatario, tipooficio, cargo_destinatario, dependencia FROM oficios where destinatario like '%$nombre%' AND tipoOficio = 'medios' ");


while ($r=mysql_fetch_array ($sql))
{
	$results[] = array("id"=>$r["id"],
	"value"=>$r["destinatario"], 
	"cargo"=>$r["cargo_destinatario"], "dependencia"=>$r["dependencia"]);
}

echo json_encode($results);
?>