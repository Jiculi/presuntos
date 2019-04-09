<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//----------------------- Estado del Sistema ----------------------------
if($_REQUEST['proceso'] == "estadoSistema") {
	//estado sistema
	$query= "UPDATE configuracion set boleano = ".$_REQUEST['sistemaEdo']." WHERE proceso = '".$_REQUEST['proceso']."' ";
	$sql = $conexion->update($query,false);
	//mensaje
	$query= "UPDATE configuracion set boleano = ".$_REQUEST['sistemaEdo'].",opciones = '".$_REQUEST['mensajeTxt']."' WHERE proceso = 'mensajeCierre' ";
	$sql = $conexion->update($query,false);

	if($sql) echo "Datos guardados...";
}
//----------------------------------------Asistencia----------------------------
?>

