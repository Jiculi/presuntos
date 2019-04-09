<?php
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
$accion = valorSeguro($_POST['accion']);
$tipo = valorSeguro($_POST['tipo_oficio_adicional']);
$oficio = valorSeguro($_POST['oficio_tipo_oficio_adicional']);
$fecha = valorSeguro($_POST['fecha_tipo_oficio_adicional']);
$acuse = valorSeguro($_POST['acuse_tipo_oficio_adicional']);
$leyenda = valorSeguro($_POST['leyenda_tipo_oficio_adicional']);
$referencia = valorSeguro($_POST['referencia_tipo_oficio_adicional']);
//------------------------------------------------------------------------------
$sql = $conexion->insert("INSERT INTO otros_oficios 
								SET
									num_accion = '$accion',
									folio_volante = '$oficio',
									documentoExtra = '$oficioRef',
									fecha = '$fecha',
									acuse = '$acuse',
									leyenda = '$leyenda',
									atiende = '',
									referencia = '$referencia'
									tipo = '$tipo',
									status = 1",false);	
echo $txtSql."<br><br>".$sql;
?>

