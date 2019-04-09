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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style>
	.files td{ padding:5px;}
</style>

<script>
function enviaF(num)
{
	var formulario = document.getElementById('form_'+num);
	formulario.submit();	
}
</script>

</head>

<body>
<!-- 
	<div id='cargaAjax'> <img src="images/load_chico.gif" /> </div>
-->
<h3> Subir documentación</h3>

<iframe name="frameCarga" height="50" frameborder="0" width="100%"></iframe>

<?php
$nuevoNombre = cadenaNormalOficio($folio);
$nuevoNombre = str_replace("\"","",$nuevoNombre);
$nuevoNombre = str_replace("\'","",$nuevoNombre);
$nuevoNombre = str_replace(" ","",$nuevoNombre);
$nuevoNombre = str_replace("/","!",$nuevoNombre);


echo '
	<form action="cont/pfrr_subeDocs.php" name="formOficio'.$i.'" id=formOficio'.$i.'" target="frameCarga"  method="post" enctype="multipart/form-data"  >
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
	';
?>

<br />


</body>
</html>