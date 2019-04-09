<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();


if($_REQUEST['tipo'] == '102')
{
	
	$query = "INSERT INTO opiniones_historial SET
				num_accion = '".$_REQUEST['accion']."',
				oficio = '".$_REQUEST['oficio_req']."',
				oficioRecepcion = '".fechaMysql($_REQUEST['fecha_oficio_req'])."',
				oficioAcuse = '".fechaMysql($_REQUEST['fecha_acuse_oficio_req'])."',
				estadoTramite = '102',
				fechaSistema = '".date("Y-m-d h:i:s")."',
				horaSistema='".date("h:i:s")."',
				usuario='".$_REQUEST['user']."',
				status = 1";
	$sql = $conexion->insert($query,false);
	
	
	$queryA="UPDATE opiniones set
	 detalle_de_estado_de_tramite= '102',
	 fecha_estado_tramite= '".date("Y-m-d")."',
	 ip_edo_tram='".$_REQUEST['user']."',
	 hora_act_edo_tram= '".date("h:i:s")."'
	 where num_accion='".$_REQUEST['accion']."'"; 
	 $sqlA= $conexion->update($queryA,false);
	
		//echo "Asistencia  -> ".print_r($_POST);

}

?>