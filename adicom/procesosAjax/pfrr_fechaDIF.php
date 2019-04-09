<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$idPresunto = valorSeguro($_REQUEST['idPresunto']);
$presunto = valorSeguro($_REQUEST['presunto']);
$rfc = valorSeguro($_REQUEST['rfc']);
$fecha = valorSeguro($_REQUEST['fecha']);
$accion = valorSeguro($_REQUEST['accion']);
$oficio = valorSeguro($_REQUEST['oficio']);
//-------------------------- SQL VERIFICA DEVOLUCIONES -------------------------

$sql = $conexion->update("INSERT INTO pfrr_audiencias SET
							num_accion = '".$accion."',
							idPresunto = '".$idPresunto."',
							presunto = '".$presunto."',
							rfc = '".fechaMysql($fecha)."',
							oficio_citatorio = '".$oficio."',
							fecha_audiencia = '".fechaMysql($fecha)."',
							tipo = 2,
							revisada = 0
							", false);

mysql_free_result($sql);
//mysql_close($conexion);

?>
