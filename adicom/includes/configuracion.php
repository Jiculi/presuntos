<?php
require_once("clases.php");
$conexion = new conexion;
$conexion->conectar();

$sql = $conexion->select("SELECT * FROM configuracion",false);

while($r = mysql_fetch_array($sql))
{
	if($r['proceso'] == 'activaPestanas') define('ACTIVAPESTANAS',$r['boleano']);
	if($r['proceso'] == 'estadoSistema')  define('ESTADOSISTEMA',$r['boleano']);
	if($r['proceso'] == 'mensajeCierre')  define('MENSAJECIERRE',$r['opciones']);
}
?>