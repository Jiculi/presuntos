<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------

$clavesicsa = valorSeguro($_REQUEST['prescripcion']);
$acc =  valorSeguro($_REQUEST['num_accion']);

$edt = valorSeguro($_REQUEST['edt']);
$user = valorSeguro($_REQUEST['usu']);
$hoy=date("Y-m-d");
$hora=date("H:i:s");

//------------------------------------------------------------------------------
if($clavesicsa != "")
{
	$sql = $conexion->update("UPDATE pfrr SET superveniente = '".$clavesicsa."' WHERE num_accion = '".$acc."' ",false);
	
		$sqlh = $conexion->insert("INSERT INTO pfrr_historial
			  SET 
				`num_accion` = '".$acc."',
				`tipo`='Guarda Clave SICSA',
				`sicsa` = '".$clavesicsa."',
				`estadoTramite`='".$edt."',
				`fechaSistema`='".$hoy."',
				`horaSistema`='".$hora."',
				`usuario`='".$user."',
				`nombreProceso`='".$edt."' ");
		
}


//if($sql) echo "Se cambio fecha de prescripcion a $prescripcion";
//echo "UPDATE po SET prescripcion = '".$prescripcion."' WHERE num_accion = '".$accion."' ";
							  
	//$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '2' WHERE num_accion = '".$num_accion."'" ,false);
	//servidor_contratista	cargo_servidor	irregularidad	num_accion	vencimiento_plazo	monto
?>