<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------

//------------------------------------------------------------------------------
print_r($_REQUEST);
echo "<br><br>";

if($_REQUEST['funcion'] == "nuevo")
{
	$nombre 	=	$_REQUEST['nombreNEW'];
	$direccion 	= 	$_REQUEST['direccionNEW'];
	$idPresunto =	$_REQUEST['idPresunto'];
	$accion 	=	$_REQUEST['numAccion'];
	
	$sql = $conexion->insert("INSERT INTO medios_representantes_legales
							  SET 
								  nombre = '".$nombre."',
								  direccion = '".$direccion."',
								  idPresunto = '".$idPresunto."',
								  num_accion = '".$accion."' ",false);
	
	if($sql) echo "---------- OK --------------";
	//$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '2' WHERE num_accion = '".$num_accion."'" ,false);
	//servidor_contratista	cargo_servidor	irregularidad	num_accion	vencimiento_plazo	monto
}
if($_REQUEST['funcion'] == "actualiza")
{
	$nombre 	=	$_REQUEST['nombreMOD'];
	$direccion 	= 	$_REQUEST['direccionMOD'];
	$idPresunto =	$_REQUEST['idPresunto'];
	$accion 	=	$_REQUEST['numAccion'];
	
	$sql = $conexion->insert("UPDATE medios_representantes_legales
							  SET 
								  nombre = '".$nombre."',
								  direccion = '".$direccion."',
								  idPresunto = '".$idPresunto."',
								  num_accion = '".$accion."' 
								  WHERE id = ".$_REQUEST["idRepresentante"]." ",false);
	
	if($sql) echo "---------- OK --------------";
							  
	//$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '2' WHERE num_accion = '".$num_accion."'" ,false);
	//servidor_contratista	cargo_servidor	irregularidad	num_accion	vencimiento_plazo	monto
}
if($_REQUEST['funcion'] == "eliminar")
{
	$sql = $conexion->insert("DELETE FROM medios_representantes_legales WHERE id = ".$_REQUEST["idRepresentante"]." ",false);
	if($sql) echo "---------- OK --------------";
}