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
//--------------- Alta usuario
$hoy=date("Y-m-d H:i:s");
//---------------- Inicio de Alta
if($_REQUEST['tipoForm'] == "alta")
	
{
	//---------- Asignación de datos del formulario a variables nuevas ----------------
$nombre = valorSeguro($_POST['empnom']);
$curp = valorSeguro($_POST['empcurp']);
$usuario = valorSeguro($_POST['empusu']);
$password = valorSeguro($_POST['emppas']);
$nivel = valorSeguro ($_POST['empniv']);
$direccion = valorSeguro($_POST['empdir']);
//$tipo = valorSeguro($_POST['emptip']);
$perfil = valorSeguro($_POST['empper']);

//$otros_po = valorSeguro($_POST['empopo']);
//$otros_pfrr = valorSeguro($_POST['empopf']);
$genero = valorSeguro($_POST['empgen']);
$fecha_ingreso = valorSeguro($_POST['empfin']);
$sustituye = valorSeguro($_POST['empsus']);
$puesto = valorSeguro($_POST['emppue']);
$ascenso = valorSeguro($_POST['empasc']);
//$ascenso2 = valorSeguro($_POST['empas2']);
//$fecha_baja = valorSeguro($_POST['empfba']);
$puesto_ant = valorSeguro($_POST['emppan']);



if($status == "" OR $status == "0" ){$status = "0.5";}
if($usuario == ""){$usuario = "usersn"; $password = "passwordn"; }

	$query = "INSERT INTO juicios 
			  SET 
			  `id` = '',
			  `nojuicio` = '".$nombre."',
			  `entidad` = '".$curp."',
			  `fechanot` = '".fechaMysql($fecha_ingreso)."',
			  `subnivel` = '".$sustituye."',
			  `dir` = '".$genero."',
			  `accion` = '".$usuario."',
			  `procedimiento` = '".$password."',
			  `sub` = '".$puesto."',
			  `salaconocimiento` = '".$nivel."',
			  `juicionulidad` = '".$perfil."',
			  `actor` = '".$direccion."',
			  `vencimiento` = '".fechaMysql($ascenso)."',
			  `monto` = '".$puesto_ant."'";
			  
		
		$sql = $conexion->insert($query);
		
	
	
}
 //---------------- Fin de Alta

//--------------- Modifica usuario---------------------
//--------------- Modifica usuario---------------------



//---------------------------- Inicio de Actualización


	
	
 //---------------------------- Fin de Actualización
?>