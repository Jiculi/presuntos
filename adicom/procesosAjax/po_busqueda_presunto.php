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
$cont = 0;

$sql=$conexion->select("select * from po_presuntos where num_accion like '%$accion%' AND servidor_contratista like '%$nombre%'");

while ($r=mysql_fetch_array ($sql))
{
	$results[] = array("id"=>$r["creacion"],"value"=>$r["servidor_contratista"], "cargo"=>$r["cargo_servidor"], "dependencia"=>"");
}

echo json_encode($results);

?>




