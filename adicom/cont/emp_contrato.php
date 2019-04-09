<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$co = valorSeguro($_REQUEST['co']);
$usu = $_REQUEST['usuario'];

$parte = explode("-", $co);
$parte1 = explode("/", $parte[1]);

$nombre_fichero = "../empleados/contrato/SP.DGRH.".$parte1[0]."-2017.pdf";

if (file_exists($nombre_fichero)) 
{
	echo " <embed src='empleados/contrato/SP.DGRH.".$parte1[0]."-2017.pdf#toolbar=0' type='application/pdf' width='799' height='550'> </embed> ";
} else {
	echo " El fichero $nombre_fichero no existe ";
}
/*
SP.DGRH-0200/2017 base de datos

SP.DGRH.0200-2017 archivos pdf
*/
?>