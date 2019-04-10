<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$accion= $_REQUEST["term"];
$direccion = $_REQUEST["direccion"];
$nivel = $_REQUEST["nivel"];


$sql=$conexion->select("select SUBSTRING(nojuicio, 6) as juicio , actor, accion, procedimiento, dir, subnivel FROM juicios where nojuicio like '%$accion%'");

/*else $sql=$conexion->select("select SUBSTRING(nojuicio, 6) as juicios, actor, accion, procedimiento, dir, subnivel, juicios where juicios like '%$accion%'  AND  subnivel LIKE '".$nivel."%'  ");*/

while ($r=mysql_fetch_array ($sql))
{
	$sql1=$conexion->select("select nombre,direccion from usuarios where nivel = '".$r["subnivel"]."' ");
	$dir = mysql_fetch_array ($sql1);
	$director = $dir['nombre'];
	$menFinal = "";


	//sacamos estado de tramiteen texto --------------
	$edoGral = (dameEstado($r["detalle_edo_tramite"]));
	
	$results[] = array("value"=>$r["juicio"], "turnado"=>$director, "direccion"=>$r["dir"]);

}
echo json_encode($results);
?>




