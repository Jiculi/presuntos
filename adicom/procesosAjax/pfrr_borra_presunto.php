<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$funcion = valorSeguro($_REQUEST['funcion']);
$idPresunto = valorSeguro($_REQUEST['idPresunto']);
$servidor = valorSeguro($_REQUEST['servidor']);
$cargo = valorSeguro($_REQUEST['cargo']);
$tipoPresunto = valorSeguro($_REQUEST['tipoPresunto']);
$irregularidad = valorSeguro($_REQUEST['irregularidad']);
$monto = valorSeguro($_REQUEST['monto']);
$fecha = valorSeguro($_REQUEST['fecha']);
$hora = valorSeguro($_REQUEST['hora']);
$usuario = valorSeguro($_REQUEST['usuario']);
$accion =  valorSeguro($_REQUEST['num_accion']);
//------------------------------------------------------------------------------
print_r($_REQUEST);
echo "<br><br>";

//if($funcion == "borra")
{
	$sql = $conexion->delete("UPDATE  pfrr_presuntos_audiencias set status='0'
							  WHERE cont= '$idPresunto' ",false);
	
	if($sql) echo "---------- OK --------------";
							  
	//$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '2' WHERE num_accion = '".$num_accion."'" ,false);
	//servidor_contratista	cargo_servidor	irregularidad	num_accion	vencimiento_plazo	monto
}