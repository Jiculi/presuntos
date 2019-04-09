<?php 

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$accion = valorSeguro($_REQUEST['numAccion']);
// si es ofiocio o PFRR (numero de procedimiento)
if(isset($_REQUEST['oficio'])){
	$oficio = valorSeguro($_REQUEST['oficio']);
	$tipo = "oficio";
}
else {
	$oficio = valorSeguro($_REQUEST['pfrr']);
	$tipo = "pfrr";
}
//si es sicsa o pfrr 
if(isset($_REQUEST['sicsa']))
	$sicsa = valorSeguro($_REQUEST['sicsa']);
else 
	$sicsa = valorSeguro($_REQUEST['sicsa']);
//--------------------------------------------
$usuario = valorSeguro($_REQUEST['usuario']);

$strUs = dameUsuario($usuario);
$usuario = $strUs['nombre'];

$sicsa = str_replace("/","!",$sicsa);
/*
$txt = "SELECT * FROM archivos WHERE num_accion = '".$accion ."' AND oficioDoc = '".$oficioConvertido."' ";	
	$sqlS = $conexion->select($txt, false);
*/
?>
<html>
<head>
</head>

<body>
<?php
/*	
    echo $accion;
	echo $oficio;
*/
?>
	<span style="float:left"><h3>Solicitado por <?php echo $usuario  ?></h3></span>
    <a href="#" class="submit_line redonda5" style="float:right; margin:3px" onClick="marcaCralVisto('<?php echo $oficio ?>','<?php echo $accion ?>','<?php echo $tipo ?>')">Marcar como visto</a>
    <embed src="<?php echo "archivos/".$sicsa.".pdf" ?>" type="application/pdf" width="100%" height="94%">
    



</body>
</html>
<!--
<HTML>
<BODY>
<embed src="archivo.pdf" type="application/pdf" width="100%" height="100%">
</BODY>
</HTML> 

-->