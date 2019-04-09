<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<!--
<script src="../js/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="../js/funciones.js" type="text/javascript" ></script>
<script src="../js/ajax.js" type="text/javascript"></script>
-->
<style>
	body{ margin:0; padding:0; 
	background:#FFF;
	color: #393939;
	font-family: Arial;
	font-size: 12px;}
</style>
</head>

<body onload=" document.getElementById('fondoAjax').style.display = 'none' ">

<div id='fondoAjax'> <center> <img src="../images/load_chico.gif" /> <b> Subiendo documento... </b> </center> </div>


<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

//-------------------- IMAGEN ----------------------------------
if (isset($_FILES)) 
{
   $cadFile = fileData($_FILES['adjunto']['name']);
   //$newNom = date("mdHis").".".$cadFile["ext"];
	
   //echo "<br>".$newNom."<br>";	
   //Recibo parámetros del archivo de upload
   
   $oficio = valorSeguro($_POST['oficio']);
	$usuario = valorSeguro($_REQUEST['usuario']);
   $tipo =  $_FILES['adjunto']['type'];
   $nom_original =  $_FILES['adjunto']['name'];
   $tamano = $_FILES['adjunto']['size'];
   
   $slash = "/";
   $coma = "\"";
   
   $archivo = str_ireplace($slash,"!",$_FILES['adjunto']['tmp_name']);
   $nvoNom = str_ireplace($slash,"!",$_POST['nomDoc']);
   $archivo = str_ireplace($coma,"--",$archivo);
   $nvoNom = str_ireplace($coma,"--",$nvoNom);
   
   $nvoNomExt = valorSeguro($nvoNom).".".$cadFile["ext"];
   //$nvoNom = date("mdHis").".".$cadFile["ext"];
   
   //echo $nvoNom;
  $url="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
  //-- verificamos en que ambiente estamos ------------
  if (stripos($url, "adicom") !== false) $capeta = "/empleados/";
  else $capeta = "/prueba/empleados/";
		
  if(move_uploaded_file($_FILES['adjunto']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$capeta.$nvoNomExt))
   {
	   // cualquier documento se inserta en la tabla archivos
		$query1 = "INSERT INTO archivos SET num_accion = '".$_POST['nombre']."',oficio = '".$oficio."', tipoDoc = '".$_POST['tipoDoc']."', oficioDoc = '".$nvoNom."', nombreDoc = '".$nvoNomExt."' ";
		$sql1 = $conexion->insert($query1,false);
		
		if($_POST['tipoDoc'] == "foto"){
			$query2 = "UPDATE usuario_historial SET movimiento = 'foto', empleado = '".$_POST['nombre']."', datos = '".$_POST['nomDoc']."', fecha = '".date("Y-m-d")."', nombre = '".$usuario."'  ";
			$sql2 = $conexion->update($query2,false);
		}
		
		if($_POST['tipoDoc'] == "contrato"){
			$query2 = "UPDATE usuario_historial SET movimiento = 'contrato', empleado = '".$_POST['nombre']."', datos = '".$_POST['nomDoc']."', fecha = '".date("Y-m-d")."', nombre = '".$usuario."'  ";
			$sql2 = $conexion->update($query2,false);
		}
		

		
		echo "
			<center>
				<span style='color:green; font-weight:bold'>
					Se subio el archivo correctamente el archivo $nvoNom <br> Se ha marcado como atendido ... 
					<!--
					$query1 <br>
					$query2 <br>
					$query3 <br>
					-->
				</span>
			</center>"; 
			
		echo "<script> window.parent.compruebaNot() </script>";
   }
   else
   {
		echo "<center><span style='color:red; font-weight:bold'>Hubo un error al subir el archivo <br> El oficio sigue pendiente</span></center>"; 
   }
}
//---------------------------------------------------- SUBE IMAGEN ----------------------------------------------------------
function fileData($path) 
{
	// Comprobamos si el fichero existe
	$data["exists"] = is_file($path);
	// Comprobamos si el fichero es escribible
	$data["writable"] = is_writable($path);
	// Leemos los permisos del fichero
	$data["chmod"] = ($data["exists"] ? substr(sprintf("%o", fileperms($path)), -4) : FALSE);
	// Extraemos la extensión, un sólo paso
	$data["ext"] = substr(strrchr($path, "."),1);
	// Primer paso de lectura de ruta
	$data["path"] = array_shift(explode(".".$data["ext"],$path));
	// Primer paso de lectura de nombre
	$data["name"] = array_pop(explode("/",$data["path"]));
	// Ajustamos nombre a FALSE si está vacio
	$data["name"] = ($data["name"] ? $data["name"] : FALSE);
	// Ajustamos la ruta a FALSE si está vacia
	$data["path"] = ($data["exists"] ? ($data["name"] ? realpath(array_shift(explode($data["name"],$data["path"]))) : realpath(array_shift(explode($data["ext"],$data["path"])))) : ($data["name"] ? array_shift(explode($data["name"],$data["path"])) : ($data["ext"] ? array_shift(explode($data["ext"],$data["path"])) : rtrim($data["path"],"/"))));
	// Ajustamos el nombre a FALSE si está vacio o a su valor en caso contrario
	$data["filename"] = (($data["name"] OR $data["ext"]) ? $data["name"].($data["ext"] ? "." : "").$data["ext"] : FALSE);
	// Devolvemos los resultados
	return $data;
}

?>
</body>
</html>