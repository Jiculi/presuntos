<title>ejecutoria_amparo</title>
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
//if($_REQUEST['tipoForm'] == "alta")

$repjui = valorSeguro($_REQUEST['empid']);
{
	//---------- Asignación de datos del formulario a variables nuevas ----------------
$actor = valorSeguro($_REQUEST['actor']);
$sala = valorSeguro($_REQUEST['sala']);
$jnu = valorSeguro($_REQUEST['jnu']);
$fnot = valorSeguro($_REQUEST['fnot']);
$venc = valorSeguro($_REQUEST['venc']);
$monto = valorSeguro($_REQUEST['monto']);

//------------------- Actualiza datos en la base

	$query = "UPDATE juicios SET 
		
		actor = '".$actor."',
		salaconocimiento = '".$sala."', 
		fechanot ='".fechaMysql ($fnot)."',	 
		juicionulidad = '".$jnu."',
		vencimiento ='".fechaMysql ($venc)."',
		monto = '".$monto."'

			  WHERE id= '".$repjui."'; "; 
			  
		$sql = $conexion->update($query);
		
		
		

}  //---------------------------- Fin de Actualización
?>