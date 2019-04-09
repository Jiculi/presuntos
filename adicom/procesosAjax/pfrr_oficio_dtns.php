<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$oficio_dtns = valorSeguro($_POST['oficio']);



$sql=$conexion-> select("SELECT fecha_oficio,folio from oficios where folio = '".$oficio_dtns."' ");
$r = mysql_fetch_array($sql);

echo fechaNormal($r['fecha_oficio']);



?>