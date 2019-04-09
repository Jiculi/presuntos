<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/funciones.php");
// ----------------------- cvariables ---------------------------------------------------------------
$accion= $_REQUEST["term"];
$direccion = $_REQUEST["direccion"];
$nivel = $_REQUEST["nivel"];
// ----------------------- conexion principal ---------------------------------------------------------------
require_once("../includes/clases.php");
$conexion = new conexion;
$conexion->conectar();

if($direccion == "DG") $sql=$conexion->select("select num_accion,direccion,abogado,detalle_de_estado_de_tramite FROM po where num_accion like '%$accion%'" );
else $sql=$conexion->select("SELECT num_accion,detalle_de_estado_de_tramite FROM po WHERE num_accion LIKE '%$accion%' AND  subnivel LIKE '".$nivel."%'  ");

while ($r=mysql_fetch_array ($sql))
{
	
	$sql1=$conexion->select("select nombre,direccion from usuarios where nivel = '".$r["direccion"]."' ");
	$dir = mysql_fetch_array ($sql1);
	$director = $dir['nombre'];
	$edoGral = (dameEstado($r["detalle_de_estado_de_tramite"]));
	
	
	$results[] = array("value"=>$r["num_accion"], "direccion"=>$r["direccion"],"estadoTxt"=>$edoGral, "estado"=>$r["detalle_de_estado_de_tramite"]);
}
echo json_encode($results);

?>