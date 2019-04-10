<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$accion = valorSeguro($_REQUEST['accion']);
$sql = $conexion->select("SELECT oficio,sicsa,oficioNotEntidad,oficioNotOIC,status,idArchivo FROM po_historial WHERE num_accion = '$accion' AND status = 1 ",false);
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
$sqlO = $conexion->select("SELECT * FROM archivos WHERE num_accion = '".$accion."' ",false);
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
while($r = mysql_fetch_array($sql))
{
	$folioOficio= cadenaNormalOficio($r['oficio']);
	$folioSicsa = cadenaNormalOficio($r['sicsa']);
	$folioNotEn = cadenaNormalOficio($r['oficioNotEntidad']);
	$folioNotOi = cadenaNormalOficio($r['oficioNotOIC']);
	$aleatorio = mt_rand(1,10000000);
	
	$i++;
	//if($r['oficio'] != "" && stripos($r['oficio'],"DGRRFEM") !== false )
	if($folioOficio != "")
	{
		//sustituimos
	   $nuevoNombre = cadenaNormalOficio($folioOficio);
	   $nuevoNombre = str_replace("\"","",$nuevoNombre);
	   $nuevoNombre = str_replace("\'","",$nuevoNombre);
	   $nuevoNombre = str_replace(" ","",$nuevoNombre);
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
			<form action="cont/po_subeDocs.php" name="formOficio'.$aleatorio.'" id="formOficio'.$aleatorio.'" target="frameCarga"  method="post" enctype="multipart/form-data"  >
			<table class="files">
				<tr>
				<td> <img src="images/'.$imagen.'" /> </td>
				<td width="150" class="etiquetaPo">Oficio: </td>
				<td width="200"> '.$nuevoNombre.'</td>
				<td><input class="redonda3" type="file" name="adjunto" id="adjunto" '.$disabled.'  /></td>
					<input type="hidden" name="oficio" value="'.$nuevoNombre.'" '.$disabled.' >
					<input type="hidden" name="nomDoc" value="'.$nuevoNombre.'" '.$disabled.' >
					<input type="hidden" name="accion" value="'.$accion.'" '.$disabled.' >
					<input type="hidden" name="tipoDoc" value="oficio" '.$disabled.' >
				
				<td>';

		if($disabled != "disabled") echo '<input class="submit_line" type="button" name="Subir" value="Subir" '.$disabled.' onclick="enviaF(\'formOficio'.$aleatorio.'\')"  />';
				 
				 echo '
				 </td>
				</tr>
			</table>
			</form>
			';
	}
	if($folioSicsa != "")
	{
		//sustituimos
	   $nuevoNombre = cadenaNormalOficio($folioSicsa);
	   $nuevoNombre = str_replace("\"","",$nuevoNombre);
	   $nuevoNombre = str_replace("\'","",$nuevoNombre);
	   $nuevoNombre = str_replace(" ","",$nuevoNombre);
	   //echo "<br> --- ". $nuevoNombre;
		
		//echo "oficio - ".stripslashes(html_entity_decode($r['sicsa']));
		// si existe el oficio en el array $docsSubidos poner OK ....
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
			<form action="cont/po_subeDocs.php" name="formSicsa'.$aleatorio.'" id="formSicsa'.$aleatorio.'" target="frameCarga"  method="post" enctype="multipart/form-data"  >
			<table class="files">
				<tr>
				<td> <img src="images/'.$imagen.'" /> </td>
				<td width="150" class="etiquetaPo">SICSA: </td>
				<td width="200"> '.$nuevoNombre.'  </td>
				<td><input class="redonda3" type="file" name="adjunto" id="adjunto"'. $disabled.' /></td>
					<input type="hidden" name="oficio" value="'.$nuevoNombre.'" '.$disabled.' >
					<input type="hidden" name="nomDoc" value="'.$nuevoNombre.'" '.$disabled.' >
					<input type="hidden" name="accion" value="'.$accion.'" '.$disabled.' >
					<input type="hidden" name="tipoDoc" value="sicsa" '.$disabled.' >
				<td>';
				
		if($disabled != "disabled") echo '<input class="submit_line" type="button" name="Subir" value="Subir" '. $disabled.'  onclick="enviaF(\'formSicsa'.$aleatorio.'\')" />';
				
		echo '		</td>
				</tr>
			</table>
			</form>
			';
	}
	if($folioNotEn != "" )
	{
		//sustituimos
	   $nuevoNombre = cadenaNormalOficio($folioNotEn);
	   $nuevoNombre = str_replace("\"","",$nuevoNombre);
	   $nuevoNombre = str_replace("\'","",$nuevoNombre);
	   $nuevoNombre = str_replace(" ","",$nuevoNombre);
	   //echo "<br> --- ". $nuevoNombre;
		
		//echo "oficio - ".stripslashes(html_entity_decode($r['oficioNotEntidad']));
		// si existe el oficio en el array $docsSubidos poner OK ....
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
			<form action="cont/po_subeDocs.php" name="formOficioNot'.$aleatorio.'" id="formOficioNot'.$aleatorio.'" target="frameCarga"  method="post" enctype="multipart/form-data"  >
			<table class="files">
				<tr>
				<td> <img src="images/'.$imagen.'" /> </td>
				<td width="150" class="etiquetaPo">Oficio Not. Ent.: </td>
				<td width="200"> '.$nuevoNombre.'  </td>
				<td><input class="redonda3" type="file" name="adjunto" id="adjunto"'. $disabled.' /></td>
					<input type="hidden" name="oficio" value="'.$nuevoNombre.'" '.$disabled.' >
					<input type="hidden" name="nomDoc" value="'.$nuevoNombre.'" '.$disabled.' >
					<input type="hidden" name="accion" value="'.$accion.'" '.$disabled.' >
					<input type="hidden" name="tipoDoc" value="oficio not entidad" '.$disabled.' >
				<td>';
				
		if($disabled != "disabled") echo '<input class="submit_line" type="button" name="Subir" value="Subir"'. $disabled.'  onclick="enviaF(\'formOficioNot'.$aleatorio.'\')"  />';
				
		echo '		</td>
				</tr>
			</table>
			</form>
			';
	}
	if($folioNotOi != "" )
	{
		//sustituimos
	   $nuevoNombre = cadenaNormalOficio($folioNotOi);
	   $nuevoNombre = str_replace("\"","",$nuevoNombre);
	   $nuevoNombre = str_replace("\'","",$nuevoNombre);
	   $nuevoNombre = str_replace(" ","",$nuevoNombre);
	   //echo "<br> --- ". $nuevoNombre;
		
		//echo "oficio - ".stripslashes(html_entity_decode($r['oficioNotOIC']));
		// si existe el oficio en el array $docsSubidos poner OK ....
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
			<form action="cont/po_subeDocs.php" name="formNotOIC'.$aleatorio.'" id="formNotOIC'.$aleatorio.'" target="frameCarga"  method="post" enctype="multipart/form-data"  >
			<table class="files">
				<tr>
				<td> <img src="images/'.$imagen.'" /> </td>
				<td width="150" class="etiquetaPo">Oficio OIC: </td>
				<td width="200"> '.$nuevoNombre.'  </td>
				<td><input class="redonda3" type="file" name="adjunto" id="adjunto"'. $disabled.' /></td>
					<input type="hidden" name="oficio" value="'.$nuevoNombre.'" '.$disabled.' >
					<input type="hidden" name="nomDoc" value="'.$nuevoNombre.'" '.$disabled.' >
					<input type="hidden" name="accion" value="'.$accion.'" '.$disabled.' >
					<input type="hidden" name="tipoDoc" value="oficio oic" '.$disabled.' >
				<td>';
		if($disabled != "disabled") echo '<input class="submit_line" type="button" name="Subir" value="Subir"'. $disabled.' onclick="enviaF(\'formNotOIC'.$aleatorio.'\')"   />';
		
		echo '</td>
				</tr>
			</table>
			</form>
			';
	}


}
?>

<br />


</body>
</html>