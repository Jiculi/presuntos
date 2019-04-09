<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$nombre = valorSeguro($_REQUEST['nombre']);
$tipo = valorSeguro($_REQUEST['tipo']);
$sql = $conexion->select("SELECT nombre, usuario FROM usuarios WHERE nombre = '$nombre' AND (status = 1 OR status = 0.5) ",false);
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
<h3> Subir documentación</h3>

<iframe name="frameCarga" height="50" frameborder="0" width="100%"></iframe>

<?php
//-------------------- sacamos todos los archivos de la BD archivos ------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
$sqlO = $conexion->select("SELECT * FROM archivos WHERE num_accion = '".$nombre."' ",false);
$docsSubidos = array();
while($o = mysql_fetch_array($sqlO))
{
	//$oficioDoc = str_replace("!","/",$o['oficioDoc']);
	//$oficioDoc = str_replace("--","\"",$oficioDoc);
	//$oficioDoc = stripslashes(html_entity_decode($oficioDoc));
	//$docsSubidos[] = $oficioDoc;
	$docsSubidos[] = cadenaNormalOficio($o['oficioDoc']);
}

//print_r($docsSubidos);
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//while($r = mysql_fetch_array($sql))
//{
$r = mysql_fetch_array($sql)
	$tipo= cadenaNormalOficio($tipo);
	
	//$i++;
	//if($r['oficio'] != "" && stripos($r['oficio'],"DGRRFEM") !== false )
		
	if($tipo == "foto")	{
		//sustituimos
	   $nuevoNombre = $r['nombre'];
	   $nuevoNombre = str_replace(" ","_",$nuevoNombre);
	   //echo "<br> --- ". $nuevoNombre;

		//echo "oficio - ".stripslashes(html_entity_decode($r['oficio']));
		// si existe el oficio en el array $docsSubidos poner OK ....
		if (in_array($nuevoNombre, $docsSubidos)) 
		{
			$disabled = "disabled";
			$imagen = "OK20.png";
		}
		else
		{
			$disabled = "";
			 $imagen = "war20.png";
		}
		
		echo '
			<form action="cont/emp_docs.php" name="formfoto" id="formfoto" target="frameCarga"  method="post" enctype="multipart/form-data"  >
			<table class="files">
				<tr>
				<td> <img src="images/'.$imagen.'" /> </td>
				<td width="150" class="etiquetaPo">foto: </td>
				<td width="200"> '.$nuevoNombre.'</td>
				<td><input class="redonda3" type="file" name="adjunto" id="adjunto" '.$disabled.'  /></td>
					<input type="hidden" name="oficio" value="'.$nuevoNombre.'" '.$disabled.' >
					<input type="hidden" name="nomDoc" value="'.$nuevoNombre.'" '.$disabled.' >
					<input type="hidden" name="accion" value="'.$nombre.'" '.$disabled.' >
					<input type="hidden" name="tipoDoc" value="foto" '.$disabled.' >
				
				<td>';

		if($disabled != "disabled") echo '<input class="submit_line" type="button" name="Subir" value="Subir" '.$disabled.' onclick="enviaF(\'formfoto\')"  />';
				 
				 echo '
				 </td>
				</tr>
			</table>
			</form>
			';
	}

//}
?>

<br />


</body>
</html>