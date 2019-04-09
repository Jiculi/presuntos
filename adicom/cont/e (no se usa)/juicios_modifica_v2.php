<title>ejecutoria_amparo</title>
<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//print_r($_REQUEST);

//--------------- Alta usuario
$hoy=date("Y-m-d H:i:s");
//---------------- Inicio de Alta
//if($_REQUEST['tipoForm'] == "alta")

$id = valorSeguro($_REQUEST['id']);

	//---------- Asignación de datos del formulario a variables nuevas ----------------
$oficio_contestacion = valorSeguro($_REQUEST['oficio_contestacion']);
$fecha_pre_tribunal = valorSeguro($_REQUEST['fecha_pre_tribunal']);
$comparecencia = valorSeguro($_REQUEST['comparecencia']);
$oficio_ampliacion = valorSeguro($_REQUEST['oficio_ampliacion']);
$fecha_pre_ampliacion = valorSeguro($_REQUEST['fecha_pre_ampliacion']);
$oficio_alegatos = valorSeguro($_REQUEST['oficio_alegatos']);
$fecha_pre_alegatos = valorSeguro($_REQUEST['fecha_pre_alegatos']);
$sentencia_primera = valorSeguro($_REQUEST['sentencia_primera']);
$fecha_sentencia = valorSeguro($_REQUEST['fecha_sentencia']);
$fecha_not_sentencia = valorSeguro($_REQUEST['fecha_not_sentencia']);
$toca_en_revision = valorSeguro($_REQUEST['toca_revision']);
$fecha_pre_rf = valorSeguro($_REQUEST['fecha_pre_rf']);
$toca_amparo = valorSeguro($_REQUEST['toca_amparo']);
$fecha_not = valorSeguro($_REQUEST['fecha_not']);
$ejecutoria_revision = valorSeguro($_REQUEST['ejecutoria_revision']);
$fecha_ejec_rev = valorSeguro($_REQUEST['fecha_ejec_rev']);
$fecha_not_ejec_rev = valorSeguro($_REQUEST['fecha_not_ejec_rev']);
$ejecutoria_amparo = valorSeguro($_REQUEST['ejecutoria_amparo']); 
$fecha_not_ejec_amp  =  valorSeguro($_REQUEST['fecha_not_ejec_amp']);


$fecha_ejec_amp = valorSeguro($_REQUEST['fecha_ejec_amp']);  
$sentencia_cumplimiento = valorSeguro($_REQUEST['sentencia_cumplimiento']); 
$fecha_sent_cumplimiento = valorSeguro($_REQUEST['fecha_sent_cumplimiento']);
$fecha_not_cumplimiento = valorSeguro($_REQUEST['fecha_not_cumplimiento']);
$estado = valorSeguro($_REQUEST['estado']);  
$fecha_conclusion = valorSeguro($_REQUEST['fecha_conclusion']);
$observaciones = valorSeguro($_REQUEST['observaciones']);
$resultado = valorSeguro($_REQUEST['resultado']);


//------------------- Actualiza datos en la base

	$query = "UPDATE juiciosNew SET 
		
		oficio_contestacion = '".$oficio_contestacion."',
		comparecencia = '".$comparecencia."', 
		fecha_pre_tribunal ='".fechaMysql ($fecha_pre_tribunal)."',	 
		oficio_ampliacion = '".$oficio_ampliacion."',
		fecha_pre_ampliacion ='".fechaMysql ($fecha_pre_ampliacion)."',
		oficio_alegatos = '".$oficio_alegatos."',
		fecha_pre_alegatos ='".fechaMysql ($fecha_pre_alegatos)."', 
		sentencia_primera = '".$sentencia_primera."', 
		fecha_sentencia ='".fechaMysql ($fecha_sentencia)."', 
		fecha_not_sentencia ='".fechaMysql ($fecha_not_sentencia)."', 
		toca_en_revision ='".$toca_en_revision."', 
		fecha_pre_rf = '".fechaMysql ($fecha_pre_rf)."', 
		toca_amparo = '".$toca_amparo."', 
		fecha_not ='".fechaMysql ($fecha_not)."',
		ejecutoria_revision = '".$ejecutoria_revision."',
		fecha_ejec_rev ='".fechaMysql ($fecha_ejec_rev)."', 
		fecha_not_ejec_rev ='".fechaMysql ($fecha_not_ejec_rev)."', 
		ejecutoria_amparo ='".($ejecutoria_amparo)."',
		fecha_ejec_amp ='".fechaMysql ($fecha_ejec_amp)."', 
	    fecha_not_ejec_amp ='".fechaMysql ($fecha_not_ejec_amp)."', 	
		sentencia_cumplimiento ='".($sentencia_cumplimiento)."',
		fecha_sent_cumplimiento ='".fechaMysql ($fecha_sent_cumplimiento)."', 
		fecha_not_cumplimiento ='".fechaMysql ($fecha_not_cumplimiento)."',
		estado = '".$estado."',
		resultado = '".$resultado."',	 
 
		fecha_conclusion ='".fechaMysql ($fecha_conclusion)."', 
		observaciones = '".$observaciones."'

			  WHERE id= '".$id."'; "; 
			  
		$sql = $conexion->update($query);
		
		
		

  //---------------------------- Fin de Actualización
?>