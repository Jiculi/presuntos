<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Documento sin título</title>

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
   $nvoNom = str_replace("\"","",$nvoNom);
   $nvoNom = str_replace("\'","",$nvoNom);
    
   $nvoNomExt = $nvoNom.".".$cadFile["ext"];
   //$nvoNom = date("mdHis").".".$cadFile["ext"];
   
   //echo $nvoNom;
  $url="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
  //-- verificamos en que ambiente estamos ------------
  if (stripos($url, "adicom") !== false) $capeta = "/dgr/desarrollo/archivos/";
  else $capeta = "/dgr/desarrollo/prueba/archivos/";
		
  if(move_uploaded_file($_FILES['adjunto']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$capeta.$nvoNomExt))
   {
		$sql = $conexion->insert("INSERT INTO archivos SET num_accion = '".$_POST['accion']."', tipoDoc = '".$_POST['tipoDoc']."', oficioDoc = '".$nvoNom."', nombreDoc = '".$nvoNomExt."' ",false);
		
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