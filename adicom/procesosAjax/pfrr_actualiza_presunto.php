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

foreach($_POST as $nombre_campo => $valor)
{
   $asignacion = "\$" . $nombre_campo . " = '" . valorSeguro($valor) . "';"; 
   eval($asignacion);
}

if($funcion == "nuevo")
{
	$sql = $conexion->insert("INSERT INTO pfrr_presuntos_audiencias
							  SET 
							  	  num_accion='$accion',
								  nombre = '$new_nombre',	
								  cargo	= '$new_cargo',
								  tipo = '$new_tipoPresunto', 
								  dependencia = '$new_dependencia', 
								  rfc = '$new_rfc', 
								  status = '1', 
								  domicilio = '$new_domicilio',	
								  accion_omision = '$new_irregularidad', 	
								  fecha_accion_omision_1 = '".fechaMysql($new_fechaAO1)."', 	
								  fecha_accion_omision_2 = '".fechaMysql($new_fechaAO2)."', 
								  prescripcion_accion_omision = '".fechaMysql($new_fechaPAO)."'
								  ",false);
	
	if($sql) echo "---------- OK --------------";
}

if($funcion == "actualiza")
{
	$sql = $conexion->update("UPDATE pfrr_presuntos_audiencias
							  SET 
								  servidor_contratista='$servidor', 
								  cargo_servidor='$cargo',
								  tipo_presunto='$tipoPresunto',  
								  irregularidad='$irregularidad', 
								  monto='$monto'
							  WHERE creacion= '$idPresunto' ",false);
	
	if($sql) echo "---------- OK --------------";
}