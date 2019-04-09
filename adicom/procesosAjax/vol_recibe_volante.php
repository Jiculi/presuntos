<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$tipoAccion= valorSeguro(trim($_POST['tipoAccion']));
$idVol= valorSeguro(trim($_POST['idVol']));
$folio= valorSeguro(trim($_POST['folio']));
$remitente= valorSeguro(trim($_POST['remitente']));
$cargo= valorSeguro(trim($_POST['cargo']));
$oficio= valorSeguro($_POST['oficio']);
$fechaOficio= valorSeguro(fechaMysql($_POST['fechaOficio']));
$fechaAcuse= valorSeguro(fechaMysql($_POST['fechaAcuse']));
$movimiento= valorSeguro($_POST['movimiento']);
$accion= valorSeguro($_POST['accion']);
$asunto= valorSeguro($_POST['asunto']);
$dependencia= valorSeguro(trim($_POST['dependencia']));
$turnado= valorSeguro($_POST['turnado']);
$direccion= valorSeguro($_POST['direccion']);
$cral= valorSeguro($_POST['cral']);
$fechaCral= valorSeguro(fechaMysql($_POST['fechaCral']));
$acuseCral= valorSeguro(fechaMysql($_POST['acuseCral']));
$usuario =valorSeguro($_POST['usuario']); 

//-------------------------- fecha y hora de volante --------------------------
$fechasVolantes = date('Y-m-d');
$horasVolantes = date("H:i:s");
//-------------------------- cancela movimiento -------------------------------
echo $queryV = "UPDATE volantes SET semaforo = 1 WHERE folio = '".$folio."' ";
//echo $queryVC = "UPDATE volantes_contenido SET semaforo = 1 WHERE folio = ".$folio." ";
$sql = $conexion->update($queryV,false); 
//$sql = $conexion->update($queryVC,false); 
//-------------------------- modifica movimiento ------------------------------
if($sql) echo "ok";
else echo "fail";
