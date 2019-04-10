<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

//require_once("../includes/clases.php");
require_once("../includes/clases2.php");
require_once("../includes/clases3.php");

require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$accion= $_REQUEST["term"];
$sql=$conexion->select("select num_accion,direccion,abogado,detalle_de_estado_de_tramite,prescripcion FROM po where num_accion like '%$accion%'");

while ($r=mysql_fetch_array ($sql))
{
	//---------------------------------------------------------------------------------------------------
	// --- vemos si hay presuntos -----------------------------------------------------------------------
	$sqlPresuntos = $conexion->select("select num_accion FROM po_presuntos where num_accion = '".$accion."'");
	$totalPresuntos = mysql_num_rows($sqlPresuntos);
	// --- vemos si hay montos ---------------------------------------------------------------------------
	$totalMontoPO = dameTotalPO($accion);
	//----------------------------------------------------------------------------------------------------

	$sql1=$conexion->select("SELECT nombre,direccion FROM usuarios WHERE nivel = '".$r["direccion"]."' ");
	$dir = mysql_fetch_array ($sql1);
	$director = $dir['nombre'];
	
	$results[] = array("value"=>$r["num_accion"], "direccion"=>$r["direccion"], "turnado"=>$director, "direccion"=>$r["direccion"], "estado"=>$r["detalle_de_estado_de_tramite"], "prescripcion"=>$r["prescripcion"], "presuntos"=>$totalPresuntos, "montototal"=>$totalMontoPO);
}
//-----------------------------------------------------------
$conexion3 = new conexion3;
$conexion3->conectar();

$sql=$conexion3->select("select num_accion,direccion,abogado,detalle_de_estado_de_tramite,prescripcion FROM po where num_accion like '%$accion%'");

while ($r=mysql_fetch_array ($sql))
{
	//---------------------------------------------------------------------------------------------------
	// --- vemos si hay presuntos -----------------------------------------------------------------------
	$sqlPresuntos = $conexion->select("select num_accion FROM po_presuntos where num_accion = '".$accion."'");
	$totalPresuntos = mysql_num_rows($sqlPresuntos);
	// --- vemos si hay montos ---------------------------------------------------------------------------
	$totalMontoPO = dameTotalPO($accion);
	//----------------------------------------------------------------------------------------------------

	$sql1=$conexion3->select("SELECT nombre,direccion FROM usuarios WHERE nivel = '".$r["direccion"]."' ");
	$dir = mysql_fetch_array ($sql1);
	$director = $dir['nombre'];
	
	$results[] = array("value"=>$r["num_accion"], "direccion"=>$r["direccion"], "turnado"=>$director, "direccion"=>$r["direccion"], "estado"=>$r["detalle_de_estado_de_tramite"], "prescripcion"=>$r["prescripcion"], "presuntos"=>$totalPresuntos, "montototal"=>$totalMontoPO);
}



echo json_encode($results);

?>




