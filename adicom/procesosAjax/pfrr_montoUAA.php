<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$nvoMonto = valorSeguro($_REQUEST['monto']);
$accion =  valorSeguro($_REQUEST['accion']);
$nvoMonto = str_replace(",","",$nvoMonto);
//------------------------------------------------------------------------------
$sql = $conexion->update("UPDATE pfrr SET monto_no_solventado_UAA = '".$nvoMonto."' WHERE num_accion = '".$accion."' ",false);

if($sql) echo "Se cambio el monto de la accion $accion a $nvoMonto.";
else echo $sql;
