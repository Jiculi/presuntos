<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//---------------------------------------------------------------------------------------------------
$accion = 		valorSeguro($_REQUEST['accion']);
$fecha = 		fechaMysql(valorSeguro($_REQUEST['fecha']));
$idPresunto =	valorSeguro($_REQUEST['idPresunto']);
$tipo =			valorSeguro($_REQUEST['tipoNot']);
//$oficio =		valorSeguro($_REQUEST['oficio']);
$usuario = 		valorSeguro($_REQUEST['usuario']);
$direccion = 	valorSeguro($_REQUEST['direccion']);
print_r($_POST);
//---------------------------------------------------------------------------------------------------
$query = "SELECT detalle_edo_tramite,fecha_edo_tramite,fecha_notificacion_resolucion,tipo_resolucion FROM pfrr WHERE num_accion = '".$accion."' limit 1";
$sqlPFRR = $conexion->select($query,false);
$pfrr = mysql_fetch_array($sqlPFRR);

//---------------------------------------------------------------------------------------------------
if ($tipo =="abstencion"){
		$sqltxt = "INSERT pfrr_historial 
		SET 
		 num_accion = '".$accion."',
		 tipo = '".$tipo."',
		 oficio = '".$oficio."',
		 oficioRecepcion = '".$fecha."',
		 estadoTramite = 23,
		 fechaSistema = '".date("Y-m-d")."',
		 horaSistema =  '".date("h:i:s")."',	
		 usuario = '".$usuario."',	
		 nombreProceso = 23,	
		 status = 1,
		 atendido = 1, 
		 visto = 1";
	$sql2 = $conexion->select($sqltxt,false);
	
	$sqltxt = "UPDATE pfrr_presuntos_audiencias SET fecha_notificacion_resolucion = '".$fecha."' WHERE num_accion = '".$accion."' AND cont = ".$idPresunto." ";
	$sql2 = $conexion->select($sqltxt,false);
	
	if($pfrr['detalle_edo_tramite'] != 23 && $pfrr['fecha_notificacion_resolucion'] == "" && $pfrr['tipo_resolucion'] == "" ) {
		$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 23, usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."', fecha_notificacion_resolucion = '".$fecha."',  hora = '".date("h:i:s")."',tipo_resolucion = '".$tipo."' WHERE num_accion = '".$accion."' ";
		$sql1 = $conexion->select($sqltxt,false);
	}
}

if ($tipo =="responsabilidad")
{
	$sqltxt = "INSERT pfrr_historial 
	SET 
	 num_accion = '".$accion."',
	 tipo = '".$tipo."',
	 oficio = '".$oficio."',
	 oficioRecepcion = '".$fecha."',
	 estadoTramite = 24,
	 presunto = ".$idPresunto.",
	 fechaSistema = '".date("Y-m-d")."',
	 horaSistema =  '".date("h:i:s")."',	
	 usuario = '".$usuario."',	
	 nombreProceso = 24,	
	 status = 1,
	 atendido = 1, 
	 visto = 1";
	 $sql2 = $conexion->select($sqltxt,false);
	 
	$sqltxt = "UPDATE pfrr_presuntos_audiencias SET fecha_notificacion_resolucion = '".$fecha."' WHERE num_accion = '".$accion."' AND cont = ".$idPresunto." ";
	$sql2 = $conexion->select($sqltxt,false);

	if($pfrr['detalle_edo_tramite'] != 24 || $pfrr['fecha_notificacion_resolucion'] == "" || $pfrr['tipo_resolucion'] == "" ) {
		$sql2 = $conexion->select($sqltxt,false);
		$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 24, usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."',fecha_notificacion_resolucion = '".$fecha."', hora = '".date("h:i:s")."',tipo_resolucion = '".$tipo."' WHERE num_accion = '".$accion."' ";
		$sql1 = $conexion->select($sqltxt,false);
	}
}
	
if ($tipo =="inexistencia")
{
	$sqltxt = "INSERT pfrr_historial 
	SET 
	 num_accion = '".$accion."',
	 tipo = '".$tipo."',
	 oficioRecepcion = '".$fecha."',
	 estadoTramite = 25,
	 presunto = ".$idPresunto.",
	 fechaSistema = '".date("Y-m-d")."',
	 horaSistema =  '".date("h:i:s")."',	
	 usuario = '".$usuario."',	
	 nombreProceso = 25,	
	 status = 1,
	 atendido = 1, 
	 visto = 1";
	$sql2 = $conexion->select($sqltxt,false);
	
	$sqltxt = "UPDATE pfrr_presuntos_audiencias SET fecha_notificacion_resolucion = '".$fecha."' WHERE num_accion = '".$accion."' AND cont = ".$idPresunto." ";
	$sql2 = $conexion->select($sqltxt,false);
	
	if($pfrr['detalle_edo_tramite'] != 25 || $pfrr['fecha_notificacion_resolucion'] == "" || $pfrr['tipo_resolucion'] == "" ) {
		$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 25, usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."',fecha_notificacion_resolucion = '".$fecha."', hora = '".date("h:i:s")."',tipo_resolucion = '".$tipo."' WHERE num_accion = '".$accion."' ";
		$sql1 = $conexion->select($sqltxt,false);
	}
}

if ($tipo =="sobreseimiento")
{
	$sqltxt = "INSERT pfrr_historial 
	SET 
	 num_accion = '".$accion."',
	 tipo = '".$tipo."',
	 oficioRecepcion = '".$fecha."',
	 estadoTramite = 26,
	 presunto = ".$idPresunto.",
	 fechaSistema = '".date("Y-m-d")."',
	 horaSistema =  '".date("h:i:s")."',	
	 usuario = '".$usuario."',	
	 nombreProceso = 26,	
	 status = 1,
	 atendido = 1, 
	 visto = 1";
	$sql2 = $conexion->select($sqltxt,false);
	
	echo $sqltxt = "UPDATE pfrr_presuntos_audiencias SET fecha_notificacion_resolucion = '".$fecha."' WHERE num_accion = '".$accion."' AND cont = ".$idPresunto." ";
	$sql2 = $conexion->select($sqltxt,false);
	
	if($pfrr['detalle_edo_tramite'] != 26 || $pfrr['fecha_notificacion_resolucion'] == "" || $pfrr['tipo_resolucion'] == "" ) {
		$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 26, usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."',fecha_notificacion_resolucion = '".$fecha."', hora = '".date("h:i:s")."' WHERE num_accion = '".$accion."' ";
		$sql1 = $conexion->select($sqltxt,false);
	}
}