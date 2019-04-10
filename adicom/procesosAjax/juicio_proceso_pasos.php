<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
//$vUsuario = valorSeguro($_REQUEST['user']);
//$vFecha = valorSeguro($_REQUEST['fecha']);
//$vHora = valorSeguro($_REQUEST['hora']);
$hoy=date("Y-m-d H:i:s");
$hora=date("h:i:s");
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
if ($_POST["proceso"]=="contestacion")
{
	$oficio_contestacion=valorSeguro($_POST['oficio_de_devolucionJU']);
	$acusedev=fechaMysql(valorSeguro($_POST['acusedev']));
	$juicio=valorSeguro($_POST['juicio']);
		
//----------------------------------------CONTESTACIÓN-----------------------------
//----------------------------------------CONTESTACIÓN-----------------------------		
	$sql = $conexion->update("UPDATE juicios SET estado= 'En espera de Sentencia' WHERE id = '".$juicio."'" ,false);	
	
	$sqltxt = "INSERT INTO juicios_historial 
			SET 
			 nojuicio = '".$juicio."',
			 tipo = 'contestacion',	
			 oficio	= '".$oficio_contestacion."',
			 oficioAcuse = '".$acusedev."',
			 estadoTramite = '2',
			 status = 1,
			 FechaMov = '".$hoy."',
			 HoraMov = '".$hora."' 
			 ";
			 
		$sql2 = $conexion->select($sqltxt,false);
}

//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
if ($_POST["proceso"]=="ampliacion")
{
	$oficio_contestacion=valorSeguro($_POST['oficio_de_devolucionJU']);
	$acusedev=fechaMysql(valorSeguro($_POST['acusedev']));
	$juicio=valorSeguro($_POST['juicio']);
		
//----------------------------------------AMPLIACIÓN-----------------------------
//----------------------------------------AMPLIACIÓN-----------------------------
	
	$sql = $conexion->update("UPDATE juicios SET estado= 'En espera de Sentencia con Ampliacion' WHERE id = '".$juicio."'" ,false);	
	
	$sqltxt = "INSERT INTO juicios_historial 
			SET 
			 nojuicio = '".$juicio."',
			 tipo = 'ampliacion',	
			 oficio	= '".$oficio_contestacion."',
			 oficioAcuse = '".$acusedev."',
			 estadoTramite = '3',
			 status = 1,
			 FechaMov = '".$hoy."',
			 HoraMov = '".$hora."' 
			 ";			 
		
		$sql2 = $conexion->select($sqltxt,false);
	
}
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

if ($_POST["proceso"]=="alegatos")
{
	$oficio_contestacion=valorSeguro($_POST['oficio_de_devolucionJU']);
	$acusedev=fechaMysql(valorSeguro($_POST['acusedev']));
	$juicio=valorSeguro($_POST['juicio']);
		
//----------------------------------------ALEGATOS-----------------------------
//----------------------------------------ALEGATOS-----------------------------
	
	$sql = $conexion->update("UPDATE juicios SET estado= 'en Espera de Sentencia con Alegatos' WHERE id = '".$juicio."'" ,false);	
	
	
	$sqltxt = "INSERT INTO juicios_historial 
			SET 
			 nojuicio = '".$juicio."',
			 tipo = 'alegatos',	
			 oficio	= '".$oficio_contestacion."',
			 oficioAcuse = '".$acusedev."',
			 estadoTramite = '4',
			 status = 1,
			 FechaMov = '".$hoy."',
			 HoraMov = '".$hora."' 
			 ";			
			 
		$sql2 = $conexion->select($sqltxt,false);
	
//------------------------------------------------------------------------------		
		
		echo "asistencia  -> ".print_r($_POST);
}

?>
