<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------

$nivel=valorSeguro($_POST['nivel']);
$status=valorSeguro($_POST['status']);


$sql1 = $conexion->update("UPDATE usuarios SET otros_po = '".$status."', hora_otros_po= '".date('H:i:s')."' WHERE nivel = '".$nivel."' ",false); 
//$sql3 = $conexion->update("UPDATE pfrr SET abogado = '".$abogado."',subnivel='".$subnivel."' WHERE num_accion = '".$accion."' ",false); 
//-------------------------- modifica movimiento ------------------------------
if($sql1) echo "ok";
else echo "fail";
