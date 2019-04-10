<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases2.php");
require_once("../includes/clases3.php");

require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$accion= $_REQUEST["term"];
$direccion = $_REQUEST["direccion"];
$nivel = $_REQUEST["nivel"];

if($direccion == "DG") $sql=$conexion->select("select num_accion,direccion,abogado,detalle_de_estado_de_tramite from po where num_accion like '%$accion%'");
//else $sql=$conexion->select("SELECT num_accion,direccion,abogado,detalle_de_estado_de_tramite,subnivel FROM po WHERE num_accion like '%$accion%' AND subnivel like '%$nivel%' ");
else $sql=$conexion->select("select num_accion,direccion,abogado,detalle_de_estado_de_tramite from po where num_accion like '%$accion%'");

while ($r=mysql_fetch_array ($sql))
{
	$sql1=$conexion->select("select nombre,direccion from usuarios where nivel = '".$r["direccion"]."' ");
	$dir = mysql_fetch_array ($sql1);
	$director = $dir['nombre'];
	
	$results[] = array("value"=>$r["num_accion"], "direccion"=>$r["direccion"], "turnado"=>$director, "direccion"=>$r["direccion"], "estado"=>$r["detalle_de_estado_de_tramite"]);
}
//-----------------------------------------------------------
$conexion3 = new conexion3;
$conexion3->conectar();

$sql=$conexion3->select("select num_accion,direccion,abogado,detalle_de_estado_de_tramite FROM po where num_accion like '%$accion%'");

while ($r=mysql_fetch_array ($sql))
{
	$sql1=$conexion3->select("SELECT nombre,direccion FROM usuarios WHERE direccion = '".$r["direccion"]."' ");
	$dir = mysql_fetch_array ($sql1);
	$director = $dir['nombre'];
	
	$results[] = array("value"=>$r["num_accion"], "direccion"=>$r["direccion"], "turnado"=>$director, "direccion"=>$r["direccion"], "estado"=>$r["detalle_de_estado_de_tramite"]);
}

echo json_encode($results);

?>




