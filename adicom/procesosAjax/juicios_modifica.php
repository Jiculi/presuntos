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
$oficio_contestacion = valorSeguro($_REQUEST['of_contesta']);
$comparecencia = valorSeguro($_REQUEST['comp']);
$fecha_pre_tribunal = valorSeguro($_REQUEST['pre_tribunal']);
$oficio_ampliacion = valorSeguro($_REQUEST['of_amp']);
$fecha_pre_ampliacion = valorSeguro($_REQUEST['fecha_ampliacion']);
$oficio_alegatos = valorSeguro($_REQUEST['of_alegatos']);
$fecha_pre_alegatos = valorSeguro($_REQUEST['fecha_alegatos']);
$sentencia_primera = valorSeguro($_REQUEST['sentencia_1']);
$fecha_sentencia = valorSeguro($_REQUEST['fecha_sentencia']);
$fecha_not_sentencia = valorSeguro($_REQUEST['not_sentencia']);
$toca_en_revision = valorSeguro($_REQUEST['toca_revision']);
$fecha_pre_rf = valorSeguro($_REQUEST['prese_RF']);
$toca_amparo = valorSeguro($_REQUEST['to_amp']);
$fecha_not = valorSeguro($_REQUEST['notificacion']);
$ejecutoria_revision = valorSeguro($_REQUEST['ejec_rev']);
$fecha_ejec_rev = valorSeguro($_REQUEST['ejecutoria']);
$fecha_not_ejec_rev = valorSeguro($_REQUEST['not_ejec']);
$ejecutoria_amparo = valorSeguro($_REQUEST['eje_amp']); 
$fecha_not_ejec_amp  =  valorSeguro($_REQUEST['not_amparo']);


$fecha_ejec_amp = valorSeguro($_REQUEST['ejec_amparo']);  
$sentencia_cumplimiento = valorSeguro($_REQUEST['sent_cum']); 
$fecha_sent_cumplimiento = valorSeguro($_REQUEST['cumplimiento']);
$fecha_not_cumplimiento = valorSeguro($_REQUEST['notica_cumpl']);
$estado = valorSeguro($_REQUEST['edo']);  
$fecha_conclusion = valorSeguro($_REQUEST['conclusion']);
$observaciones = valorSeguro($_REQUEST['observaciones']);

//------------------- Actualiza datos en la base

	$query = "UPDATE juicios SET 
		
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
		fecha_conclusion ='".fechaMysql ($fecha_conclusion)."', 
		observaciones = '".$observaciones."'

			  WHERE id= '".$repjui."'; "; 
			  
		$sql = $conexion->update($query);
		
		
		

}  //---------------------------- Fin de Actualización
?>