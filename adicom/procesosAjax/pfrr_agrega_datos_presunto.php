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
//$nombre = valorSeguro($_REQUEST['nombre']);
$cargo = valorSeguro($_REQUEST['cargo']);
//s$tipoPresunto = valorSeguro($_REQUEST['tipo']);
$accion_omision = valorSeguro($_REQUEST['accion_omision']);

$monto_dano = valorSeguro($_REQUEST['monto_dano']);
$monto_dano = str_replace(",","",$monto_dano);

$monto_aclarado = valorSeguro($_REQUEST['monto_aclarado']);
$monto_aclarado = str_replace(",","",$monto_aclarado);

$monto_aclaradoUAA = valorSeguro($_REQUEST['monto_aclaradoUAA']);
$monto_aclaradoUAA = str_replace(",","",$monto_aclaradoUAA);

$monto_reintegrado = valorSeguro($_REQUEST['monto_reintegrado']);
$monto_reintegrado = str_replace(",","",$monto_reintegrado);

$intereses = valorSeguro($_REQUEST['intereses']);
$intereses = str_replace(",","",$intereses);

$interesesD = valorSeguro($_REQUEST['interesesD']);
$interesesD = str_replace(",","",$interesesD);

$importe_frr = valorSeguro($_REQUEST['importe_frr']);
$importe_frr = str_replace(",","",$importe_frr);

$fecha_accion_omision1 = fechaMysql($_REQUEST['fecha_accion_omision1']);
$fecha_accion_omision2 = fechaMysql($_REQUEST['fecha_accion_omision2']);
$pres_accion_omision = fechaMysql($_REQUEST['pres_accion_omision']);
$monto_pres = valorSeguro($_REQUEST['monto_pres']);
$fecha_dep_monto = fechaMysql($_REQUEST['fecha_dep_monto']);
$fecha_dep_int = fechaMysql($_REQUEST['fecha_dep_int']);
$fecha_registro =fechaMysql( $_REQUEST['fecha_registro']);
$rfc= valorSeguro($_REQUEST['rfc']);
$domicilio= valorSeguro($_REQUEST['domicilio']);
$dependencia= valorSeguro($_REQUEST['dependencia']);
$tipo= valorSeguro($_REQUEST['tipo']);

$oficio_citatorio=valorSeguro($_REQUEST['oficio_citatorio']);
$fecha_oficio_cit=fechaMysql($_REQUEST['fecha_oficio_cit']);
$fecha_noti_cit=fechaMysql($_REQUEST['fecha_noti_cit']);
$tipo_noti= valorSeguro($_REQUEST['tipo_noti']);
$fecha_citacion=fechaMysql($_REQUEST['fecha_citacion']);

$hora = valorSeguro($_REQUEST['hora']);
$usuario = valorSeguro($_REQUEST['usuario']);
$direccion = valorSeguro($_REQUEST['direccion']);
$accion =  valorSeguro($_REQUEST['num_accion']);
//------------------------------------------------------------------------------
echo "<br><br>";

if($funcion == "actualiza"){
	$sql = $conexion->update("UPDATE pfrr_presuntos_audiencias
							  SET 
								  cargo = '".$cargo."',
								  dependencia = '".$dependencia."',
								  rfc = '".$rfc."',
								  domicilio = '".$domicilio."',
								  accion_omision = '".$accion_omision."',
								  fecha_accion_omision_1 = '".$fecha_accion_omision1."',
								  fecha_accion_omision_2 = '".$fecha_accion_omision2."',
								  prescripcion_accion_omision = '".$pres_accion_omision."',
								  monto = '".$monto_pres."',
								  status='1'
								  							  
							  WHERE cont= ".$idPresunto." ",false);
	
	if($sql) echo "---------- OK --------------";
}

if($funcion == "actualizaMontosDano"){
	$sql = $conexion->update("UPDATE pfrr_presuntos_audiencias
							  SET 
								  monto='".$monto_dano."',
								  monto_aclarado='".$monto_aclarado."',
								  monto_aclarado_uaa='".$monto_aclaradoUAA."',
								  fecha_deposito='".$fecha_dep_monto."',
								  importe_frr='".$importe_frr."',
								  resarcido='".$monto_reintegrado."',
								  fecha_registro='".$fecha_registro."'
							  WHERE cont= ".$idPresunto." ",false);
	
	if($sql) echo "---------- OK --------------";
}
if($funcion == "actualizaMontosIntereses"){
	$sql = $conexion->update("UPDATE pfrr_presuntos_audiencias
							  SET 
								  fecha_deposito_intereses_resarcidos='".$fecha_dep_int."',
								  interesesDano='".$interesesD."',
  								  importe_frr='".$importe_frr."',
								  intereses_resarcidos='".$intereses."'
							  WHERE cont= ".$idPresunto." ",false);
	
	if($sql) echo "---------- OK --------------";
}
print_r($_REQUEST);
