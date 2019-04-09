<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$accion = valorSeguro($_REQUEST['numAccion']);
$fecha = valorSeguro($_REQUEST['fecha']);
//$diast = valorSeguro($_REQUEST['sumad']);

?>
<link href="css/estilos_pfrr.css" rel="stylesheet" type="text/css" />
<?php

echo "<br><br><center><h3> La acción $accion </h3></center>";
echo "<br><br><center><h3> No se ha cargado el </h3></center>";
echo "<br><br><center><h3><FONT SIZE=5 > Monto de Inicio del PFRR </FONT></h3></center>";

?>