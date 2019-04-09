<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$accion= $_REQUEST["term"];
$direccion = $_REQUEST["direccion"];

if($direccion == "DG") $sql=$conexion->select("select num_accion,direccion,abogado,detalle_de_estado_de_tramite from po where num_accion like '%$accion%'");
else $sql=$conexion->select("select num_accion,direccion,abogado,detalle_de_estado_de_tramite from po where num_accion like '%$accion%' and direccion = '%$direccion%'");

while ($r=mysql_fetch_array ($sql))
{
	$sql1=$conexion->select("select nombre,direccion,perfil from usuarios where perfil = 'Director' AND direccion = '".$r["direccion"]."' ");
	$dir = mysql_fetch_array ($sql1);
	$director = $dir['nombre'];
	
	$results[] = array("value"=>$r["num_accion"], "direccion"=>$r["direccion"], "turnado"=>$director, "direccion"=>$r["direccion"], "estado"=>$r["detalle_de_estado_de_tramite"]);
}

echo json_encode($results);

?>




