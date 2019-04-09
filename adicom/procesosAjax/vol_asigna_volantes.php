<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------

$idVol= valorSeguro(trim($_POST['idVol']));
$folio= valorSeguro(trim($_POST['folio']));
$accion= valorSeguro($_POST['accionA']);
$direccion= valorSeguro($_POST['direccion']);
$aboPart=valorSeguro($_POST['abagadoAsig']);
$usuario =valorSeguro($_POST['usuario']);

$aboPart = explode("|",$aboPart);
$abogado = $aboPart[0];
$subnivel= $aboPart[1];

$sql1 = $conexion->update("UPDATE po SET abogado = '".$abogado."',subnivel='".$subnivel."' WHERE num_accion = '".$accion."' ",false); 
$sql3 = $conexion->update("UPDATE pfrr SET abogado = '".$abogado."',subnivel='".$subnivel."' WHERE num_accion = '".$accion."' ",false); 
if($sql1)
	$sql2 = $conexion->update("UPDATE volantes SET semaforo = 2 WHERE id = ".$idVol." ",false); 
if($sql3)
	$sql2 = $conexion->update("UPDATE volantes SET semaforo = 2 WHERE id = ".$idVol." ",false); 
//-------------------------- modifica movimiento ------------------------------
if($sql1 && $sql2) echo "ok";
else echo "fail";
