<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$accionesCh = $_REQUEST['accionesCh'];
$tipo = $_REQUEST['tipo'];
//-------------------------- SQL VERIFICA LOS CAMPOS MARCADOS -------------------------
//print_r($accionesCh);

foreach($accionesCh AS $k => $value) 
{ 
	$acciones[] = $k;
}

$acciones_str = implode(",", $acciones);
//echo "<br><br>".$acciones_str;
echo "<h3>";

if($tipo == "bajas")
{
	$sql = $conexion->update("UPDATE po SET bajaAnunciada = 1 WHERE id IN (".$acciones_str.") ", false);
	echo "Se actualizaron a Bajas Anunciadas las siguientes acciones...<br><br>";
}
if($tipo == "quita")
{
	$sql = $conexion->update("UPDATE po SET bajaAnunciada = 0 WHERE id IN (".$acciones_str.") ", false);
	echo "Se quitaron de Bajas Anunciadas las siguientes acciones...<br><br>";
}

foreach($accionesCh AS $k => $value) 
{
	$sql = $conexion->update("SELECT id,num_accion FROM po WHERE id = $k ", false);
	$r = mysql_fetch_array($sql);
	echo " - ".$r['num_accion']."<br>";
}
echo "</h3>";

@mysql_free_result($sql);
//mysql_close($conexion);

?>
