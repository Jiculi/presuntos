<?php
// El objetivo de este demo no es realizar una busqueda con php, sino mostrar lo simple
// que es programar una rutina de autocompletado con jQuery UI, por esta razon no vamos
// a realizar nada importante en este archivo.

// recuperamos el criterio de la busqueda
?>
<?php
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
$accion = $_REQUEST["term"];
$direccion = $_REQUEST["direccion"];
//if (!$criterio) return;
//------------------------------------------------------------------------------
if(isset($_REQUEST["direccion"]) && $_REQUEST["direccion"] =! "")
{
	if($direccion == "DG")
		$sql = $conexion->select("SELECT num_accion FROM po WHERE num_accion LIKE '%".$accion."%' ",false);
	else 
		$sql = $conexion->select("SELECT num_accion FROM po WHERE direccion = '".$direccion."' AND num_accion LIKE '%".$accion."%' ",false);
}
//else 
	//$sql = $conexion->select("SELECT num_accion FROM po WHERE num_accion LIKE '%".$accion."%' ",false);
	
	//if($direccion == "DG") $men = "Huevos";

$total = mysql_num_rows($sql);
$contador = 0;

while($r = mysql_fetch_array($sql))
{
	//$results[] = array('label' => $r['num_accion']." dir ".$direccion );
	$results[] = array('label' => $r['num_accion'] );
}
echo json_encode($results);
?>

