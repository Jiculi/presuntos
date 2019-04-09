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
$accion1 = $_REQUEST["accion1"];
$tipo = $_REQUEST["tipo"];
$seleccion = $_REQUEST["seleccion"];

$cont = 0;


if($seleccion == 2) 
{
	$sql=$conexion->select("SELECT * from directores_uaa INNER JOIN fondos on fondos.UAA=directores_uaa.uaa	where  fondos.num_accion = '".$accion."'");
	$r=mysql_fetch_array ($sql);
	
	echo $r["director"]."|".$r["cargo"]."|".$r["uaa"];
}









?>




