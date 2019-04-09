<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
$accion = valorSeguro($_REQUEST['accion']);
$direccion = $_REQUEST['direccion'];

$query = "SELECT * FROM pfrr_bitacora_adicional WHERE num_accion LIKE '".$accion."%' and status !='0' ORDER BY folio desc";
$sql = $conexion->select($query,false);
$total = mysql_num_rows($sql);

//sacamos todos loq que sean otros
$consulta = "SELECT value FROM oficios_options WHERE estado = 'PFRR' AND tipo = 'otros'";
$sqlCon = $conexion->select($consulta);
while($rc = mysql_fetch_assoc($sqlCon))	$valores[] = $rc["value"];

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
//--------------- sacamos los oficios de la tabla archivos y los reemplazamos por sus respectivos links ------------------
$sqlO = $conexion->select("SELECT * FROM archivos WHERE num_accion LIKE '".$accion."%' ",false);
while($o = mysql_fetch_array($sqlO))
{
	$oficioDoc = str_replace("!","/",$o['oficioDoc']);
	$oficioDoc = str_replace("\"","",$oficioDoc);
	$oficioDoc = str_replace("\'","",$oficioDoc);
	$oficioDoc = str_replace(" ","",$oficioDoc);
	$oficioDoc = cadenaNormalOficio($oficioDoc);
	$docsSubidos[] = $oficioDoc; 
}

//print_r($docsSubidos);


while($r = mysql_fetch_array($sql))
{
	
	$i++;
	//if($r['oficio'] != "" && stripos($r['oficio'],"DGRRFEM") !== false)
	if($r['folio'] != "")
	{
		//sustituimos
	   $nuevoNombre = cadenaNormalOficio($r['folio']);
	   $nuevoNombre = str_replace("\"","",$nuevoNombre);
	   $nuevoNombre = str_replace("\'","",$nuevoNombre);
	   $nuevoNombre = str_replace(" ","",$nuevoNombre);
	   //echo "<br> --- ". $nuevoNombre;
	   
		// si existe el oficio en el array $docsSubidos poner OK ....
		if (@in_array($nuevoNombre, $docsSubidos))
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
			<form action="cont/pfrr_subeDocs.php" name="formOficio'.$i.'" id=formOficio'.$i.'" target="frameCarga"  method="post" enctype="multipart/form-data"  >
			<table class="files">
				<tr>
				<td> <img src="images/'.$imagen.'" /> </td>
				<td width="150" class="etiquetaPo">Oficio: </td>
				<td width="200"> '.$nuevoNombre.'  </td>
				<td><input class="redonda3" type="file" name="adjunto" id="adjunto"  '. $disabled.' /></td>
					<input type="hidden" name="oficio" value="'.$nuevoNombre.'">
					<input type="hidden" name="nomDoc" value="'.$nuevoNombre.'">
					<input type="hidden" name="accion" value="'.$accion.'">
					<input type="hidden" name="tipoDoc" value="oficio">
				<td><input class="submit_line" type="submit" name="Subir" value="Subir"  '. $disabled.' /></td>
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