<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//print_r($_REQUEST);

//--------------- Alta usuario

$hoy=date("Y-m-d H:i:s");
//---------------- Inicio de Alta
if($_REQUEST['tipoForm'] == "alta")
	
{
	//---------- Asignación de datos del formulario a variables nuevas ----------------
$nombre = valorSeguro($_POST['empnom']);
// $mEntidad = valorSeguro($_POST['entidad']);
$mAccion = valorSeguro($_POST['mAccion']);
$mProcedimiento = valorSeguro($_POST['mProcedimiento']);
$nivel = valorSeguro ($_POST['empniv']);
$direccion = valorSeguro($_POST['empdir']);
//$tipo = valorSeguro($_POST['emptip']);
$perfil = valorSeguro($_POST['empper']);

//$otros_po = valorSeguro($_POST['empopo']);
//$otros_pfrr = valorSeguro($_POST['empopf']);
$mDir = valorSeguro($_POST['mDir']);
$fecha_ingreso = valorSeguro($_POST['empfin']);
$mSubnivel = valorSeguro($_POST['mSubnivel']);
$puesto = valorSeguro($_POST['emppue']);
$ascenso = valorSeguro($_POST['empasc']);
//$ascenso2 = valorSeguro($_POST['empas2']);
//$fecha_baja = valorSeguro($_POST['empfba']);
$puesto_ant = valorSeguro($_POST['emppan']);



//if($status == "" OR $status == "0" ){$status = "0.5";}
//if($mAccion == ""){$mAccion = "usersn"; $mProcedimiento = "passwordn"; }

	$query = "INSERT INTO juiciosNew 
			  SET 
			  `nojuicio` = '".$nombre."',
			  `fechanot` = '".fechaMysql($fecha_ingreso)."',
			  `subnivel` = '".$mSubnivel."',
			  `dir` = '".$mDir."',
			  `accion` = '".$mAccion."',
			  `procedimiento` = '".$mProcedimiento."',
			  `sub` = '".$puesto."',
			  `salaconocimiento` = '".$nivel."',
			  `juicionulidad` = '".$perfil."',
			  `actor` = '".$direccion."',
			  `vencimiento` = '".fechaMysql($ascenso)."',
			  `monto` = '".$puesto_ant."'";
			  
		
		$sql = $conexion->insert($query);
		
	
	
}

?>