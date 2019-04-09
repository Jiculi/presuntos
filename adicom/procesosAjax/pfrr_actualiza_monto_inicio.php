<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();


//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$monto = valorSeguro($_REQUEST['monto_inicio']);
$accion =  valorSeguro($_REQUEST['num_accion']);

$clv_sicsa = valorSeguro($_REQUEST['clv_sicsa']);
$n_dt = valorSeguro($_REQUEST['ndt']);

$montopdr = valorSeguro($_REQUEST['montopdr']);
$acc =  valorSeguro($_REQUEST['num_acc']);

$edt = valorSeguro($_REQUEST['edotram']);
$user = valorSeguro($_REQUEST['usm']);
$hoy=date("Y-m-d");
$hora=date("H:i:s");

//------------------------------------------------------------------------------
if( $clv_sicsa != "" )
{
	$sql = $conexion->update("UPDATE `dgr`.`pfrr` SET `superveniente` = '".$clv_sicsa."' WHERE `pfrr`.`num_accion` = '".$acc."' ",false);
	
	/*$sqlh = $conexion->insert("INSERT INTO pfrr_historial
			  SET 
				`num_accion` = '".$accion."',
				`tipo`='monto_frr',
				`estadoTramite`='".$edt."',
				`fechaSistema`='".$hoy."',
				`horaSistema`='".$hora."',
				`usuario`='".$user."',
				`nombreProceso`='".$edt."',
				`montos`='".$monto."' ");*/
}

else if($montopdr != "")
{
	$sql = $conexion->update("UPDATE pfrr SET monto_pdr = '".$montopdr."' WHERE num_accion = '".$acc."' ",false);
	
		$sqlh = $conexion->insert("INSERT INTO pfrr_historial
			  SET 
				`num_accion` = '".$acc."',
				`tipo`='monto_pdr',
				`estadoTramite`='".$edt."',
				`fechaSistema`='".$hoy."',
				`horaSistema`='".$hora."',
				`usuario`='".$user."',
				`nombreProceso`='".$edt."',
				`montos`='".$montopdr."' ");
		
}
else if($monto != "")
{
	$sql = $conexion->update("UPDATE pfrr SET inicio_frr = '".$monto."' WHERE num_accion = '".$accion."' ",false);
	
		$sqlh = $conexion->insert("INSERT INTO pfrr_historial
			  SET 
				`num_accion` = '".$accion."',
				`tipo`='monto_frr',
				`estadoTramite`='".$edt."',
				`fechaSistema`='".$hoy."',
				`horaSistema`='".$hora."',
				`usuario`='".$user."',
				`nombreProceso`='".$edt."',
				`montos`='".$monto."' ");
}
else if( $n_dt != "" )
{
	$sql = $conexion->update("UPDATE `dgr`.`pfrr` SET `num_DT` = '".$n_dt."' WHERE `pfrr`.`num_accion` = '".$acc."' ",false);
	
	/*$sqlh = $conexion->insert("INSERT INTO pfrr_historial
			  SET 
				`num_accion` = '".$accion."',
				`tipo`='monto_frr',
				`estadoTramite`='".$edt."',
				`fechaSistema`='".$hoy."',
				`horaSistema`='".$hora."',
				`usuario`='".$user."',
				`nombreProceso`='".$edt."',
				`montos`='".$monto."' ");*/
}
/*
else if( $n_dt != "" )
{
	$sql = $conexion->update("UPDATE `dgr`.`pfrr` SET `num_DT` = '".$n_dt."' WHERE `pfrr`.`num_accion` = '".$acc."' ",false);
	
	/*$sqlh = $conexion->insert("INSERT INTO pfrr_historial
			  SET 
				`num_accion` = '".$accion."',
				`tipo`='monto_frr',
				`estadoTramite`='".$edt."',
				`fechaSistema`='".$hoy."',
				`horaSistema`='".$hora."',
				`usuario`='".$user."',
				`nombreProceso`='".$edt."',
				`montos`='".$monto."' ");*/


//if($sql) echo "Se cambio fecha de prescripcion a $prescripcion";
//echo "UPDATE po SET prescripcion = '".$prescripcion."' WHERE num_accion = '".$accion."' ";
							  
	//$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '2' WHERE num_accion = '".$num_accion."'" ,false);
	//servidor_contratista	cargo_servidor	irregularidad	num_accion	vencimiento_plazo	monto
?>