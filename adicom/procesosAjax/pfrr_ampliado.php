<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$accion =  valorSeguro($_REQUEST['num_accion']);
$ch = valorSeguro($_REQUEST['chk1']);
$c2 = valorSeguro($_REQUEST['chk2']);
$c3 = valorSeguro($_REQUEST['chk3']);
$amp = "";

if($ch == "on") $amp.="Reintegro|";
if($c2 == "on") $amp.="Subejercicio|";
if($c3 == "on") $amp.="Mixto|";
//------------------------------------------------------------------------------
$sql = $conexion->update("UPDATE pfrr SET ampliados = '".$amp."' WHERE num_accion = '".$accion."' ",false);

?>