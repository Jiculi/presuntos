<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$accion = valorSeguro($_REQUEST['accion']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
    <script type="text/javascript" src="js/menu.js"></script>
    <script type="text/javascript" src="js/funciones.js"></script>
    <script type="text/javascript" src="js/ajax.js"></script>
    <script type="text/javascript" src="js/ajaxMisa.js"></script>
    <script type="text/javascript" src="js/ajaxConfiguracion.js"></script>
   	<script type="text/javascript" src="calendario/js/jquery-ui-1.10.3.custom.js"></script>
<style>
	.files td{ padding:5px;}
</style>
<script>
function enviaF(nom)
{
	var formulario = document.getElementById(nom);
	//var confirma = confirm("Se enviara la siguiente información: \n\n"+$$("#"+nom+""));
	formulario.submit();	
}
</script>
</head>

<body>
<!-- 
	<div id='cargaAjax'> <img src="images/load_chico.gif" /> </div>
-->
<h3> Capturar Observaciones al Estado de Trámite </h3>

<iframe name="frameCarga" height="50" frameborder="0" width="100%"></iframe>

<?php
echo $accion;
?>


<br />

</body>
</html>