<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$idpresunto = valorSeguro($_REQUEST['idpresunto']);
$presunto = valorSeguro($_REQUEST['presunto']);
$cargo = valorSeguro($_REQUEST['cargo']);
$dependencia = valorSeguro($_REQUEST['dependencia']);
$rfc = valorSeguro($_REQUEST['rfc']);
$accion = valorSeguro($_REQUEST['accion']);
$oficio = valorSeguro($_REQUEST['oficio']);
$fecha = valorSeguro($_REQUEST['fecha']);

$sql=$conexion->insert("INSERT INTO pfrr_audiencias SET 
							num_accion = '".$accion."',
							idPresunto = '".$idpresunto."',
							presunto = '".$presunto."',
							rfc = '".$rfc."',
							oficio_citatorio = '".$oficio."',
							fecha_audiencia = '".$fecha."',
							tipo = 2,
							revisada = 0
							");
?>




