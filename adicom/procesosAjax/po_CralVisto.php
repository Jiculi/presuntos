<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$folio = valorSeguro($_REQUEST['folio']);
$accion = valorSeguro($_REQUEST['accion']);
$tipo =  valorSeguro($_REQUEST['tipo']);
//-------------------------- SQL VERIFICA DEVOLUCIONES -------------------------
if($tipo != "pfrr"){
	$txtSQL = "UPDATE oficios_contenido SET visto = 1 WHERE num_accion = '".$accion."' AND folio = '".$folio."' ";
	$sql = $conexion->update($txtSQL, false);
}else{
	$txtSQL = "UPDATE pfrr SET cralVisto = 1 WHERE num_accion = '".$accion."' AND num_procedimiento = '".$folio."' ";
	$sql = $conexion->update($txtSQL, false);
}
echo $txtSQL;
?>
