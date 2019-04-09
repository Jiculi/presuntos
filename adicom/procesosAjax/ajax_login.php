<?php
//------------------------------------------------------------------------------
session_start();
//------------------------------------------------------------------------------
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
//------------------------------------------------------------------------------
include("../includes/clases.php");
include("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$user = valorSeguro($_POST['user']);
$pass = valorSeguro($_POST['pass']);
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
$contador = 0;
$sql = $conexion->select("SELECT * FROM usuarios WHERE usuario = '".$user."' AND password = '".$pass."' AND status = 1 ",false);
$r = mysql_fetch_array($sql);
$contador = mysql_num_rows($sql);
//------------------------------------------------------------------------------
if($contador != 0)
{
	$_SESSION['acceso'] = true;
	$_SESSION['adicom'] = true;
	$_SESSION['id'] = $r['id'];
	$_SESSION['usuario'] = $r['usuario'];
	$_SESSION['nombre'] = $r['nombre'];
	$_SESSION['no_empleado'] = $r['no_empleado'];
	$_SESSION['direccion'] = $r['direccion'];
	$_SESSION['nivel'] = $r['nivel'];
	$_SESSION['oficios'] = $r['generar_oficio'];
	$_SESSION['a'] = $r['a'];
	echo "ok";
}
?>
