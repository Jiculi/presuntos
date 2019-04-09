<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$con=0;
foreach($_POST as $nombre_campo => $valor)
{
   $resultado = strpos($nombre_campo, "accionVinculada_"); 
   if($resultado  !== FALSE)
   {
	   if($con == 0) $accion = valorSeguro($valor);
	   $acciones .= valorSeguro($valor)."|";
	   $con++;
   }
   else
   {
      $asignacion = "\$" . $nombre_campo . " = '" . valorSeguro($valor) . "';"; 
   eval($asignacion);

   }
}

$user = $_SESSION['usuario'];

//---------- Asignación de datos del formulario a variables nuevas ----------------
$piso =valorSeguro($_REQUEST['num_piso']);
$tomo = valorSeguro($_REQUEST['num_tomo']);
$caja = valorSeguro($_REQUEST['num_caja']);


{

//-------------------------------------------
$query = "INSERT INTO correspondencia SET 


num_accion= '".$acciones."',
subnivel= '".$userForm."',
piso = '".$piso."',
tomo = '".$tomo."',
caja = '".$caja."';

 ";



$sql = $conexion->insert($query);


		


		
	}
	
	echo $num_piso."|".$num_tomo."|".$num_caja."|".$accion."|".$userForm;
	
	@mysql_free_result($sql);
?>
