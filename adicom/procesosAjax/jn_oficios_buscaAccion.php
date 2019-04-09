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

if ( $nivel == "S" ) { $nivel = $_REQUEST["direccion"];}

if($direccion == "DG" || $direccion == "A") $sql=$conexion->select("select accion, procedimiento, estado, juicionulidad 
                       FROM juiciosnew
                       where accion like '%$accion%'");
else $sql=$conexion->select("select accion, procedimiento, estado, juicionulidad
                       FROM juiciosnew
                       where accion like '%$accion%'  AND  subnivel LIKE '".$nivel."%'  ");

while ($r=mysql_fetch_array ($sql))
{
	
    $results[] = array("value"=>$r["accion"], "estado"=>$r["estado"], 
                       "procedimiento"=>$r["procedimiento"],"jn"=>$r["juicionulidad"]);
}
echo json_encode($results);
?>




