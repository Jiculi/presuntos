<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$prescripcion = fechaMysql(valorSeguro($_REQUEST['prescripcion']));
$accion =  valorSeguro($_REQUEST['num_accion']);

$nuevafecha = strtotime ( '+5 year' , strtotime ( $prescripcion ) ) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
//------------------------------------------------------------------------------
$sql = $conexion->update("UPDATE pfrr SET fecha_IR = '".$prescripcion."', prescripcion = '"$nuevafecha"' WHERE num_accion = '".$accion."' ",false);

if($sql) echo "Se cambio fecha de prescripcion a $prescripcion";
//echo "UPDATE po SET prescripcion = '".$prescripcion."' WHERE num_accion = '".$accion."' ";
							  
	//$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '2' WHERE num_accion = '".$num_accion."'" ,false);
	//servidor_contratista	cargo_servidor	irregularidad	num_accion	vencimiento_plazo	monto
	
	
?>