<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------

$nivelpfrr=valorSeguro($_POST['nivelpfrr']);
$nivelpo=valorSeguro($_POST['nivel']);


/*$sql2 = $conexion->select("SELECT * from usuarios where nivel <> DG and (po_otros ='1' or pfrr_otros='1')",false);
$r=mysql_fetch_array($sql2);*/

$sql1 = $conexion->update("UPDATE usuarios SET otros_pfrr = '0' WHERE nivel <> 'DG'",false); 
$sql3 = $conexion->update("UPDATE usuarios SET otros_po = '0' WHERE nivel <> 'DG'",false); 
//$sql3 = $conexion->update("UPDATE pfrr SET abogado = '".$abogado."',subnivel='".$subnivel."' WHERE num_accion = '".$accion."' ",false); 
//-------------------------- modifica movimiento ------------------------------
if($sql1) echo "ok";
if($sql3) echo "ok";

else echo "fail";
 