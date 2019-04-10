<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$accion = valorSeguro($_REQUEST['numAccion']);
$fecha = valorSeguro($_REQUEST['fecha']);
$diast = valorSeguro($_REQUEST['sumad']);

?>

<?php
if($diast == 1){
echo "<br><br><center><h3> La acción $accion lleva: </h3></center>";
echo "<br><br><center><h3><FONT SIZE=5 > $diast día </FONT></h3></center>";
echo "<br><br><center><h3> En Proceso de Notificación. </h3></center>";
}else{
	echo "<br><br><center><h3> La acción $accion lleva: </h3></center>";
	echo "<br><br><center><h3><FONT SIZE=5 > $diast días </FONT></h3></center>";
	echo "<br><br><center><h3> En Proceso de Notificación. </h3></center>";
}
?>