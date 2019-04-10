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
   
   $tipo =  $_FILES['adjunto']['type'];
   $nom_original =  $_FILES['adjunto']['name'];
   $tamano = $_FILES['adjunto']['size'];
   
   $slash = "/";

   $archivo = str_ireplace($slash,"!",$_FILES['adjunto']['tmp_name']);
   //-------- seleccionamos su nombre 
   $nvoNom = str_ireplace($slash,"!",$_POST['nomDoc']);
   $nvoNomExt = $nvoNom.".".$cadFile["ext"];
   //$nvoNom = date("mdHis").".".$cadFile["ext"];
   
   //echo $nvoNom;
  $url="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
  //-- verificamos en que ambiente estamos ------------
  if (stripos($url, "adicom") !== false) $capeta = "/adicom/archivos/";
  else $capeta = "/prueba/archivos/";
		
  if(move_uploaded_file($_FILES['adjunto']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$capeta.$nvoNomExt))
   {
		//$sql = $conexion->insert("INSERT INTO archivos SET num_accion = '".$_POST['accion']."', tipoDoc = '".$_POST['tipoDoc']."', oficioDoc = '".$nvoNom."', nombreDoc = '".$nvoNomExt."', contenidoDoc = '".$_FILES['adjunto']['tmp_name']."' ",false);
		$sql = $conexion->insert("INSERT INTO archivos SET num_accion = '".$_POST['accion']."', tipoDoc = '".$_POST['tipoDoc']."', oficioDoc = '".$nvoNom."', nombreDoc = '".$nvoNomExt."' ",false);
		//$ultimoId = mysql_insert_id();

		$sql2 = $conexion->update("UPDATE pfrr_historial SET sicsa = '".$_POST['cralCarga']."', sicsaRecepcion = '".date("Y-m-d")."' , atendido = 1 WHERE oficio = '".$_POST['oficio']."' AND num_accion = '".$_POST['accion']."' ",false);
		
		echo "<center><span style='color:green; font-weight:bold'>Se subio el archivo correctamente el archivo $nvoNom <br> Se ha marcado como atendido ...</span></center>"; 
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