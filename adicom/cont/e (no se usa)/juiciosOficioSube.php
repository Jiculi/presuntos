<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
$accion = valorSeguro($_REQUEST['accion']);
$folio = valorSeguro($_REQUEST['folio']);
$direccion = $_REQUEST['direccion'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sube archivo</title>
    <link rel="stylesheet" href="css/juiciosOficioSube.css">

<style>
	.files td{ padding:5px;}
</style>

<script>
function enviaF(num) {
	var formulario = document.getElementById('form_'+num);
	formulario.submit();	
}

function cerrarCuadrito() {
	$("#cuadroOficios").fadeOut();
	$('#popup-overlay').fadeOut('slow');
}
</script>

</head>

<body>
<!-- 
	<div id='cargaAjax'> <img src="images/load_chico.gif" /> </div>
-->
<div class="navbar">
	<a href="#" class="logo">Subir documentación</a>
	<div class="navbar-right">
		  <a href="javascript:cerrarCuadrito()">Cerrar</a>
	</div>
</div>


<?php
$nuevoNombre = cadenaNormalOficio($folio);
$nuevoNombre = str_replace("\"","",$nuevoNombre);
$nuevoNombre = str_replace("\'","",$nuevoNombre);
$nuevoNombre = str_replace(" ","",$nuevoNombre);
$nuevoNombre = str_replace("/","!",$nuevoNombre);


echo '<div id="formita">
	<iframe name="frameCarga" height="50" frameborder="0" width="100%"></iframe>

	<form action="cont/pfrr_subeDocs_v2.php" name="aaaa'.$i.'" id=aaaa'.$i.'" target="frameCarga"  method="post" enctype="multipart/form-data"  >
	<table class="files">
		<tr>
			<td width="50" class="etiquetaPo">Oficio: </td>
			<td width="200"> '.$nuevoNombre.'  </td>
		</tr>
		<tr>
			<td colspan="2"><input class="redonda3" type="file" name="adjunto" id="adjunto"  '. $disabled.' /></td>
		</tr>
		<tr>
			<td colspan="2">
				<center>
					<input class="submit-login" type="submit" name="Subir Archivo" value="Subir"  '. $disabled.' />
				</center>
			</td>
		</tr>
	</table>
	
	<input type="hidden" name="oficio" value="'.$nuevoNombre.'">
	<input type="hidden" name="nomDoc" value="'.$nuevoNombre.'">
	<input type="hidden" name="accion" value="'.$accion.'">
	<input type="hidden" name="tipoDoc" value="oficio">
	</form>
	</div>
	';
?>

<br />


</body>
</html>